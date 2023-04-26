<?php

namespace Drupal\example\Plugin\rest\resource;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\example\AppRepository;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Represents Home Content as a resource.
 *
 * @RestResource(
 *   id = "es_general",
 *   label = @Translation("General Content"),
 *   serialization_class = "",
 *   uri_paths = {
 *     "canonical" = "/api/get/{lang}/general"
 *   }
 * )
 */
class General extends ResourceBase {
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
          $container->get('config.factory'),
      );
  }

  /**
   * {@inheritdoc}
   */
  public function get($lang) {
    $mecuryConfigs = $this->configFactory->get('example.settings');

    $data = [
      'articles' => [
        'title' => $mecuryConfigs->get('articles_title_' . $lang),
        'description' => $mecuryConfigs->get('articles_description_' . $lang),
        'seo' => [
          'title' => $mecuryConfigs->get('articles_seo_title_' . $lang),
          'description' => $mecuryConfigs->get('articles_seo_description_' . $lang),
          'keywords' => $mecuryConfigs->get('articles_seo_keywords_' . $lang),
        ],
      ],
      'solutions' => [
        'title' => $mecuryConfigs->get('solutions_title_' . $lang),
        'description' => $mecuryConfigs->get('solutions_description_' . $lang),
        'seo' => [
          'title' => $mecuryConfigs->get('solutions_seo_title_' . $lang),
          'description' => $mecuryConfigs->get('solutions_seo_description_' . $lang),
          'keywords' => $mecuryConfigs->get('solutions_seo_keywords_' . $lang),
        ],
      ],
      'products' => [
        'title' => $mecuryConfigs->get('products_title_' . $lang),
        'description' => $mecuryConfigs->get('products_description_' . $lang),
        'seo' => [
          'title' => $mecuryConfigs->get('products_seo_title_' . $lang),
          'description' => $mecuryConfigs->get('products_seo_description_' . $lang),
          'keywords' => $mecuryConfigs->get('products_seo_keywords_' . $lang),
        ],
      ],
      'innovations' => [
        'title' => $mecuryConfigs->get('innovations_title_' . $lang),
        'description' => $mecuryConfigs->get('innovations_description_' . $lang),
        'seo' => [
          'title' => $mecuryConfigs->get('innovations_seo_title_' . $lang),
          'description' => $mecuryConfigs->get('innovations_seo_description_' . $lang),
          'keywords' => $mecuryConfigs->get('innovations_seo_keywords_' . $lang),
        ],
      ],
      'locations' => [
        'title' => $mecuryConfigs->get('locations_title_' . $lang),
        'seo' => [
          'title' => $mecuryConfigs->get('locations_seo_title_' . $lang),
          'description' => $mecuryConfigs->get('locations_seo_description_' . $lang),
          'keywords' => $mecuryConfigs->get('locations_seo_keywords_' . $lang),
        ],
      ],
      'partners' => [
        'title' => $mecuryConfigs->get('partners_title_' . $lang),
        'description' => $mecuryConfigs->get('partners_description_' . $lang),
        'seo' => [
          'title' => $mecuryConfigs->get('partners_seo_title_' . $lang),
          'description' => $mecuryConfigs->get('partners_seo_description_' . $lang),
          'keywords' => $mecuryConfigs->get('partners_seo_keywords_' . $lang),
        ],
      ],
      'cloud' => [
        'description' => $mecuryConfigs->get('cloud_description_' . $lang),
      ],
      'saas' => [
        'description' => $mecuryConfigs->get('saas_description_' . $lang),
      ],
      'newsletter' => [
        'heading' => $mecuryConfigs->get('newsletter_heading_' . $lang),
        'description' => $mecuryConfigs->get('newsletter_description_' . $lang),
        'checkbox' => $mecuryConfigs->get('newsletter_checkbox_' . $lang),
      ],
      'page_404' => [
        'heading' => $mecuryConfigs->get('title_404_' . $lang),
        'description' => $mecuryConfigs->get('description_404_' . $lang),
        'seo' => [
          'title' => $mecuryConfigs->get('seo_title_404_' . $lang),
          'description' => $mecuryConfigs->get('seo_description_404_' . $lang),
          'keywords' => $mecuryConfigs->get('seo_keywords_404_' . $lang),
        ],
      ],
      'cookie_policy' => [
        'body' => $mecuryConfigs->get('cookie_policy_text_' . $lang),
        'button' => $mecuryConfigs->get('cookie_policy_accept_btn_label_' . $lang),
        'link' => [
          'label' => $mecuryConfigs->get('cookie_policy_link_label_' . $lang),
          'url' => $mecuryConfigs->get('cookie_policy_link_url_' . $lang),
        ],
      ],
      'request_demo' => [
        'label' => $mecuryConfigs->get('request_demo_link_label_' . $lang),
        'url' => $mecuryConfigs->get('request_demo_link_url_' . $lang),
      ],
      'footer_copyright' => $mecuryConfigs->get('footer_copyright_' . $lang),
    ];

    if (empty($data)) {
      return new ModifiedResourceResponse([], Response::HTTP_NO_CONTENT);
    }
    else {
      return new ModifiedResourceResponse($data, Response::HTTP_OK);
    }
  }

}
