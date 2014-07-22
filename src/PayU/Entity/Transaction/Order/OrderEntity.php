<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\EntityInterface;
use \PayU\Entity\EntityException;

use \PayU\Entity\Transaction\ShippingAddressEntity;
use \PayU\Entity\Transaction\Order\BuyerEntity;
use \PayU\Entity\Transaction\Order\AdditionalValuesEntity;

/**
 * Order entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class OrderEntity implements EntityInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->shippingAddress  = new ShippingAddressEntity();
        $this->additionalValues = new AdditionalValuesEntity();
        $this->buyer            = new BuyerEntity();
    }

    /**
     * Client identifier id.
     * @var string
     */
    protected $accountId = null;

    /**
     * Set client identifier id.
     *
     * @param  string $accountId
     * @return OrderEntity
     */
    public function setAccountId($accountId)
    {
        $this->accountId = (string)$accountId;
        return $this;
    }

    /**
     * Get client identifier id.
     * @return string
     */
    public function getAccountId()
    {
        return (string)$this->accountId;
    }

    /**
     * Reference code on merchant system.
     * @var string
     */
    protected $referenceCode = null;

    /**
     * Set reference code on merchant system.
     *
     * @param  string $referenceCode
     * @return OrderEntity
     */
    public function setReferenceCode($referenceCode)
    {
        $this->referenceCode = (string)$referenceCode;
        return $this;
    }

    /**
     * Get reference code on merchant system.
     */
    public function getReferenceCode()
    {
        return (string)$this->referenceCode;
    }

    /**
     * Request order description.
     * @var string
     */
    protected $description = null;

    /**
     * Set request order description.
     *
     * @param  string $description
     * @return OrderEntity
     */
    public function setDescription($description)
    {
        $this->description = (string)$description;
        return $this;
    }

    /**
     * Get request order description.
     * @return string
     */
    public function getDescription()
    {
        return (string)$this->description;
    }

    /**
     * Language of e-mails.
     * @var string
     */
    protected $language = 'en';

    /**
     * Set language of e-mails.
     *
     * @param  string language
     * @return OrderEntity
     */
    public function setLanguage($language = 'en')
    {
        $this->language = (string)$language;
        return $this;
    }

    /**
     * Get language of e-mails.
     * @return string
     */
    public function getLanguage()
    {
        return (string)$this->language;
    }

    /**
     * Notify url.
     * @var string
     */
    protected $notifyUrl = null;

    /**
     * Set notify url.
     *
     * @param  string $notifyUrl
     * @return OrderEntity
     * @throws EntityException
     */
    public function setNotifyUrl($notifyUrl)
    {
        if (substr($notifyUrl, 0, 4) != 'http') {
            $message = sprintf('Invalid url: %s', $notifyUrl);
            throw new EntityException($message);
        }
        $this->notifyUrl = (string)$notifyUrl;
        return $this;
    }

    /**
     * Get notify url.
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * Signature of order.
     * @var string
     */
    protected $signature = null;

    /**
     * Set signature of order.
     *
     * @param  string $signature
     * @return OrderEntity
     */
    public function setSignature($signature)
    {
        $this->signature = (string)$signature;
        return $this;
    }

    /**
     * Get signature of order.
     * @return string
     */
    public function getSignature()
    {
        return (string)$this->signature;
    }

    /**
     * Shipping addreess.
     *
     * @see \PayU\Entity\Transaction\ShippingAddressEntity
     * @var ShippingAddressEntity
     */
    protected $shippingAddress = null;

    /**
     * Set shipping addreess.
     *
     * @param  ShippingAddressEntity $shippingAddress
     * @return OrderEntity
     */
    public function setShippingAddress(ShippingAddressEntity $shippingAddress)
    {
        $this->shippingAddress = $shippingAddress;
        return $this;
    }

    /**
     * Set shipping addreess.
     * @return ShippingAddressEntity
     */
    public function getShippingAddress()
    {
        return $this->shippingAddress;
    }

    /**
     * Order buyer.
     *
     * @see \PayU\Entity\Transaction\Order\BuyerEntity
     * @var BuyerEntity
     */
    protected $buyer = null;

    /**
     * Set order buyer.
     *
     * @param  BuyerEntity $buyer
     * @return OrderEntity
     */
    public function setBuyer(BuyerEntity $buyer)
    {
        $this->buyer = $buyer;
        return $this;
    }

    /**
     * Get order buyer.
     * @return BuyerEntity
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Order additional values.
     *
     * @see \PayU\Entity\Transaction\Order\AdditionalValuesEntity
     * @var AdditionalValuesEntity
     */
    protected $additionalValues = null;

    /**
     * Set order additional values.
     *
     * @param  AdditionalValuesEntity $additionalValues
     * @return OrderEntity
     */
    public function setAdditionalValues(AdditionalValuesEntity $additionalValues)
    {
        $this->additionalValues;
        return $this;
    }

    /**
     * Get order additional values.
     * @return AdditionalValuesEntity
     */
    public function getAdditionalValues()
    {
        return $this->additionalValues;
    }

    /**
     * Generate array order.
     * @return array
     */
    public function toArray()
    {
        return array(
            'accountId'        => $this->accountId,
            'referenceCode'    => $this->referenceCode,
            'description'      => $this->description,
            'language'         => $this->language,
            'notifyUrl'        => $this->notifyUrl,
            'signature'        => $this->signature,
            'shippingAddress'  => $this->shippingAddress->toArray(),
            'buyer'            => $this->buyer->toArray(),
            'additionalValues' => $this->additionalValues->toArray(),
        );
    }
}
