<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

use \PayU\Entity\EntityAbstract;
use \PayU\Merchant\MerchantCredentials;
use \PayU\Entity\Transaction\TransactionEntity;

/**
 * Request order class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class RequestEntity extends EntityAbstract
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->transaction = new TransactionEntity();
    }
    
    /**
     * Language.
     * @var string
     */
    protected $language = 'en';
    
    /**
     * Set the language.
     * 
     * @param  string $language
     * @return RequestEntity
     */
    public function setLanguage($language)
    {
        $this->language = (string)$language;
        return $this;
    }
    
    /**
     * Get the language.
     * @return string
     */
    public function getLanguage()
    {
        return (string)$this->language;
    }
    
    /**
     * Api command.
     * @var string
     */
    protected $command = null;
    
    /**
     * Set api command.
     * 
     * @param  string $command
     * @return RequestEntity
     */
    public function setCommand($command)
    {
        $this->command = (string)$command;
        return $this;
    }
    
    /**
     * Get api command.
     * @return string
     */
    public function getCommand()
    {
        return (string)$this->command;
    }
    
    /**
     * Test flag.
     * @var bool
     */
    protected $isTest = false;
    
    /**
     * Set test flag.
     * 
     * @param  bool $flag
     * @return RequestEntity
     */
    public function setIsTest($flag = true)
    {
        $this->isTest = (bool)$flag;
        return $this;
    }
    
    /**
     * Get test flag.
     * @return bool
     */
    public function getIsTest()
    {
        return (bool)$this->isTest;
    }
    
    /**
     * Merchant.
     * @var MerchantCredentials
     */
    protected $merchant = null;
    
    /**
     * Set merchant.
     * 
     * @param  MerchantCredentials $merchant
     * @return RequestEntity
     */
    public function setMerchant(MerchantCredentials $merchant)
    {
        $this->merchant = $merchant;
        return $this;
    }
    
    /**
     * Get merchant.
     * @return MerchantCredentials
     */
    public function getMerchant()
    {
        return $this->merchant;
    }
    
    /**
     * Transaction object.
     * @var TransactionEntity
     */
    protected $transaction = null;

    /**
     * Set the transaction.
     *
     * @param  TransactionEntity $transaction
     * @return RequestEntity
     */
    public function setTransaction(TransactionEntity $transaction)
    {
        $this->transaction = $transaction;
        return $this;
    }

    /**
     * Get the transaction.
     * @return TransactionEntity
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Returns if object is empty
     * @return bool
     */
    public function isEmpty()
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (
                $value !== null and
                $value !== false and
                $property !== 'language' and
                $property !== 'transaction'
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Generate arry order.
     * @return array
     */
    public function toArray()
    {
        return array('transaction' => $this->transaction->toArray());
    }
}
