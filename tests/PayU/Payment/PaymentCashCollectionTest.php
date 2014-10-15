<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Payment;

use \PayU\Payment\PaymentApi;
use \PayU\Payment\PaymentTypes;
use \PayU\Payment\PaymentMethods;
use \PayU\Payment\PaymentCurrency;
use \PayU\Payment\PaymentCountries;

use \PayU\Entity\Transaction\TransactionEntity;
use \PayU\Entity\Transaction\ShippingAddressEntity;
use \PayU\Merchant\MerchantCredentials;

use \Tbs\Helper\Cpf;
use \stdClass;

require_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'bootstrap.php';

/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PaymentCashCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PaymentApi
     */
    protected $object = null;

    /**
     * @var MerchantCredentials
     */
    protected $credentials = null;

    /**
     * @var array
     */
    protected $payuCredentials = array
    (
        'accountId'  => '509171',
        'merchantId' => '500238',
        'apiLogin'   => '11959c415b33d0c',
        'apiKey'     => '6u39nqhq8ftd0hlvnjfs66eh8c',
    );

    /**
     * Setup.
     */
    protected function setUp()
    {
        $this->credentials = MerchantCredentials::getInstance();
        $this->credentials->setAccountId($this->payuCredentials['accountId'])
                          ->setMerchantId($this->payuCredentials['merchantId'])
                          ->setApiLogin($this->payuCredentials['apiLogin'])
                          ->setApiKey($this->payuCredentials['apiKey']);
        $this->object = new PaymentApi($this->credentials);
        $this->object->setStaging();
    }

    /**
     * TearDown.
     */
    protected function tearDown()
    {
        $this->credentials->resetInstance();
        unset($this->object, $this->credentials);
    }

    /**
     * Provides a OK data to test cash collection.
     * @return array
     */
    public function providerMockTransaction()
    {
        $transaction = new TransactionEntity();

        //Transaction.
        $ipAddress = rand(1,254) . '.' . rand(1,254) . '.' . rand(1,254) . '.' . rand(1,254);
        $cookie    = 'cookie_' . md5(rand(1000, 2000));

        $browsers = array
        (
            'Safari',
            'Chrome',
            'Firefox',
            'Opera',
            'IE'
        );
        $userAgent = $browsers[rand(0, count($browsers)-1)];

        $paymentMethods = array
        (
            PaymentMethods::BAPRO,
            PaymentMethods::COBRO_EXPRESS,
            PaymentMethods::PAGOFACIL,
            PaymentMethods::RAPIPAGO,
            PaymentMethods::RIPSA,
        );
        $paymentMethod = $paymentMethods[rand(0, count($paymentMethods))];

        $transaction->setPaymentMethod($paymentMethod)
                    ->setPaymentCountry(PaymentCountries::ARGENTINA)
                    ->setIpAddress($ipAddress)
                    ->setCookie($cookie)
                    ->setUserAgent($userAgent);
        //Transaction.

        //Order.
        $order = $transaction->getOrder();
        $order->setAccountId('accountId_' . rand(1,9) . rand(1,9) . rand(1,9))
              ->setReferenceCode('referenceCode_' . rand(1,9) . rand(1,9) . rand(1,9))
              ->setDescription('description_' . rand(1,9) . rand(1,9) . rand(1,9))
              ->setLanguage('en')
              ->setNotifyUrl('http://notifyurl-' . rand(1,9) . rand(1,9) . rand(1,9) . '.com')
              ->setSignature(sha1('signature'));
        //Order.

        //Buyer.
        $buyer = $order->getBuyer();
        $buyer->setFullName('person name ' . rand(1,9) . rand(1,9) . rand(1,9))
              ->setEmailAddress('email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com')
              ->setDniNumber(Cpf::random());
        //Buyer.

        //Additional values.
        $additionalValues = $order->getAdditionalValues();
        $additionalValues->addTax('TX_VALUE', PaymentCurrency::ARGENTINA, 100);
        //Additional values.

        //Payer.
        $payer = $transaction->getPayer();
        $payer->setFullName('person name ' . rand(1,9) . rand(1,9) . rand(1,9))
              ->setEmailAddress('email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com');
        //Payer.

        return array(
            array($transaction)
        );
    }

    /**
     * @see PaymentApi::cashCollection()
     * @dataProvider providerMockTransaction
     *
     * @param \PayU\Entity\Transaction\TransactionEntity $transaction
     */
    public function testCashCollection($transaction)
    {
        $rs = $this->object->cashCollection($transaction);
        $this->_testTransactionResponse($rs);
    }

    /**
     * Verify transaction response.
     * @param stdClass $response
     */
    private function _testTransactionResponse($response)
    {
        $this->assertInstanceOf('\stdClass', $response);
        $this->assertTrue(isset($response->code));
        $this->assertEquals(0, strlen($response->error));

        $this->assertTrue(isset($response->transactionResponse));
        $this->assertInstanceOf('\stdClass', $response->transactionResponse);

        $transaction = $response->transactionResponse;

        $this->assertTrue(isset($response->transactionResponse->orderId));
        $this->assertTrue(isset($response->transactionResponse->transactionId));
        $this->assertTrue(isset($response->transactionResponse->state));
        $this->assertTrue(isset($response->transactionResponse->responseCode));

        $this->assertEquals(0, strlen($transaction->paymentNetworkResponseCode));
        $this->assertEquals(0, strlen($transaction->paymentNetworkResponseErrorMessage));
        $this->assertEquals(0, strlen($transaction->trazabilityCode));
        $this->assertEquals(0, strlen($transaction->authorizationCode));
        $this->assertEquals(0, strlen($transaction->pendingReason));
        $this->assertEquals(0, strlen($transaction->errorCode));
        $this->assertEquals(0, strlen($transaction->responseMessage));
        $this->assertEquals(0, strlen($transaction->transactionDate));
        $this->assertEquals(0, strlen($transaction->transactionTime));
        $this->assertEquals(0, strlen($transaction->operationDate));
        $this->assertEquals(0, strlen($transaction->extraParameters));
    }
}
