<?php

namespace Drupal\example\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Query\Condition;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Render\Markup;
use Drupal\example\Others\ReportHelper;
use Drupal\file\Entity\File;
use Drupal\webform\Entity\WebformSubmission;
use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;

/**
 * General purpose controller.
 */
class PageController extends ControllerBase {
  use ReportHelper;

  /**
   * Replicated pager variable.
   *
   * @return array
   *   Renderable pager element.
   */
  protected array $pager = [
    '#type' => 'pager',
  ];

  /**
   * Get subscribers report.
   *
   * @return array
   *   Renderable table array.
   */
  public function subscriptions() {
    $header = $this->getHeader();
    $rows = $this->generateReportData();
    $build['list'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t("There are no records found."),
    ];

    $build['pager'] = $this->pager;

    return $build;
  }

  /**
   * Get header.
   *
   * @return array
   *   Report table header.
   */
  public function getHeader() {
    $header = [
      $this->t('Nombre'),
      $this->t('Correo Electrónico'),
      $this->t('TCPP'),
      $this->t('Fecha de Creación'),
    ];
    return $header;
  }

  /**
   * Get reports data.
   *
   * @return array
   *   Report table rows.
   */
  public function generateReportData($csv = FALSE) {
    $select = \Drupal::database()->select('es_mecury_subscriptions', 's');
    $select->fields('s');
    $select = $select->extend('Drupal\Core\Database\Query\PagerSelectExtender');
    $select->limit(20)->element(0);
    $select->orderBy('id');
    $result = $select->execute();

    $rows = [];
    foreach ($result as $item) {

      if ($item->tcpp) {
        $status = 'Yes';
      }
      else {
        $status = 'No';
      }

      $timeObj = DrupalDateTime::createFromTimestamp($item->created);
      $time = $timeObj->format('Y-m-d g:i:s A');

      $rows[] = [
        $item->name,
        $item->email,
        $status,
        $time,
      ];
    }

    return $rows;
  }

  /**
   * Report generator.
   *
   * @param string $fhame
   *   Dynamic function name.
   * @param string $fname
   *   Dynamic file name.
   *
   * @return \Generator
   *   Report generator.
   */
  public function reportGenerator($fhame, $fname) {
    $this->openOutputStream();
    // Header.
    fputcsv($this->file, $this->{$fhame}());

    // Data.
    $rows = $this->{$fname}(TRUE);
    foreach ($rows as $row) {
      yield fputcsv($this->file, array_values($row));
    }
  }

  /**
   * Get contact requests report.
   *
   * @return array
   *   Renderable table array.
   */
  public function contact() {
    $header = $this->getContactHeader();
    $rows = $this->generateContactReportData();
    $build['list'] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#empty' => $this->t("There are no records found."),
    ];

    $build['pager'] = $this->pager;

