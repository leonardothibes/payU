<?php
/**
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

namespace PayU\Payment;

/**
 * Constants for supported payment methods.
 *
 * @package PayU\Payment
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */
class PaymentMethods
{
	/**
	 * @country Brazil
	 * @country Argentina
	 * @country Panama
	 * @country Mexico
	 * @country Colombia
	 */
	const VISA = 'VISA';

	/**
	 * @country Brazil
	 * @country Argentina
	 * @country Panama
	 * @country Mexico
	 * @country Colombia
	 * @country Peru
	 */
	const MASTERCARD = 'MASTERCARD';

	/**
	 * @country Brazil
	 * @country Colombia
	 */
	const DINERS = 'DINERS';

	/**
	 * @country Brazil
	 * @country Argentina
	 * @country Colombia
	 * @country Mexico
	 */
	const AMEX = 'AMEX';

	/**
	 * @country Brazil
	 */
	const BOLETO_BANCARIO = 'BOLETO_BANCARIO';
	const ELO             = 'ELO';

	/**
	 * @country Argentina
	 */
	const ARGENCARD     = 'ARGENCARD';
	const BAPRO         = 'BAPRO';
	const CABAL         = 'CABAL';
	const COBRO_EXPRESS = 'COBRO_EXPRESS';
	const NARANJA       = 'NARANJA';
	const PAGOFACIL     = 'PAGOFACIL';
	const RAPIPAGO      = 'RAPIPAGO';
	const RIPSA         = 'RIPSA';
	const SHOPPING      = 'SHOPPING';

	/**
	 * @country Mexico
	 */
	const BANCOMER     = 'BANCOMER';
	const IXE          = 'IXE';
	const OXXO         = 'OXXO';
	const SANTANDER    = 'SANTANDER';
	const SCOTIABANK   = 'SCOTIABANK';
	const SEVEN_ELEVEN = 'SEVEN_ELEVEN';


	/**
	 * @country Colombia
	 */
	const ACH_DEBIT       = 'ACH_DEBIT';
	const BALOTO          = 'BALOTO';
	const BANK_REFERENCED = 'BANK_REFERENCED';
	const PSE             = 'PSE';

	/**
	 * @country Peru
	 */
	const BCP = 'BCP';
}
