<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    	$merchant = array(

    		//site default credentials for test.
    		//'apiLogin' => '403ba744e9827f3',
    		//'apiKey'   => '676k86ks53la6tni6clgd30jf6',
    		//site default credentials for test.

    		//Rocket credentials for real.
    		'apiLogin' => '11959c415b33d0c',
    		'apiKey'   => '6u39nqhq8ftd0hlvnjfs66eh8c',
    		//Rocket credentials for real.
    	);
        $data = array(
        	'test'     => true,
        	'language' => 'es',
        	'command'  => 'GET_PAYMENT_METHODS',
        	'merchant' => $merchant,
        );
        $json = json_encode($data);

        $rest = new Zend_Rest_Client('https://stg.api.payulatam.com');
        $rest->
		//$rs   = $rest->restPost('/payments-api/4.0/service.cgi', $json);

        /*$http = new Zend_Http_Client('https://stg.api.payulatam.com/payments-api/4.0/service.cgi');
        $http->setMethod('post')
             ->setHeaders('Content-Type', 'application/json; charset=utf-8')
             ->setHeaders('Accept', 'application/json')
             ->setHeaders('Content-Length', 'length')
             ->setRawData($json);
        $rs = $http->request();*/

		echo "<pre>";
		//print_r($rs->getBody());
		print_r($rs);
		echo "</pre>";
		die();
    }

    public function indexAction()
    {
        // action body
    }


}

