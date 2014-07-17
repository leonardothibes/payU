<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Entity\EntityInterface;

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
	 */

	/**
	 * Client IP address(optional).
	 * @var string
	 */
	protected $ipAddress = null;

	/**
	 * Cookie value on client(optional).
	 * @var string
	 */
	protected $cookie = null;

	/**
	 * Client browser name(optional).
	 * @var string
	 */
	protected $userAgent = null;

	/**
	 * Order registry.
	 * @var \PayU\Entity\Transaction\Order\OrderEntity
	 */
	protected $order = null;

	/**
	 * Generate arry order.
	 * @return array
	 */
	public function toArray()
	{
		return array();
	}
}
































