<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = 'password';
$token = 'app token here';
$realmID = 1234;
$appdbid = 'app dbid here';

// 
$IPP = new QuickBooks_IPP();

if ($Context = $IPP->authenticate($username, $password, $token))
{
	$IPP->application($appdbid);
	
	//$IPP->useDebugMode(true);
	
	if ($IPP->assertFederatedIdentity($Context, 'XXXXXod-intuit.ipp.prod', 'https://secure.your-url.com/saml.php'))
	{
		print('SUCCESS!');
	}
	else
	{
		print('Error [' . $IPP->errorCode() . ': ' . $IPP->errorText() . ', ' . $IPP->errorDetail() . ']');
	}
	
	print("\n\n\n\n");
	print($IPP->lastRequest());
	print("\n\n\n\n");
	print($IPP->lastResponse());
}
else
{
	print('Auth error...?');
}