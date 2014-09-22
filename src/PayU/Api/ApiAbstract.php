<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Api;

use \PayU\PayUException;
use \PayU\Api\ApiInterface;
use \PayU\Merchant\MerchantCredentials;
use \SimpleXMLElement;

/**
 * Base of PayU api.
 *
 * @package PayU
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
abstract class ApiAbstract implements ApiInterface
{
    /**
     * Simple XML raw object.
     * @var SimpleXMLElement
     */
    protected $xmlRequest = null;

    /**
     * @var SimpleXMLElement
     */
    protected $lastXmlRequest = null;

    /**
     * Response raw from the PayU request.
     * @var string
     */
    protected $responseRaw = null;

    /**
     * Merchant credentials object.
     * @var MerchantCredentials
     */
    protected $credentials = null;

    /**
     * Language configuration of return messages.
     * @var string
     */
    protected $language = null;

    /**
     * Staging flag.
     * @var bool
     */
    protected $isStaging = false;

    /**
     * Set the Merchant credentials on class contruction.
     *
     * @param MerchantCredentials $credentials
     * @param string              $language
     *
     * @return void
     */
    public function __construct(MerchantCredentials $credentials, $language = 'en')
    {
        $this->credentials = $credentials;
        $this->language    = (string)$language;
        $this->resetRequest();
    }

    /**
     * @return SimpleXMLElement
     */
    public function getLastXmlRequest()
    {
        return $this->lastXmlRequest;
    }

    /**
     * @param SimpleXMLElement $lastXmlRequest
     * @return $this
     */
    protected function setLastXmlRequest($lastXmlRequest)
    {
        $this->lastXmlRequest = $lastXmlRequest;
        return $this;
    }



    /**
     * Reset request object.
     * @return ApiAbstract
     */
    protected function resetRequest()
    {
        $this->xmlRequest = new SimpleXMLElement('<request />');
        return $this;
    }

    /**
     * Get XML raw object.
     * @return SimpleXMLElement
     */
    public function getXmlRawObject()
    {
        return $this->getLastXmlRequest();
    }

    /**
     * Get XML raw string.
     * @return string
     */
    public function getXmlRawString()
    {
        return $this->getLastXmlRequest()->asXML();
    }

    /**
     * Get response raw from the PayU request as json string.
     * @return string
     */
    public function getResponseRawString()
    {
        return (string)$this->responseRaw;
    }

    /**
     * Get response raw from the PayU request as stdClass.
     * @return \stdClass
     */
    public function getResponseRawObject()
    {
        return json_decode($this->responseRaw);
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
    public function getApiUrl()
    {
        $apiUrl = $this->credentials->getApiUrl();
        if (strlen($apiUrl)) {
            return $apiUrl;
        }
        if ($this->isProduction()) {
            return $this->apiUrlProduction;
        } else {
            return $this->apiUrlStaging;
        }
    }

    /**
     * Add test to json.
     *
     * @param  string $json Json command.
     * @return string
     */
    protected function addTest($json)
    {
        $array         = json_decode($json, true);
        $array['test'] = $this->isStaging();
        return json_encode($array);
    }

    /**
     * Add credentials to json.
     *
     * @param  string $json Json command.
     * @return string
     */
    protected function addLanguage($json)
    {
        $array             = json_decode($json, true);
        $array['language'] = $this->language;
        return json_encode($array);
    }

    /**
     * Add merchant credentials to json.
     *
     * @param  string $json Json command.
     * @return string
     */
    protected function addMerchant($json)
    {
        $merchant = array(
            'apiLogin' => $this->credentials->getApiLogin(),
            'apiKey'   => $this->credentials->getApiKey(),
        );
        $array = json_decode($json, true);
        $array['merchant'] = $merchant;
        return json_encode($array);
    }

    /**
     * Add metadata to json api command.
     *
     * @param  string $json Json command.
     * @return string
     */
    protected function addMetadata($json)
    {
        $json = $this->addTest($json);
        $json = $this->addLanguage($json);
        return $this->addMerchant($json);
    }

    /**
     * Make the cURL request in PayU webservice.
     *
     * @param  string $json Json body of request.
     * @return array
     * @throws PayUException
     */
    protected function curlRequest($json)
    {
        //HTTP headers.
        $headers = array(
            'Content-Type: application/json',
            'Accept: application/json',
            'Content-Length: ' . strlen($json),
        );
        //HTTP headers.

        try {
            //cUrl request.
            $ch = curl_init($this->getApiUrl());
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $this->responseRaw = curl_exec($ch);
            $response          = json_decode($this->responseRaw);
            //cUrl request.

            //Error treatment.
            $error = curl_error($ch);
            if (strlen($error)) {
                throw new PayUException($error);
            }
            //Error treatment.

            //Error treatment.
            if (strlen((string)$response->error)) {
                throw new PayUException($response->error);
            }
            //Error treatment.
        } catch (Exception $e) {
            throw new PayUException($e->getMessage(), $e->getCode());
        }

        return $response;
    }

    /**
     * Make the cURL request in PayU webservice.
     *
     * @param  DOMDocument $xml
     * @return array
     * @throws PayUException
     */
    protected function curlRequestXml($xml)
    {
        //HTTP headers.
        $headers = array(
            'Content-Type: application/xml',
            'Accept: application/json',
            'Content-Length: ' . strlen($xml),
        );
        //HTTP headers.

        try {
            //cUrl request.
            $ch = curl_init($this->getApiUrl());
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $this->responseRaw = curl_exec($ch);
            $response          = json_decode($this->responseRaw);
            //cUrl request.

            //Error treatment.
            $error = curl_error($ch);
            if (strlen($error)) {
                throw new PayUException($error);
            }
            //Error treatment.

            //Error treatment.
            if (strlen((string)$response->error)) {
                throw new PayUException($response->error);
            }
            //Error treatment.
        } catch (Exception $e) {
            throw new PayUException($e->getMessage(), $e->getCode());
        }

        return $response;
    }
}
