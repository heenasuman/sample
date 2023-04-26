<?php

namespace Drupal\example\Plugin\jsonapi\FieldEnhancer;

use Drupal\jsonapi_extras\Plugin\ResourceFieldEnhancerBase;
use Shaper\Util\Context;

/**
 * Perform additional manipulations to Image fields.
 *
 * @ResourceFieldEnhancer(
 *   id = "example_image",
 *   label = @Translation("Relative to Absolute Url (Image Field)"),
 *   description = @Translation("Convert relative image url to Absolute."),
 *   dependencies = {"file"}
 * )
 */
class ImageEnhancer extends ResourceFieldEnhancerBase {

  /**
   * {@inheritdoc}
   */
  protected function doUndoTransform($data, Context $context) {
    if (isset($data['value']) && isset($data['url'])) {
      $repo = \Drupal::service('example.repository');
      $data['url'] = $repo->getFileUrlFromUri($data['value']);
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
