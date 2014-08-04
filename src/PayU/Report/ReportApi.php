<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Report;

use \PayU\Report\ReportException;
use \PayU\Api\ApiAbstract;
use \PayU\Api\ApiStatus;

use \SimpleXMLElement;
use \Exception;
use \stdClass;

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

    /**
     * Ping request for service health.
     *
     * @return bool
     * @throws ReportException
     */
    public function ping()
    {
    	try {
    		$json     = '{"command": "PING"}';
    		$json     = $this->addMetadata($json);
    		$response = $this->curlRequest($json);
    		return ($response->code == ApiStatus::SUCCESS);
    	} catch (Exception $e) {
    		throw new ReportException($e->getMessage(), $e->getCode());
    	}
    }

    /**
     * Build base xml object for api request.
     * @return ReportApi
     */
    protected function buildXmlObject()
    {
    	$this->xmlRequest->addChild('language', $this->language);
    	$this->xmlRequest->addChild('command', 'ORDER_DETAIL');
    	$this->xmlRequest->addChild('isTest', ($this->isStaging() ? 'true' : 'false'));

    	$merchant = $this->xmlRequest->addChild('merchant');
    	$merchant->addChild('apiLogin', $this->getCredentials()->getApiLogin());
    	$merchant->addChild('apiKey', $this->getCredentials()->getApiKey());

    	$details = $this->xmlRequest->addChild('details');
    	$details->addAttribute('class', 'java.util.HashMap');

    	return $this;
    }

    /**
     * Add order ids to XML object.
     *
     * @param  string $orderId
     * @return ReportApi
     */
    protected function addOrderId($orderId)
    {
    	$entry  = $this->xmlRequest->details->addChild('entry');
    	$string = $entry->addChild('string', 'orderId');
    	$object = $entry->addChild('object', $orderId);
    	$object->addAttribute('class', 'java.lang.Integer');
    	return $this;
    }

    /**
     * Query one order.
     *
     * @param  string $orderId
     * @return stdClass
     */
    public function fetchByOrderId($orderId)
    {
    	return $this->fetchMultipleByOrderId(array($orderId));
    }

    /**
     * List multiple orders.
     *
     * @param  array $orderIds
     * @return array
     * @throws ReportException
     */
    public function fetchMultipleByOrderId(array $orderIds)
    {
    	try {
    		$this->buildXmlObject();
    		foreach ($orderIds as $orderId) {
    			$this->addOrderId($orderId);
    		}
    		return $this->curlRequestXml(
    				$this->xmlRequest->asXML()
    		);
    	} catch (Exception $e) {
    		throw new ReportException($e->getMessage());
    	}
    }
}
