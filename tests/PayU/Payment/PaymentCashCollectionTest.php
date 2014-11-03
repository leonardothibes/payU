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
use \PayU\Entity\Transaction\BillingAddressEntity;
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
        $this->credentials = new MerchantCredentials();
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
        $paymentMethod = $paymentMethods[rand(0, count($paymentMethods)-1)];

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
        $billingAddress = new BillingAddressEntity();
        $billingAddress->setStreet1('street1_' . rand(1,1000))
                       ->setStreet2('street2_' . rand(1,1000))
                       ->setCity('city_' . rand(1,1000))
                       ->setState('state_' . rand(1,1000))
                       ->setCountry(PaymentCountries::PANAMA)
                       ->setPostalCode('postalCode_' . rand(1,1000))
                       ->setPhone('phone_' . rand(1,1000));
        $payer = $transaction->getPayer();
        $payer->setFullName('person name ' . rand(1,9) . rand(1,9) . rand(1,9))
              ->setEmailAddress('email' . rand(1,9) . rand(1,9) . rand(1,9) . '@foo-bar.com')
              ->setContactPhone(rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9) . rand(1,9))
              ->setDniNumber(Cpf::random())
              ->setBillingAddress($billingAddress);
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
        $rs = $this->object->cashCollection($transaction, rand(1, 10));

        $this->assertInstanceOf('\stdClass', $rs);
        $this->assertEquals('SUCCESS', $rs->code);
        $this->assertEquals(0, strlen($rs->error));

        $this->assertTrue(isset($rs->transactionResponse));
        $this->assertInstanceOf('\stdClass', $rs->transactionResponse);

        $transaction = $rs->transactionResponse;

        $this->assertTrue(isset($transaction->orderId));
        $this->assertGreaterThan(0, strlen($transaction->orderId));

        $this->assertTrue(isset($transaction->transactionId));
        $this->assertGreaterThan(0, strlen($transaction->transactionId));

        $this->assertTrue(isset($transaction->state));
        $this->assertEquals('PENDING', $transaction->state);

        $this->assertEquals(0, strlen($transaction->paymentNetworkResponseCode));
        $this->assertEquals(0, strlen($transaction->paymentNetworkResponseErrorMessage));

        $this->assertTrue(isset($transaction->trazabilityCode));
        $this->assertGreaterThan(0, strlen($transaction->trazabilityCode));

        $this->assertTrue(isset($transaction->authorizationCode));
        $this->assertGreaterThan(0, strlen($transaction->authorizationCode));

        $this->assertTrue(isset($transaction->pendingReason));
        $this->assertEquals('AWAITING_NOTIFICATION', $transaction->pendingReason);

        $this->assertTrue(isset($transaction->responseCode));
        $this->assertEquals('PENDING_TRANSACTION_CONFIRMATION', $transaction->responseCode);

        $this->assertEquals(0, strlen($transaction->errorCode));
        $this->assertEquals(0, strlen($transaction->responseMessage));
        $this->assertEquals(0, strlen($transaction->transactionDate));
        $this->assertEquals(0, strlen($transaction->transactionTime));
        $this->assertEquals(0, strlen($transaction->operationDate));

        $this->assertTrue(isset($transaction->extraParameters));
        $this->assertInstanceOf('\stdClass', $transaction->extraParameters);

        $extraParameters = $transaction->extraParameters;

        $this->assertTrue(isset($extraParameters->URL_PAYMENT_RECEIPT_HTML));
        $regex = '/https:\/\/stg.gateway.payulatam.com\/ppp-web-gateway\/voucher.zul\?vid=[a-z0-9]{39}/i';
        $this->assertRegExp($regex, $extraParameters->URL_PAYMENT_RECEIPT_HTML);

        $this->assertTrue(isset($extraParameters->BAR_CODE));
        $this->assertGreaterThan(0, strlen($extraParameters->BAR_CODE));

        $this->assertTrue(isset($extraParameters->REFERENCE));
        $this->assertEquals($transaction->orderId, $extraParameters->REFERENCE);
    }
}
