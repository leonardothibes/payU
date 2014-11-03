<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Payment\PaymentTypes;
use \PayU\Payment\PaymentMethods;
use \PayU\Payment\PaymentCountries;

use \PayU\Entity\Transaction\TransactionEntity;
use \PayU\Entity\Transaction\CreditCardEntity;
use \PayU\Entity\Transaction\PayerEntity;
use \PayU\Entity\Transaction\ExtraParametersEntity;
use \PayU\Entity\Transaction\Order\OrderEntity;

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
	 * @see TransactionEntity::getExpiration()
	 */
	public function testGetExpiration()
	{
		$rs = $this->object->getExpiration();
		$this->assertInternalType('int', $rs);
		$this->assertEquals(4, $rs);
	}

	/**
	 * @see TransactionEntity::setExpiration()
	 */
	public function testSetExpiration1()
	{
		$rs = $this->object->setExpiration()->getExpiration();
		$this->assertInternalType('int', $rs);
		$this->assertEquals(4, $rs);
	}

	/**
	 * @see TransactionEntity::setExpiration()
	 */
	public function testSetExpiration2()
	{
		$expiration = rand(1, 10);
		$rs         = $this->object->setExpiration($expiration);
		$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

		$rs = $this->object->getExpiration();
		$this->assertInternalType('int', $rs);
		$this->assertEquals($expiration, $rs);
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
     * @see TransactionEntity::getDeviceSessionId()
     */
    public function testGetDeviceSessionId()
    {
    	$rs = $this->object->getDeviceSessionId();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see TransactionEntity::setDeviceSessionId()
     */
    public function testSetDeviceSessionId()
    {
    	$deviceSessionId = md5(session_id().microtime());
    	$rs              = $this->object->setDeviceSessionId($deviceSessionId);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getDeviceSessionId();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($deviceSessionId, $rs);
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
    	$orderEntity = new OrderEntity();

    	$accountId = 'accountId_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$orderEntity->setAccountId($accountId);

    	$referenceCode = 'referenceCode_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$orderEntity->setReferenceCode($referenceCode);

    	$description = 'description_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$orderEntity->setDescription($description);

    	$language = 'language_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$orderEntity->setLanguage($language);

    	$notifyUrl = 'http://notifyurl-' . rand(1,9) . rand(1,9) . rand(1,9) . '.com';
    	$orderEntity->setNotifyUrl($notifyUrl);

    	$signature = sha1('signature');
    	$orderEntity->setSignature($signature);

    	$rs = $this->object->setOrder($orderEntity);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

		$rs = $this->object->getOrder();
		$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

		$this->assertEquals($accountId    , $rs->getAccountId());
		$this->assertEquals($referenceCode, $rs->getReferenceCode());
		$this->assertEquals($description  , $rs->getDescription());
		$this->assertEquals($language     , $rs->getLanguage());
		$this->assertEquals($notifyUrl    , $rs->getNotifyUrl());
		$this->assertEquals($signature    , $rs->getSignature());
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
    	$creditCardEntity = new CreditCardEntity();

    	$number = str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4);
    	$creditCardEntity->setNumber($number);

    	$securityCode = rand(1,9) . rand(1,9) . rand(1,9);
    	$creditCardEntity->setSecurityCode($securityCode);

    	$expirationDate = rand(1,9) . rand(1,9) . rand(1,9). rand(1,9) . '/' . rand(1,9) . rand(1,9);
    	$creditCardEntity->setExpirationDate($expirationDate);

    	$name = 'person name ' . rand(1,9) . rand(1,9) . rand(1,9);
    	$creditCardEntity->setName($name);

    	$rs = $this->object->setCreditCard($creditCardEntity);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getCreditCard();
    	$this->assertInstanceOf('PayU\Entity\Transaction\CreditCardEntity', $rs);

    	$this->assertEquals($number        , $rs->getNumber());
    	$this->assertEquals($securityCode  , $rs->getSecurityCode());
    	$this->assertEquals($expirationDate, $rs->getExpirationDate());
    	$this->assertEquals($name          , $rs->getName());
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
    	$payerEntity = new PayerEntity();

    	$fullName = 'person name ' . rand(1,9) . rand(1,9) . rand(1,9);
    	$payerEntity->setFullName($fullName);

    	$emailAddress = 'email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com';
    	$payerEntity->setEmailAddress($emailAddress);

    	$rs = $this->object->setPayer($payerEntity);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getPayer();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\PayerEntity', $rs);

		$this->assertEquals($fullName    , $rs->getFullName());
		$this->assertEquals($emailAddress, $rs->getEmailAddress());
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
    	$extraParametersEntity = new ExtraParametersEntity();

    	$installmentsNumber = rand(1, 10);
    	$extraParametersEntity->setInstallmentsNumber($installmentsNumber);

    	$installmentsType = rand(1, 3);
    	$extraParametersEntity->setInstallmentsType($installmentsType);

    	$securityCodeIndicator = rand(0, 2);
    	$extraParametersEntity->setSecurityCodeIndicator($securityCodeIndicator);

    	$responseUrl = 'https://response-url-' . rand(1, 1000) . '.com';
    	$extraParametersEntity->setResponseUrl($responseUrl);

    	$rs = $this->object->setExtraParameters($extraParametersEntity);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\TransactionEntity', $rs);

    	$rs = $this->object->getExtraParameters();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ExtraParametersEntity', $rs);

		$this->assertEquals($installmentsNumber   , $rs->getInstallmentsNumber());
		$this->assertEquals($installmentsType     , $rs->getInstallmentsType());
		$this->assertEquals($securityCodeIndicator, $rs->getSecurityCodeIndicator());
		$this->assertEquals($responseUrl          , $rs->getResponseUrl());
    }

	/**
	 * @see RequestEntity::isEmpty()
	 */
	public function testIsEmptyTrue()
	{
		$rs = $this->object->isEmpty();
		$this->assertTrue($rs);
	}

	/**
	 * @see RequestEntity::isEmpty()
	 */
	public function testIsEmptyFalse()
	{
		$this->object->setPaymentMethod('what-ever');
		$rs = $this->object->isEmpty();
		$this->assertFalse($rs);
	}

    /**
     * @see TransactionEntity::toArray()
     */
    public function testToArray()
    {
    	$rs = $this->object->toArray();
		$this->assertArrayHasKey('expiration'     , $rs);
		$this->assertArrayHasKey('type'           , $rs);
		$this->assertArrayHasKey('paymentMethod'  , $rs);
		$this->assertArrayHasKey('paymentCountry' , $rs);
		$this->assertArrayHasKey('ipAddress'      , $rs);
		$this->assertArrayHasKey('cookie'         , $rs);
		$this->assertArrayHasKey('userAgent'      , $rs);
		$this->assertArrayHasKey('order'          , $rs);
		$this->assertArrayHasKey('creditCard'     , $rs);
		$this->assertArrayHasKey('payer'          , $rs);
		$this->assertArrayHasKey('extraParameters', $rs);
    }
}
