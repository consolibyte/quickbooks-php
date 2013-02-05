<?php

header('Content-Type: text/plain');

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = '';
$token = '';
$realmID = 192848234;

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);

$IPP->application($Context, 'bf4in6uym');

$Service = new QuickBooks_IPP_Service_UOM();

$list = $Service->findAll($Context, $realmID);

//print_r($list);

foreach ($list as $UOM)
{
	print('Unit of measure [' . $UOM->getName() . '] of type [' . $UOM->getBaseType() . ']' . "\n");
	for ($i = 0; $i < $UOM->countConvUnit(); $i++)
	{
		$ConvUnit = $UOM->getConvUnit($i);
		
		print("\t" . $ConvUnit->getName() . ', ' . $ConvUnit->getConvRatio() . "\n");
	}
	print("\n");
}
