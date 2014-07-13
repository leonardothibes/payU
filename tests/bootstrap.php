<?php
/**
 * @category Tests
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

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
require_once '../vendor/autoload.php';

//Ativando componente de log.
$logfile = LIBRARY_PATH . '/../logs/payu_' . date('Y-m-d') . '.log';
\Tbs\Log::getInstance()->setLogger(
	new \Tbs\Log\File($logfile)
);
