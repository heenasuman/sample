<?php

namespace Drupal\example\Plugin\rest\resource;

use Drupal\example\AppRepository;
use Drupal\node\Entity\Node;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Represents Products Content as a resource.
 *
 * @RestResource(
 *   id = "es_products_list",
 *   label = @Translation("Products List"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "canonical" = "/api/get/{lang}/products/list"
 *   }
 * )
 */
class ProductsList extends ResourceBase {
  /**
   * The ES Repository.
   *
   * @var \Drupal\example\AppRepository
   */
  protected $repository;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration,
  $plugin_id,
  $plugin_definition,
  array $serializer_formats,
        LoggerInterface $logger,
  AppRepository $repository
    ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
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
      );
  }

  /**
   * {@inheritdoc}
   */
  public function get($lang) {
    $data = [];

    $products = $this->repository->getRecordsFromTable(
      'node_field_data',
      ['nid'],
      ['type' => 'product', 'langcode' => 'es', 'status' => 1],
      NULL,
      TRUE
    );

    foreach ($products as $product) {
      $productNode = Node::load($product->nid);
      if ($productNode->hasTranslation($lang)) {
        $productNode = $productNode->getTranslation($lang);
      }

      $data[] = [
        'title' => $productNode->getTitle(),
        'image' => (!$productNode->field_image->isEmpty()) ? $this->repository->getFileUrlFromUri($productNode->field_image->entity->getFileUri()) : '',
        'cta' => '/api/get/' . $lang . '/product/' . $productNode->id(),
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
