<?php

/**
 * Example of fetching multiple pages of results from IDS
 * 
 * WARNING: 
 * 	You should be aware that IDS paging of result sets using ChunkSize is 
 * 	sort of silly. Due to the way IDS is implemented on Intuit's end of things, 
 * 	IDS may return *up to twice* the number of records you asked for in a given 
 * 	page. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 */

// Content type
header('Content-Type: text/plain');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// QuickBooks library
require_once '../QuickBooks.php';

// AppCenter username/password
$username = 'keith@consolibyte.com';
$password = 'abcd1234';

// App security token
$token = 'tex3r7hwifx6cci3zk43ibmnd';

// Realm ID
$realmID = 133828393;

// DBID
$dbid = 'be9mh7qd5';

// Create our IPP instance
$IPP = new QuickBooks_IPP();

if ($Context = $IPP->authenticate($username, $password, $token))
{
	// DBID
	$IPP->dbid($Context, $dbid);
	
	// Flavor
	$IPP->flavor(QuickBooks_IPP_IDS::FLAVOR_DESKTOP);
	
	// Create a new Customer Service for IDS access
	$CustomerService = new QuickBooks_IPP_Service_Customer();
	
	// Page the result set 
	$pagesize = 10;
	$page = 1;
		
	do 
	{
		// Get a list of Customers from QuickBooks
		if ($customer_list = $CustomerService->findAll($Context, $realmID, null, null, $page, $pagesize))
		{
			print("\n\n\n" . 'Page: ' . $page . "\n");
			foreach ($customer_list as $key => $Customer)
			{
				print(($key + 1) . ': ' . $Customer->getName() . ' with balance of: ');
				
				if ($OpenBalance = $Customer->getOpenBalance())
				{
					print('$ ' . sprintf('%01.2f', $OpenBalance->getAmount()) . "\n");
				}
				else
				{
					print('$ 0.00 (no object)' . "\n");
				}
			}
			
			print("\n\n");
			
			$returned = count($customer_list);
			$page++;
		}
		else
		{
			print('An error occurred: ' . $CustomerService->errorCode() . ': ' . $CustomerService->errorMessage() . "\n");
		}
	}
	while ($returned >= $pagesize);
}
else
{
	print('Authentication to IPP/IDS failed!');
}
