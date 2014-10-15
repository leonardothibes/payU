<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

use \PayU\Entity\EntityInterface;

/**
 * Interface for all order entities.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
abstract class EntityAbstract implements EntityInterface
{
    /**
     * Returns if object is empty
     * @return bool
     */
    public function isEmpty()
    {
        foreach (get_object_vars($this) as $property) {
            if ($property !== null and $property !== false and $property !== '') {
                return false;
            }
        }
        return true;
    }
}
