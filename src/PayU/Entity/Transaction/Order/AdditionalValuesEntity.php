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
    protected $additionalValues = array(
    	self::TX_VALUE            => array('currency' => 'US', 'value' => 0),
    	self::TX_TAX              => array('currency' => 'US', 'value' => 0),
    	self::TX_TAX_RETURN_BASE  => array('currency' => 'US', 'value' => 0),
    	self::TX_ADDITIONAL_VALUE => array('currency' => 'US', 'value' => 0),
    );

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
        $this->additionalValues[$tax]['currency'] = (string)$currency;
        $this->additionalValues[$tax]['value']    = (string)$value;
        return $this;
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
