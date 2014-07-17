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
	const VISA   = 'VISA';

	/**
	 * @country Brazil
	 * @country Argentina
	 * @country Panama
	 * @country Mexico
	 * @country Colombia
	 */
	const MASTER = 'MASTERCARD';

	const DINNRS = 'DINERS';

	[0] => stdClass Object
	(
			[id] => 167
			[description] => AMEX
			[country] => BR
	)

	[1] => stdClass Object
	(
			[id] => 163
			[description] => DINERS
			[country] => BR
	)

	[2] => stdClass Object
	(
			[id] => 160
			[description] => BOLETO_BANCARIO
			[country] => BR
	)

	[3] => stdClass Object
	(
			[id] => 162
			[description] => VISA
			[country] => BR
	)

	[4] => stdClass Object
	(
			[id] => 164
			[description] => MASTERCARD
			[country] => BR
	)

	[5] => stdClass Object
	(
			[id] => 166
			[description] => ELO
			[country] => BR
	)

	[0] => stdClass Object
	(
			[id] => 195
			[description] => VISA
			[country] => AR
	)

	[1] => stdClass Object
	(
			[id] => 191
			[description] => PAGOFACIL
			[country] => AR
	)

	[2] => stdClass Object
	(
			[id] => 208
			[description] => RIPSA
			[country] => AR
	)

	[3] => stdClass Object
	(
			[id] => 196
			[description] => MASTERCARD
			[country] => AR
	)

	[4] => stdClass Object
	(
			[id] => 302
			[description] => BANCOMER
			[country] => MX
	)

	[5] => stdClass Object
	(
			[id] => 197
			[description] => AMEX
			[country] => AR
	)

	[6] => stdClass Object
	(
			[id] => 100
			[description] => BCP
			[country] => PE
	)

	[7] => stdClass Object
	(
			[id] => 254
			[description] => PSE
			[country] => CO
	)

	[8] => stdClass Object
	(
			[id] => 251
			[description] => MASTERCARD
			[country] => CO
	)

	[9] => stdClass Object
	(
			[id] => 252
			[description] => AMEX
			[country] => CO
	)

	[10] => stdClass Object
	(
			[id] => 304
			[description] => IXE
			[country] => MX
	)

	[11] => stdClass Object
	(
			[id] => 305
			[description] => SANTANDER
			[country] => MX
	)

	[12] => stdClass Object
	(
			[id] => 220
			[description] => VISA
			[country] => PA
	)

	[13] => stdClass Object
	(
			[id] => 199
			[description] => NARANJA
			[country] => AR
	)

	[14] => stdClass Object
	(
			[id] => 222
			[description] => MASTERCARD
			[country] => PA
	)

	[15] => stdClass Object
	(
			[id] => 139
			[description] => AMEX
			[country] => MX
	)

	[16] => stdClass Object
	(
			[id] => 193
			[description] => COBRO_EXPRESS
			[country] => AR
	)

	[17] => stdClass Object
	(
			[id] => 260
			[description] => VISA
			[country] => MX
	)

	[18] => stdClass Object
	(
			[id] => 200
			[description] => CABAL
			[country] => AR
	)

	[19] => stdClass Object
	(
			[id] => 198
			[description] => SHOPPING
			[country] => AR
	)

	[20] => stdClass Object
	(
			[id] => 192
			[description] => BAPRO
			[country] => AR
	)

	[21] => stdClass Object
	(
			[id] => 253
			[description] => DINERS
			[country] => CO
	)

	[22] => stdClass Object
	(
			[id] => 306
			[description] => SCOTIABANK
			[country] => MX
	)

	[23] => stdClass Object
	(
			[id] => 190
			[description] => RAPIPAGO
			[country] => AR
	)

	[24] => stdClass Object
	(
			[id] => 102
			[description] => MASTERCARD
			[country] => PE
	)

	[25] => stdClass Object
	(
			[id] => 26
			[description] => ACH_DEBIT
			[country] => CO
	)

	[26] => stdClass Object
	(
			[id] => 130
			[description] => SEVEN_ELEVEN
			[country] => MX
	)

	[27] => stdClass Object
	(
			[id] => 250
			[description] => VISA
			[country] => CO
	)

	[28] => stdClass Object
	(
			[id] => 131
			[description] => OXXO
			[country] => MX
	)

	[29] => stdClass Object
	(
			[id] => 35
			[description] => BALOTO
			[country] => CO
	)

	[30] => stdClass Object
	(
			[id] => 261
			[description] => MASTERCARD
			[country] => MX
	)

	[31] => stdClass Object
	(
			[id] => 36
			[description] => BANK_REFERENCED
			[country] => CO
	)

	[32] => stdClass Object
	(
			[id] => 201
			[description] => ARGENCARD
			[country] => AR
	)

}
