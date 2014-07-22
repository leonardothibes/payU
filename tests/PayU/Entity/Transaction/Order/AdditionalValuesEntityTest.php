<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;
use \PayU\Entity\Transaction\Order\AdditionalValuesEntity;
require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class AdditionalValuesEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AdditionalValuesEntity
     */
    protected $object = null;

    /**
     * Setup.
     */
    protected function setUp()
    {
    	$this->object = new AdditionalValuesEntity;
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
    	unset($this->object);
    }

    /**
     * Test constants.
     */
    public function testConstants()
    {
		$this->assertEquals(AdditionalValuesEntity::TX_VALUE, 'TX_VALUE');
		$this->assertEquals(AdditionalValuesEntity::TX_TAX, 'TX_TAX');
		$this->assertEquals(AdditionalValuesEntity::TX_TAX_RETURN_BASE, 'TX_TAX_RETURN_BASE');
		$this->assertEquals(AdditionalValuesEntity::TX_ADDITIONAL_VALUE, 'TX_ADDITIONAL_VALUE');
    }

    /**
     * @see AdditionalValuesEntity::toArray()
     */
    public function testToArray()
    {
    	$this->object->addTax(AdditionalValuesEntity::TX_VALUE, 'BRL'    , 'BRL', 1000);
    	$this->object->addTax(AdditionalValuesEntity::TX_TAX, 'BRL'      , 'BRL', 1000);
    	$this->object->addTax(AdditionalValuesEntity::TX_TAX_RETURN_BASE , 'BRL', 1000);
    	$this->object->addTax(AdditionalValuesEntity::TX_ADDITIONAL_VALUE, 'BRL', 1000);

    	$rs = $this->object->toArray();

    	$this->assertInternalType('array', $rs);
    	$this->assertEquals(4, count($rs));

    	$this->assertArrayHasKey(AdditionalValuesEntity::TX_VALUE, $rs);
    	$this->assertArrayHasKey(AdditionalValuesEntity::TX_TAX, $rs);
    	$this->assertArrayHasKey(AdditionalValuesEntity::TX_TAX_RETURN_BASE, $rs);
    	$this->assertArrayHasKey(AdditionalValuesEntity::TX_ADDITIONAL_VALUE, $rs);

    	$this->markTestIncomplete();
    }
}
