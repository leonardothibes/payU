<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Entity\EntityAbstract;
use \PayU\Entity\EntityException;

/**
 * Payer entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PayerEntity extends EntityAbstract
{
    /**
     * Payer full name.
     * @var string
     */
    protected $fullName = null;

    /**
     * Set payer full name.
     *
     * @param  string $fullName
     * @return PayerEntity
     */
    public function setFullName($fullName)
    {
        $this->fullName = (string)$fullName;
        return $this;
    }

    /**
     * Get payer full name.
     * @return string
     */
    public function getFullName()
    {
        return (string)$this->fullName;
    }

    /**
     * Payer e-mail address.
     * @var string
     */
    protected $emailAddress = null;

    /**
     * Set payer e-mail address.
     *
     * @param  string $emailAddress
     * @return PayerEntity
     * @throws EntityException
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = (string)$emailAddress;
        return $this;
    }

    /**
     * Get payer e-mail address.
     * @return string
     */
    public function getEmailAddress()
    {
        return (string)$this->emailAddress;
    }

    /**
     * Generate array order.
     * @return array
     */
    public function toArray()
    {
        return array(
            'fullName'     => $this->fullName,
            'emailAddress' => $this->emailAddress,
        );
    }
}
