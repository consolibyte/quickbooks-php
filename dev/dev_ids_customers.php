<?php

header('Content-Type: text/plain');

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

// 
$IPP = new QuickBooks_IPP();
if ($Context = $IPP->authenticate($username, $password, $token))
{
	$IPP->application($Context, 'be9mh7qd5');
	
	$user = $IPP->getUserInfo($Context);
	print_r($user);
	
	//exit;
	
	$Service = new QuickBooks_IPP_Service_Customer();
	
	if ($list = $Service->findAll($Context, $realmID))
	{
		//print_r($list);
		
		foreach ($list as $Customer)
		{
			print('Name is [' . $Customer->getName() . ']' . "\n");
		}
	}
	
	//print($Service->lastRequest());
	//print($Service->lastResponse());
}
else
{
	print('Auth failed!');
}

exit;
