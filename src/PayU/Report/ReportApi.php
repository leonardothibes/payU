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
     *
     * @param  string $command
     * @return ReportApi
     */
    protected function buildXmlObject($command)
    {
        $this->xmlRequest->addChild('language', $this->language);
        $this->xmlRequest->addChild('command', $command);
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
     * Get order details by order id.
     *
     * @param  string $orderId
     * @return stdClass
     */
    public function fetchByOrderId($orderId)
    {
        try {
            $this->buildXmlObject('ORDER_DETAIL');
            $this->addOrderId($orderId);
            return $this->curlRequestXml(
                $this->xmlRequest->asXML()
            );
        } catch (Exception $e) {
            throw new ReportException($e->getMessage());
        }
    }

    /**
     * Add reference code to XML object.
     *
     * @param  string $referenceCode
     * @return ReportApi
     */
    protected function addReferenceCode($referenceCode)
    {
        $entry  = $this->xmlRequest->details->addChild('entry');
        $string = $entry->addChild('string', 'referenceCode');
        $object = $entry->addChild('object', $referenceCode);
        $object->addAttribute('class', 'java.lang.String');
        return $this;
    }

    /**
     * Get order details by reference code.
     *
     * FIXME: Está fazendo "like" ao invés de "=".
     *
     * @param  string $referenceCode
     * @return stdClass
     */
    public function fetchByReferenceCode($referenceCode)
    {
        try {
            $this->buildXmlObject('ORDER_DETAIL_BY_REFERENCE_CODE');
            $this->addReferenceCode($referenceCode);
            return $this->curlRequestXml(
                $this->xmlRequest->asXML()
            );
        } catch (Exception $e) {
            throw new ReportException($e->getMessage());
        }
    }

    /**
     * Add transaction id to XML object.
     *
     * @param  string $transactionId
     * @return ReportApi
     */
    protected function addTransactionId($transactionId)
    {
        $entry  = $this->xmlRequest->details->addChild('entry');
        $string = $entry->addChild('string', 'transactionId');
        $object = $entry->addChild('object', $transactionId);
        $object->addAttribute('class', 'java.lang.String');
        return $this;
    }

    /**
     * Get order details by transaction id.
     *
     * @param  string $transactionId
     * @return stdClass
     */
    public function fetchByTransactionId($transactionId)
    {
        try {
            $this->buildXmlObject('TRANSACTION_RESPONSE_DETAIL');
            $this->addTransactionId($transactionId);
            $response = $this->curlRequestXml(
                $this->xmlRequest->asXML()
            );
            if ($response->code == 'SUCCESS' and $response->result == '') {
                $message = sprintf('Entity [Order] Not Found with TransactionId [%d].', $transactionId);
                throw new ReportException($message);
            }
            return $response;
        } catch (Exception $e) {
            throw new ReportException($e->getMessage());
        }
    }
}