    return $build;
  }

  /**
   * Contact report generator.
   *
   * @param bool $csv
   *   TRUE if csv, false otherwise.
   *
   * @return array
   *   Rows array.
   */
  public function generateContactReportData($csv = FALSE) {
    $repo = \Drupal::service('example.repository');

    $query = \Drupal::database()->select('webform_submission', 's');
    $query->join('webform_submission_data', 'type', 's.sid = type.sid');
    $query->join('taxonomy_term_field_data', 't', 't.tid = type.value and t.langcode = s.langcode');
    $query->fields('s', ['sid', 'created']);
    $query->addField('t', 'name', 'type');
    $query->condition('type.name', 'type');
    $select = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender');
    $select->limit(20)->element(0);
    $select->orderBy('s.sid');
    $result = $select->execute();

    $rows = [];
    $linkedinCopy = 'linkedin';
    foreach ($result as $item) {
      $dataObj = WebformSubmission::load($item->sid);
      $data = $dataObj->getData();
      if ($data['tcpp']) {
        $status = 'Yes';
      }
      else {
        $status = 'No';
      }

      $timeObj = DrupalDateTime::createFromTimestamp($item->created);
      $time = $timeObj->format('Y-m-d g:i:s A');

      if (!empty($data[$linkedinCopy]['url'])) {
        if ($csv) {
          $linkedin = $data[$linkedinCopy]['url'];
        }
        else {
          $linkedin = Markup::create('<a target="_blank" href="' . $data[$linkedinCopy]['url'] . '">' . $data[$linkedinCopy]['url'] . '</a>');
        }
      }
      else {
        $linkedin = '';
      }

      $cv = '';
      if (!empty($data['cv'])) {
        $file = File::load($data['cv']);

        if (!empty($file->getFileUri())) {
          $cvUrl = $repo->getFileUrlFromUri($file->getFileUri());

          if ($csv) {
            $cv = $cvUrl;
          }
          else {
            $cv = Markup::create('<a target="_blank" href="' . $cvUrl . '">' . $cvUrl . '</a>');
          }
        }
      }

      $rows[] = [
        $data['name'],
        $data['email'],
        $data['telephone'],
        $item->type,
        $linkedin,
        $cv,
        $data['message'],
        $status,
        $time,
      ];
    }

    return $rows;
  }

  /**
   * Contact header.
   *
   * @return array
   *   Header array for the contact report.
   */
  public function getContactHeader() {
    $header = [
      $this->t('Nombre'),
      $this->t('Correo Electrónico'),
      $this->t('Número de Telefono'),
      $this->t('Tipo de Requerimiento'),
      $this->t('LINKEDIN'),
      $this->t('CV'),
      $this->t('Mensaje'),
      $this->t('TCPP'),
      $this->t('Fecha de Creación'),
    ];
    return $header;
  }

  /**
   * Articles search.
   *
   * @param string $lang
   *   Language code.
   *
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   *   Json search results.
   */
  public function getArticles($lang) {
    $keys = \Drupal::request()->query->get('keys');
    return new JsonResponse(
      [
        'data' => $this->getData($lang, $keys),
        'method' => 'GET',
        'status' => 200,
      ]
    );
  }

  /**
   * Get Data callback.
   *
   * @param string $lang
   *   Language code.
   * @param string $keys
   *   Searchable key.
   *
   * @return array
   *   Search results.
   */
  public function getData($lang, $keys) {
    $result = [];
    $or = new Condition('OR');
    $or->condition('nd.title', '%' . \Drupal::database()->escapeLike($keys) . '%', 'LIKE');
    $or->condition('t.name', '%' . \Drupal::database()->escapeLike($keys) . '%', 'LIKE');
    $or->condition('b.body_value', '% ' . \Drupal::database()->escapeLike($keys) . ' %', 'LIKE');
    $or->condition('sum.field_summary_value', '%' . \Drupal::database()->escapeLike($keys) . '%', 'LIKE');
    $or->condition('a.field_author_value', '%' . \Drupal::database()->escapeLike($keys) . '%', 'LIKE');
    $or->condition('keys.field_keywords_value', '%' . \Drupal::database()->escapeLike($keys) . '%', 'LIKE');

    $query = \Drupal::database()->select('node_field_data', 'nd');
    $query->leftJoin('node', 'n', 'nd.nid = n.nid');
    $query->leftJoin('node__body', 'b', 'b.entity_id = nd.nid AND b.langcode = nd.langcode');
    $query->leftJoin('node__field_summary', 'sum', 'sum.entity_id = nd.nid AND sum.langcode = nd.langcode');
    $query->leftjoin('node__field_publication_date', 'date', 'date.entity_id = nd.nid AND date.langcode = nd.langcode');
    $query->leftJoin('node__field_keywords', 'keys', 'keys.entity_id = nd.nid AND keys.langcode = nd.langcode');
    $query->leftJoin('node__field_tags', 'tags', 'tags.entity_id = nd.nid');
    $query->leftJoin('taxonomy_term_field_data', 't', 'tags.field_tags_target_id = t.tid AND nd.langcode = t.langcode');
    $query->leftJoin('node__field_image', 'img', 'img.entity_id = nd.nid');
    $query->leftJoin('node__field_mobile_image', 'imgmobil', 'imgmobil.entity_id = nd.nid');
    $query->leftJoin('file_managed', 'f', 'img.field_image_target_id = f.fid');
    $query->leftJoin('file_managed', 'fm', 'imgmobil.field_mobile_image_target_id = fm.fid');
    $query->leftJoin('node__field_author', 'a', 'a.entity_id = nd.nid AND a.langcode = nd.langcode');

    $query->fields('n', ['nid', 'uuid']);
    $query->fields('nd', ['title']);
    $query->addField('sum', 'field_summary_value', 'body_summary');
    $query->addField('t', 'name');
    $query->addField('a', 'field_author_value', 'author');
    $query->addField('f', 'uri', 'desktop');
    $query->addField('fm', 'uri', 'mobile');
    $query->addField('date', 'field_publication_date_value', 'field_publication_date');
    $query->condition('nd.status', 1);
    $query->condition('nd.type', 'blog');
    $query->condition('nd.langcode', $lang);
    $query->condition($or);
    $query->orderBy('date.field_publication_date_value', 'DESC');
    $results = $query->execute();

    $langCodes = \Drupal::languageManager()->getLanguages();
    $langCodesList = array_keys($langCodes);
    $existingRecords = [];
    foreach ($results as $blog) {
      if(in_array($blog->uuid, $existingRecords)) continue;
      $existingRecords[] = $blog->uuid;

      $path = [];
      foreach ($langCodesList as $langCode) {
        $path[$langCode] = \Drupal::service('path_alias.manager')->getAliasByPath('/node/' . $blog->nid, $langCode);
      }
      $dateTime = new DrupalDateTime($blog->field_publication_date);
      $date = $dateTime->format('d') . ' de [' . $dateTime->format('m') . '] de ' . $dateTime->format('Y');
      $result[] = [
        "id" => $blog->uuid,
        "title" => $blog->title,
        "field_summary" => $blog->body_summary,
        "field_publication_date" => $date,
        "field_tags_value" => $blog->name,
        "field_author" => $blog->author,
        "field_image_value" => !empty($blog->desktop) ? \Drupal::service('file_url_generator')->generateAbsoluteString($blog->desktop) : '',
        "field_mobile_image_value" => !empty($blog->mobile) ? \Drupal::service('file_url_generator')->generateAbsoluteString($blog->mobile) : '',
        "path" => $path,
      ];
    }
    return $result;
  }

  /**
   * Get render requests.
   *
   * @return array
   *   Renderable table array.
   */
  public function render() {
    $mecuryConfigs = \Drupal::config('example.settings');
    $token = $mecuryConfigs->get('deploy_request_token');
    $account = $mecuryConfigs->get('deploy_request_num_account');
    $env = $mecuryConfigs->get('deploy_request_env');
    $client = new Client();
    $json = $client->post("https://gitlab.com/api/v4/projects/$account/trigger/pipeline?token=$token&ref=$env")->getBody()->getContents();
    \Drupal::messenger()->addMessage('Despliegue iniciado exitosamente. espere un momento para ver los cambios en su sitio');
    return $this->redirect('<front>');
  }

}
