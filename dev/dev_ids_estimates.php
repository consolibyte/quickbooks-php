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
$Service = new QuickBooks_IPP_Service_Estimate();

$list = $Service->findAll($Context, $realmID);

foreach ($list as $Estimate)
{
	print('Estimate ' . $Estimate->getId() . ' / #' . $Estimate->getHeader()->getDocNumber() . ' is to be emailed: ' . $Estimate->getHeader()->getToBeEmailed() . "\n");
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
			print($Line->getDescription() . '   $ ' . $Line->getUnitPrice() . ' x ' . $Line->getQuantity() . "\n");
			//print_r($Line);
		}
	}
	
	print("\n");
	print("\n");
	
	$ID = $Estimate->getId();
	break;
}


$Estimate = $Service->findById($Context, $realmID, $ID);

print('Fetched estimate: ' . $Estimate->getHeader()->getDocNumber() . "\n\n");
