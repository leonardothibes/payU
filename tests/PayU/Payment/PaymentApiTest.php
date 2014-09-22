<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Payment;

use \PayU\Payment\PaymentApi;
use \PayU\Payment\PaymentTypes;
use \PayU\Payment\PaymentMethods;
use \PayU\Payment\PaymentCountries;

use \PayU\Entity\Transaction\TransactionEntity;
use \PayU\Entity\Transaction\ShippingAddressEntity;
use \PayU\Merchant\MerchantCredentials;

use \Tbs\Helper\Cpf;
use \stdClass;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PaymentApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaymentApi
     */
    protected $object = null;

    /**
     * @var MerchantCredentials
     */
    protected $credentials = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->credentials = MerchantCredentials::getInstance();
    	$this->credentials->setAccountId(PAYU_ACCOUNT_ID)
    	                  ->setMerchantId(PAYU_MERCHANT_ID)
    	                  ->setApiLogin(PAYU_API_LOGIN)
    					  ->setApiKey(PAYU_API_KEY);
    	$this->object = new PaymentApi($this->credentials);
    	$this->object->setStaging();
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	$this->credentials->resetInstance();
    	unset($this->object, $this->credentials);
    }

    /**
     * @see ApiAbstract::getApiUrl()
     */
    public function testGetApiUrlCredentialOverride()
    {
    	$apiUrl = 'http://apiurl.com';
    	$this->credentials->setApiUrl($apiUrl);

    	$rs = $this->object->getApiUrl();
    	$this->assertInternalType('string', $rs);
    }

    /**
     * @see ApiAbstract::getApiUrl()
     */
    public function testGetApiUrlInStaging()
    {
    	$rs = $this->object->setStaging(true)->getApiUrl();
    	$this->assertEquals('https://stg.api.payulatam.com/payments-api/4.0/service.cgi', $rs);
    }

    /**
     * @see ApiAbstract::getApiUrl()
     */
    public function testGetApiUrlInProduction()
    {
    	$rs = $this->object->setStaging(false)->getApiUrl();
    	$this->assertEquals('https://api.payulatam.com/payments-api/4.0/service.cgi', $rs);
    }

    /**
     * @see PaymentApi::getHtml()
     */
    public function testGetHtml()
    {
    	$id = PaymentApi::getDeviceSessionId();
    	$rs = $this->object->getHtml($id);

    	$deviceSessionId = $id . PaymentApi::USER_ID;
    	$position        = strpos($rs, $deviceSessionId);

    	$this->assertGreaterThan(0, $position);
    }

	/**
	 * @see PaymentApi::ping()
	 */
    public function testPing()
    {
    	$rs = $this->object->ping();
    	$this->assertInternalType('bool', $rs);
    	$this->assertTrue($rs);
    }

    /**
     * @see PaymentApi::ping()
     */
    public function testPingWrongCredentials()
    {
    	try {
    		$this->credentials->setApiLogin('wrong-login')
    		                  ->setApiKey('wrong-key');
    		$rs = $this->object->ping();
    	} catch (\Exception $e) {
    		$this->assertInstanceOf('\PayU\PayUException', $e);
    		$this->assertEquals('Invalid credentials', $e->getMessage());
    		$this->assertEquals(0, $e->getCode());
    	}
    }

    /**
     * @see PaymentApi::paymentMethods()
     */
    public function testPaymentMethods()
    {
    	$rs = $this->object->paymentMethods();

    	$this->assertInternalType('array', $rs);
    	$this->assertGreaterThan(0, count($rs));

    	foreach ($rs as $paymentMethod) {

    		$this->assertInstanceOf('\stdClass', $paymentMethod);

    		$this->assertTrue(isset($paymentMethod->id));
    		$this->assertTrue(is_numeric($paymentMethod->id));

    		$this->assertTrue(isset($paymentMethod->description));
    		$this->assertGreaterThan(0, strlen($paymentMethod->description));

    		$this->assertTrue(isset($paymentMethod->country));
    		$this->assertEquals(2, strlen($paymentMethod->country));
    	}
    }

    /**
     * @see PaymentApi::paymentMethods()
     */
    public function testPaymentMethodsWrongCredentials()
    {
    	try {
    		$this->credentials->setApiLogin('wrong-login')
    	                      ->setApiKey('wrong-key');
    		$rs = $this->object->paymentMethods();
    	} catch (\Exception $e) {
    		$this->assertInstanceOf('\PayU\PayUException', $e);
    		$this->assertEquals('Invalid credentials', $e->getMessage());
    		$this->assertEquals(0, $e->getCode());
    	}
    }

	/**
	 * Provides a OK data to test authorization and capture.
	 * @return array
	 */
    public function providerMockTransaction()
    {
    	$transaction = new TransactionEntity();

    	//Transaction.
    	$ipAddress = rand(1,254) . '.' . rand(1,254) . '.' . rand(1,254) . '.' . rand(1,254);
    	$cookie    = 'cookie_' . md5(rand(1000, 2000));

    	$browsers = array(
    			'Safari',
    			'Chrome',
    			'Firefox',
    			'Opera',
    			'IE'
    	);
    	$userAgent = $browsers[rand(0, count($browsers)-1)];

    	$transaction->setPaymentMethod(PaymentMethods::VISA)
    	            ->setPaymentCountry(PaymentCountries::PANAMA)
    	            ->setIpAddress($ipAddress)
    	            ->setCookie($cookie)
    	            ->setUserAgent($userAgent);
    	//Transaction.

    	//Shipping address.
    	$shippingAddress = new ShippingAddressEntity();
    	$shippingAddress->setStreet1('street1_' . rand(1,1000))
				    	->setStreet2('street2_' . rand(1,1000))
				    	->setCity('city_' . rand(1,1000))
				    	->setState('state_' . rand(1,1000))
				    	->setCountry(PaymentCountries::PANAMA)
				    	->setPostalCode('postalCode_' . rand(1,1000))
				    	->setPhone('phone_' . rand(1,1000));
    	//Shipping address.

    	//Order.
    	$order = $transaction->getOrder();
    	$order->setAccountId('accountId_' . rand(1,9) . rand(1,9) . rand(1,9))
    	      ->setReferenceCode('referenceCode_' . rand(1,9) . rand(1,9) . rand(1,9))
    	      ->setDescription('description_' . rand(1,9) . rand(1,9) . rand(1,9))
    	      ->setLanguage('en')
    	      ->setNotifyUrl('http://notifyurl-' . rand(1,9) . rand(1,9) . rand(1,9) . '.com')
    	      ->setSignature(sha1('signature'))
    	      ->setShippingAddress($shippingAddress);
    	//Order.

    	//Buyer.
    	$buyer = $order->getBuyer();
    	$buyer->setFullName('person name ' . rand(1,9) . rand(1,9) . rand(1,9))
    	      ->setEmailAddress('email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com')
    	      ->setDniNumber(Cpf::random())
    	      ->setShippingAddress($shippingAddress);
    	//Buyer.

    	//Additional values.
    	$additionalValues = $order->getAdditionalValues();
    	$additionalValues->addTax('TX_VALUE', 'USD', 100);
    	//Additional values.

    	//Credit card.
    	$creditCard = $transaction->getCreditCard();
    	$creditCard->setNumber('4111111111111111')
    	           ->setSecurityCode(rand(1,9) . rand(1,9) . rand(1,9))
    	           ->setExpirationDate(rand(2015,2020) . '/' . rand(10,12))
                   ->setName('person name ' . rand(1,9) . rand(1,9) . rand(1,9));
    	//Credit card.

    	//Payer.
    	$payer = $transaction->getPayer();
    	$payer->setFullName('person name ' . rand(1,9) . rand(1,9) . rand(1,9))
    	      ->setEmailAddress('email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com');
    	//Payer.

    	return array(
    		array($transaction)
    	);
    }

    /**
     * Verify transaction response.
     * @param stdClass $response
     */
    private function _testTransactionResponse($response)
    {
    	$this->assertInstanceOf('\stdClass', $response);
    	$this->assertTrue(isset($response->code));
    	$this->assertEquals(0, strlen($response->error));

    	$this->assertTrue(isset($response->transactionResponse));
    	$this->assertInstanceOf('\stdClass', $response->transactionResponse);

    	$transaction = $response->transactionResponse;

    	$this->assertTrue(isset($response->transactionResponse->orderId));
    	$this->assertTrue(isset($response->transactionResponse->transactionId));
    	$this->assertTrue(isset($response->transactionResponse->state));
    	$this->assertTrue(isset($response->transactionResponse->responseCode));

    	$this->assertEquals(0, strlen($transaction->paymentNetworkResponseCode));
    	$this->assertEquals(0, strlen($transaction->paymentNetworkResponseErrorMessage));
    	$this->assertEquals(0, strlen($transaction->trazabilityCode));
    	$this->assertEquals(0, strlen($transaction->authorizationCode));
    	$this->assertEquals(0, strlen($transaction->pendingReason));
    	$this->assertEquals(0, strlen($transaction->errorCode));
    	$this->assertEquals(0, strlen($transaction->responseMessage));
    	$this->assertEquals(0, strlen($transaction->transactionDate));
    	$this->assertEquals(0, strlen($transaction->transactionTime));
    	$this->assertEquals(0, strlen($transaction->operationDate));
    	$this->assertEquals(0, strlen($transaction->extraParameters));
    }

    /**
     * @see PaymentApi::authorize()
     * @dataProvider providerMockTransaction
     *
     * @param \PayU\Entity\Transaction\TransactionEntity $transaction
     */
    public function testAuthorize($transaction)
    {
    	$rs = $this->object->authorize($transaction);
    	$this->_testTransactionResponse($rs);
    }

    /**
     * @see PaymentApi::authorizeAndCapture()
     * @dataProvider providerMockTransaction
     *
     * @param \PayU\Entity\Transaction\TransactionEntity $transaction
     */
    public function testAuthorizeAndCapture($transaction)
    {
    	$rs = $this->object->authorizeAndCapture($transaction);
    	$this->_testTransactionResponse($rs);
    }

    /**
     * @see PaymentApi::capture()
     * @dataProvider providerMockTransaction
     *
     * @param \PayU\Entity\Transaction\TransactionEntity $transaction
     */
    public function testCapture($transaction)
    {
        $this->markTestIncomplete(
            "Needs a real transaction. Actually provider returns only denied transactions."
        );

        $mock = $this->object->authorize($transaction);
        $rs   = $this->object->capture(
            $mock->transactionResponse->orderId,
            $mock->transactionResponse->transactionId
        );
    }

    /**
     * @see PaymentApi::refund()
     * @dataProvider providerMockTransaction
     *
     * @param \PayU\Entity\Transaction\TransactionEntity $transaction
     */
    public function testRefund($transaction)
    {
        $this->markTestSkipped(
            "PayU Latam doesn't implement REFUND in test environment"
        );
    	$mock = $this->object->authorizeAndCapture($transaction);
    	$rs   = $this->object->refund(
    		$mock->transactionResponse->orderId,
    		$mock->transactionResponse->transactionId
    	);

        $this->_testTransactionResponse($rs);
    }
}
