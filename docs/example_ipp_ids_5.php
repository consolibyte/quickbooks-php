<?php

require_once 'config.php';
require_once "IntuitAnywhere.php";
require_once '/Users/kpalmer/Projects/QuickBooks/QuickBooks.php';


$arr = mysql_fetch_assoc(mysql_query("SELECT * FROM quickbooks_oauth ORDER BY quickbooks_oauth_id DESC LIMIT 1"));

print_r($arr);

$oauth = new OAuthSimple();

$parameters = array();

$path = 'https://services.intuit.com/sb/company/v2/available';
		
		$signatures = array(
			'consumer_key' => $oauth_consumer_key, 
			'shared_secret' => $oauth_consumer_secret  
		);
		
 
    	$signatures['access_token'] = $arr['oauth_access_token'];
    	$signatures['access_secret'] = $arr['oauth_access_token_secret'];
 
    
    $sign_args = array(
    	'path'=>$path,  
      'parameters'=>$parameters,  
      'signatures'=>$signatures
    );
    
    /*
    if ( $data ) {
    	$sign_args['action'] = 'POST';
    }
    */
    
    $signed = $oauth->sign($sign_args);  

	$data = null;	

    $curl = curl_init();  
    
    
    print('<pre>');
    print_r($sign_args);
    print('</pre>');
    
    
    if ( $data ) {
		/* THIS IS WHERE I STARTED PLAYING WITH DIFFERENT THINGS TO GET THE POST TO WORK */
		
    	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: '.$signed['header']));//,'Content-Type: application/xml'));
  		curl_setopt($curl, CURLOPT_URL,$path);
    	curl_setopt($curl, CURLOPT_POST,       1 );
    	curl_setopt($curl, CURLOPT_POSTFIELDS, urlencode($data) );
    } else {
    	curl_setopt($curl, CURLOPT_URL,$signed['signed_url']);  
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