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
    protected $apiUrlProduction = 'https://api.payulatam.com/payments-api/4.0/service.cgi';

    /**
     * Payment api url for staging.
     * @var string
     */
    protected $apiUrlStaging = 'https://stg.api.payulatam.com/payments-api/4.0/service.cgi';

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
     * Compute signature of order.
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
     * Compute the device session id.
     * @return string
     */
    private function computeDeviceSessionId()
    {
        return md5(session_id().microtime());
    }

    /**
     * Make a request "authorize" and "authorizeAndCapture" methods.
     *
     * @param  TransactionEntity $transaction
     * @return stdClass
     */
    private function authorizeRequest(TransactionEntity $transaction)
    {
        $requestEntity = new RequestEntity();
        $request       = $requestEntity->setCommand('SUBMIT_TRANSACTION')
                                       ->setMerchant($this->credentials)
                                       ->setTransaction($transaction)
                                       ->setIsTest($this->isStaging);

        $this->xmlRequest->addChild('language', $request->getLanguage());
        $this->xmlRequest->addChild('command', $request->getCommand());
        $this->xmlRequest->addChild('isTest', ($request->getIsTest() ? 'true' : 'false'));

        $merchant = $this->xmlRequest->addChild('merchant');
        $merchant->addChild('apiLogin', $request->getMerchant()->getApiLogin());
        $merchant->addChild('apiKey', $request->getMerchant()->getApiKey());

        $xmlTransaction = $this->xmlRequest->addChild('transaction');
        $xmlTransaction->addChild('type', $transaction->getType());
        $xmlTransaction->addChild('paymentMethod', $transaction->getPaymentMethod());
        $xmlTransaction->addChild('paymentCountry', $transaction->getPaymentCountry());
        $xmlTransaction->addChild('ipAddress', $transaction->getIpAddress());
        $xmlTransaction->addChild('cookie', $transaction->getCookie());
        $xmlTransaction->addChild('userAgent', $transaction->getUserAgent());
        $xmlTransaction->addChild('deviceSessionId', $this->computeDeviceSessionId());

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

        //Order signature.
        $additionalValues = $order->getAdditionalValues()->toArray();
        $tx_value         = $additionalValues[0]['additionalValue']['value'];
        $currency         = $additionalValues[0]['additionalValue']['currency'];
        $signature        = $this->computeSignature($order->getReferenceCode(), $tx_value, $currency);
        $xmlOrder->addChild('signature', $signature);
        //Order signature.

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

        $response = $this->curlRequestXml(
            $this->xmlRequest->asXML()
        );

        $this->resetRequest();
        return $response;
    }

    /**
     * Authorize a payment order.
     *
     * @param  TransactionEntity $transaction
     * @return stdClass
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
     * @return stdClass
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
        trigger_error('Not implemented, yet...');
    }

    /**
     * Cancel the transaction and no money is charged from the buyer.
     *
     * @param int    $orderId     Order ideentification of payU
     * @param string $transaction PayU transaction identification.
     *
     * @return stdClass
     */
    public function refund($orderId, $transaction)
    {
        $this->xmlRequest->addChild('language', $this->language);
        $this->xmlRequest->addChild('command', 'SUBMIT_TRANSACTION');
        $this->xmlRequest->addChild('isTest', ($this->isStaging ? 'true' : 'false'));

        $merchant = $this->xmlRequest->addChild('merchant');
        $merchant->addChild('apiLogin', $this->credentials->getApiLogin());
        $merchant->addChild('apiKey', $this->credentials->getApiKey());

        $xmlTransaction = $this->xmlRequest->addChild('transaction');
        $xmlTransaction->addChild('type', PaymentTypes::REFUND);
        $xmlTransaction->addChild('parentTransactionId', $transaction);

        $order = $xmlTransaction->addChild('order');
        $order->addChild('id', $orderId);

        $respose = $this->curlRequestXml(
            $this->xmlRequest->asXML()
        );

        $this->resetRequest();
        return $respose;
    }
}
