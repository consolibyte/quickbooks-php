<?php

header('Content-Type: text/plain');

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

require_once '../QuickBooks.php';

// 
$username = 'support@consolibyte.com';
$password = '';
$token = '';
$realmID = 182938192;

// 
$IPP = new QuickBooks_IPP();
if ($Context = $IPP->authenticate($username, $password, $token))
{
	$IPP->application($Context, 'bf4in6uym');
	
	$Service = new QuickBooks_IPP_Service_Discount();
	
	$list = $Service->findAll($Context, $realmID);
	
	//print_r($list);
	
	foreach ($list as $Discount)
	{
		//print_r($Discount);
		print($Discount->getId() . ', ' . $Discount->getName() . ', ' . $Discount->getAmount()->getAmount() . "\n\n");
	}
}
else
{
	print('Could not authenticate...');
}