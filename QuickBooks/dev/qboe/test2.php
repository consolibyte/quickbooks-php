<?php

$PHP_URL = '';
$PHP_Request = '';

$PHP_Cert = dirname(__FILE__) . '/trusted-certificate.pem';
//$PHP_Cert = '/usr/home/academickeys/www/html/qboe/test.pem';
$PHP_Cert = '/Users/kpalmer/Projects/QuickBooks/QuickBooks/dev/qboe/test.pem';

FNC_do_call($PHP_URL, $PHP_Request, $PHP_Cert);

function FNC_do_call($PHP_URL, $PHP_Request, $PHP_Cert) 
{ 
	//$PHP_Header[] = "Content-type: application/x-qbmsxml"; 
	//$PHP_Header[] = "Content-length: ".strlen($PHP_Request); 

	$handle = fopen("/tmp/curlerrors.txt", "w"); 

	$PHP_URL = 'https://webapps.quickbooks.com/j/AppGateway';
	
	$cticket = 'TGT-139-pHesG$zxjInpOUKET4P9GQ';
	$cticket = 'TGT-47-1sRm2nXMVfm$n8hb2MZfVQ';
	$appid = '134476472';
	$login = 'test.www.academickeys.com';
	
	$PHP_Request = '<?xml version="1.0" ?> 
	<?qbxml version="6.0"?> 
	<QBXML> 
	<SignonMsgsRq> 
	<SignonAppCertRq> 
	<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime> 
	<ApplicationLogin>' . $login . '</ApplicationLogin> 
	<ConnectionTicket>' . $cticket . '</ConnectionTicket> 
	<Language>English</Language> 
	<AppID>' . $appid . '</AppID> 
	<AppVer>1</AppVer> 
	</SignonAppCertRq> 
	</SignonMsgsRq> 
	</QBXML>';

	// V1-184-bftHbtvBbE4IKmMUM1KBHQ:134864687

	$sticket = 'V1-184-EAmEv$CgvE4hTGuR3_YrjQ:134864687';	

	$PHP_Request = '<?xml version="1.0" ?> 
	<?qbxml version="6.0"?> 
	<QBXML> 
	<SignonMsgsRq>
	<SignonTicketRq> 
	<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime> 
	<SessionTicket>' . $sticket . '</SessionTicket>
	<Language>English</Language> 
	<AppID>' . $appid . '</AppID>
	<AppVer>1</AppVer> 
	</SignonTicketRq> 
	</SignonMsgsRq> 
	<QBXMLMsgsRq onError="continueOnError"> 
	<CustomerQueryRq requestID="2" /> 
	</QBXMLMsgsRq> 
	</QBXML>';
	

	$ch = curl_init(); 

$header[] = 'Content-Type: application/x-qbxml'; 
$header[] = 'Content-Length: '.strlen($PHP_Request); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 

	curl_setopt($ch, CURLOPT_POST, 1); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); 
	curl_setopt($ch, CURLOPT_URL, $PHP_URL); 
	curl_setopt($ch, CURLOPT_TIMEOUT, 3); 
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $PHP_Header); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $PHP_Request); 
	curl_setopt($ch, CURLOPT_STDERR, $handle); 
	curl_setopt($ch, CURLOPT_VERBOSE, 1); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); 
	curl_setopt($ch, CURLOPT_SSLCERT, $PHP_Cert); 

	$data = curl_exec($ch); 
	
	print($PHP_Request);
	
	print_r($data);
	//exit;

	if (curl_errno($ch)) 
	{ 
		die("Error = ".curl_error($ch)); 
	} 
	else 
	{ 
		curl_close($ch);	
	} 
	
	return $data; 
} 
