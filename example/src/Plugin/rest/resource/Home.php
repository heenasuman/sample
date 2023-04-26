<?php

namespace Drupal\example\Plugin\rest\resource;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\example\AppRepository;
use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Represents Home Content as a resource.
 *
 * @RestResource(
 *   id = "es_home",
 *   label = @Translation("Home Content"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "canonical" = "/api/get/{lang}/home"
 *   }
 * )
 */
class Home extends ResourceBase {
  /**
   * The ES Repository.
   *
   * @var \Drupal\example\AppRepository
   */
  protected $repository;

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
  AppRepository $repository,
  ConfigFactoryInterface $configFactory
    ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->configFactory = $configFactory;
    $this->repository = $repository;
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
          $container->get('example.repository'),
          $container->get('config.factory')
      );
  }

  /**
   * {@inheritdoc}
   */
  public function get($lang) {
    $data = [];
    // Home Page Banner Content.
    $siteConfigs = $this->configFactory->get('system.site');
    $frontPage = $siteConfigs->get('page.front');
    $nid = (int) filter_var($frontPage, FILTER_SANITIZE_NUMBER_INT);
    $keywords = [];
    if (is_numeric($nid)
          && !empty($this->repository->getRecordsFromTable(
            'node_field_data',
            [],
            [
              'nid' => $nid,
              'type' => 'landing',
              'langcode' => 'es',
              'status' => 1,
            ],
          )
      )) {
      $node = Node::load($nid);
      if ($node->hasTranslation($lang)) {
        $node = $node->getTranslation($lang);

        if (!$node->field_keywords->isEmpty()) {
          foreach ($node->field_keywords->getValue() as $val) {
            $keywords[] = $val['value'];
          }
        }
      }
      $data['banner'] = [
        'title' => $node->getTitle(),
        'body' => $node->body->value,
        'keywords' => $keywords,
        'cta_label' => $node->field_cta_label->value,
      ];
    }

    // Blog Content.
    $blogs = $this->repository->getRecordsFromTable(
      'node_field_data',
      ['nid'],
      ['type' => 'article', 'langcode' => 'es', 'status' => 1],
      3,
      TRUE
    );
    foreach ($blogs as $blog) {
      $blogNode = Node::load($blog->nid);
      if ($blogNode->hasTranslation($lang)) {
        $blogNode = $blogNode->getTranslation($lang);
      }

      $data['blogs'][] = [
        'title' => $blogNode->getTitle(),
        'image' => (!$blogNode->field_image->isEmpty()) ? $this->repository->getFileUrlFromUri($blogNode->field_image->entity->getFileUri()) : '',
        'cta' => '/api/get/' . $lang . '/article/' . $blogNode->id(),
      ];
    }

    if (empty($data)) {
      return new ModifiedResourceResponse([], Response::HTTP_NO_CONTENT);
    }
    else {
      return new ModifiedResourceResponse($data, Response::HTTP_OK);
    }
  }

}
