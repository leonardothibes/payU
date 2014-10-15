<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Entity\Transaction;

use \PayU\Entity\EntityAbstract;
use \PayU\Entity\EntityException;

/**
 * Extra parameters entity class.
 *
 * @package PayU\Entity
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class ExtraParametersEntity extends EntityAbstract
{
    /**
     * Installments number.
     * @var int
     */
    protected $installmentsNumber = 1;

    /**
     * Set installments number.
     *
     * @param  int $installmentsNumber
     * @return ExtraParametersEntity
     */
    public function setInstallmentsNumber($installmentsNumber)
    {
        $this->installmentsNumber = (int)$installmentsNumber;
        return $this;
    }

    /**
     * Get installments number.
     * @return int
     */
    public function getInstallmentsNumber()
    {
        return (int)$this->installmentsNumber;
    }

    /**
     * Installments type options.
     */
    const INSTALLMENTS_NUMBER                 = 'INSTALLMENTS_NUMBER';
    const INSTALLMENTS_TYPE                   = 'INSTALLMENTS_TYPE';
    const INSTALLMENT_PAYMENT_ON_SITE         = 1;
    const INSTALLMENT_BUSINESS_FUNDING        = 2;
    const INSTALLMENT_PAYMENT_NETWORK_FUNDING = 3;

    /**
     * Installments type.
     * @var int
     */
    protected $installmentsType = self::INSTALLMENT_PAYMENT_ON_SITE;

    /**
     * Set installments type.
     *
     * @param  int $installmentsType
     * @return ExtraParametersEntity
     * @throws EntityException
     */
    public function setInstallmentsType($installmentsType)
    {
        $acceptedTypes = array(
            self::INSTALLMENT_PAYMENT_ON_SITE,
            self::INSTALLMENT_BUSINESS_FUNDING,
            self::INSTALLMENT_PAYMENT_NETWORK_FUNDING,
        );
        if (!in_array($installmentsType, $acceptedTypes)) {
            throw new EntityException('Invalid installment type');
        }
        $this->installmentsType = (int)$installmentsType;
        return $this;
    }

    /**
     * Set installments type.
     */
    public function getInstallmentsType()
    {
        return (int)$this->installmentsType;
    }

    /**
     * Security code indicator options.
     */
    const SECURITY_CODE_INDICATOR    = 'SECURITY_CODE_INDICATOR';
    const SECURITY_CODE_NOT_PROVIDED = 0;
    const SECURITY_CODE_PROVIDED     = 1;
    const SECURITY_CODE_UNREADABLE   = 2;
    const SECURITY_CODE_NON_EXISTENT = 9;

    /**
     * Security code indicator.
     * @var int
     */
    protected $securityCodeIndicator = self::SECURITY_CODE_PROVIDED;

    /**
     * Set security code indicator.
     *
     * @param  int $securityCodeIndicator
     * @return ExtraParametersEntity
     * @throws EntityException
     */
    public function setSecurityCodeIndicator($securityCodeIndicator)
    {
        $acceptedCodes = array(
            self::SECURITY_CODE_NOT_PROVIDED,
            self::SECURITY_CODE_PROVIDED,
            self::SECURITY_CODE_NON_EXISTENT,
            self::SECURITY_CODE_UNREADABLE,
        );
        if (!in_array($securityCodeIndicator, $acceptedCodes)) {
            throw new EntityException('Invalid code indicator');
        }
        $this->securityCodeIndicator = (int)$securityCodeIndicator;
        return $this;
    }

    /**
     * Get security code indicator.
     * @return int
     */
    public function getSecurityCodeIndicator()
    {
        return (int)$this->securityCodeIndicator;
    }

    /**
     * Response url option.
     */
    const RESPONSE_URL = 'RESPONSE_URL';

    /**
     * Response url.
     * @var string
     */
    protected $responseUrl = null;

    /**
     * Set response url.
     *
     * @param  string $responseUrl
     * @return ExtraParametersEntity
     */
    public function setResponseUrl($responseUrl)
    {
        if (substr($responseUrl, 0, 4) != 'http') {
            $message = sprintf('Invalid url: %s', $responseUrl);
            throw new EntityException($message);
        }
        $this->responseUrl = (string)$responseUrl;
        return $this;
    }

    /**
     * Get response url.
     * @return string
     */
    public function getResponseUrl()
    {
        return (string)$this->responseUrl;
    }

    /**
     * Returns if object is empty
     * @return bool
     */
    public function isEmpty()
    {
        foreach (get_object_vars($this) as $property => $value) {
            if (
                $value !== null and
                $value !== false and
                $value !== 1
            ) {
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
            self::INSTALLMENTS_NUMBER     => $this->installmentsNumber,
            self::INSTALLMENTS_TYPE       => $this->installmentsType,
            self::SECURITY_CODE_INDICATOR => $this->securityCodeIndicator,
            self::RESPONSE_URL            => $this->responseUrl,
        );
    }
}
