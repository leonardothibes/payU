<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction\Order;

use \PayU\Entity\EntityInterface;

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
	 * @var int
	 */
	protected $accountId = null;

	/**
	 * Reference code on merchant system.
	 * @var string
	 */
	protected $referenceCode = null;

	/**
	 * Request ordert description.
	 * @var string
	 */
	protected $description = null;

	/**
	 * Language of e-mails.
	 * @var string
	 */
	protected $language = null;

	/**
	 * Notify url.
	 * @var string
	 */
	protected $notifyUrl = null;

	/**
	 * Signature of order.
	 * @var string
	 */
	protected $signature = null;

	/**
	 * Shipping addreess.
	 * @var \PayU\Entity\Transaction\ShippingAddressEntity
	 */
	protected $shippingAddress = null;

	/**
	 * Order buyer interface.
	 * @var \PayU\Entity\Transaction\Order\BuyerEntity
	 */
	protected $buyer = null;

	/**
	 * Order additional values.
	 * @var \PayU\Entity\Transaction\Order\AdditionalValuesEntity
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





















