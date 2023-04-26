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
 * Represents Solutions Content as a resource.
 *
 * @RestResource(
 *   id = "es_solutions_list",
 *   label = @Translation("Solutions List"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "canonical" = "/api/get/{lang}/solutions/list"
 *   }
 * )
 */
class SolutionsList extends ResourceBase {
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

    $solutions = $this->repository->getRecordsFromTable(
      'node_field_data',
      ['nid'],
      ['type' => 'solution', 'langcode' => 'es', 'status' => 1],
      NULL,
      TRUE
    );

    foreach ($solutions as $solution) {
      $solutionNode = Node::load($solution->nid);
      if ($solutionNode->hasTranslation($lang)) {
        $solutionNode = $solutionNode->getTranslation($lang);
      }

      $data[] = [
        'title' => $solutionNode->getTitle(),
        'image' => (!$solutionNode->field_image->isEmpty()) ? $this->repository->getFileUrlFromUri($solutionNode->field_image->entity->getFileUri()) : '',
        'cta' => '/api/get/' . $lang . '/solution/' . $solutionNode->id(),
        'category' => ($solutionNode->field_category->entity->hasTranslation($lang)) ? $solutionNode->field_category->entity->getTranslation($lang)->label() : $solutionNode->field_category->entity->label(),
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
