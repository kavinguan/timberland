<?php
ini_set("display_errors"  ,"On");
ini_set("error_reporting" ,"E_ALL & ~E_NOTICE");
set_time_limit(120);
ini_set('default_socket_timeout', '3600'); 

/**
 *
 *
 * 调用SOAP服务
 *
 * @param string $wsdl
 */
function callSoap ($wsdl, $refresh = false)
{
	try {
		$options = array('soap_version' => SOAP_1_2, 'exceptions' => true,
				'trace' => true, 'connection_timeout' => 120);
		if ($refresh == true) {
			$options['cache_wsdl'] = WSDL_CACHE_NONE;
		} else {
			$options['cache_wsdl'] = WSDL_CACHE_MEMORY;
		}
		$client = new SoapClient($wsdl, $options);
		return $client;
	} catch (Exception $e) {
		//var_dump(implode("|", array(date("Y-m-d H:i:s"), $e->getFile(), $e->getLine(), $e->getMessage())));
		return false;
	}
}

if($_FILES['uma_upload_image']['error']==0) {
	try {
		$client = callSoap('http://scrm.umaman.com/soa/image/soap?wsdl');
		if($client!==false) {
			$fileByte = base64_encode(file_get_contents($_FILES['uma_upload_image']['tmp_name']));
			$_id = $client->storeImage(strtolower($_FILES['uma_upload_image']['name']), $fileByte);
			echo 'http://scrm.umaman.com/soa/image/get/id/' . $_id;
		}
		else {
			echo 0;exit();
		}
	}
	catch(Exception $e) {
		echo 0;exit();
	}
}
else {
	echo 0;exit();
}
