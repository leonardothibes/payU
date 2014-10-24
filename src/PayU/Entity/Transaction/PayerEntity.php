<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Entity\Transaction\BillingAddressEntity;
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
     * Constructor.
     */
    public function __construct()
    {
        $this->billingAddress = new BillingAddressEntity();
    }

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
     * DNI number
     * @var string
     */
    protected $dniNumber = null;

    /**
     * Set DNI number
     *
     * @param  string $dniNumber
     * @return PayerEntity
     */
    public function setDniNumber($dniNumber)
    {
        $this->dniNumber = (string)$dniNumber;
        return $this;
    }

    /**
     * Get DNI number
     * @return string
     */
    public function getDniNumber()
    {
        return (string)$this->dniNumber;
    }

    /**
     * Contact number.
     * @var string
     */
    protected $contactPhone = null;

    /**
     * Set the contact phone.
     *
     * @param  string $contactPhone
     * @return PayerEntity
     */
    public function setContactPhone($contactPhone)
    {
        $this->contactPhone = (string)$contactPhone;
        return $this;
    }

    /**
     * Get the contact phone.
     * @return string
     */
    public function getContactPhone()
    {
        return (string)$this->contactPhone;
    }

    /**
     * Billing address.
     * @var BillingAddressEntity
     */
    protected $billingAddress = null;

    /**
     * Set the billing address.
     *
     * @param  BillingAddressEntity $billingAddress
     * @return PayerEntity
     */
    public function setBillingAddress(BillingAddressEntity $billingAddress)
    {
        $this->billingAddress = $billingAddress;
        return $this;
    }

    /**
     * Get the billing address.
     * @return BillingAddressEntity
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
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
            'contactPhone' => $this->contactPhone,
            'BuyerAddress' => $this->billingAddress,
        );
    }
}
