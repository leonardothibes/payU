<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;
use \PayU\Entity\Transaction\TransactionEntity;
use PayU\Payment\PaymentTypes;
use PayU\Payment\PaymentMethods;
use PayU\Payment\PaymentCountries;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class TransactionEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TransactionEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new TransactionEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

	/**
	 * @see TransactionEntity::getType()
	 */
    public function testGetType()
    {
    	$rs = $this->object->getType();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see TransactionEntity::setType()
     */
    public function testSetType1()
    {
    	$rs = $this->object->setType(PaymentTypes::AUTHORIZATION);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getType();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(PaymentTypes::AUTHORIZATION, $rs);
    }

    /**
     * @see TransactionEntity::setType()
     */
    public function testSetType2()
    {
    	$rs = $this->object->setType(PaymentTypes::AUTHORIZATION_AND_CAPTURE);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getType();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(PaymentTypes::AUTHORIZATION_AND_CAPTURE, $rs);
    }

    /**
     * @see TransactionEntity::getPaymentMethod()
     */
    public function testGetPaymentMethod()
    {
    	$rs = $this->object->getPaymentMethod();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @return array
     */
    public function providerPaymentMethods()
    {
    	return array(
    		array(PaymentMethods::VISA),
    		array(PaymentMethods::MASTERCARD),
    		array(PaymentMethods::AMEX),
    		array(PaymentMethods::DINERS),
    	);
    }

    /**
     * @see TransactionEntity::setPaymentMethod()
     * @dataProvider providerPaymentMethods
     */
    public function testSetPaymentMethod($paymentMethod)
    {
    	$rs = $this->object->setPaymentMethod($paymentMethod);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getPaymentMethod();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($paymentMethod, $rs);
    }

    /**
     * @see TransactionEntity::getPaymentCountry()
     */
    public function testGetPaymentCountry()
    {
    	$rs = $this->object->getPaymentCountry();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @return array
     */
    public function providerPaymentoCountries()
    {
    	return array(
    		array(PaymentCountries::BRAZIL),
    		array(PaymentCountries::ARGENTINA),
    		array(PaymentCountries::PANAMA),
    		array(PaymentCountries::MEXICO),
    		array(PaymentCountries::COLOMBIA),
    		array(PaymentCountries::PERU),
    	);
    }

    /**
     * @see TransactionEntity::setPaymentCountry()
     * @dataProvider providerPaymentoCountries
     */
    public function testSetPaymentCountry($paymentCountry)
    {
    	$rs = $this->object->setPaymentCountry($paymentCountry);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getPaymentCountry();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($paymentCountry, $rs);
    }

    /**
     * @see TransactionEntity::getIpAddress()
     */
    public function testGetIpAddress()
    {
    	$rs = $this->object->getIpAddress();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see TransactionEntity::setIpAddress()
     */
    public function testSetIpAddress()
    {
    	$ipAddress = rand(1, 254) . '.' . rand(1, 254) . '.' . rand(1, 254) . '.' . rand(1, 254);
    	$rs        = $this->object->setIpAddress($ipAddress);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getIpAddress();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($ipAddress, $rs);
    }

    /**
     * @see TransactionEntity::getCookie()
     */
    public function testGetCookie()
    {
    	$rs = $this->object->getCookie();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see TransactionEntity::setCookie()
     */
    public function testSetCookie()
    {
    	$cookie = 'cookie-value-' . rand(100, 1000);
    	$rs     = $this->object->setCookie($cookie);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getCookie();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($cookie, $rs);
    }

    /**
     * @see TransactionEntity::getUserAgent()
     */
    public function testGetUserAgent()
    {
    	$rs = $this->object->getUserAgent();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see TransactionEntity::setUserAgent()
     */
    public function testSetUserAgent()
    {
    	$userAgent = 'user-agent-' . rand(100, 1000);
    	$rs        = $this->object->setUserAgent($userAgent);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getUserAgent();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($userAgent, $rs);
    }

    /**
     * @see TransactionEntity::getOrder()
     */
    public function testGetOrder()
    {
    	$rs = $this->object->getOrder();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);
    }

    /**
     * @see TransactionEntity::setOrder()
     */
    public function testSetOrder()
    {
    	$this->markTestIncomplete();
    }

    /**
     * @see TransactionEntity::getCreditCard()
     */
    public function testGetCreditCard()
    {
    	$rs = $this->object->getCreditCard();
    	$this->assertInstanceOf('PayU\Entity\Transaction\CreditCardEntity', $rs);
    }

    /**
     * @see TransactionEntity::setCreditCard()
     */
    public function testSetCreditCard()
    {
    	$this->markTestIncomplete();
    }

    /**
     * @see TransactionEntity::getPayer()
     */
    public function testGetPayer()
    {
    	$rs = $this->object->getPayer();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\PayerEntity', $rs);
    }

    /**
     * @see TransactionEntity::setPayer()
     */
    public function testSetPayer()
    {
    	$this->markTestIncomplete();
    }

    /**
     * @see TransactionEntity::getExtraParameters()
     */
    public function testGetExtraParameters()
    {
    	$rs = $this->object->getExtraParameters();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ExtraParametersEntity', $rs);
    }

    /**
     * @see TransactionEntity::setExtraParameters()
     */
    public function testSetExtraParameters()
    {
    	$this->markTestIncomplete();
    }

    /**
     * @see TransactionEntity::toArray()
     */
    public function testToArray()
    {
    	$this->markTestIncomplete();
    }
}




























