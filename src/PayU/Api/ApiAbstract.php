<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
* @copyright Copyright (c) The Authors
*/

namespace PayU\Api;

use \PayU\Merchant\MerchantCredentials;

/**
 * Base of PayU api.
 *
 * @package PayU
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
abstract class ApiAbstract
{
    /**
     * Merchant credentials object.
     * @var MerchantCredentials
     */
    protected $credentials = null;

    /**
     * Staging flag.
     * @var bool
     */
    protected $isStaging = false;

    /**
     * PayU api version.
     * @var string
     */
    protected $apiVer = '4.0';

    /**
     * Set the Merchant credentials on class contruction.
     *
     * @param  MerchantCredentials $credentials
     * @return void
     */
    public function __construct(MerchantCredentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * Get the credentials object.
     * @return MerchantCredentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Set the payment and reports environment to stagin.
     *
     * @param  bool $flag
     * @return ApiAbstract
     */
    public function setStaging($flag = true)
    {
        $this->isStaging = (bool)$flag;
        return $this;
    }

    /**
     * Test the staging flag is staging.
     * @return bool
     */
    public function isStaging()
    {
        return (bool)$this->isStaging;
    }

    /**
     * Test the staging flag is production.
     * @return bool
     */
    public function isProduction()
    {
        return !(bool)$this->isStaging;
    }

    /**
     * Get the api url.
     * @return string
     */
    protected function getApiUrl()
    {
    	if ($this->isProduction()) {
    		return sprintf($this->apiUrlProduction, $this->apiVer);
    	} else {
    		return sprintf($this->apiUrlStaging, $this->apiVer);
    	}
    }
}
