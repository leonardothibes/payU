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
    //private function authorizeRequest(TransactionEntity $transaction)
    private function authorizeRequest()
    {
        /*$requestEntity      = new RequestEntity();
        $request            = $requestEntity->setTransaction($transaction)->toArray();
        $request['command'] = 'SUBMIT_TRANSACTION';*/

        //Order signature.
        //$order            = $transaction->getOrder();
        //$additionalValues = $order->getAdditionalValues()->toArray();
        
        //\Tbs\Log::debug($additionalValues);
        
        /*$signature = sprintf(
            '%s~%s~%s~%s~%s',
            $this->credentials->getApiKey(),
            $this->credentials->getMerchantId(),
            $order->getReferenceCode(),
            $additionalValues['TX_TAX']['value'],
            $additionalValues['TX_TAX']['currency']
        );
        $signature = sha1($signature);
        \Tbs\Log::debug($signature);*/
        //$order->setSignature($signature);
        //Order signature.

        //$json               = json_encode($request);
        //$json               = $this->addMetadata($json);

        //\Tbs\Log::debug($json);
        
        $xml = '
<request>

	<language>en</language>
	<command>SUBMIT_TRANSACTION</command>
	<isTest>true</isTest>
	
	<merchant>
		<apiLogin>11959c415b33d0c</apiLogin>
		<apiKey>6u39nqhq8ftd0hlvnjfs66eh8c</apiKey>
	</merchant>
	
	<transaction>
	
		<type>AUTHORIZATION_AND_CAPTURE</type>
        <paymentMethod>VISA</paymentMethod>
        <paymentCountry>PA</paymentCountry>
        
        <ipAddress>127.0.0.1</ipAddress>
        <cookie>cookie_52278879710130</cookie>
        <userAgent>Firefox</userAgent>
		
		<order>
		
			<accountId>500537</accountId>
			<referenceCode>testPanama1</referenceCode>
			<description>Test order Panama</description>
			<language>en</language>
			<notifyUrl>http://pruebaslap.xtrweb.com/lap/pruebconf.php</notifyUrl>
			<signature>bdedc9902977ac9eafb232444e37d51189cf9c0d</signature>
			
			<shippingAddress>
		      	<street1>Calle 93 B 17 – 25</street1>
                <city>Panama</city>
                <state>Panama</state>
                <country>PA</country>
                <postalCode>000000</postalCode>
                <phone>5582254</phone>
			</shippingAddress>
			
			<buyer>
				<fullName>José Pérez</fullName>
				<emailAddress>test@payulatam.com</emailAddress>
				<dniNumber>1155255887</dniNumber>
				
				<shippingAddress>
					<street1>Calle 93 B 17 – 25</street1>
					<city>Panama</city>
					<state>Panama</state>
					<country>PA</country>
					<postalCode>000000</postalCode>
					<phone>5582254</phone>
				</shippingAddress>
				
			</buyer>
			
			<additionalValues>
				<entry>
					<string>TX_VALUE</string>
					<additionalValue>
						<value>5</value>
						<currency>USD</currency>
					</additionalValue>
				</entry>
			</additionalValues>
			
		</order>
		
		<creditCard>
			<number>4111111111111111</number>
			<securityCode>123</securityCode>
			<expirationDate>2018/08</expirationDate>
			<name>Test</name>
		</creditCard>
		
		<payer>
			<fullName>José Pérez</fullName>
			<emailAddress>test@payulatam.com</emailAddress>
		</payer>
		
		<extraParameters>
			<entry>
				<string>RESPONSE_URL</string>
				<string>http://www.misitioweb.com/respuesta.php</string>
			</entry>
			<entry>
				<string>INSTALLMENTS_NUMBER</string>
				<string>1</string>
			</entry>
		</extraParameters>
		
	</transaction>
	
</request>
        ';

        return $this->curlRequestXml($xml);
    }

    /**
     * Authorize a payment order.
     *
     * @param  TransactionEntity $transaction
     * @return ResponseEntity
     */
    /*public function authorize(TransactionEntity $transaction)
    {
        $transaction->setType(PaymentTypes::AUTHORIZATION);
        return $this->authorizeRequest($transaction);
    }*/
    public function authorize()
    {
    	return $this->authorizeRequest();
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
