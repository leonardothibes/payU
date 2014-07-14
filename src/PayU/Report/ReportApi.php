<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Report;

use \PayU\Api\ApiAbstract;

/**
 * Report api class.
 *
 * @package PayU\Report
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class ReportApi extends ApiAbstract
{
    /**
     * Report api url for production.
     * @var string
     */
    protected $apiUrlProduction = 'https://api.payulatam.com/reports-api/%s/service.cgi';

    /**
     * Report api url for staging.
     * @var string
     */
    protected $apiUrlStaging = 'https://stg.api.payulatam.com/reports-api/%s/service.cgi';
}
