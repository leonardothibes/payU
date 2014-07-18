<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Entity\EntityInterface;
use \PayU\Entity\Transaction\Order\OrderEntity;

/**
 * Request transaction order class.
 *
 * @package PayU\Entity\Transaction
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class TransactionEntity implements EntityInterface
{
	/**
	 * Type of transaction.
	 *
	 * @see \PayU\Payment\PaymentTypes
	 * @var string
	 */
	protected $type = null;

	/**
	 * Set type of transaction.
	 *
	 * @see   \PayU\Payment\PaymentTypes
	 * @param stirng $type
	 *
	 * @return TransactionEntity
	 */
	public function setType($type)
	{
		$this->type = (string)$type;
		return $this;
	}

	/**
	 * Get type of transaction.
	 * @return stirng
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * Payment method.
	 *
	 * @see \PayU\Payment\PaymentMethods
	 * @var string
	 */
	protected $paymentMethod = null;

	/**
	 * Set payment method.
	 *
	 * @see   \PayU\Payment\PaymentMethods
	 * @param string $paymentMethod
	 *
	 * @return TransactionEntity
	 */
	public function setPaymentMethod($paymentMethod)
	{
		$this->paymentMethod = (string)$paymentMethod;
		return $this;
	}

	/**
	 * Get payment method.
	 * @return string
	 */
	public function getPaymentMethod()
	{
		return $this->paymentMethod;
	}

	/**
	 * Payment country.
	 *
	 * @see \PayU\Payment\PaymentCountries
	 * @var string
	 */
	protected $paymentCountry = null;

	/**
	 * Set payment country.
	 *
	 * @see   \PayU\Payment\PaymentCountries
	 * @param string $paymentCountry
	 *
	 * @return TransactionEntity
	 */
	public function setPaymentCountry($paymentCountry)
	{
		$this->paymentCountry = (string)$paymentCountry;
	}

	/**
	 * Get payment country.
	 * @return string
	 */
	public function getPaymentCountry()
	{
		return $this->paymentCountry;
	}

	/**
	 * Client IP address(optional).
	 * @var string
	 */
	protected $ipAddress = null;

	/**
	 * Set client IP address.
	 *
	 * @param  string $ipAddress
	 * @return TransactionEntity
	 */
	public function setIpAddress($ipAddress)
	{
		$this->ipAddress = (string)$ipAddress;
		return $this;
	}

	/**
	 * Get client IP address.
	 * @return string
	 */
	public function getIpAddress()
	{
		return (string)$this->ipAddress;
	}

	/**
	 * Cookie value on client(optional).
	 * @var string
	 */
	protected $cookie = null;

	/**
	 * Set cookie value.
	 *
	 * @param  string $cookie
	 * @return TransactionEntity
	 */
	public function setCookie($cookie)
	{
		$this->cookie = (string)$cookie;
		return $this;
	}

	/**
	 * Get cookie value.
	 * @return string
	 */
	public function getCookie()
	{
		return (string)$this->cookie;
	}

	/**
	 * Client user agent(optional).
	 * @var string
	 */
	protected $userAgent = null;

	/**
	 * Set user agent.
	 *
	 * @param  string $userAgent
	 * @return TransactionEntity
	 */
	public function setUserAgent($userAgent)
	{
		$this->userAgent = (string)$userAgent;
		return $this;
	}

	/**
	 * Set user agent.
	 * @return string
	 */
	public function getUserAgent()
	{
		return (string)$this->userAgent;
	}

	/**
	 * Order registry.
	 * @var \PayU\Entity\Transaction\Order\OrderEntity
	 */
	protected $order = null;

	/**
	 * Set order registry.
	 *
	 * @param  OrderEntity $order
	 * @return TransactionEntity
	 */
	public function serOrder(OrderEntity $order)
	{
		$this->order = $order;
		return $this;
	}

	/**
	 * Get order registry.
	 * @return OrderEntity
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * Generate arry order.
	 * @return array
	 */
	public function toArray()
	{
		return array();
	}
}
