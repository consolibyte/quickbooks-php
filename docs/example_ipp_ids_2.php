<?php

/**
 * Example of reading/writing data to/from Intuit Data Services
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', true);

// Output format
header('Content-Type: text/plain');

// Include the library
require_once '../QuickBooks.php';

// AppCenter username/password
// 
// IMPORTANT NOTE:
//	Normally, you'd never collect your end-users username/password. You'll 
//	never get through Intuit's tech review with code that does this. However, 
//	it makes testing a lot easier when you're initially developing stuff. 
$username = 'keith@consolibyte.com';
$password = 'abcd1234';

// Application security token
$token = 'tex3r7hwifx6cci3zk43ibmnd';

// Your realm ID
$realmID = 133828393;

// Your DBID
$dbid = 'be9mh7qd5';

// Create our IPP instance
$IPP = new QuickBooks_IPP();

// Log in
if ($Context = $IPP->authenticate($username, $password, $token))
{
	// Set our DBID
	$IPP->dbid($dbid);
	
	// Set our flavor
	$IPP->flavor(QuickBooks_IPP_IDS::FLAVOR_DESKTOP);
	
	// Create a new Customer Service for IDS access
	$CustomerService = new QuickBooks_IPP_Service_Customer();
	
	// Get a list of Customers from QuickBooks
	$customer_list = $CustomerService->findAll($Context, $realmID);
	
	// Create a new Invoice Service for IDS access
	$InvoiceService = new QuickBooks_IPP_Service_Invoice();
	
	// Get a list of invoices
	$invoice_list = $InvoiceService->findAll($Context, $realmID);
	
	// Loop through the customer list
	foreach ($customer_list as $key => $Customer)
	{
		// Print the customer name
		print($Customer->getName() . "\r\n");
		
		// Loop through the invoice list
		foreach ($invoice_list as $key => $Invoice)
		{
			//print_r($Invoice);
			
			if ($Invoice->getHeader()->getCustomerId() != $Customer->getId())
			{
				continue;
			}
			
			$str = str_replace(array("\t", "\n", "\r"), ' ', '
				' . $Invoice->getHeader()->getDocNumber() . '
				' . date('M. jS Y', strtotime($Invoice->getHeader()->getTxnDate())) . '
				' . $Invoice->getHeader()->getARAccountName() . '
				$ ' . sprintf('%01.2f', $Invoice->getHeader()->getTotalAmt()) . '
			');
			
			print('   ' . $str . "\r\n");
		}
		
		print("\r\n\r\n");
	}
	
	print('<pre>');
	print_r($customer_list);
	print_r($invoice_list);
	print('</pre>');
}