<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Entity\EntityInterface;

/**
 * Shipping address entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class ShippingAddressEntity implements EntityInterface
{
    /**
     * First line of address.
     * @var string
     */
    protected $street1 = null;

    /**
     * Set first line of address.
     *
     * @param  string $street1
     * @return ShippingAddressEntity
     */
    public function setStreet1($street1)
    {
        $this->street1 = (string)$street1;
        return $this;
    }

    /**
     * Get first line of address.
     * @return string
     */
    public function getStreet1()
    {
        return (string)$this->street1;
    }

    /**
     * Seccond line of address.
     * @var string
     */
    protected $street2 = null;

    /**
     * Set seccond line of address.
     *
     * @param  string $street1
     * @return ShippingAddressEntity
     */
    public function setStreet2($street2)
    {
        $this->street2 = (string)$street2;
        return $this;
    }

    /**
     * Get seccond line of address.
     * @return string
     */
    public function getStreet2()
    {
        return (string)$this->street2;
    }

    /**
     * @var string
     */
    protected $city = null;

    /**
     * Set city.
     *
     * @param  string $city
     * @return ShippingAddressEntity
     */
    public function setCity($city)
    {
        $this->city = (string)$city;
        return $this;
    }

    /**
     * Get city.
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @var string
     */
    protected $state = null;

    /**
     * Set state.
     *
     * @param  string $state
     * @return ShippingAddressEntity
     */
    public function setState($state)
    {
        $this->state = (string)$state;
        return $this;
    }

    /**
     * Get state.
     * @return string
     */
    public function getState()
    {
        return (string)$this->state;
    }

    /**
     * @var string
     */
    protected $country = null;

    /**
     * Set country.
     *
     * @param  string $country
     * @return ShippingAddressEntity
     */
    public function setCountry($country)
    {
        $this->country = (string)$country;
        return $this;
    }

    /**
     * Get country.
     */
    public function getCountry()
    {
        return (string)$this->country;
    }

    /**
     * @var string
     */
    protected $postalCode = null;

    /**
     * Set postal code.
     *
     * @param  string $postalCode
     * @return ShippingAddressEntity
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = (string)$postalCode;
        return $this;
    }

    /**
     * Get postal code.
     * @return string
     */
    public function getPostalCode()
    {
        return (string)$this->postalCode;
    }

    /**
     * @var string
     */
    protected $phone = null;

    /**
     * Set phone.
     */
    public function setPhone($phone)
    {
        $this->phone = (string)$phone;
        return $this;
    }

    /**
     * Get phone.
     * @return string
     */
    public function getPhone()
    {
        return (string)$this->phone;
    }


    /**
     * Returns if object is empty
     * @return bool
     */
    public function isEmpty()
    {
        foreach (get_object_vars($this) as $property) {
            if($property !== null) {
                return false;
            }
        }
        return true;
    }

    /**
     * Generate arry order.
     * @return array
     */
    public function toArray()
    {
        return array(
            'street1'    => $this->street1,
            'street2'    => $this->street2,
            'city'       => $this->city,
            'state'      => $this->state,
            'country'    => $this->country,
            'postalCode' => $this->postalCode,
            'phone'      => $this->phone,
        );
    }
}
