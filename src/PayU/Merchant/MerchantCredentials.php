<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Merchant;

/**
 * Merchant credentials class.
 *
 * @package PayU\Credentials
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class MerchantCredentials
{
    /**
     * Singleton instance.
     * @var MerchantCredentials
     */
    protected static $instance = null;

    /**
     * Merchant api login.
     * @var string
     */
    protected $apiLogin = null;

    /**
     * Merchant api key.
     * @var string
     */
    protected $apiKey = null;

    /**
     * Gets a singleton instance of class.
     * @return MerchantCredentials
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Block non singleton instance by visibility.
     */
    protected function __construct()
    {
        //Do nothing...yet
    }

    /**
     * Reset the singleton instance.
     */
    public function resetInstance()
    {
        self::$instance = null;
    }

    /**
     * Set the merchant api login.
     *
     * @param  string $apiLogin
     * @return MerchantCredentials
     */
    public function setApiLogin($apiLogin = null)
    {
        $this->apiLogin = (string)$apiLogin;
        return $this;
    }

    /**
     * Get the merchant api login.
     * @return string
     */
    public function getApiLogin()
    {
        return $this->apiLogin;
    }

    /**
     * Set the merchant api key.
     *
     * @param  string $apiKey
     * @return MerchantCredentials
     */
    public function setApiKey($apiKey = null)
    {
        $this->apiKey = (string)$apiKey;
        return $this;
    }

    /**
     * Get the merchant api key.
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }
}
