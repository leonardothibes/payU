<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

use \PayU\Payment\PaymentTypes;
use \PayU\Payment\PaymentMethods;
use \PayU\Payment\PaymentCountries;

use \PayU\Entity\RequestEntity;
use \PayU\Entity\Transaction\TransactionEntity;
use \PayU\Entity\Transaction\CreditCardEntity;
use \PayU\Entity\Transaction\PayerEntity;
use \PayU\Entity\Transaction\ExtraParametersEntity;
use \PayU\Entity\Transaction\Order\OrderEntity;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class RequestEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RequestEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new RequestEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * @see RequestEntity::getTransaction()
     */
    public function testGetTransaction()
    {
    	$rs = $this->object->getTransaction();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);
    }

    /**
     * Transaction mock data provider.
     * @return array
     */
    public function providerTransactionMockData()
    {
    	$types = array(
    		PaymentTypes::AUTHORIZATION_AND_CAPTURE,
    		PaymentTypes::AUTHORIZATION
    	);
    	$type = $types[rand(0, count($types)-1)];

    	$methods = array(
    		PaymentMethods::VISA,
    		PaymentMethods::MASTERCARD,
    	);
    	$method = $methods[rand(0, count($methods)-1)];

    	$countries = array(
    		PaymentCountries::ARGENTINA,
    		PaymentCountries::BRAZIL,
    		PaymentCountries::COLOMBIA,
    		PaymentCountries::MEXICO,
    		PaymentCountries::PANAMA,
    	);
    	$country = $countries[rand(0, count($countries)-1)];

    	$ip     = rand(1,254) . '.' . rand(1,254) . '.' . rand(1,254) . '.' . rand(1,254);
    	$cookie = 'cookie_' . md5(rand(1000, 2000));

    	$browsers = array(
    		'Safari',
    		'Chrome',
   			'Firefox',
   			'Opera',
   			'IE'
    	);
    	$browser = $browsers[rand(0, count($browsers)-1)];

    	return array(
			array($type, $method, $country, $ip, $cookie, $browser)
    	);
    }

    /**
     * @see RequestEntity::setTransaction()
     * @dataProvider providerTransactionMockData
     */
    public function testSetTransaction($type, $paymentMethod, $paymentCountry, $ipAddress, $cookie, $userAgent)
    {
		$transaction = new TransactionEntity();
		$transaction->setType($type)
		            ->setPaymentMethod($paymentMethod)
		            ->setPaymentCountry($paymentCountry)
		            ->setIpAddress($ipAddress)
		            ->setCookie($cookie)
		            ->setUserAgent($userAgent);
		$rs = $this->object->setTransaction($transaction);
		$this->assertInstanceOf('\PayU\Entity\RequestEntity', $rs);

		$rs = $this->object->getTransaction();
		$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

		$this->assertEquals($type          , $rs->getType());
		$this->assertEquals($paymentMethod , $rs->getPaymentMethod());
		$this->assertEquals($paymentCountry, $rs->getPaymentCountry());
		$this->assertEquals($ipAddress     , $rs->getIpAddress());
		$this->assertEquals($cookie        , $rs->getCookie());
		$this->assertEquals($userAgent     , $rs->getUserAgent());
    }

    /**
     * @see RequestEntity::toArray()
     * @dataProvider providerTransactionMockData
     */
    public function testToArray($type, $paymentMethod, $paymentCountry, $ipAddress, $cookie, $userAgent)
    {
    	$transaction = $this->object->getTransaction();
    	$transaction->setType($type)
			    	->setPaymentMethod($paymentMethod)
			    	->setPaymentCountry($paymentCountry)
			    	->setIpAddress($ipAddress)
			    	->setCookie($cookie)
			    	->setUserAgent($userAgent);
    	$this->object->setTransaction($transaction);

    	$rs = $this->object->toArray();

    	$this->assertInternalType('array', $rs);
    	$this->assertEquals(1, count($rs));
    	$this->assertArrayHasKey('transaction', $rs);

    	$transaction = $rs['transaction'];
		$this->assertInternalType('array', $transaction);
		$this->assertEquals(10, count($transaction));

		$this->assertArrayHasKey('type', $transaction);
		$this->assertEquals($type, $transaction['type']);

		$this->assertArrayHasKey('paymentMethod', $transaction);
		$this->assertEquals($paymentMethod, $transaction['paymentMethod']);

		$this->assertArrayHasKey('paymentCountry', $transaction);
		$this->assertEquals($paymentCountry, $transaction['paymentCountry']);

		$this->assertArrayHasKey('ipAddress', $transaction);
		$this->assertEquals($ipAddress, $transaction['ipAddress']);

		$this->assertArrayHasKey('cookie', $transaction);
		$this->assertEquals($cookie, $transaction['cookie']);

		$this->assertArrayHasKey('userAgent', $transaction);
		$this->assertEquals($userAgent, $transaction['userAgent']);

		$this->assertArrayHasKey('order', $transaction);
		$this->assertInternalType('array', $transaction['order']);

		$this->assertArrayHasKey('creditCard', $transaction);
		$this->assertInternalType('array', $transaction['creditCard']);

		$this->assertArrayHasKey('payer', $transaction);
		$this->assertInternalType('array', $transaction['payer']);

		$this->assertArrayHasKey('extraParameters', $transaction);
		$this->assertInternalType('array', $transaction['extraParameters']);
    }
}
