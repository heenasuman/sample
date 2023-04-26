<?php

namespace Drupal\example\Plugin\WebformHandler;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Webform Date Validation handler.
 *
 * @WebformHandler(
 *   id = "recaptcha_v3_validator_handler_custom",
 *   label = @Translation("Recaptcha V3 Handler Validator"),
 *   category = @Translation("Custom"),
 *   description = @Translation("Recaptcha V3 Handler Validator"),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_SINGLE,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 *   submission = \Drupal\webform\Plugin\WebformHandlerInterface::SUBMISSION_OPTIONAL,
 * )
 */
class RecaptchaV3Handler extends WebformHandlerBase {

  /**
   * Custom validation for Captcha.
   */
  public function validateForm(array &$form, FormStateInterface $form_state, WebformSubmissionInterface $webform_submission) {
    parent::validateForm($form, $form_state, $webform_submission);
    if (!$form_state->hasAnyErrors()) {
      $current_path = \Drupal::service('path.current')->getPath();
      if ($current_path == '/webform_rest/submit') {
        $data = Json::decode(\Drupal::request()->getContent());
        if (!example_validate_recaptcha_v3($data['captcha'])) {
          $error_message = \Drupal::config('recaptcha_v3.settings')
            ->get('error_message');
          $form_state->setErrorByName('captcha', $error_message);
        }
      }
    }
  }

}
