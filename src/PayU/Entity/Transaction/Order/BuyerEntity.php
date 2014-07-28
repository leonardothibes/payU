<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\EntityInterface;
use \PayU\Entity\EntityException;
use \PayU\Entity\Transaction\ShippingAddressEntity;

use \Tbs\Helper\Email;

/**
 * Order buyer entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class BuyerEntity implements EntityInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->shippingAddress = new ShippingAddressEntity();
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
     * @return BuyerEntity
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
     * @return BuyerEntity
     * @throws EntityException
     */
    public function setEmailAddress($emailAddress)
    {
        if (!Email::isValid($emailAddress)) {
            $message = sprintf('Invalid e-mail address: %s', $emailAddress);
            throw new EntityException($message);
        }
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
     * @return BuyerEntity
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
     * Shipping address.
     * @var ShippingAddressEntity
     */
    protected $shippingAddress = null;

    /**
     * Set shipping address.
     *
     * @param  ShippingAddressEntity $shippingAddress
     * @return BuyerEntity
     */
    public function setShippingAddress(ShippingAddressEntity $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    /**
     * Get shipping address.
     * @return ShippingAddressEntity
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }
    
    /**
     * Generate xml order.
     * @return \SimpleXMLElement
     */
    public function toXml()
    {
    	$xml = new \SimpleXMLElement('<buyer />');
    	
    	$xml->addChild('fullName', $this->fullName);
    	$xml->addChild('emailAddress', $this->emailAddress);
    	$xml->addChild('dniNumber', $this->dniNumber);
    	 
    	$shippingAddress = $xml->addChild('shippingAddress', $this->shippingAddress->toXml());
    	
    	/*$shippingAddress->addChild('street1', $this->shippingAddress->getStreet1());
    	$shippingAddress->addChild('street2', $this->shippingAddress->getStreet2());
    	$shippingAddress->addChild('city', $this->shippingAddress->getCity());
    	$shippingAddress->addChild('state', $this->shippingAddress->getState());
    	$shippingAddress->addChild('country', $this->shippingAddress->getCountry());
    	$shippingAddress->addChild('postalCode', $this->shippingAddress->getPostalCode());
    	$shippingAddress->addChild('phone', $this->shippingAddress->getPhone());*/
    	 
    	return $xml;
    }

    /**
     * Generate arry order.
     * @return array
     */
    public function toArray()
    {
        return array(
            'fullName'        => $this->fullName,
            'emailAddress'    => $this->emailAddress,
            'dniNumber'       => $this->dniNumber,
            'shippingAddress' => $this->shippingAddress->toArray(),
        );
    }
}
