<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\EntityAbstract;

/**
 * Order additional values entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class AdditionalValuesEntity extends EntityAbstract
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
     * Returns if object is empty
     * @return bool
     */
    public function isEmpty()
    {
        return (count($this->additionalValues) === 0);
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
