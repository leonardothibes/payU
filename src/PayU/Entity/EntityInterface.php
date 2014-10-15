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
     * Returns if object is empty
     * @return bool
     */
    public function isEmpty();

    /**
     * Generate array order.
     * @return array
     */
    public function toArray();
}
