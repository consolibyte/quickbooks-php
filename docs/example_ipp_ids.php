<?php

header('Content-Type: text/plain');

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

// Create a new Customer Service for IDS
$CustomerService = new QuickBooks_IPP_Service_Customer();

// Get a list of Customers from QuickBooks
$list = $CustomerService->findAll($Context, $realmID);

// Print them out
foreach ($list as $Customer)
{
	$line = '';
	$city = '';
	$state = '';
	if ($Address = $Customer->getAddress(0))
	{
		$line = $Address->getLine1();
		$city = $Address->getCity();
		$state = $Address->getCountrySubDivisionCode();
	}
	
	print('Customer name is: ' . $Customer->getName() . ' has an address of: ' . $line . ' ' . $city . ' ' . $state . "\n");
}


