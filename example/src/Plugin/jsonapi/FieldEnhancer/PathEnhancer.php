<?php

namespace Drupal\example\Plugin\jsonapi\FieldEnhancer;

use Drupal\jsonapi_extras\Plugin\ResourceFieldEnhancerBase;
use Drupal\path_alias\Entity\PathAlias;
use Shaper\Util\Context;

/**
 * Perform additional manipulations to Image fields.
 *
 * @ResourceFieldEnhancer(
 *   id = "example_path",
 *   label = @Translation("Multi-lingual Paths (Alias Field)"),
 *   description = @Translation("Provide path aliases in the disregard of language filter."),
 *   dependencies = {"file"}
 * )
 */
class PathEnhancer extends ResourceFieldEnhancerBase {

  /**
   * {@inheritdoc}
   */
  protected function doUndoTransform($data, Context $context) {
    if (isset($data['pid'])) {
      $path = PathAlias::load($data['pid']);
      $systemPath = $path->get('path')->getValue();
      $langCodes = \Drupal::languageManager()->getLanguages();
      $langCodesList = array_keys($langCodes);
      $data = [];
      foreach ($langCodesList as $lang) {
        $data[$lang] = \Drupal::service('path_alias.manager')->getAliasByPath($systemPath[0]['value'], $lang);
      }
    }

    return $data;
  }

  /**
   * {@inheritdoc}
   */
  protected function doTransform($data, Context $context) {
    return $data;
  }

  /**
   * {@inheritdoc}
   */
  public function getOutputJsonSchema() {
    return [
      'oneOf' => [
      ['type' => 'object'],
      ['type' => 'array'],
      ],
    ];
  }

}
