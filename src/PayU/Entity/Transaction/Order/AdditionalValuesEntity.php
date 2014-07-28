<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\EntityInterface;

/**
 * Order additional values entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class AdditionalValuesEntity implements EntityInterface
{
    /**
     * Additional values indexes constants.
     */
    const TX_VALUE            = 'TX_VALUE';
    const TX_TAX              = 'TX_TAX';
    const TX_TAX_RETURN_BASE  = 'TX_TAX_RETURN_BASE';
    const TX_ADDITIONAL_VALUE = 'TX_ADDITIONAL_VALUE';

    /**
     * Additional values list.
     * @var array
     */
    protected $additionalValues = array();

    /**
     * Add tax.
     *
     * @param string $tax
     * @param string $currency
     * @param string $value
     *
     * @return AdditionalValuesEntity
     */
    public function addTax($tax, $currency, $value)
    {
    	$this->additionalValues[] = array(
    		'string' => $tax,
    		'additionalValue' => array(
    			'currency' => $currency,
    			'value'    => $value,
    		)
    	);
        return $this;
    }
    
    /**
	 * Generate xml order.
	 * @return \SimpleXMLElement
	 */
	public function toXml()
    {
    	$xml = new \SimpleXMLElement('<additionalValues />');
    	
    	if (count($this->additionalValues) > 0) {
    		foreach ($this->additionalValues as $row) {
    			
	    		$entry = $xml->addChild('entry');
	    		$entry->addChild('string', $row['string']);
	    		
	    		$additionalValue = $entry->addChild('additionalValue');
	    		$additionalValue->addChild('currency', $row['additionalValue']['currency']);
	    		$additionalValue->addChild('value', $row['additionalValue']['value']);
    		}
    	}
    	
    	return $xml;
    }

    /**
     * Generate arry order.
     * @return array
     */
    public function toArray()
    {
        return $this->additionalValues;
    }
}
