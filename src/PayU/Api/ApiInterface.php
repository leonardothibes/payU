<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Api;

/**
 * Interface for api client classes.
 *
 * @package PayU\Api
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
interface ApiInterface
{
    /**
     * Ping request for service health.
     * @return bool
     */
    public function ping();
}
