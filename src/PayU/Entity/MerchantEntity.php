<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

use \PayU\Entity\MerchantEntity;

/**
 * Merchant order class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class MerchantEntity
{
    /**
     * Merchant id.
     * @var string
     */
    protected $merchantId = null;
    
    /**
     * Set merchant id.
     *
     * @param  string $merchantId
     * @return MerchantEntity
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = (string)$merchantId;
        return $this;
    }
    
    /**
     * Get merchant id.
     * @return string
     */
    public function getMerchantId()
    {
        return (string)$this->merchantId;
    }
    
    /**
     * Api login.
     * @var string
     */
    protected $apiLogin = null;
    
    /**
     * Set api login.
     *
     * @param  string $apiLogin
     * @return MerchantEntity
     */
    public function setApiLogin($apiLogin)
    {
        $this->apiLogin = (string)$apiLogin;
        return $this;
    }
    
    /**
     * Get api login.
     * @return string
     */
    public function getApiLogin()
    {
        return (string)$this->apiLogin;
    }

    /**
     * Api key.
     * @var string
     */
    protected $apiKey = null;
    
    /**
     * Set api key.
     *
     * @param string $apiKey
     * @return MerchantEntity
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = (string)$apiKey;
        return $this;
    }
    
    /**
     * Get api key.
     * @return string
     */
    public function getApiKey()
    {
        return (string)$this->apiKey;
    }

    /**
     * Account id.
     * @var string
     */
    protected $accountId = null;
    
    /**
     * Set account id.
     *
     * @param  string $accountId
     * @return MerchantEntity
     */
    public function setAccountId($accountId)
    {
        $this->accountId = (string)$accountId;
        return $this;
    }

    /**
     * Get account id.
     * @return string
     */
    public function getAccountId()
    {
        return (string)$this->accountId;
    }
}
