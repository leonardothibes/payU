<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

use \PayU\Entity\EntityInterface;
use \PayU\Entity\Transaction\TransactionEntity;

/**
 * Request order class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class RequestEntity implements EntityInterface
{
    /**
     * Transaction object.
     * @var TransactionEntity
     */
    protected $transaction = null;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->transaction = new TransactionEntity();
    }

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
     * Generate arry order.
     * @return array
     */
    public function toArray()
    {
        return array('transaction' => $this->transaction->toArray());
    }
}
