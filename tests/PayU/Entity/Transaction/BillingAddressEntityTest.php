<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;
use \PayU\Entity\Transaction\BillingAddressEntity;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class BillingAddressEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BillingAddressEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new BillingAddressEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    public function testIsEmptyWithEmptyObjectShouldReturnTrue()
    {
        $this->assertTrue($this->object->isEmpty());
    }

	/**
	 * @see BillingAddressEntity::getStreet1()
	 */
    public function testGetStreet1()
    {
		$rs = $this->object->getStreet1();
		$this->assertEquals(0, strlen($rs));
    }

    /**
	 * @see BillingAddressEntity::setStreet1()
	 */
    public function testSetStreet1()
    {
    	$street1 = 'street_' . rand(1,9);
    	$rs      = $this->object->setStreet1($street1);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\BillingAddressEntity', $rs);

    	$rs = $this->object->getStreet1();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($street1, $rs);
    }

    /**
	 * @see BillingAddressEntity::getStreet2()
	 */
    public function testGetStreet2()
    {
		$rs = $this->object->getStreet2();
		$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BillingAddressEntity::setStreet2()
     */
    public function testSetStreet2()
    {
    	$street2 = 'street_' . rand(1,9);
    	$rs      = $this->object->setStreet2($street2);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\BillingAddressEntity', $rs);

    	$rs = $this->object->getStreet2();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($street2, $rs);
    }

    /**
     * @see BillingAddressEntity::getCity()
     */
    public function testGetCity()
    {
    	$rs = $this->object->getCity();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BillingAddressEntity::setCity()
     */
    public function testSetCity()
    {
    	$city = 'city_' . rand(1,9);
    	$rs   = $this->object->setCity($city);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\BillingAddressEntity', $rs);

    	$rs = $this->object->getCity();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($city, $rs);
    }

    /**
     * @see BillingAddressEntity::getState()
     */
    public function testGetState()
    {
    	$rs = $this->object->getState();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BillingAddressEntity::setState()
     */
    public function testSetState()
    {
    	$state = 'state_' . rand(1,9);
    	$rs    = $this->object->setState($state);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\BillingAddressEntity', $rs);

    	$rs = $this->object->getState();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($state, $rs);
    }

    /**
     * @see BillingAddressEntity::getCountry()
     */
    public function testGetCountry()
    {
    	$rs = $this->object->getCountry();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BillingAddressEntity::setCountry()
     */
    public function testSetCountry()
    {
    	$country = 'country_' . rand(1,9);
    	$rs      = $this->object->setCountry($country);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\BillingAddressEntity', $rs);

    	$rs = $this->object->getCountry();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($country, $rs);
    }

    /**
     * @see BillingAddressEntity::getPostalCode()
     */
    public function testGetpostalCode()
    {
    	$rs = $this->object->getPostalCode();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BillingAddressEntity::setPostalCode()
     */
    public function testSetPostalCode()
    {
    	$postalCode = 'postalCode_' . rand(1,9);
    	$rs         = $this->object->setPostalCode($postalCode);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\BillingAddressEntity', $rs);

    	$rs = $this->object->getPostalCode();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($postalCode, $rs);
    }

    /**
     * @see BillingAddressEntity::getPhone()
     */
    public function testGetPhone()
    {
    	$rs = $this->object->getPhone();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BillingAddressEntity::setPhone()
     */
    public function testSetPhone()
    {
    	$phone = rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs    = $this->object->setPhone($phone);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\BillingAddressEntity', $rs);

    	$rs = $this->object->getPhone();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($phone, $rs);
    }

    /**
     * @see BillingAddressEntity::isEmpty()
     */
    public function testIsEmptyTrue()
    {
        $rs = $this->object->isEmpty();
        $this->assertTrue($rs);
    }

    /**
     * @see BillingAddressEntity::isEmpty()
     */
    public function testIsEmptyFalse()
    {
        $this->object->setCity('what-ever');
        $rs = $this->object->isEmpty();
        $this->assertFalse($rs);
    }
    
    /**
     * @see BillingAddressEntity::toArray()
     */
    public function testToArray()
    {
    	$entity = array(
    		'street1'    => 'street1_' . rand(1,1000),
   			'street2'    => 'street1_' . rand(1,1000),
   			'city'       => 'city_' . rand(1,1000),
   			'state'      => 'state_' . rand(1,1000),
   			'country'    => 'country_' . rand(1,1000),
   			'postalCode' => 'postalCode_' . rand(1,1000),
   			'phone'      => 'phone_' . rand(1,1000),
    	);

    	$this->object->setStreet1($entity['street1'])
    	             ->setStreet2($entity['street2'])
    	             ->setCity($entity['city'])
    	             ->setState($entity['state'])
    	             ->setCountry($entity['country'])
    	             ->setPostalCode($entity['postalCode'])
    	             ->setPhone($entity['phone']);

    	$rs = $this->object->toArray();
    	$this->assertSame($entity, $rs);
    }

    public function testIsEmptyWithNotEmptyObjectShouldReturnFalse()
    {
        $this->object->setCity('Test');
        $this->assertFalse($this->object->isEmpty());
    }
}
