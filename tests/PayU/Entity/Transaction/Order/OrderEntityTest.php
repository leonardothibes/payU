<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\Transaction\Order\OrderEntity;
use \PayU\Entity\Transaction\Order\BuyerEntity;
use \PayU\Entity\Transaction\Order\AdditionalValuesEntity;
use \PayU\Entity\Transaction\ShippingAddressEntity;
use \Tbs\Helper\Cpf;

require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class OrderEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OrderEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new OrderEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

	/**
	 * @see OrderEntity::getAccountId()
	 */
    public function testGetAccountId()
    {
    	$rs = $this->object->getAccountId();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see OrderEntity::setAccountId()
     */
    public function testSetAccountId()
    {
    	$accountId = 'accountId_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs        = $this->object->setAccountId($accountId);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

    	$rs = $this->object->getAccountId();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($accountId, $rs);
    }

    /**
     * @see OrderEntity::getReferenceCode()
     */
    public function testGetReferenceCode()
    {
    	$rs = $this->object->getReferenceCode();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see OrderEntity::setReferenceCode()
     */
    public function testSetReferenceCode()
    {
    	$referenceCode = 'referenceCode_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs            = $this->object->setReferenceCode($referenceCode);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

    	$rs = $this->object->getReferenceCode();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($referenceCode, $rs);
    }

    /**
     * @see OrderEntity::getDescription()
     */
    public function testGetDescription()
    {
    	$rs = $this->object->getDescription();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see OrderEntity::setDescription()
     */
    public function testSetDescription()
    {
    	$description = 'description_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs            = $this->object->setDescription($description);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

    	$rs = $this->object->getDescription();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($description, $rs);
    }

    /**
     * @see OrderEntity::getLanguage()
     */
    public function testGetLanguage()
    {
    	$rs = $this->object->getLanguage();
    	$this->assertEquals('en', $rs);
    }

    /**
     * @see OrderEntity::setLanguage()
     */
    public function testSetLanguage()
    {
    	$language = 'language_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs       = $this->object->setLanguage($language);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

    	$rs = $this->object->getLanguage();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($language, $rs);
    }

    /**
     * @see OrderEntity::setLanguage()
     */
    public function testSetLanguageDefault()
    {
    	$rs = $this->object->setLanguage()
    	                   ->getLanguage();
    	$this->assertEquals('en', $rs);
    }

    /**
     * @see OrderEntity::getNotifyUrl()
     */
    public function testGetNotifyUrl()
    {
    	$rs = $this->object->getNotifyUrl();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see OrderEntity::setNotifyUrl()
     */
    public function testSetNotifyUrl()
    {
    	$notifyUrl = 'http://notifyurl-' . rand(1,9) . rand(1,9) . rand(1,9) . '.com';
    	$rs        = $this->object->setNotifyUrl($notifyUrl);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

    	$rs = $this->object->getNotifyUrl();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($notifyUrl, $rs);
    }

    /**
     * @see OrderEntity::setNotifyUrl()
     */
    public function testSetNotifyUrlException()
    {
    	try {
    		$this->object->setNotifyUrl('url-here');
    	} catch (\Exception $e) {
    		$this->assertInstanceOf('\PayU\Entity\EntityException', $e);
    		$this->assertEquals('Invalid url: url-here', $e->getMessage());
    		$this->assertEquals(0, $e->getCode());
    	}
    }

    /**
     * @see OrderEntity::getSignature()
     */
    public function testGetSignature()
    {
    	$rs = $this->object->getSignature();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see OrderEntity::setSignature()
     */
    public function testSetSignature()
    {
    	$signature = sha1('signature');
    	$rs        = $this->object->setSignature($signature);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

    	$rs = $this->object->getSignature();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($signature, $rs);
    }

    /**
     * @see OrderEntity::getShippingAddress()
     */
    public function testGetShippingAddress()
    {
    	$rs = $this->object->getShippingAddress();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs);

    	$this->assertEquals(0, strlen($rs->getStreet1()));
    	$this->assertEquals(0, strlen($rs->getStreet2()));
    	$this->assertEquals(0, strlen($rs->getCity()));
    	$this->assertEquals(0, strlen($rs->getState()));
    	$this->assertEquals(0, strlen($rs->getCountry()));
    	$this->assertEquals(0, strlen($rs->getPostalCode()));
    	$this->assertEquals(0, strlen($rs->getPhone()));
    }

    /**
     * @see OrderEntity::setShippingAddress()
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
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);

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
	 * @see OrderEntity::getBuyer()
	 */
    public function testGetBuyer()
    {
    	$rs = $this->object->getBuyer();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\BuyerEntity', $rs);

    	$this->assertEquals(0, strlen($rs->getFullName()));
    	$this->assertEquals(0, strlen($rs->getEmailAddress()));
    	$this->assertEquals(0, strlen($rs->getDniNumber()));
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $rs->getShippingAddress());
    }

    /**
     * @see OrderEntity::setBuyer()
     */
    public function testSetBuyer()
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

    	$buyerEntity = new BuyerEntity();
    	$buyerEntity->setShippingAddress($shippingAddress);

   		$buyer = array(
    		'fullName'        => 'person name ' . rand(1,9) . rand(1,9) . rand(1,9),
    		'emailAddress'    => 'email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com',
    		'dniNumber'       => Cpf::random(),
    		'shippingAddress' => $address,
    	);
    	$buyerEntity->setFullName($buyer['fullName'])
    	            ->setEmailAddress($buyer['emailAddress'])
    	            ->setDniNumber($buyer['dniNumber']);
    	$this->object->setBuyer($buyerEntity);

    	$rs = $this->object->getBuyer();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\BuyerEntity', $rs);

    	$this->assertEquals($buyer['fullName'], $rs->getFullName());
    	$this->assertEquals($buyer['emailAddress'], $rs->getEmailAddress());
    	$this->assertEquals($buyer['dniNumber'], $rs->getDniNumber());

    	$shippingAddress = $rs->getShippingAddress();
    	$this->assertInstanceOf('\PayU\Entity\Transaction\ShippingAddressEntity', $shippingAddress);

    	$this->assertEquals($shippingAddress->getStreet1()   , $address['street1']);
    	$this->assertEquals($shippingAddress->getStreet2()   , $address['street2']);
    	$this->assertEquals($shippingAddress->getCity()      , $address['city']);
    	$this->assertEquals($shippingAddress->getState()     , $address['state']);
    	$this->assertEquals($shippingAddress->getCountry()   , $address['country']);
    	$this->assertEquals($shippingAddress->getPostalCode(), $address['postalCode']);
    	$this->assertEquals($shippingAddress->getPhone()     , $address['phone']);
    }

    /**
     * @see OrderEntity::getAdditionalValues()
     */
    public function testGetAdditionalValues()
    {
		$rs = $this->object->getAdditionalValues();
		$this->assertInstanceOf('\PayU\Entity\Transaction\Order\AdditionalValuesEntity', $rs);
    }

    /**
     * @see OrderEntity::setAdditionalValues()
     */
    public function testSetAdditionalValues()
    {
    	$additionalValues = new AdditionalValuesEntity();
    	$additionalValues->addTax(AdditionalValuesEntity::TX_VALUE, 'BRL'    , 'BRL', 1000);
    	$additionalValues->addTax(AdditionalValuesEntity::TX_TAX, 'BRL'      , 'BRL', 1000);
    	$additionalValues->addTax(AdditionalValuesEntity::TX_TAX_RETURN_BASE , 'BRL', 1000);
    	$additionalValues->addTax(AdditionalValuesEntity::TX_ADDITIONAL_VALUE, 'BRL', 1000);

    	$rs = $this->object->setAdditionalValues($additionalValues);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\Order\OrderEntity', $rs);
    }

	/**
	 * @see OrderEntity::isEmpty()
	 */
	public function testIsEmptyTrue()
	{
		$rs = $this->object->isEmpty();
		$this->assertTrue($rs);
	}

	/**
	 * @see OrderEntity::isEmpty()
	 */
	public function testIsEmptyFalse()
	{
		$this->object->setAccountId('what-ever');
		$rs = $this->object->isEmpty();
		$this->assertFalse($rs);
	}
    
    /**
     * @see OrderEntity::toArray()
     */
    public function testToArray()
    {
    	$accountId = 'accountId_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$this->object->setAccountId($accountId);

    	$referenceCode = 'referenceCode_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$this->object->setReferenceCode($referenceCode);

    	$description = 'description_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$this->object->setDescription($description);

    	$language = 'language_' . rand(1,9) . rand(1,9) . rand(1,9);
    	$this->object->setLanguage($language);

    	$notifyUrl = 'http://notifyurl-' . rand(1,9) . rand(1,9) . rand(1,9) . '.com';
    	$this->object->setNotifyUrl($notifyUrl);

    	$signature = sha1('signature');
    	$this->object->setSignature($signature);

    	$shippingAddress = $this->object->getShippingAddress();
    	$shippingAddress->setStreet1('street1_' . rand(1,1000))
				    	->setStreet2('street2_' . rand(1,1000))
				    	->setCity('city_' . rand(1,1000))
				    	->setState('state_' . rand(1,1000))
				    	->setCountry('country_' . rand(1,1000))
				    	->setPostalCode('postalCode_' . rand(1,1000))
				    	->setPhone('phone_' . rand(1,1000));

    	$buyer = $this->object->getBuyer();
    	$buyer->setFullName('person name ' . rand(1,9) . rand(1,9) . rand(1,9))
	    	  ->setEmailAddress('email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com')
	    	  ->setDniNumber(Cpf::random())
    		  ->setShippingAddress($shippingAddress);

    	$additionalValues = $this->object->getAdditionalValues();
    	$additionalValues->addTax(AdditionalValuesEntity::TX_VALUE, 'BRL'    , 'BRL', 1000);
    	$additionalValues->addTax(AdditionalValuesEntity::TX_TAX, 'BRL'      , 'BRL', 1000);
    	$additionalValues->addTax(AdditionalValuesEntity::TX_TAX_RETURN_BASE , 'BRL', 1000);
    	$additionalValues->addTax(AdditionalValuesEntity::TX_ADDITIONAL_VALUE, 'BRL', 1000);

    	$order = $this->object->toArray();
    	$this->assertInternalType('array', $order);

    	$this->assertEquals($accountId, $order['accountId']);
    	$this->assertEquals($referenceCode, $order['referenceCode']);
    	$this->assertEquals($description, $order['description']);
    	$this->assertEquals($language, $order['language']);
    	$this->assertEquals($notifyUrl, $order['notifyUrl']);
    	$this->assertEquals($signature, $order['signature']);

    	$this->assertEquals($shippingAddress->getStreet1()   , $order['shippingAddress']['street1']);
    	$this->assertEquals($shippingAddress->getStreet2()   , $order['shippingAddress']['street2']);
    	$this->assertEquals($shippingAddress->getCity()      , $order['shippingAddress']['city']);
    	$this->assertEquals($shippingAddress->getState()     , $order['shippingAddress']['state']);
    	$this->assertEquals($shippingAddress->getCountry()   , $order['shippingAddress']['country']);
    	$this->assertEquals($shippingAddress->getPostalCode(), $order['shippingAddress']['postalCode']);
    	$this->assertEquals($shippingAddress->getPhone()     , $order['shippingAddress']['phone']);

    	$this->assertEquals($buyer->getFullName()      , $order['buyer']['fullName']);
    	$this->assertEquals($buyer->getEmailAddress()  , $order['buyer']['emailAddress']);
    	$this->assertEquals($buyer->getDniNumber()     , $order['buyer']['dniNumber']);
    	$this->assertEquals($shippingAddress->toArray(), $order['buyer']['shippingAddress']);

    	$this->assertEquals($additionalValues->toArray(), $order['additionalValues']);
    }
}
