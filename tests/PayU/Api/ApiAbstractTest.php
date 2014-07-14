<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Api;

use \PayU\Api\ApiAbstract;
use \PayU\Merchant\MerchantCredentials;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';
class ApiAbstractMock extends ApiAbstract { public function ping() {} }

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class ApiAbstractTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ApiAbstractMock
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
		$this->credentials->setApiLogin(PAYU_API_LOGIN)
    	                  ->setApiKey(PAYU_API_KEY);
    	$this->object = new ApiAbstractMock($this->credentials);
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
     * @see ApiAbstract::getCredentials()
     */
	public function testGetCredentials()
	{
		$rs = $this->object->getCredentials();
		$this->assertSame($this->credentials, $rs);
		$this->assertEquals(PAYU_API_LOGIN, $rs->getApiLogin());
		$this->assertEquals(PAYU_API_LOGIN, $rs->getApiLogin());
	}

	/**
	 * @see ApiAbstract::isStaging()
	 */
	public function testIsStagingDefaultValue()
	{
		$rs = $this->object->isStaging();
		$this->assertInternalType('bool', $rs);
		$this->assertFalse($rs);
	}

	/**
	 * @see ApiAbstract::isProduction()
	 */
	public function testIsProductionDefaultValue()
	{
		$rs = $this->object->isProduction();
		$this->assertInternalType('bool', $rs);
		$this->assertTrue($rs);
	}

	/**
	 * @see ApiAbstract::setStaging()
	 */
	public function testSetStaging1()
	{
		$rs = $this->object->setStaging();
		$this->assertInstanceOf('\PayU\Api\ApiAbstract', $rs);

		$rs = $this->object->isStaging();
		$this->assertTrue($rs);
	}

	/**
	 * @see ApiAbstract::setStaging()
	 */
	public function testSetStaging2()
	{
		$rs = $this->object->setStaging(true);
		$this->assertInstanceOf('\PayU\Api\ApiAbstract', $rs);

		$rs = $this->object->isStaging();
		$this->assertTrue($rs);
	}

	/**
	 * @see ApiAbstract::setStaging()
	 */
	public function testSetStaging3()
	{
		$rs = $this->object->setStaging(false);
		$this->assertInstanceOf('\PayU\Api\ApiAbstract', $rs);

		$rs = $this->object->isStaging();
		$this->assertFalse($rs);

		$rs = $this->object->isProduction();
		$this->assertTrue($rs);
	}
}
