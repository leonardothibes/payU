<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU;

/**
 * Version api functions.
 *
 * @package PayU
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PayUVersion
{
    /**
     * Get location of version number file.
     * @return string
     */
    public static function getVersionFileLocation()
    {
        return realpath(dirname(__FILE__) . '/Version/Number.txt');
    }

    /**
     * Get the current version number.
     * @return string
     */
    public static function getCurrent()
    {
        $file = self::getVersionFileLocation();
        return trim(file_get_contents($file), '\t\n\r');
    }
}
