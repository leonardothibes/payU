<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

use \PayU\Merchant\MerchantCredentials;
use \PayU\Entity\RequestEntity;

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
    	$this->object = new RequestEntity($this->credentials);
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
     * @see RequestEntity::ping()
     */
    public function testPing()
    {
    	$rs = $this->object->ping();
    	$this->assertTrue($rs);
    }

    /**
     * @see RequestEntity::addTransaction()
     */
	public function testAddTransaction()
	{
		$transaction = array('test' => 'ok');
		$rs          = $this->object->addTransaction($transaction)->toJson();
		$rs          = json_decode($rs, true);

		$this->assertInternalType('array', $rs);
		$this->assertArrayHasKey('transaction', $rs);
		$this->assertArrayHasKey('test', $rs['transaction']);
		$this->assertEquals('ok', $rs['transaction']['test']);
	}
}
