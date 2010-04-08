<?php

/**
 * QuickBooks OOP API use with the QuickBooks Canadian Desktop Editions
 * 
 * This file works in tandam with the docs/example_api_server.php file. 
 * Communication with QuickBooks Desktop Editions is accomplished via the Web 
 * Connector, which should be pointed at the docs/example_api_server.php file. 
 * 
 * You'll find that many of the API calls provide a callback parameter, the 
 * name of a function to call when QuickBooks sends back a response. This is 
 * because the QuickBooks Web Connector does not provide real-time 
 * communication with QuickBooks. This file queues up example requests, and 
 * then the Web Connector connects and runs these requests againts QuickBooks 
 * at some point and calls your callback functions with the response data from 
 * QuickBooks. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Just for testing
header('Content-Type: text/plain');

// Make sure we show any errors that occur
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// PHP complains if we don't set the timezone correctly
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

// Include path for the QuickBooks library
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks');

/**
 * QuickBooks framework
 */
require_once 'QuickBooks.php';

// This is the username and password you provide to the QuickBooks Web 
//	Connector and to the .QWC file you create and load into the Web Connector. 
$user = 'api';
$pass = 'password';

// Tell the API we're connecting via the Web Connector
$source_type = QUICKBOOKS_API_SOURCE_WEB_CONNECTOR;

// DSN-style connection string for the database to use for queueing up requests/logging
$api_driver_dsn = 'mysql://root:@localhost/quickbooks_api';

// This is not used with the Web Connector
$source_dsn = null;

// These can be left at the defaults...
$api_options = array();
$source_options = array();
$driver_options = array();

// Create the database schema if neccessary
if (!QuickBooks_Utilities::initialized($api_driver_dsn))
{
	// Create the example tables
	$file = dirname(__FILE__) . '/example.sql';
	if (file_exists($file))
	{
		$contents = file_get_contents($file);	
		foreach (explode(';', $contents) as $sql)
		{
			if (!trim($sql))
			{
				continue;
			}
			
			mysql_query($sql) or die(trigger_error(mysql_error()));
		}
	}
	else
	{
		die('Could not locate "./example.sql" to create the demo SQL schema!');
	}
	
	// 
	QuickBooks_Utilities::initialize($api_driver_dsn);
	
	// This 
	QuickBooks_Utilities::createUser($api_driver_dsn, $user, $pass);
}

// 
$API = new QuickBooks_API($api_driver_dsn, $user, $source_type, $source_dsn, $api_options, $source_options, $driver_options);

// Get the complete list of "Customers" from QuickBooks
// 
// Unfortunately, non-US versions of QuickBooks do not yet support the use of 
//	"iterators" to break up the response from QuickBooks into many smaller 
//	chunks. So, if we ask for the complete customer list, the response is so 
//	large that the transfer takes a long time, the Web Connector times out, or 
//	the HTTP server throws an error after receiving to much data. 
//	
//	Thus, instead of sending just a single request, we're going to fetch the 
//	list of customers by date range instead. 
$seconds_in_a_day = 60 * 60 * 24;
for ($i = strtotime('2009-04-07'); $i < time(); $i = $i + $seconds_in_a_day)
{
	$search = array(
		'FromModifiedDate' => QuickBooks_Utilities::datetime($i), 
		'ToModifiedDate' => QuickBooks_Utilities::datetime($i + $seconds_in_a_day),
		);
	if ($API->searchCustomers($search, '_quickbooks_ca_customer_search_callback'))
	{
		print('Fetch customers from: ' . $search['FromModifiedDate'] . ' to ' . $search['ToModifiedDate'] . "\n");
	}
}


// Get a complete list of "Invoices" from QuickBooks
$seconds_in_a_day = 60 * 60 * 24;
for ($i = strtotime('2009-04-07'); $i < time(); $i = $i + $seconds_in_a_day)
{
	$search = array(
		'ModifiedDateRangeFilter FromModifiedDate' => QuickBooks_Utilities::datetime($i), 
		'ModifiedDateRangeFilter ToModifiedDate' => QuickBooks_Utilities::datetime($i + $seconds_in_a_day),
		);
	
	if ($API->searchInvoices($search, '_quickbooks_ca_invoice_search_callback'))
	{
		print('Fetch invoices from: ' . $search['ModifiedDateRangeFilter FromModifiedDate'] . ' to ' . $search['ModifiedDateRangeFilter ToModifiedDate'] . "\n");
	}
}



