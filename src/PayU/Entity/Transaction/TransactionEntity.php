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
	 * Supported values:
	 *     - AUTHORIZATION
	 *     - AUTHORIZATION_AND_CAPTURE
	 *
	 * @var string
	 */
	protected $type = null;


	protected $paymentMethod = null;
	protected $paymentCountry = null;
	protected $ipAddress = null;
	protected $cookie = null;
	protected $userAgent = null;
}
































