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
 * Represents Newsletter Subscription request as a resource.
 *
 * @RestResource(
 *   id = "es_newsletter_subscription",
 *   label = @Translation("Newsletter Subscription"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "create" = "/api/newsletter/subscription"
 *   }
 * )
 */
class NewsletterSubscription extends ResourceBase {
  /**
   * The ES Repository.
   *
   * @var \Drupal\example\AppRepository
   */
  protected $repository;

  /**
   * The Email Validation Service.
   *
   * @var \Drupal\Component\Utility\EmailValidator
   */
  protected $emailValidator;

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
  $emailValidator,
  MailManagerInterface $mailManager,
  AppRepository $repository,
  ConfigFactoryInterface $configFactory
    ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->emailValidator = $emailValidator;
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
          $container->get('email.validator'),
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
    if (empty($data)) {
      return new ModifiedResourceResponse(
        ['code' => 400, 'message' => $this->t('Missing parameters.')],
        Response::HTTP_BAD_REQUEST
      );
    }

    foreach (['name', 'email'] as $field) {
      if (!isset($data[$field]) || empty($data[$field])) {
        return new ModifiedResourceResponse(
          ['code' => 400, 'message' => $this->t('Missing parameter.')],
          Response::HTTP_BAD_REQUEST
        );
      }
    }

    if (!$this->emailValidator->isValid($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
      return new ModifiedResourceResponse(
        ['code' => 400, 'message' => $this->t('Invalid email.')],
        Response::HTTP_BAD_REQUEST
      );
    }

    if (isset($data['tcpp']) && !is_bool($data['tcpp'])) {
      return new ModifiedResourceResponse(
        [
          'code' => 400,
          'message' => $this->t('Only boolean values are allowed.'),
        ],
        Response::HTTP_BAD_REQUEST
      );
    }

    if (!empty($this->repository->getRecordsFromTable(
      'es_mecury_subscriptions', [], ['email' => $data['email']]))
    ) {
      return new ModifiedResourceResponse(
        ['code' => 200, 'message' => $this->t('Success.')],
        Response::HTTP_OK
      );
    }
    elseif ($this->repository->insertRecordsToTable(
          'es_mecury_subscriptions', [
            'name' => $data['name'],
            'email' => $data['email'],
            'tcpp' => isset($data['tcpp']) && $data['tcpp'] == TRUE ? 1 : 0,
            'created' => \Drupal::time()->getRequestTime(),
            'status' => 1,
          ]
      )
      ) {
      /*$this->mailManager->mail(
      'example',
      'newsletter_confirmation',
      $data['email'],
      $langcode,
      ['name' => $data['name']],
      );*/
      $this->mailManager->mail(
        'example',
        'newsletter_activation',
        $data['email'],
        $langcode,
        ['name' => $data['name']],
      );

      $this->mailManager->mail(
        'example',
        'newsletter_admin_notification',
        $siteConfigs->get('mail'),
        $langcode,
        ['name' => $data['name'], 'email' => $data['email']],
      );
      return new ModifiedResourceResponse(
        ['code' => 200, 'message' => $this->t('Success.')],
        Response::HTTP_OK
      );
    }
    else {
      return new ModifiedResourceResponse(
        ['code' => 400, 'message' => $this->t('Failed.')],
        Response::HTTP_BAD_REQUEST
      );
    }
  }

}
