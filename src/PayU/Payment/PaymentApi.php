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

use \SimpleXMLElement;
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
     * Compute signature of order
     * 
     * @param string $referenceCode
     * @param stirng $tx_value
     * @param string $currency
     * 
     * @return string
     */
    private function computeSignature($referenceCode, $tx_value, $currency)
    {
    	$signature = sprintf(
    		'%s~%s~%s~%s~%s',
    		$this->credentials->getApiKey(),
    		$this->credentials->getMerchantId(),
    		$referenceCode,
    		$tx_value,
    		$currency
    	);
    	return sha1($signature);
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
        $request       = $requestEntity->setCommand('SUBMIT_TRANSACTION')
                                       ->setMerchant($this->credentials)
                                       ->setTransaction($transaction)
                                       ->setIsTest($this->isStaging);

        //Order signature.
        $order            = $transaction->getOrder();
        $additionalValues = $order->getAdditionalValues()->toArray();
        $tx_value         = $additionalValues[0]['additionalValue']['value'];
        $currency         = $additionalValues[0]['additionalValue']['currency'];
        $signature        = $this->computeSignature($order->getReferenceCode(), $tx_value, $currency);
        //Order signature.
        
        $xmlRequest = new SimpleXMLElement('<request />');
        
        $xmlRequest->addChild('language', $request->getLanguage());
        $xmlRequest->addChild('command', $request->getCommand());
        $xmlRequest->addChild('isTest', ($request->getIsTest() ? 'true' : 'false'));
        
        $merchant = $xmlRequest->addChild('merchant');
        $merchant->addChild('apiLogin', $request->getMerchant()->getApiLogin());
        $merchant->addChild('apiKey', $request->getMerchant()->getApiKey());
        
        $xmlTransaction = $xmlRequest->addChild('transaction');
        $xmlTransaction->addChild('type', $transaction->getType());
        $xmlTransaction->addChild('paymentMethod', $transaction->getPaymentMethod());
        $xmlTransaction->addChild('paymentCountry', $transaction->getPaymentCountry());
        $xmlTransaction->addChild('ipAddress', $transaction->getIpAddress());
        $xmlTransaction->addChild('cookie', $transaction->getCookie());
        $xmlTransaction->addChild('userAgent', $transaction->getUserAgent());
        
        $creditCard    = $transaction->getCreditCard();
        $xmlCreditCard = $xmlTransaction->addChild('creditCard');
        $xmlCreditCard->addChild('number', $creditCard->getNumber());
        $xmlCreditCard->addChild('securityCode', $creditCard->getSecurityCode());
        $xmlCreditCard->addChild('expirationDate', $creditCard->getExpirationDate());
        $xmlCreditCard->addChild('name', $creditCard->getName());
        
        $payer    = $transaction->getPayer();
        $xmlPayer = $xmlTransaction->addChild('payer');
        $xmlPayer->addChild('fullName', $payer->getFullName());
        $xmlPayer->addChild('emailAddress', $payer->getEmailAddress());
        
        $order    = $transaction->getOrder();
        $xmlOrder = $xmlTransaction->addChild('order');
        $xmlOrder->addChild('accountId', $request->getMerchant()->getAccountId());
        $xmlOrder->addChild('referenceCode', $order->getReferenceCode());
        $xmlOrder->addChild('description', $order->getDescription());
        $xmlOrder->addChild('language', $order->getLanguage());
        $xmlOrder->addChild('notifyUrl', $order->getNotifyUrl());
        $xmlOrder->addChild('signature', $signature);
        
        $shippingAddress    = $order->getShippingAddress();
        $xmlShippingAddress = $xmlOrder->addChild('shippingAddress');
        $xmlShippingAddress->addChild('street1', $shippingAddress->getStreet1());
        $xmlShippingAddress->addChild('street2', $shippingAddress->getStreet2());
        $xmlShippingAddress->addChild('city', $shippingAddress->getCity());
        $xmlShippingAddress->addChild('state', $shippingAddress->getState());
        $xmlShippingAddress->addChild('country', $shippingAddress->getCountry());
        $xmlShippingAddress->addChild('postalCode', $shippingAddress->getPostalCode());
        $xmlShippingAddress->addChild('phone', $shippingAddress->getPhone());
                
        $buyer    = $order->getBuyer();
        $xmlBuyer = $xmlOrder->addChild('buyer');
        $xmlBuyer->addChild('fullName', $buyer->getFullName());
        $xmlBuyer->addChild('emailAddress', $buyer->getEmailAddress());
        $xmlBuyer->addChild('dniNumber', $buyer->getDniNumber());
        
        $xmlBuyerShippingAddress = $xmlBuyer->addChild('shippingAddress');
        $xmlBuyerShippingAddress->addChild('street1', $shippingAddress->getStreet1());
        $xmlBuyerShippingAddress->addChild('street2', $shippingAddress->getStreet2());
        $xmlBuyerShippingAddress->addChild('city', $shippingAddress->getCity());
        $xmlBuyerShippingAddress->addChild('state', $shippingAddress->getState());
        $xmlBuyerShippingAddress->addChild('country', $shippingAddress->getCountry());
        $xmlBuyerShippingAddress->addChild('postalCode', $shippingAddress->getPostalCode());
        $xmlBuyerShippingAddress->addChild('phone', $shippingAddress->getPhone());
        
        $additionalValues    = $order->getAdditionalValues()->toArray();
        $xmlAdditionalValues = $xmlOrder->addChild('additionalValues');
        $entry = $xmlAdditionalValues->addChild('entry');
        $entry->addChild('string', $additionalValues[0]['string']);
        $additionalValue = $entry->addChild('additionalValue');
        $additionalValue->addChild('currency', $additionalValues[0]['additionalValue']['currency']);
        $additionalValue->addChild('value', $additionalValues[0]['additionalValue']['value']);
        
        $extraParameters    = $transaction->getExtraParameters()->toArray();
        $xmlExtraParameters = $xmlTransaction->addChild('extraParameters');
        if (count($extraParameters) > 0) {
        	foreach ($extraParameters as $label => $value) {
        		$entry  = $xmlExtraParameters->addChild('entry');
        		$entry->addChild('string', $label);
        		$entry->addChild('string', $value);
        	}
        }
        
        return $this->curlRequestXml(
        	$xmlRequest->asXML()
        );
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
