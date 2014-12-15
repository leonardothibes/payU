<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;
use \PayU\Entity\Transaction\ExtraParametersEntity;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class ExtraParametersEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ExtraParametersEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new ExtraParametersEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Testing constants values.
     */
    public function testConstantsValues()
    {
    	$this->assertEquals(ExtraParametersEntity::INSTALLMENTS_NUMBER                , 'INSTALLMENTS_NUMBER');
    	$this->assertEquals(ExtraParametersEntity::INSTALLMENTS_TYPE                  , 'INSTALLMENTS_TYPE');
    	$this->assertEquals(ExtraParametersEntity::INSTALLMENT_PAYMENT_ON_SITE        , 1);
    	$this->assertEquals(ExtraParametersEntity::INSTALLMENT_BUSINESS_FUNDING       , 2);
    	$this->assertEquals(ExtraParametersEntity::INSTALLMENT_PAYMENT_NETWORK_FUNDING, 3);
    	$this->assertEquals(ExtraParametersEntity::SECURITY_CODE_INDICATOR            , 'SECURITY_CODE_INDICATOR');
    	$this->assertEquals(ExtraParametersEntity::SECURITY_CODE_NOT_PROVIDED         , 0);
    	$this->assertEquals(ExtraParametersEntity::SECURITY_CODE_PROVIDED             , 1);
    	$this->assertEquals(ExtraParametersEntity::SECURITY_CODE_UNREADABLE           , 2);
    	$this->assertEquals(ExtraParametersEntity::SECURITY_CODE_NON_EXISTENT         , 9);
    	$this->assertEquals(ExtraParametersEntity::RESPONSE_URL                       , 'RESPONSE_URL');
    }

	/**
	 * @see ExtraParametersEntity::getInstallmentsNumber()
	 */
    public function testGetInstallmentsNumber()
    {
    	$rs = $this->object->getInstallmentsNumber();
    	$this->assertInternalType('int', $rs);
    	$this->assertEquals(1, $rs);
    }

    /**
     * @see ExtraParametersEntity::setInstallmentsNumber()
     */
    public function testSetInstallmentsNumber()
    {
    	$installmentsNumber = rand(1, 10);
    	$rs                 = $this->object->setInstallmentsNumber($installmentsNumber);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ExtraParametersEntity', $rs);

    	$rs = $this->object->getInstallmentsNumber();
    	$this->assertInternalType('int', $rs);
    	$this->assertEquals($installmentsNumber, $rs);
    }

    /**
     * @see ExtraParametersEntity::getInstallmentsType
     */
    public function testGetInstallmentsType()
    {
    	$rs = $this->object->getInstallmentsType();
    	$this->assertNull($rs);
    }

    /**
     * @see ExtraParametersEntity::setInstallmentsType()
     */
    public function testSetInstallmentsType()
    {
    	$installmentsType = rand(1, 3);
    	$rs               = $this->object->setInstallmentsType($installmentsType);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ExtraParametersEntity', $rs);

    	$rs = $this->object->getInstallmentsType();
    	$this->assertInternalType('int', $rs);
    	$this->assertEquals($installmentsType, $rs);
    }

    /**
     * @see ExtraParametersEntity::setInstallmentsType()
     * @expectedException \PayU\Entity\EntityException
     */
    public function testSetInstallmentsTypeException()
    {
    	$this->object->setInstallmentsType(4);
    }

    /**
     * @see ExtraParametersEntity::setSecurityCodeIndicator()
     */
    public function testGetSecurityCodeIndicator()
    {
    	$rs = $this->object->getSecurityCodeIndicator();
    	$this->assertInternalType('int', $rs);
    	$this->assertEquals(ExtraParametersEntity::SECURITY_CODE_PROVIDED, $rs);
    }

    /**
     * @see ExtraParametersEntity::setSecurityCodeIndicator()
     */
    public function testSetSecurityCodeIndicator()
    {
    	$securityCodeIndicator = rand(0, 2);
    	$rs                    = $this->object->setSecurityCodeIndicator($securityCodeIndicator);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ExtraParametersEntity', $rs);

    	$rs = $this->object->getSecurityCodeIndicator();
    	$this->assertInternalType('int', $rs);
    	$this->assertEquals($securityCodeIndicator, $rs);
    }

    /**
     * @see ExtraParametersEntity::setSecurityCodeIndicator()
     * @expectedException \PayU\Entity\EntityException
     */
    public function testSetSecurityCodeIndicatorException()
    {
    	$securityCodeIndicator = rand(3, 8);
    	$this->object->setSecurityCodeIndicator($securityCodeIndicator);
    }

    /**
     * @see ExtraParametersEntity::getResponseUrl()
     */
    public function testGetResponseUrl()
    {
    	$rs = $this->object->getResponseUrl();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see ExtraParametersEntity::setResponseUrl()
     */
    public function testSetResponseUrl()
    {
    	$responseUrl = 'https://response-url-' . rand(1, 1000) . '.com';
    	$rs          = $this->object->setResponseUrl($responseUrl);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ExtraParametersEntity', $rs);

    	$rs = $this->object->getResponseUrl();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($responseUrl, $rs);
    }

    /**
     * @see ExtraParametersEntity::setResponseUrl()
     * @expectedException \PayU\Entity\EntityException
     */
    public function testSetResponseUrlException()
    {
    	$this->object->setResponseUrl('invalid-url-here');
    }

	/**
	 * @see ExtraParametersEntity::isEmpty()
	 */
	public function testIsEmptyTrue()
	{
		$rs = $this->object->isEmpty();
		$this->assertTrue($rs);
	}

	/**
	 * @see ExtraParametersEntity::isEmpty()
	 */
	public function testIsEmptyFalse()
	{
		$this->object->setInstallmentsNumber(2);
		$rs = $this->object->isEmpty();
		$this->assertFalse($rs);
	}

    /**
     * @see ExtraParametersEntity::toArray()
     */
    public function testToArray()
    {
    	$installmentsNumber    = rand(1, 10);
    	$installmentsType      = rand(1, 3);
    	$securityCodeIndicator = rand(0, 2);
    	$responseUrl           = 'https://response-url-' . rand(1, 1000) . '.com';

    	$this->object->setInstallmentsNumber($installmentsNumber)
    	             ->setInstallmentsType($installmentsType)
    	             ->setSecurityCodeIndicator($securityCodeIndicator)
    	             ->setResponseUrl($responseUrl);
    	$rs = $this->object->toArray();

    	$this->assertInternalType('array', $rs);
    	$this->assertEquals($installmentsNumber   , $rs[ExtraParametersEntity::INSTALLMENTS_NUMBER]);
    	$this->assertEquals($installmentsType     , $rs[ExtraParametersEntity::INSTALLMENTS_TYPE]);
    	$this->assertEquals($securityCodeIndicator, $rs[ExtraParametersEntity::SECURITY_CODE_INDICATOR]);
    	$this->assertEquals($responseUrl          , $rs[ExtraParametersEntity::RESPONSE_URL]);
    }
}
