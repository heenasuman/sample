<?php

namespace Drupal\example\Plugin\rest\resource;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\example\AppRepository;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Subscription confirmation request as a resource.
 *
 * @RestResource(
 *   id = "es_subscription_confirmation",
 *   label = @Translation("Newsletter Subscription Confirmation"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "create" = "/api/subscription/confirmation"
 *   }
 * )
 */
class SubscriptionConfirmation extends ResourceBase {
  /**
   * The ES Repository.
   *
   * @var \Drupal\example\AppRepository
   */
  protected $repository;

  /**
   * A mail manager for sending email.
   *
   * @var \Drupal\Core\Mail\MailManagerInterface
   */
  protected $mailManager;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration,
  $plugin_id,
  $plugin_definition,
  array $serializer_formats,
  LoggerInterface $logger,
  MailManagerInterface $mailManager,
  AppRepository $repository,
  ConfigFactoryInterface $configFactory
    ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->mailManager = $mailManager;
    $this->repository = $repository;
    $this->configFactory = $configFactory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
          $configuration,
          $plugin_id,
          $plugin_definition,
          $container->getParameter('serializer.formats'),
          $container->get('logger.factory')->get('rest'),
          $container->get('plugin.manager.mail'),
          $container->get('example.repository'),
          $container->get('config.factory'),
      );
  }

  /**
   * {@inheritdoc}
   */
  public function post($data) {
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $siteConfigs = $this->configFactory->get('system.site');
    if (!isset($data['email']) || empty($data['email'])) {
      return new ModifiedResourceResponse(
        ['code' => 400, 'message' => $this->t('Missing parameters.')],
        Response::HTTP_BAD_REQUEST
      );
    }

    if (!empty($record = $this->repository->getRecordsFromTable(
      'es_mecury_subscriptions', [], ['email' => $data['email']]))
    ) {
      if ($this->repository->updateSubscription($data['email'])) {
        $this->mailManager->mail(
          'example',
          'newsletter_activation',
          $data['email'],
          $langcode,
          ['name' => $record[0]->name],
        );

        $this->mailManager->mail(
          'example',
          'newsletter_admin_notification',
          $siteConfigs->get('mail'),
          $langcode,
          ['name' => $record[0]->name, 'email' => $data['email']],
        );
        return new ModifiedResourceResponse(
          ['code' => 200, 'message' => $this->t('Success.')],
          Response::HTTP_OK
        );
      }
    }
    else {
      return new ModifiedResourceResponse(
        ['code' => 400, 'message' => $this->t('No record found.')],
        Response::HTTP_BAD_REQUEST
      );
    }
  }

}