// Fetch a specific customer from QuickBooks by Name 
// 
// We're going to query QuickBooks for a customer named "Keith Palmer". 
//	The query will be executed against QuickBooks and the function named 
//	"_quickbooks_ca_customer_getbyname_callback" will be called with an 
//	Iterator object. The Iterator will either be empty (there is no customer by 
//	the name of "Keith Palmer") or contain Keith's complete customer record. 
// 
// Pretend for a minute that we actually have "Keith Palmer" in our own web 
//	application, and what we'd really like to do is check if he exists in 
//	QuickBooks, and then create a mapping so we know that Keith's primate key 
//	in our database maps to QuickBooks primary key XYZ. To accomplish this, 
//	we'll call the API method passing in Keith's primary key, so we can create 
//	the mapping later in the callback function.
$customers_name = 'Keith Palmer';
$primary_key_of_customer_in_your_application = 15;
if ($API->getCustomerByName($customers_name, '_quickbooks_ca_customer_getbyname_callback', $primary_key_of_customer_in_your_application))
{
	print('Queued up a request to fetch a customer named "' . $customers_name . '"!' . "\n");
}



// Adding a new customer to QuickBooks
// 
// This example shows how to queue up a request to add a new customer to 
//	QuickBooks. Remember that the Name element of a customer is unique within 
//	QuickBooks, and the request will fail and send you back an error message if 
//	another customer in QuickBooks already has that name. 

$name = 'Shannon\'s Company (' . mt_rand() . ')';
$fname = 'Shannon';
$lname = 'Daniels';		// (the mt_rand() call is just so I don't get duplicate customer errors while testing)

$Customer = new QuickBooks_Object_Customer();

// This is a unique name (usually a company name) for the customer
$Customer->setName($name);

$Customer->setFirstName($fname);
$Customer->setLastName($lname);

$Customer->setShipAddress(
	'134 Stonemill Road', 
	'', 			// Address line 2
	'', 			// Address line 3
	'', 			// Address line 4 (only usable if you *do not* specify city/state/postalcode/country
	'', 			// Address line 5 (only usable if you *do not* specify city/state/postalcode/country
	'Toronto', 		// City
	'', 			// This is the US state field, don't use this with CA editions of QuickBooks
	'Ontario', 		// Province or state
	'H1B 12L',		// Postal code
	'Canada');		// Country
$Customer->setMiddleName('B.');
$Customer->setSalutation('Ms.');

$Customer->setPhone('1.860.634.1602');

// Queue up the actual request to be sent to QuickBooks via the Web Connector
//	
// Notice that we also provide the primary key of this customer from within our 
//	application, so we can create a mapping which maps this customer to the 
//	QuickBooks primary key. 
// 
// We also provide a priority, we want to make sure that this request runs 
//	*before* the request below, because we need to create the customer *before* 
//	we create an invoice for them. Higher priorities run sooner.
$primary_key_of_customer_in_your_application = 20;
$priority_of_add_customer_request = 25;
if ($API->addCustomer(
	$Customer, 
	'_quickbooks_ca_customer_add_callback', 
	$primary_key_of_customer_in_your_application, 
	$priority_of_add_customer_request))
{
	print('Queued up a request to add customer #' . $primary_key_of_customer_in_your_application . ', "' . $Customer->getName() . '" to QuickBooks!' . "\n");
}



// Adding an invoice to QuickBooks 
// 
// This shows an example of queueing up a request to add a new invoice to 
//	QuickBooks. The process for adding estimates, purchase orders, and sales 
//	receipts is *very* similar to the process for adding invoices. 

$primary_key_of_invoice_in_your_application = 125;

// Create the new invoice object
$Invoice = new QuickBooks_Object_Invoice();

// We're going to assign this invoice to the customer we created above, #20, 
//	"Shannon Daniels". There are a few ways you can refer to that customer. You 
//	can refer to them by their Name/FullName attribute ("Shannon's Company" in 
//	the example shown above), by their ListID (a primary key within QuickBooks) 
//	or, if you've created a mapping between the customer's primary key within 
//	your application and the customer in QuickBooks, you can refer to them by 
//	the primary key within your application, and the framework will map this 
//	value to a ListID for you. 
// 
// 	For this example, we're going to refer to them by their mapped primar key, 
//	because the callback function "_quickbooks_ca_customer_add_callback" that 
//	we used above when adding Shannon creates this mapping for us. 
$Invoice->setCustomerApplicationID($primary_key_of_customer_in_your_application);
// $Invoice->setCustomerName('The Company Name Here');
// $Invoice->setCustomerListID($ListID_from_QuickBooks);

// Invoice #125
$Invoice->setRefNumber($primary_key_of_invoice_in_your_application);

// Set some other fields... 
$Invoice->setMemo('This invoice was created using the QuickBooks PHP API!');

