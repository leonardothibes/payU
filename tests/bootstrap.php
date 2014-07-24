<?php
/**
 * @category Tests
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

/**
 * Test api credentials provided by PayU
 * @link http://docs.payulatam.com/pt-br/integracao-com-api/o-que-voce-precisa-saber-a-integracao-via-api/
 */
//define('MERCHANT_ID', '500365');                      //Brazil
//define('PAYU_API_LOGIN', '403ba744e9827f3');          //Brazil
//define('PAYU_API_KEY', '676k86ks53la6tni6clgd30jf6'); //Brazil

define('MERCHANT_ID', '500238');                      //Colombia, Panama, Peru, Mexico, Argentina
define('PAYU_API_LOGIN', '11959c415b33d0c');          //Colombia, Panama, Peru, Mexico, Argentina
define('PAYU_API_KEY', '6u39nqhq8ftd0hlvnjfs66eh8c'); //Colombia, Panama, Peru, Mexico, Argentina

// Path for api.
define('LIBRARY_PATH', dirname(__FILE__) . '/../src');

// Path for test stuff.
define('STUFF_PATH', dirname(__FILE__) . '/PayU/.stuff');

// Defining PHP include path.
set_include_path(implode(PATH_SEPARATOR, array(
	LIBRARY_PATH,
	get_include_path(),
)));

// Composer autoload.
require_once LIBRARY_PATH . '/../vendor/autoload.php';

//Ativando componente de log.
$logfile = LIBRARY_PATH . '/../logs/payu_' . date('Y-m-d') . '.log';
\Tbs\Log::getInstance()->setLogger(
	new \Tbs\Log\File($logfile)
);
