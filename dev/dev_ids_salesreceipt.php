<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);
$IPP->application($Context, 'be9mh7qd5');

// Create a new Service for IDS access
$Service = new QuickBooks_IPP_Service_SalesReceipt();

$list = $Service->findAll($Context, $realmID);

//print($Service->lastRequest($Context));

//print($Service->lastResponse($Context));


$Service = new QuickBooks_IPP_Service_SalesRep();

$list = $Service->findAll($Context, $realmID);

foreach ($list as $SalesRep)
{
	print('Sales Rep: ' . $SalesRep->getInitials() . ' last modified on ' . $SalesRep->getMetaData()->getLastUpdatedTime('H:i:s d/m/Y') . "\n");
}

print_r($list);

/*
foreach ($list as $Estimate)
{
	print('Estimate #' . $Estimate->getHeader()->getDocNumber() . ' is to be emailed: ' . $Estimate->getHeader()->getToBeEmailed() . "\n");
	print('	Should we email it? ');
	
	if ($Estimate->getHeader()->getToBeEmailed())
	{
		print('YES');
	}
	else
	{
		print('NO');
	}
	
	print("\n");
	
	for ($i = 0; $i < 10; $i++)
	{
		$Line = $Estimate->getLine($i);
		
		if ($Line)
		{
			print_r($Line);
		}
	}
	
	print("\n");
	print("\n");
}
*/

//print_r($list);

//print($Service->lastResponse());