<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Api;

use \PayU\Api\ApiAbstract;
use \PayU\Merchant\MerchantCredentials;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';
class ApiAbstractMock extends ApiAbstract {}

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
    	unset($this->object);
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
}




















