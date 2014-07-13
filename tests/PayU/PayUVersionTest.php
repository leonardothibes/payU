<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU;
use \PayU\PayUVersion;
require_once dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PayUVersionTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @see PayUVersion::getVersionFileLocation()
	 */
    public function testGetVersionFileLocation()
    {
    	$rs = PayUVersion::getVersionFileLocation();
    	$this->assertInternalType('string', $rs);
    	$this->assertTrue(file_exists($rs));
    }

    /**
     * @see PayUVersion::getCurrent()
     */
    public function testGetCurrent()
    {
    	$v  = file_get_contents(LIBRARY_PATH . '/PayU/Version/Number.txt');
    	$rs = PayUVersion::getCurrent();

    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($v, $rs);
    }
}
