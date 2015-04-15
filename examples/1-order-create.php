<?php

require_once __DIR__ . '/config.php';

$merchant = new \PayU\Merchant\MerchantCredentials();
$merchant->setAccountId(PAYU_CREDENTIAL_ACCOUNT_ID);
$merchant->setMerchantId(PAYU_CREDENTIAL_MERCHANT_ID);
$merchant->setApiLogin(PAYU_CREDENTIAL_API_LOGIN);
$merchant->setApiKey(PAYU_CREDENTIAL_API_KEY);

$payuPaymentApi = new \PayU\Payment\PaymentApi($merchant);
$payuPaymentApi->setStaging(true);

$transaction = new \PayU\Entity\Transaction\TransactionEntity();
$transaction->setType(\PayU\Payment\PaymentTypes::AUTHORIZATION_AND_CAPTURE);
$transaction->setPaymentCountry('PA');
$transaction->setIpAddress('127.0.0.1');

$orderEntity = $transaction->getOrder();
$orderEntity->setReferenceCode(rand(1, 1000));
$orderEntity->setDescription('Some description here');

$shippingEntity = $orderEntity->getShippingAddress();
$shippingEntity->setStreet1('Address Line 1');
$shippingEntity->setStreet2('Address Line 2');
$shippingEntity->setCity('City');
$shippingEntity->setPostalCode('123456');
$shippingEntity->setPhone('12345678');
$shippingEntity->setCountry('PA');

//Buyer info.
$buyerEntity = $orderEntity->getBuyer();
$buyerEntity->setFullName('Customer Name');
$buyerEntity->setEmailAddress('customer.email@enterprise.com');

$billingAddressEntity = $buyerEntity->getShippingAddress();
$billingAddressEntity->setStreet1('Address Line 1');
$billingAddressEntity->setStreet2('Address Line 2');
$billingAddressEntity->setCity('City');
$billingAddressEntity->setPostalCode('123456');
$billingAddressEntity->setPhone('12345678');
$billingAddressEntity->setCountry('PA');
//Buyer info.

$additionalValues = $orderEntity->getAdditionalValues();
$additionalValues->addTax('TX_VALUE', 'USD', 3200);
