<?php

namespace Drupal\example\Plugin\rest\resource;

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Represents Menu Links as a resource.
 *
 * @RestResource(
 *   id = "es_menu_links",
 *   label = @Translation("Menu Links"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "canonical" = "/api/get/{lang}/menu"
 *   }
 * )
 */
class MenuLinks extends ResourceBase {

  /**
   * The menu service.
   *
   * @var \Drupal\menu_link_content\Entity\MenuLinkContent
   */
  protected $menu;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration,
  $plugin_id,
  $plugin_definition,
  array $serializer_formats,
        LoggerInterface $logger,
  $menu
    ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition, $serializer_formats, $logger);
    $this->menu = $menu;
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
          $container->get('menu.link_tree')
      );
  }

  /**
   * {@inheritdoc}
   */
  public function get($lang) {
    /** @var \Drupal\menu_link_content\MenuLinkContentInterface $entity */

    $data = [];
    foreach (['main', 'social-links', 'footer'] as $menuName) {
      $main = \Drupal::entityTypeManager()
        ->getStorage('menu_link_content')
        ->getQuery()->condition('menu_name', $menuName)
        ->sort('weight', 'ASC')->execute();
      $tree = MenuLinkContent::loadMultiple($main);

      $data[$menuName] = [];
      foreach ($tree as $item) {
        if ($item->hasTranslation($lang)) {
          $item = $item->getTranslation($lang);
        }
        $data[$menuName][] = [
          'title' => $item->getTitle(),
          'url' => $item->getUrlObject()->toString(),
        ];
      }
    }

    return new ModifiedResourceResponse(
          $data,
          Response::HTTP_OK
      );
  }

}
