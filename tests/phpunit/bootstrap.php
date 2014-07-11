<?php
/**
 * @package Tests\Bootstrap
 * @author Leonardo Thibes <leonardothibes@gmail.com>
 * @copyright Copyright (c) The Authors
 */

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../src/payU/application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'testing'));

// Ensure library is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

// Composer autoloader
require_once APPLICATION_PATH . '/../vendor/autoload.php';

// Zend autoloader.
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

//Ativando componente de log.
$logfile = APPLICATION_PATH . '/../../../logs/payU_' . date('Y-m-d') . '.log';
\Tbs\Log::getInstance()->setLogger(
		new \Tbs\Log\File($logfile)
);

// Running the application bootstrap
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap();