<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Payment;

use \PayU\Payment\PaymentException;
use \PayU\Api\ApiAbstract;
use \PayU\Api\ApiStatus;

use \PayU\Payment\PaymentTypes;
use \PayU\Entity\RequestEntity;
use \PayU\Entity\Transaction\TransactionEntity;

use \Exception;
use \stdClass;

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
     *
     * @return bool
     * @throws PaymentException
     */
    public function ping()
    {
        try {
            $json     = '{"command": "PING"}';
            $json     = $this->addMetadata($json);
            $response = $this->curlRequest($json);
            return ($response->code == ApiStatus::SUCCESS);
        } catch (Exception $e) {
            throw new PaymentException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * List all payment methods accepted by country configuration.
     *
     * @return array
     * @throws PaymentException
     */
    public function paymentMethods()
    {
        try {
            $json     = '{"command": "GET_PAYMENT_METHODS"}';
            $json     = $this->addMetadata($json);
            $response = $this->curlRequest($json);
            return $response->paymentMethods;
        } catch (Exception $e) {
            throw new PaymentException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Make a request "authorize" and "authorizeAndCapture" methods.
     *
     * @param  TransactionEntity $transaction
     * @return ResponseEntity
     */
    private function authorizeRequest(TransactionEntity $transaction)
    {
    	$requestEntity = new RequestEntity();
    	$request       = $requestEntity->setTransaction($transaction)->toArray();
    	$request['command'] = 'SUBMIT_TRANSACTION';
        $json               = json_encode($request);
        $json               = $this->addMetadata($json);

        \Tbs\Log::debug($json);

        return $this->curlRequest($json);
    }

    /**
     * Authorize a payment order.
     *
     * @param  TransactionEntity $transaction
     * @return ResponseEntity
     */
    public function authorize(TransactionEntity $transaction)
    {
    	$transaction->setType(PaymentTypes::AUTHORIZATION);
        return $this->authorizeRequest($transaction);
    }

    /**
     * Authorize and capture a payment order.
     *
     * @param  TransactionEntity $transaction
     * @return ResponseEntity
     */
    public function authorizeAndCapture(TransactionEntity $transaction)
    {
    	$transaction->setType(PaymentTypes::AUTHORIZATION_AND_CAPTURE);
        return $this->authorizeRequest($transaction);
    }

    /**
     * Capture an payment.
     */
    public function capture()
    {
    }

    /**
     * Cancel the transaction and no money is charged from the buyer.
     */
    public function void()
    {
    }
}
