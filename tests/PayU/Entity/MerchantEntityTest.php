<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;
use \PayU\Entity\MerchantEntity;
require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class MerchantEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MerchantEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new MerchantEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }
    
    /**
     * @see MerchantEntity::getMerchantId()
     */
    public function testGetMerchantId()
    {
    	$rs = $this->object->getMerchantId();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }
    
    /**
     * @see MerchantEntity::setMerchantId()
     */
    public function testSetMerchantId()
    {
    	$merchantId = 'merchant_id_' . rand(1, 1000);
    	$rs         = $this->object->setMerchantId($merchantId);
    	$this->assertInstanceOf('\PayU\Entity\MerchantEntity', $rs);
    	
    	$rs = $this->object->getMerchantId();
    	$this->assertEquals($merchantId, $rs);
    }
    
    /**
     * @see MerchantEntity::getApiLogin()
     */
    public function testGetApiLogin()
    {
    	$rs = $this->object->getApiLogin();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see MerchantEntity::setApiLogin()
     */
    public function testSetApiLogin()
    {
    	$apiLogin = 'api_login_' . rand(1, 1000);
    	$rs       = $this->object->setApiLogin($apiLogin);
    	$this->assertInstanceOf('\PayU\Entity\MerchantEntity', $rs);
    	 
    	$rs = $this->object->getApiLogin();
    	$this->assertEquals($apiLogin, $rs);
    }
    
    /**
     * @see MerchantEntity::getApiKey()
     */
    public function testGetApiKey()
    {
    	$rs = $this->object->getApiKey();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }
    
    /**
     * @see MerchantEntity::setApiKey()
     */
    public function testSetApiKey()
    {
    	$apiKey = 'api_key_' . rand(1, 1000);
    	$rs     = $this->object->setApiKey($apiKey);;
    	$this->assertInstanceOf('\PayU\Entity\MerchantEntity', $rs);
    	
    	$rs = $this->object->getApiKey();
    	$this->assertEquals($apiKey, $rs);
    }
    
    /**
     * @see MerchantEntity::getAccountId()
     */
    public function testGetAccountId()
    {
    	$rs = $this->object->getAccountId();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(0, strlen($rs));
    }
    
    /**
     * @see MerchantEntity::setAccountId()
     */
    public function testSetAccountId()
    {
    	$accountId = 'account_id_' . rand(1, 1000);
    	$rs        = $this->object->setAccountId($accountId);
    	$this->assertInstanceOf('\PayU\Entity\MerchantEntity', $rs);
    	 
    	$rs = $this->object->getAccountId();
    	$this->assertEquals($accountId, $rs);
    }
}
