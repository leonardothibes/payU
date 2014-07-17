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
	 * Payment method.
	 *
	 * @see \PayU\Payment\PaymentMethods
	 * @var string
	 */
	protected $paymentMethod = null;

	/**
	 * Payment country.
	 *
	 * @see \PayU\Payment\PaymentCountries
	 * @var string
	 */
	protected $paymentCountry = null;

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
































