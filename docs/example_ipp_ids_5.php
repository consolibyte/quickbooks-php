<?php

// Turn on some error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

print_r($arr);



//$oauth = new OAuthSimple();
$oauth = new QuickBooks_IPP_OAuth($oauth_consumer_key, $oauth_consumer_secret);

$parameters = array();

$url = 'https://services.intuit.com/sb/company/v2/available';

/*		
		$signatures = array(
			'consumer_key' => $oauth_consumer_key, 
			'shared_secret' => $oauth_consumer_secret  
		);
*/		
 
 /*
    	$signatures['access_token'] = $arr['oauth_access_token'];
    	$signatures['access_secret'] = $arr['oauth_access_token_secret'];
 
    
    $sign_args = array(
    	'path'=>$path,  
      'parameters'=>$parameters,  
      'signatures'=>$signatures
    );
    
    $signed = $oauth->sign($sign_args);  
*/

$args = array(
	'oauth_token' => $arr['oauth_access_token'], 
	'oauth_secret' => $arr['oauth_access_token_secret'],
	);


$signed = $oauth->sign(QuickBooks_IPP_OAuth::METHOD_GET, $url, $args);


	$data = null;	

    $curl = curl_init();  
    
    /*
    print('<pre>');
    print_r($sign_args);
    print('</pre>');
    */
    
    if ( $data ) {
		/* THIS IS WHERE I STARTED PLAYING WITH DIFFERENT THINGS TO GET THE POST TO WORK */
		
    	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: '.$signed['header']));//,'Content-Type: application/xml'));
  		curl_setopt($curl, CURLOPT_URL,$path);
    	curl_setopt($curl, CURLOPT_POST,       1 );
    	curl_setopt($curl, CURLOPT_POSTFIELDS, urlencode($data) );
    } else {
    	curl_setopt($curl, CURLOPT_URL,$signed[2]);  
    	//curl_setopt($curl, CURLOPT_URL,$path);
    }    
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);  
    
    curl_setopt($curl, CURLOPT_HEADER, true);
    
    //curl_setopt($curl,CURLOPT_ENCODING,'gzip,deflate');
    //curl_setopt($curl,CURLOPT_SETTIMEOUT,2);  
    
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    
    $buffer = curl_exec($curl); 
    
    print('<pre>');
    print(htmlentities($buffer));
    print('</pre>');