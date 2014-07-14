<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Payment;

use \PayU\Payment\PaymentApi;
use \PayU\Merchant\MerchantCredentials;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PaymentApiTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaymentApi
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
    	$this->object = new PaymentApi($this->credentials);
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
	 * @see PaymentApi::ping()
	 */
    public function testPing()
    {
    	$rs = $this->object->ping();
    	$this->assertInternalType('bool', $rs);
    	$this->assertTrue($rs);
    }
}
