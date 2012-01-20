<?php

// Turn on some error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: text/plain');

/**
 * Require the QuickBooks library
 */
require_once dirname(__FILE__) . '/../QuickBooks.php';

/**
 * Require some IPP/OAuth configuration data
 */
require_once dirname(__FILE__) . '/example_ipp_config.php';


$res = mysql_query("SELECT * FROM quickbooks_oauth ORDER BY quickbooks_oauth_id DESC LIMIT 1") or die(mysql_error());
$arr = mysql_fetch_assoc($res);


//$oauth = new OAuthSimple();
$oauth = new QuickBooks_IPP_OAuth($oauth_consumer_key, $oauth_consumer_secret);



$url = 'https://qdc.qbo.intuit.com/qbo1/resource/customers/v2/324452215';

$data = array(
	'PageNum' => 1, 
	'ResultsPerPage' => 15, 
	);
//$data = null;

$action = QuickBooks_IPP_OAuth::METHOD_POST;
$signed = $oauth->sign($action, $url, $arr['oauth_access_token'], $arr['oauth_access_token_secret'], $data);


$data = http_build_query($data);



/*
$action = QuickBooks_IPP_OAuth::METHOD_GET;
$url = 'https://services.intuit.com/sb/company/v2/available';
$data = null;
$signed = $oauth->sign($action, $url, $arr['oauth_access_token'], $arr['oauth_access_token_secret'], $data);

print_r($signed);
*/



    $curl = curl_init();  
    
    if ($action == QuickBooks_IPP_OAuth::METHOD_POST)
    {
		
		$headers = array( 'Content-Type: application/x-www-form-urlencoded', 'Authorization: '. $signed[3]);
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//,'Content-Type: application/xml'));
  		curl_setopt($curl, CURLOPT_URL, $url);
    	curl_setopt($curl, CURLOPT_POST, true);
    	
    	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    } 
    else
    {
    	/*curl_setopt($curl, CURLOPT_URL, $signed[2]);  */
    	
		//$headers = array( 'Content-Type: application/x-www-form-urlencoded', 'Authorization: '. $signed[3]);
		//curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);//,'Content-Type: application/xml'));
  		
  		curl_setopt($curl, CURLOPT_URL, $signed[2]);
    	
    }    
    
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  
    
    curl_setopt($curl, CURLOPT_HEADER, true);
    
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    
    $buffer = curl_exec($curl); 
    
print($buffer);    
