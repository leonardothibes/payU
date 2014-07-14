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
    	unset($this->object);
    }

	/**
	 * @see MerchantCredentials::getApiLogin()
	 */
    public function testGetApiLogin()
    {
    	$rs = $this->object->getApiLogin();
    	$this->assertNull($rs);
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
    	$this->assertNull($rs);
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
