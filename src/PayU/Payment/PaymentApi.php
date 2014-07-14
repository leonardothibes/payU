<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Payment;

use \PayU\Api\ApiAbstract;

/**
 * Payent api class.
 *
 * @package PayU\Payment
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PaymentApi extends ApiAbstract
{
	/**
	 * Payment api url for production.
	 * @var string
	 */
	protected $apiUrlProduction = 'https://api.payulatam.com/payments-api/%s/service.cgi';

	/**
	 * Payment api url for staging.
	 * @var string
	 */
	protected $apiUrlStaging = 'https://stg.api.payulatam.com/payments-api/%s/service.cgi';

	/**
	 * Ping request for service health.
	 * @return bool
	 */
	public function ping()
	{
		$json     = '{"command": "PING"}';
		$json     = $this->addMetadata($json);
		$response = $this->curlRequest($json);
		return ($response->code == 'SUCCESS');
	}
}