// Now, we need to build each invoice line for the invoice. Each invoice line 
//	will contain at least a reference to an item, and probably a quantity or 
//	the item ordered, and either a total amount or a rate (price per item). 
// 
// As with customers above, the items need to be present in QuickBooks before 
//	we can add an invoice that depends on them. You can again refer to the item 
//	in three different ways: 
//	- Name/FullName 
//	- ListID
//	- a mapped primary key from your application
// 
// 	For this example, we're going to refer to the items by name, so the items 
//	must already be present in QuickBooks for this invoice to be added. 

// 3 items of type "Item Type 1" at $10.00 per item
$InvoiceLine1 = new QuickBooks_Object_Invoice_InvoiceLine();
$InvoiceLine1->setItemName('Item Type 1');
$InvoiceLine1->setRate(10.00);
$InvoiceLine1->setQuantity(3);

// 5 items of type "Item Type 2", for a total amount of $225.00 ($45.00 each)
$InvoiceLine2 = new QuickBooks_Object_Invoice_InvoiceLine();
$InvoiceLine2->setItemName('Item Type 2');
$InvoiceLine2->setAmount(225.00);
$InvoiceLine2->setQuantity(5);

// Make sure you add those invoice lines on to the invoice
$Invoice->addInvoiceLine($InvoiceLine1);
$Invoice->addInvoiceLine($InvoiceLine2);

// Queue up the request to be sent to QuickBooks
$priority_of_add_invoice_request = 10;	// Make sure this is lower than the customer add it depends on
if ($API->addInvoice(
	$Invoice, 
	'_quickbooks_ca_invoice_add_callback', 
	$primary_key_of_invoice_in_your_application, 
	$priority_of_add_invoice_request))
{
	print('Queued up a request to add invoice #' . $primary_key_of_invoice_in_your_application . ' to QuickBooks!' . "\n");
}



// Adding an estimate for a customer

$primary_key_of_estimate_in_your_application = 'ABC-123';

// Adding an estimate is very similar to adding an invoice, as most of the 
//	estimate data within QuickBooks closely mirrors the invoice data. 
$Estimate = new QuickBooks_Object_Estimate();

// Set the customer that this estimate belongs to
$Estimate->setCustomerName($name);

// Set some other estimate data
$Estimate->setTxnDate('4/2/1999');
$Estimate->setRefNumber($primary_key_of_estimate_in_your_application);

// Billing address
$Estimate->setBillAddress(
	'134 Stonemill Road', 
	'', 
	'', 
	'', 
	'', 
	'Quebec City', 
	'', 
	'Quebec', 
	'H12 ABC', 
	'Canada');

// Estimate line items
$EstimateLine1 = new QuickBooks_Object_Estimate_EstimateLine();
$EstimateLine1->setItemName('Item Type 1');
$EstimateLine1->setRate(14.95);
$EstimateLine1->setQuantity(5);

// Add the estimate line item to the estimate
$Estimate->addEstimateLine($EstimateLine1);

// Queue up the request to be sent to QuickBooks
$priority_of_add_estimate_request = 10;	// Make sure this is lower than the customer add it depends on
if ($API->addEstimate(
	$Estimate, 
	'_quickbooks_ca_estimate_add_callback', 
	$primary_key_of_estimate_in_your_application, 
	$priority_of_add_estimate_request))
{
	print('Queued up a request to add estimate #' . $primary_key_of_estimate_in_your_application . ' to QuickBooks!' . "\n");
}



// Journal entry
$JournalEntry = new QuickBooks_Object_JournalEntry();

$JournalEntry->setTransactionDate('January 2, 2009');

$DebitLine = new QuickBooks_Object_JournalEntry_JournalDebitLine();
$DebitLine->setAmount(45.0);
$DebitLine->setAccountName('Test Bank Account');
$JournalEntry->addDebitLine($DebitLine);

$CreditLine = new QuickBooks_Object_JournalEntry_JournalCreditLine();
$CreditLine->setAmount(45.0);
$CreditLine->setAccountName('Automobile Expense');
$JournalEntry->addCreditLine($CreditLine);

if ($API->addJournalEntry(
	$JournalEntry, 
	'_quickbooks_ca_journalentry_add_callback'))
{
	print('Queued up an add journal entry request to QuickBooks!' . "\n");
}


// Adding a payment for a customer
$Payment = new QuickBooks_Object_ReceivePayment();

$Payment->setCustomerApplicationID($primary_key_of_customer_in_your_application);
$Payment->setRefNumber(1234);
$Payment->setTxnDate(date('Y-m-d'));
$Payment->setTotalAmount(50.0);
$Payment->setIsAutoApply(true);

$priority_of_add_payment_request = 5; // Make sure this is lower than the customer add it depends on
if ($API->addReceivePayment(
	$Payment, 
	'_quickbooks_ca_payment_add_callback', 
	null, 
	$priority_of_add_payment_request))
{
	print('Queued up a request to add a payment to QuickBooks!' . "\n");
}

