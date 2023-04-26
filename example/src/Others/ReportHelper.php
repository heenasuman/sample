<?php

namespace Drupal\example\Others;

use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Report helper class.
 */
trait ReportHelper {
  /**
   * The file object.
   *
   * @var object
   */
  protected $file;

  /**
   * The file path.
   *
   * @var string
   */
  protected $filepath;

  /**
   * Data export callback.
   *
   * @param mixed $generator
   *   Generator service.
   * @param string $file_name
   *   Name of the file.
   *
   * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
   *   Export data on file
   */
  public function exportDataOnfile($generator, $file_name) {
    while ($generator->valid()) {
      $generator->next();
    }

    $this->closeOutputStream();

    $contentTypes = [
      'csv' => 'application/csv',
      'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ];

    preg_match('/(?:.csv|.xlsx)/i', $file_name, $parts);

    if (!$parts[0]) {
      $this->filename = $file_name . '.csv';
      $content_type = $contentTypes['csv'];
    }
    else {
      $content_type = $contentTypes[trim(strtolower($parts[0]), '.')];
    }

    $headers = [
      'Content-Type' => $content_type,
      'Content-Disposition' => 'attachment; filename=' . $file_name,
    ];
    return new BinaryFileResponse($this->filepath, 200, $headers, FALSE);
  }

  /**
   * Open output stream.
   */
  protected function openOutputStream() {
    $temp_dir = sys_get_temp_dir();
    $this->filepath = tempnam($temp_dir, "ab_php_exporter_");
    $this->file = fopen($this->filepath, 'w');
  }

  /**
   * Close output stream.
   */
  protected function closeOutputStream() {
    fclose($this->file);
  }

}
