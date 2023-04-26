<?php

namespace Drupal\example;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Database\Connection;
use Drupal\Core\File\FileUrlGeneratorInterface;

/**
 * Service for ES Mecury.
 */
class AppRepository {
  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * The file service.
   *
   * @var \Drupal\Core\File\FileUrlGeneratorInterface
   */
  protected $file;

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  public $config;

  /**
   * Dependency object.
   *
   * @param \Drupal\Core\Database\Connection $connection
   *   The database connection.
   * @param \Drupal\Core\File\FileUrlGeneratorInterface $fileUrlGenerator
   *   File generator service.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config
   *   The config factory.
   */
  public function __construct(
    Connection $connection,
    FileUrlGeneratorInterface $fileUrlGenerator,
    ConfigFactoryInterface $config
  ) {
    $this->connection = $connection;
    $this->file = $fileUrlGenerator;
    $this->config = $config->get('example.settings');
  }

  /**
   * Get database connection.
   *
   * @return \Drupal\Core\Database\Connection
   *   Connection object.
   */
  public function getConnection() {
    return $this->connection;
  }

  /**
   * Generate file url from uri.
   *
   * @param string $uri
   *   URI of image.
   *
   * @return string
   *   Absolute file url.
   */
  public function getFileUrlFromUri($uri) {
    return $this->file->generateAbsoluteString($uri);
  }

  /**
   * Get records callback.
   *
   * @param string $tableName
   *   Table name to fetch records.
   * @param array $columns
   *   Columns to return.
   * @param array $where
   *   Where condition.
   * @param int|null $limit
   *   Limit of records to return.
   * @param bool $executeObj
   *   TRUE if needed executable object, false otherwise.
   *
   * @return array|mixed
   *   Returns results array or object.
   */
  public function getRecordsFromTable($tableName, array $columns = [], array $where = [], $limit = NULL, $executeObj = FALSE) {
    try {
      $select = $this->connection->select($tableName, 't');
      $select->fields('t', $columns);
      if (!empty($where)) {
        foreach ($where as $colName => $colValue) {
          $select->condition($colName, $colValue, '=');
        }
      }

      if ($limit) {
        $select->range(0, $limit);
      }

      if ($executeObj) {
        return $select->execute();
      }
      else {
        return $select->execute()->fetchAll();
      }

    }
    catch (\Exception $e) {
      \Drupal::logger(__FUNCTION__)->error($e->getMessage());
    }
    return NULL;
  }

  /**
   * Insert callback.
   *
   * @param string $tableName
   *   Name of table to insert results.
   * @param array $data
   *   Data to be insert in table.
   *
   * @return bool|null
   *   TRUE if insertion successful, Null otherwise.
   */
  public function insertRecordsToTable($tableName, array $data) {
    $transaction = $this->getConnection()->startTransaction($tableName . '_insert');
    try {
      $select = $this->connection->insert($tableName);
      $select->fields($data);
      $select->execute();
      return TRUE;
    }
    catch (\Exception $e) {
      $transaction->rollBack();
      \Drupal::logger(__FUNCTION__)->error($e->getMessage());
    }
    return NULL;
  }

  /**
   * Update subscription status callback.
   *
   * @param string $email
   *   Email for activation.
   *
   * @return bool|null
   *   TRUE if insertion successful, Null otherwise.
   */
  public function updateSubscription(string $email) {
    $transaction = $this->getConnection()->startTransaction('es_mecury_subscriptions_update');
    try {
      $select = $this->connection->update('es_mecury_subscriptions');
      $select->fields(['status' => 1]);
      $select->condition('email', $email);
      $select->execute();
      return TRUE;
    }
    catch (\Exception $e) {
      $transaction->rollBack();
      \Drupal::logger(__FUNCTION__)->error($e->getMessage());
    }
    return NULL;
  }

}
