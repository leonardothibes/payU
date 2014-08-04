<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Report;

use \PayU\Report\ReportApi;
use \PayU\Merchant\MerchantCredentials;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class ReportApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ReportApi
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
    	$this->object = new ReportApi($this->credentials);
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
    public function testGetApiUrlInStaging()
    {
    	$rs = $this->object->setStaging(true)->getApiUrl();
    	$this->assertEquals('https://stg.api.payulatam.com/reports-api/4.0/service.cgi', $rs);
    }

    /**
     * @see ApiAbstract::getApiUrl()
     */
    public function testGetApiUrlInProduction()
    {
    	$rs = $this->object->setStaging(false)->getApiUrl();
    	$this->assertEquals('https://api.payulatam.com/reports-api/4.0/service.cgi', $rs);
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
     * Orders data provider.
     * @return array
     */
    public function providerOrderId()
    {
    	return array(
    		array(2637540)
    	);
    }

    /**
     * @see ReportApi::fetchByOrderId()
     * @dataProvider providerOrderId
     */
    public function testFetchByOrderId($orderId)
    {
    	$rs = $this->object->fetchByOrderId($orderId);
    	$this->assertInstanceOf('\stdClass', $rs);
    	$this->assertEquals($orderId, $rs->result->payload->id);
    }

    /**
     * @see ReportApi::fetchByOrderId()
     */
    public function testFetchByOrderIdNotExists()
    {
    	try {
    		$orderId = rand(1,1000);
    		$rs      = $this->object->fetchByOrderId($orderId);
    	} catch (\Exception $e) {
    		$this->assertInstanceOf('PayU\Report\ReportException', $e);
    		$this->assertEquals(0, $e->getCode());

    		$message = sprintf('Entity [Order] Not Found with Id [%d].', $orderId);
    		$this->assertEquals($message, $e->getMessage());
    	}
    }
}


























