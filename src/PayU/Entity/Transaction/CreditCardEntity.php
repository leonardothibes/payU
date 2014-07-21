<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Entity\EntityInterface;
use \PayU\Entity\EntityException;

/**
 * Credit card entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class CreditCardEntity implements EntityInterface
{
	/**
	 * Number of card.
	 * @var string
	 */
	protected $number = null;

	/**
	 * Set credit card number.
	 *
	 * Spaces will be removed.
	 *
	 * @param  string $number
	 * @return CreditCardEntity
	 */
	public function setNumber($number)
	{
		$this->number = str_replace(' ', '', (string)$number);
		return $this;
	}

	/**
	 * Get credit card number.
	 * @return string
	 */
	public function getNumber()
	{
		return (string)$this->number;
	}

	/**
	 * Security code of card.
	 * @var string
	 */
	protected $securityCode;

	/**
	 * Set securoty code.
	 *
	 * @param  string $securityCode
	 * @return CreditCardEntity
	 */
	public function setSecurityCode($securityCode)
	{
		$this->securityCode = (string)$securityCode;
		return $this;
	}

	/**
	 * Get securoty code.
	 * @return string
	 */
	public function getSecurityCode()
	{
		return (string)$this->securityCode;
	}

	/**
	 * Expiration date.
	 * @var string
	 */
	protected $expirationDate = null;

	/**
	 * Set expiration date.
	 *
	 * @param  string $expirationDate Date in YYYY/MM format.
	 * @return CreditCardEntity
	 * @throws EntityException
	 */
	public function setExpirationDate($expirationDate)
	{
		if (!preg_match('/^[0-9]{4}\/[0-9]{2}$/', $expirationDate)) {
			throw new EntityException('Invalid expiration date format, use: YYYY/MM');
		}
		$this->expirationDate = (string)$expirationDate;
		return $this;
	}

	/**
	 * Get expiration date.
	 * @return string
	 */
	public function getExpirationDate()
	{
		return (string)$this->expirationDate;
	}

	/**
	 * Client name in card.
	 * @var string
	 */
	protected $name = null;

	/**
	 * Set client name.
	 *
	 * @param  string $name
	 * @return CreditCardEntity
	 */
	public function setName($name)
	{
		$this->name = (string)$name;
		return $this;
	}

	/**
	 * Get client name.
	 */
	public function getName()
	{
		return (string)$this->name;
	}

    /**
     * Generate arry order.
     * @return array
     */
    public function toArray()
    {
        return array(
        	'number'         => $this->number,
       		'securityCode'   => $this->securityCode,
       		'expirationDate' => $this->expirationDate,
       		'name'           => $this->name,
        );
    }
}
