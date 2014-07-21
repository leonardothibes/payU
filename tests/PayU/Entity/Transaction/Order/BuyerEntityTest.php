<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\Transaction\ShippingAddressEntity;
use \PayU\Entity\Transaction\Order\BuyerEntity;
use \Tbs\Helper\Cpf;

require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class BuyerEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var BuyerEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new BuyerEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * @see BuyerEntity::getFullName()
     */
    public function testGetFullName()
    {
    	$rs = $this->object->getFullName();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BuyerEntity::setFullName()
     */
    public function testSetFullName()
    {
    	$name = 'person name ' . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs   = $this->object->setFullName($name);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\BuyerEntity', $rs);

    	$rs = $this->object->getFullName();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($name, $rs);
    }

    /**
     * @see BuyerEntity::getEmailAddress()
     */
    public function testGetEmailAddress()
    {
    	$rs = $this->object->getEmailAddress();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BuyerEntity::setEmailAddress()
     */
    public function testSetEmailAddress()
    {
    	$email = 'email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com';
    	$rs    = $this->object->setEmailAddress($email);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\BuyerEntity', $rs);

    	$rs = $this->object->getEmailAddress();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($email, $rs);
    }

    /**
     * @see BuyerEntity::setEmailAddress()
     */
    public function testSetEmailAddressInvalid()
    {
    	try {
    		$this->object->setEmailAddress('email-address');
    	} catch (\Exception $e) {
    		$this->assertInstanceOf('\PayU\Entity\EntityException', $e);
    		$this->assertEquals('Invalid e-mail address: email-address', $e->getMessage());
    		$this->assertEquals(0, $e->getCode());
    	}
    }

    /**
     * @see BuyerEntity::getDniNumber()
     */
    public function testGetDniNumber()
    {
    	$rs = $this->object->getDniNumber();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see BuyerEntity::setDniNumber()
     */
    public function testSetDniNumber()
    {
    	$dni = Cpf::random();
    	$rs  = $this->object->setDniNumber($dni);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\BuyerEntity', $rs);

    	$rs = $this->object->getDniNumber();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($dni, $rs);
    }

    /**
     * @see BuyerEntity::getShippingAddress()
     */
    public function testGetShippingAddress()
    {
    	$rs = $this->object->getShippingAddress();
    	$this->assertNull($rs);
    }

    /**
     * @see BuyerEntity::setShippingAddress()
     */
    public function testSetShippingAddress()
    {
    	$address = array(
    		'street1'    => 'street1_' . rand(1,1000),
    		'street2'    => 'street2_' . rand(1,1000),
    		'city'       => 'city_' . rand(1,1000),
    		'state'      => 'state_' . rand(1,1000),
    		'country'    => 'country_' . rand(1,1000),
    		'postalCode' => 'postalCode_' . rand(1,1000),
    		'phone'      => 'phone_' . rand(1,1000),
    	);
    	$shippingAddress = new ShippingAddressEntity();
    	$shippingAddress->setStreet1($address['street1'])
    	                ->setStreet2($address['street2'])
    	                ->setCity($address['city'])
    	                ->setState($address['state'])
    	                ->setCountry($address['country'])
    	                ->setPostalCode($address['postalCode'])
    	                ->setPhone($address['phone']);

    	$rs = $this->object->setShippingAddress($shippingAddress);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\BuyerEntity', $rs);

    	$rs = $this->object->getShippingAddress();
    	$this->assertEquals($shippingAddress->getStreet1()   , $rs->getStreet1());
    	$this->assertEquals($shippingAddress->getStreet2()   , $rs->getStreet2());
    	$this->assertEquals($shippingAddress->getCity()      , $rs->getCity());
    	$this->assertEquals($shippingAddress->getState()     , $rs->getState());
    	$this->assertEquals($shippingAddress->getCountry()   , $rs->getCountry());
    	$this->assertEquals($shippingAddress->getPostalCode(), $rs->getPostalCode());
    	$this->assertEquals($shippingAddress->getPhone()     , $rs->getPhone());
    }

    /**
     * @see BuyerEntity::toArray()
     */
    public function testToArray()
    {
    	$address = array(
    			'street1'    => 'street1_' . rand(1,1000),
    			'street2'    => 'street2_' . rand(1,1000),
    			'city'       => 'city_' . rand(1,1000),
    			'state'      => 'state_' . rand(1,1000),
    			'country'    => 'country_' . rand(1,1000),
    			'postalCode' => 'postalCode_' . rand(1,1000),
    			'phone'      => 'phone_' . rand(1,1000),
    	);
    	$shippingAddress = new ShippingAddressEntity();
    	$shippingAddress->setStreet1($address['street1'])
            	    	->setStreet2($address['street2'])
	    	            ->setCity($address['city'])
	    	            ->setState($address['state'])
	    	            ->setCountry($address['country'])
	    	            ->setPostalCode($address['postalCode'])
	    	            ->setPhone($address['phone']);
    	$this->object->setShippingAddress($shippingAddress);

    	$buyer = array(
    		'fullName'        => 'person name ' . rand(1,9) . rand(1,9) . rand(1,9),
    		'emailAddress'    => 'email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com',
    		'dniNumber'       => Cpf::random(),
    		'shippingAddress' => $address,
    	);
    	$this->object->setFullName($buyer['fullName'])
    	             ->setEmailAddress($buyer['emailAddress'])
    	             ->setDniNumber($buyer['dniNumber']);

    	$rs = $this->object->toArray();
    	$this->assertSame($buyer, $rs);
    }
}
