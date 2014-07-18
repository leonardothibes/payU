<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

/**
 * Interface for all order entities.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
interface EntityInterface
{
    /**
     * Generate arry order.
     * @return array
     */
    public function toArray();
}
