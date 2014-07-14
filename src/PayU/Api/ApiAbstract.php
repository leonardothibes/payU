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
	 * @var MerchantCredentials
	 */
	protected $credentials = null;

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
}
