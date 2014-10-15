<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;
use \PayU\Entity\Transaction\PayerEntity;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PayerEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PayerEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new PayerEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

	/**
	 * @see PayerEntity::getFullName()
	 */
    public function testGetFullName()
    {
    	$rs = $this->object->getFullName();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see PayerEntity::setFullName()
     */
    public function testSetFullName()
    {
    	$name = 'person name ' . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs   = $this->object->setFullName($name);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\PayerEntity', $rs);

    	$rs = $this->object->getFullName();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($name, $rs);
    }

    /**
     * @see PayerEntity::getEmailAddress()
     */
    public function testGetEmailAddress()
    {
    	$rs = $this->object->getEmailAddress();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see PayerEntity::setEmailAddress()
     */
    public function testSetEmailAddress()
    {
    	$email = 'email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com';
    	$rs    = $this->object->setEmailAddress($email);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\PayerEntity', $rs);

    	$rs = $this->object->getEmailAddress();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($email, $rs);
    }

    /**
     * @see PayerEntity::setEmailAddress()
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
	 * @see PayerEntity::isEmpty()
	 */
	public function testIsEmptyTrue()
	{
		$rs = $this->object->isEmpty();
		$this->assertTrue($rs);
	}

	/**
	 * @see PayerEntity::isEmpty()
	 */
	public function testIsEmptyFalse()
	{
		$this->object->setFullName('what-ever');
		$rs = $this->object->isEmpty();
		$this->assertFalse($rs);
	}

    /**
     * @see PayerEntity::toArray()
     */
    public function testToArray()
    {
    	$entity = array(
   			'fullName'     => 'person name ' . rand(1,9) . rand(1,9) . rand(1,9),
   			'emailAddress' => 'email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com',
    	);

    	$this->object->setFullName($entity['fullName'])
    	             ->setEmailAddress($entity['emailAddress']);

    	$rs = $this->object->toArray();
    	$this->assertSame($entity, $rs);
    }
}
