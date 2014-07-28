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
    	$this->credentials->setMerchantId(PAYU_MERCHANT_ID)
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
    public function estGetApiUrlInStaging()
    {
    	$rs = $this->object->setStaging(true)->getApiUrl();
    	$this->assertEquals('https://stg.api.payulatam.com/payments-api/4.0/service.cgi', $rs);
    }

    /**
     * @see ApiAbstract::getApiUrl()
     */
    public function estGetApiUrlInProduction()
    {
    	$rs = $this->object->setStaging(false)->getApiUrl();
    	$this->assertEquals('https://api.payulatam.com/payments-api/4.0/service.cgi', $rs);
    }

	/**
	 * @see PaymentApi::ping()
	 */
    public function estPing()
    {
    	$rs = $this->object->ping();
    	$this->assertInternalType('bool', $rs);
    	$this->assertTrue($rs);
    }

    /**
     * @see PaymentApi::ping()
     */
    public function estPingWrongCredentials()
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
    public function estPaymentMethods()
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
    public function estPaymentMethodsWrongCredentials()
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
    	$methods = array(
    			PaymentMethods::VISA,
    			PaymentMethods::MASTERCARD,
    	);
    	$paymentMethod = $methods[rand(0, count($methods)-1)];

    	$countries = array(
    			PaymentCountries::ARGENTINA,
    			PaymentCountries::BRAZIL,
    			PaymentCountries::COLOMBIA,
    			PaymentCountries::MEXICO,
    			PaymentCountries::PANAMA,
    	);
    	$paymentCountry = $countries[rand(0, count($countries)-1)];

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

    	$transaction->setPaymentMethod($paymentMethod)
    	            ->setPaymentCountry($paymentCountry)
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
				    	->setCountry('country_' . rand(1,1000))
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
    	$additionalValues->addTax('TX_VALUE', 'BRL', 100);
    	//Additional values.

    	//Credit card.
    	$creditCard = $transaction->getCreditCard();
    	$creditCard->setNumber(str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4))
    	           ->setSecurityCode(rand(1,9) . rand(1,9) . rand(1,9))
    	           ->setExpirationDate(rand(1,9) . rand(1,9) . rand(1,9). rand(1,9) . '/' . rand(1,9) . rand(1,9))
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
     * @see PaymentApi::authorize()
     * @dataProvider providerMockTransaction
     */
    /*public function estAuthorize($transaction)
    {
    	$rs = $this->object->authorize($transaction);

    	\Tbs\Log::debug($rs);
    }*/
    public function testAuthorize()
    {
    	$rs = $this->object->authorize();
    
    	\Tbs\Log::debug($rs);
    }

    /**
     * @see PaymentApi::authorizeAndCapture()
     */
    public function estAuthorizeAndCapture()
    {
    	$this->markTestIncomplete();
    }

    /**
     * @see PaymentApi::capture()
     */
    public function estCapture()
    {
    	$this->markTestIncomplete();
    }

    /**
     * @see PaymentApi::void()
     */
    public function estVoid()
    {
    	$this->markTestIncomplete();
    }
}




























