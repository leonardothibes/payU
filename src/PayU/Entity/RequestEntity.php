<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity;

use \PayU\Api\ApiAbstract;
use \PayU\Payment\PaymentApi;
use \PayU\Entity\EntityInterface;

/**
 * Request order class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class RequestEntity extends ApiAbstract
{
    /**
     * Request body.
     * @var array
     */
    protected $request = array('command' => 'SUBMIT_TRANSACTION');

    /**
     * Ping request for service health.
     * @return bool
     */
    public function ping()
    {
        $payment = new PaymentApi($this->credentials);
        $payment->setStaging($this->isStaging);
        return $payment->ping();
    }

    /**
     * Add a transaction entity to json.
     *
     * @param  array $transaction
     * @return RequestEntity
     */
    public function addTransaction(array $transaction)
    {
        $this->request['transaction'] = $transaction;
        return $this;
    }

    /**
     * Generate json order.
     * @return string
     */
    public function toJson()
    {
        $json = json_encode($this->request);
        return $this->addMetadata($json);
    }
}
