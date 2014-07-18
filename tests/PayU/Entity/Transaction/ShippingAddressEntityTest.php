<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;
use \PayU\Entity\Transaction\ShippingAddressEntity;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class ShippingAddressEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ShippingAddressEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new ShippingAddressEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

	/**
	 * @see ShippingAddressEntity::getStreet1()
	 */
    public function testGetStreet1()
    {
		$rs = $this->object->getStreet1();
		$this->assertEquals(0, strlen($rs));
    }

    /**
	 * @see ShippingAddressEntity::setStreet1()
	 */
    public function testSetStreet1()
    {
    	$street1 = 'street_' . rand(1,9);
    	$rs      = $this->object->setStreet1($street1);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$rs = $this->object->getStreet1();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($street1, $rs);
    }

    /**
	 * @see ShippingAddressEntity::getStreet2()
	 */
    public function testGetStreet2()
    {
		$rs = $this->object->getStreet2();
		$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see ShippingAddressEntity::setStreet2()
     */
    public function testSetStreet2()
    {
    	$street2 = 'street_' . rand(1,9);
    	$rs      = $this->object->setStreet2($street2);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$rs = $this->object->getStreet2();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($street2, $rs);
    }

    /**
     * @see ShippingAddressEntity::getCity()
     */
    public function testGetCity()
    {
    	$rs = $this->object->getCity();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see ShippingAddressEntity::setCity()
     */
    public function testSetCity()
    {
    	$city = 'city_' . rand(1,9);
    	$rs   = $this->object->setCity($city);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$rs = $this->object->getCity();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($city, $rs);
    }

    /**
     * @see ShippingAddressEntity::getState()
     */
    public function testGetState()
    {
    	$rs = $this->object->getState();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see ShippingAddressEntity::setState()
     */
    public function testSetState()
    {
    	$state = 'state_' . rand(1,9);
    	$rs    = $this->object->setState($state);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$rs = $this->object->getState();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($state, $rs);
    }

    /**
     * @see ShippingAddressEntity::getCountry()
     */
    public function testGetCountry()
    {
    	$rs = $this->object->getCountry();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see ShippingAddressEntity::setCountry()
     */
    public function testSetCountry()
    {
    	$country = 'country_' . rand(1,9);
    	$rs      = $this->object->setCountry($country);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$rs = $this->object->getCountry();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($country, $rs);
    }

    /**
     * @see ShippingAddressEntity::getPostalCode()
     */
    public function testGetpostalCode()
    {
    	$rs = $this->object->getPostalCode();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see ShippingAddressEntity::setPostalCode()
     */
    public function testSetPostalCode()
    {
    	$postalCode = 'postalCode_' . rand(1,9);
    	$rs         = $this->object->setPostalCode($postalCode);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$rs = $this->object->getPostalCode();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($postalCode, $rs);
    }

    /**
     * @see ShippingAddressEntity::getPhone()
     */
    public function testGetPhone()
    {
    	$rs = $this->object->getPhone();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see ShippingAddressEntity::setPhone()
     */
    public function testSetPhone()
    {
    	$phone = rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs    = $this->object->setPhone($phone);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$rs = $this->object->getPhone();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($phone, $rs);
    }
}
