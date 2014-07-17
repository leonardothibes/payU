<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\EntityInterface;
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
	protected $language = null;

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
	 */
	public function setNotifyUrl($notifyUrl)
	{
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
	 *
	 * This class self generate the signature.
	 *
	 * @var string
	 */
	protected $signature = null;

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
	 * @see    \PayU\Entity\Transaction\ShippingAddressEntity
	 * @return ShippingAddressEntity
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
	 * Order buyer interface.
	 *
	 * @see    \PayU\Entity\Transaction\Order\BuyerEntity
	 * @return BuyerEntity
	 */
	protected $buyer = null;

	/**
	 * Order additional values.
	 *
	 * @see    \PayU\Entity\Transaction\Order\AdditionalValuesEntity
	 * @return AdditionalValuesEntity
	 */
	protected $additionalValues = null;

	/**
	 * Generate arry order.
	 * @return array
	 */
	public function toArray()
	{
		return array();
	}
}





















