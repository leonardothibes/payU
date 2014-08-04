<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Merchant;
use \PayU\Merchant\MerchantCredentials;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class MerchantCredentialsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MerchantCredentials
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = MerchantCredentials::getInstance();
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	$this->object->resetInstance();
    	unset($this->object);
    }

    /**
     * @see MerchantCredentials::getApiUrl()
     */
    public function testGetApiUrl()
    {
    	$rs = $this->object->getApiUrl();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see MerchantCredentials::setApiUrl()
     */
    public function testSetApiUrl()
    {
    	$apiUrl = 'apiUrl_' . rand(1,1000);
    	$rs     = $this->object->setApiUrl($apiUrl);
    	$this->assertInstanceOf('\PayU\Merchant\MerchantCredentials', $rs);

    	$rs = $this->object->getApiUrl();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($apiUrl, $rs);
    }

    /**
     * @see MerchantCredentials::getMerchantId()
     */
    public function testGetMerchantId()
    {
    	$rs = $this->object->getMerchantId();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see MerchantCredentials::setMerchantId()
     */
    public function testSetMerchantId()
    {
    	$merchantId = 'merchantId_' . rand(1,1000);
    	$rs         = $this->object->setMerchantId($merchantId);
    	$this->assertInstanceOf('\PayU\Merchant\MerchantCredentials', $rs);

    	$rs = $this->object->getMerchantId();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($merchantId, $rs);
    }

	/**
	 * @see MerchantCredentials::getApiLogin()
	 */
    public function testGetApiLogin()
    {
    	$rs = $this->object->getApiLogin();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see MerchantCredentials::setApiLogin()
     */
    public function testSetApiLogin()
    {
    	$apiLogin = 'apiLogin_' . rand(1,1000);

    	$rs = $this->object->setApiLogin($apiLogin);
    	$this->assertInstanceOf('\PayU\Merchant\MerchantCredentials', $rs);

    	$rs = $this->object->getApiLogin();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($apiLogin, $rs);
    }

    /**
     * @see MerchantCredentials::getApiKey()
     */
    public function testGetApiKey()
    {
    	$rs = $this->object->getApiKey();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see MerchantCredentials::setApiKey()
     */
    public function testSetApiKey()
    {
    	$apiKey = 'apiKey_' . rand(1,1000);

    	$rs = $this->object->setApiKey($apiKey);
    	$this->assertInstanceOf('\PayU\Merchant\MerchantCredentials', $rs);

    	$rs = $this->object->getApiKey();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($apiKey, $rs);
    }
}
