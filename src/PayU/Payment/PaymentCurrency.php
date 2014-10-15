<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Payment;

/**
 * Constants for supported payment currencies.
 *
 * @package PayU\Payment
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 * @link http://www.xe.com/iso4217.php
 */
class PaymentCurrency
{
    const BRAZIL    = 'BRL';
    const ARGENTINA = 'ARS';
    const MEXICO    = 'MXN';
    const COLOMBIA  = 'COP';
    const PERU      = 'PEN';
    const PANAMA    = 'USD'; //PayU, in Panama, use the american dollar for currency.
    const USA       = 'USD';
}
