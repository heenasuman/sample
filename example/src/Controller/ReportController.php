<?php

namespace Drupal\example\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Report controller.
 */
class ReportController extends ControllerBase {

  /**
   * Report generator for subscription.
   */
  public function subscriptionsCsv() {
    ini_set('memory_limit', '5048M');
    set_time_limit(10000);
    $file_name = 'subscription_report_' . date('Y_m_d_H_i_s') . '.csv';
    $report_form = new PageController();
    return $report_form->exportDataOnfile($report_form->reportGenerator('getHeader', 'generateReportData'), $file_name);
  }

  /**
   * Report generator for contact requests.
   */
  public function contactRequestsCsv() {
    ini_set('memory_limit', '5048M');
    set_time_limit(10000);
    $file_name = 'subscription_report_' . date('Y_m_d_H_i_s') . '.csv';
    $report_form = new PageController();
    return $report_form->exportDataOnfile($report_form->reportGenerator('getContactHeader', 'generateContactReportData'), $file_name);
  }

}
