<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;
use \PayU\Entity\Transaction\CreditCardEntity;
require_once dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class CreditCardEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CreditCardEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new CreditCardEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

	/**
	 * @see CreditCardEntity::getNumber()
	 */
    public function testGetNumber()
    {
    	$rs = $this->object->getNumber();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see CreditCardEntity::setNumber()
     */
    public function testSetNumber1()
    {
    	$number = str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4);
    	$rs     = $this->object->setNumber($number);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\CreditCardEntity', $rs);

    	$rs = $this->object->getNumber();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($number, $rs);
    }

    /**
     * @see CreditCardEntity::setNumber()
     */
    public function testSetNumber2()
    {
    	$number = str_repeat(rand(1,9), 4) . ' ' . str_repeat(rand(1,9), 4) . ' ' . str_repeat(rand(1,9), 4) . ' ' . str_repeat(rand(1,9), 4);
    	$rs     = $this->object->setNumber($number);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\CreditCardEntity', $rs);

    	$rs = $this->object->getNumber();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals(str_replace(' ', '', $number), $rs);
    }

    /**
     * @see CreditCardEntity::getSecurityCode()
     */
    public function testGetSetSecurityCode()
    {
    	$rs = $this->object->getSecurityCode();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see CreditCardEntity::getSecurityCode()
     */
    public function testSetSecurityCode()
    {
    	$code = rand(1,9) . rand(1,9) . rand(1,9);
    	$rs   = $this->object->setSecurityCode($code);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\CreditCardEntity', $rs);

    	$rs = $this->object->getSecurityCode();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($code, $rs);
    }

    /**
     * @see CreditCardEntity::getExpirationDate()
     */
    public function testGetExpirationDate()
    {
    	$rs = $this->object->getExpirationDate();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see CreditCardEntity::setExpirationDate()
     */
    public function testSetExpirationDate()
    {
    	$date = rand(1,9) . rand(1,9) . rand(1,9). rand(1,9) . '/' . rand(1,9) . rand(1,9);
    	$rs   = $this->object->setExpirationDate($date);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\CreditCardEntity', $rs);

    	$rs = $this->object->getExpirationDate();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($date, $rs);
    }

    /**
     * Invalid expiration dates.
     * @return array
     */
    public function providerInvalidExpirationDates()
    {
    	return array(
    		array('12/2014'),
    		array('2014/1313'),
    	);
    }

    /**
     * @see CreditCardEntity::setExpirationDate()
     * @dataProvider providerInvalidExpirationDates
     */
    public function testSetExpirationDateException($invalidExpirationDate)
    {
    	try {
    		$this->object->setExpirationDate($invalidExpirationDate);
    	} catch (\Exception $e) {
    		$this->assertInstanceOf('\PayU\Entity\EntityException', $e);
    		$this->assertEquals('Invalid expiration date format, use: YYYY/MM', $e->getMessage());
    		$this->assertEquals(0, $e->getCode());
    	}
    }

    /**
     * @see CreditCardEntity::getName()
     */
    public function testGetName()
    {
    	$rs = $this->object->getName();
    	$this->assertEquals(0, strlen($rs));
    }

    /**
     * @see CreditCardEntity::setName()
     */
    public function testSetName()
    {
    	$name = 'person name ' . rand(1,9) . rand(1,9) . rand(1,9);
    	$rs   = $this->object->setName($name);
    	$this->assertInstanceOf('\PayU\Entity\Transaction\CreditCardEntity', $rs);

    	$rs = $this->object->getName();
    	$this->assertInternalType('string', $rs);
    	$this->assertEquals($name, $rs);
    }

	/**
	 * @see CreditCardEntity::isEmpty()
	 */
	public function testIsEmptyTrue()
	{
		$rs = $this->object->isEmpty();
		$this->assertTrue($rs);
	}

	/**
	 * @see CreditCardEntity::isEmpty()
	 */
	public function testIsEmptyFalse()
	{
		$this->object->setName('what-ever');
		$rs = $this->object->isEmpty();
		$this->assertFalse($rs);
	}

    /**
     * @see CreditCardEntity::toArray()
     */
    public function testToArray()
    {
    	$entity = array(
   			'number'         => str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4) . str_repeat(rand(1,9), 4),
   			'securityCode'   => rand(1,9) . rand(1,9) . rand(1,9),
   			'expirationDate' => rand(1,9) . rand(1,9) . rand(1,9). rand(1,9) . '/' . rand(1,9) . rand(1,9),
   			'name'           => 'person name ' . rand(1,9) . rand(1,9) . rand(1,9),
    	);

    	$this->object->setNumber($entity['number'])
    	             ->setSecurityCode($entity['securityCode'])
    	             ->setExpirationDate($entity['expirationDate'])
    	             ->setName($entity['name']);

    	$rs = $this->object->toArray();
    	$this->assertSame($entity, $rs);
    }
}
