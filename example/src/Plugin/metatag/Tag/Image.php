<?php

namespace Drupal\example\Plugin\metatag\Tag;

use Drupal\metatag\Plugin\metatag\Tag\MetaNameBase;

/**
 * Provides a plugin for the 'image' meta tag.
 *
 * @MetatagTag(
 *   id = "image",
 *   label = @Translation("Image"),
 *   description = @Translation(""),
 *   name = "image",
 *   group = "basic",
 *   weight = 2,
 *   type = "image",
 *   secure = FALSE,
 *   multiple = FALSE
 * )
 */
class Image extends MetaNameBase {
  // Nothing here yet. Just a placeholder class for a plugin.
}
