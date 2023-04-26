<?php

namespace Drupal\example\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure General Settings for this site.
 */
class ConfigForm extends ConfigFormBase {

  /**
   * Config name.
   *
   * @var string Config settings
   */
  const SETTINGS = 'example.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'example_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $config = $this->config(static::SETTINGS);

    $form['newsletter'] = [
      '#type' => 'details',
      '#title' => $this->t('Newsletter'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['newsletter']['newsletter_heading_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Newsletter Heading'),
      '#default_value' => $config->get('newsletter_heading_' . $language) ?? '',
    ];

    $form['newsletter']['newsletter_description_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Newsletter Description'),
      '#default_value' => $config->get('newsletter_description_' . $language) ?? '',
    ];

    $form['newsletter']['newsletter_checkbox_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Newsletter Checkbox'),
      '#default_value' => $config->get('newsletter_checkbox_' . $language) ?? '',
    ];

    $form['404'] = [
      '#type' => 'details',
      '#title' => $this->t('404'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['404']['title_404_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('404 Heading'),
      '#default_value' => $config->get('title_404_' . $language) ?? '',
    ];

    $form['404']['description_404_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('404 Description'),
      '#default_value' => $config->get('description_404_' . $language) ?? '',
    ];

    $form['404']['seo_title_404_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('seo_title_404_' . $language),
      '#prefix' => '<h3>SEO Purpose</h3>'
    ];

    $form['404']['seo_description_404_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('seo_description_404_' . $language),
    ];

    $form['404']['seo_keywords_404_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#default_value' => $config->get('seo_keywords_404_' . $language),
    ];

    $form['cookie'] = [
      '#type' => 'details',
      '#title' => $this->t('Cookies'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['cookie']['cookie_policy_text_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Cookie Policy Text'),
      '#default_value' => $config->get('cookie_policy_text_' . $language) ?? '',
    ];

    $form['cookie']['cookie_policy_accept_btn_label_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Aceptar Button Label'),
      '#default_value' => $config->get('cookie_policy_accept_btn_label_' . $language) ?? $this->t('Aceptar'),
    ];

    $form['cookie']['cookie_policy_link_label_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Policy Link Label'),
      '#default_value' => $config->get('cookie_policy_link_label_' . $language) ?? 'Ver política de cookies',
    ];

    $form['cookie']['cookie_policy_link_url_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Policy URL'),
      '#default_value' => $config->get('cookie_policy_link_url_' . $language) ?? '',
    ];

    $form['articles'] = [
      '#type' => 'details',
      '#title' => $this->t('Blogs'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['articles']['articles_title_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('articles_title_' . $language) ?? '',
    ];

    $form['articles']['articles_description_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('articles_description_' . $language) ?? '',
    ];

    $form['articles']['articles_seo_title_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('articles_seo_title_' . $language),
      '#prefix' => '<h3>SEO Purpose</h3>'
    ];

    $form['articles']['articles_seo_description_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('articles_seo_description_' . $language),
    ];

    $form['articles']['articles_seo_keywords_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#default_value' => $config->get('articles_seo_keywords_' . $language),
    ];

    $form['solutions'] = [
      '#type' => 'details',
      '#title' => $this->t('Solutions'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['solutions']['solutions_title_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('solutions_title_' . $language) ?? '',
    ];

    $form['solutions']['solutions_description_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('solutions_description_' . $language) ?? '',
    ];

    $form['solutions']['solutions_seo_title_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('solutions_seo_title_' . $language),
      '#prefix' => '<h3>SEO Purpose</h3>'
    ];

    $form['solutions']['solutions_seo_description_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('solutions_seo_description_' . $language),
    ];

    $form['solutions']['solutions_seo_keywords_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#default_value' => $config->get('solutions_seo_keywords_' . $language),
    ];

    $form['products'] = [
      '#type' => 'details',
      '#title' => $this->t('Products'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['products']['products_title_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('products_title_' . $language) ?? '',
    ];

    $form['products']['products_description_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('products_description_' . $language) ?? '',
    ];

    $form['products']['products_seo_title_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('products_seo_title_' . $language),
      '#prefix' => '<h3>SEO Purpose</h3>'
    ];

    $form['products']['products_seo_description_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('products_seo_description_' . $language),
    ];

    $form['products']['products_seo_keywords_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#default_value' => $config->get('products_seo_keywords_' . $language),
    ];

    $form['innovations'] = [
      '#type' => 'details',
      '#title' => $this->t('Innovations'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['innovations']['innovations_title_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('innovations_title_' . $language) ?? '',
    ];

    $form['innovations']['innovations_description_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('innovations_description_' . $language) ?? '',
    ];

    $form['innovations']['innovations_seo_title_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('innovations_seo_title_' . $language),
      '#prefix' => '<h3>SEO Purpose</h3>'
    ];

    $form['innovations']['innovations_seo_description_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('innovations_seo_description_' . $language),
    ];

    $form['innovations']['innovations_seo_keywords_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#default_value' => $config->get('innovations_seo_keywords_' . $language),
    ];

    $form['locations'] = [
      '#type' => 'details',
      '#title' => $this->t('Locations'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['locations']['locations_title_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('locations_title_' . $language) ?? '',
    ];

    $form['locations']['locations_seo_title_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('locations_seo_title_' . $language),
      '#prefix' => '<h3>SEO Purpose</h3>'
    ];

    $form['locations']['locations_seo_description_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('locations_seo_description_' . $language),
    ];

    $form['locations']['locations_seo_keywords_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#default_value' => $config->get('locations_seo_keywords_' . $language),
    ];

    $form['partners'] = [
      '#type' => 'details',
      '#title' => $this->t('Partners'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['partners']['partners_title_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('partners_title_' . $language) ?? '',
    ];

    $form['partners']['partners_description_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('partners_description_' . $language) ?? '',
    ];

    $form['partners']['partners_seo_title_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $config->get('partners_seo_title_' . $language),
      '#prefix' => '<h3>SEO Purpose</h3>'
    ];

    $form['partners']['partners_seo_description_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('partners_seo_description_' . $language),
    ];

    $form['partners']['partners_seo_keywords_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Keywords'),
      '#default_value' => $config->get('partners_seo_keywords_' . $language),
    ];

    $form['cloud'] = [
      '#type' => 'details',
      '#title' => $this->t('Cloud'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['cloud']['cloud_description_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('cloud_description_' . $language) ?? '',
    ];

    $form['saas'] = [
      '#type' => 'details',
      '#title' => $this->t('Saas'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['saas']['saas_description_' . $language] = [
      '#type' => 'text_format',
      '#format' => 'full_html',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('saas_description_' . $language) ?? '',
    ];

    $form['general'] = [
      '#type' => 'details',
      '#title' => $this->t('General'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['general']['request_demo_link_label_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Request a demo Label'),
      '#default_value' => $config->get('request_demo_link_label_' . $language) ?? 'SOLICITA UNA DEMO',
    ];

    $form['general']['request_demo_link_url_' . $language] = [
      '#type' => 'textfield',
      '#title' => $this->t('Request a demo URL'),
      '#default_value' => $config->get('request_demo_link_url_' . $language) ?? '',
    ];

    $form['general']['footer_copyright_' . $language] = [
      '#type' => 'textarea',
      '#title' => $this->t('Footer Copyright Copy'),
      '#default_value' => $config->get('footer_copyright_' . $language) ?? '',
    ];

    $form['general']['front_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Front Web Url'),
      '#default_value' => $config->get('front_url') ?? '',
    ];

    $form['captcha'] = [
      '#type' => 'details',
      '#title' => $this->t('Google Captcha'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['captcha']['captcha_site_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Site Key'),
      '#default_value' => $config->get('captcha_site_key'),
    ];

    $form['captcha']['captcha_secret_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Secret Key'),
      '#default_value' => $config->get('captcha_secret_key'),
    ];

    $form['deploy'] = [
      '#type' => 'details',
      '#title' => $this->t('Deploy Front'),
      '#collapsible' => TRUE,
      '#open' => FALSE,
    ];

    $form['deploy']['deploy_request_token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Deploy token gitlab'),
      '#default_value' => $config->get('deploy_request_token'),
    ];

    $form['deploy']['deploy_request_num_account'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Deploy number account gitlab'),
      '#default_value' => $config->get('deploy_request_num_account'),
    ];

    $form['deploy']['deploy_request_env'] = [
      '#type' => 'select',
      '#title' => $this->t('Deploy enviroment'),
      '#options' => [
        'dev' => 'dev',
        'staging' => 'staging',
        'main' => 'main',
      ],
      '#default_value' => [$config->get('deploy_request_env')],
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $language = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('newsletter_heading_' . $language, $form_state->getValue('newsletter_heading_' . $language)['value'])
      ->set('newsletter_description_' . $language, $form_state->getValue('newsletter_description_' . $language))
      ->set('newsletter_checkbox_' . $language, $form_state->getValue('newsletter_checkbox_' . $language)['value'])

      ->set('title_404_' . $language, $form_state->getValue('title_404_' . $language)['value'])
      ->set('description_404_' . $language, $form_state->getValue('description_404_' . $language)['value'])
      ->set('seo_title_404_' . $language, $form_state->getValue('seo_title_404_' . $language))
      ->set('seo_description_404_' . $language, $form_state->getValue('seo_description_404_' . $language))
      ->set('seo_keywords_404_' . $language, $form_state->getValue('seo_keywords_404_' . $language))

      ->set('cookie_policy_text_' . $language, $form_state->getValue('cookie_policy_text_' . $language)['value'])
      ->set('cookie_policy_accept_btn_label_' . $language, $form_state->getValue('cookie_policy_accept_btn_label_' . $language))
      ->set('cookie_policy_link_label_' . $language, $form_state->getValue('cookie_policy_link_label_' . $language))
      ->set('cookie_policy_link_url_' . $language, $form_state->getValue('cookie_policy_link_url_' . $language))

      ->set('request_demo_link_label_' . $language, $form_state->getValue('request_demo_link_label_' . $language))
      ->set('request_demo_link_url_' . $language, $form_state->getValue('request_demo_link_url_' . $language))
      ->set('footer_copyright_' . $language, $form_state->getValue('footer_copyright_' . $language))
      ->set('front_url', $form_state->getValue('front_url'))

      ->set('locations_title_' . $language, $form_state->getValue('locations_title_' . $language)['value'])
      ->set('locations_seo_title_' . $language, $form_state->getValue('locations_seo_title_' . $language))
      ->set('locations_seo_description_' . $language, $form_state->getValue('locations_seo_description_' . $language))
      ->set('locations_seo_keywords_' . $language, $form_state->getValue('locations_seo_keywords_' . $language))

      ->set('articles_title_' . $language, $form_state->getValue('articles_title_' . $language)['value'])
      ->set('articles_description_' . $language, $form_state->getValue('articles_description_' . $language)['value'])
      ->set('articles_seo_title_' . $language, $form_state->getValue('articles_seo_title_' . $language))
      ->set('articles_seo_description_' . $language, $form_state->getValue('articles_seo_description_' . $language))
      ->set('articles_seo_keywords_' . $language, $form_state->getValue('articles_seo_keywords_' . $language))

      ->set('products_title_' . $language, $form_state->getValue('products_title_' . $language)['value'])
      ->set('products_description_' . $language, $form_state->getValue('products_description_' . $language)['value'])
      ->set('products_seo_title_' . $language, $form_state->getValue('products_seo_title_' . $language))
      ->set('products_seo_description_' . $language, $form_state->getValue('products_seo_description_' . $language))
      ->set('products_seo_keywords_' . $language, $form_state->getValue('products_seo_keywords_' . $language))

      ->set('solutions_title_' . $language, $form_state->getValue('solutions_title_' . $language)['value'])
      ->set('solutions_description_' . $language, $form_state->getValue('solutions_description_' . $language)['value'])
      ->set('solutions_seo_title_' . $language, $form_state->getValue('solutions_seo_title_' . $language))
      ->set('solutions_seo_description_' . $language, $form_state->getValue('solutions_seo_description_' . $language))
      ->set('solutions_seo_keywords_' . $language, $form_state->getValue('solutions_seo_keywords_' . $language))

      ->set('innovations_title_' . $language, $form_state->getValue('innovations_title_' . $language)['value'])
      ->set('innovations_description_' . $language, $form_state->getValue('innovations_description_' . $language)['value'])
      ->set('innovations_seo_title_' . $language, $form_state->getValue('innovations_seo_title_' . $language))
      ->set('innovations_seo_description_' . $language, $form_state->getValue('innovations_seo_description_' . $language))
      ->set('innovations_seo_keywords_' . $language, $form_state->getValue('innovations_seo_keywords_' . $language))

      ->set('partners_title_' . $language, $form_state->getValue('partners_title_' . $language)['value'])
      ->set('partners_description_' . $language, $form_state->getValue('partners_description_' . $language)['value'])
      ->set('partners_seo_title_' . $language, $form_state->getValue('partners_seo_title_' . $language))
      ->set('partners_seo_description_' . $language, $form_state->getValue('partners_seo_description_' . $language))
      ->set('partners_seo_keywords_' . $language, $form_state->getValue('partners_seo_keywords_' . $language))

      ->set('cloud_description_' . $language, $form_state->getValue('cloud_description_' . $language)['value'])
      ->set('saas_description_' . $language, $form_state->getValue('saas_description_' . $language)['value'])

      ->set('captcha_secret_key', $form_state->getValue('captcha_secret_key'))
      ->set('captcha_site_key', $form_state->getValue('captcha_site_key'))
      ->set('deploy_request_token', $form_state->getValue('deploy_request_token'))
      ->set('deploy_request_num_account', $form_state->getValue('deploy_request_num_account'))
      ->set('deploy_request_env', $form_state->getValue('deploy_request_env'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
