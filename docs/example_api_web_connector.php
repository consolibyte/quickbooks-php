<?php

/**
 * QuickBooks OOP API use with the Desktop Editions
 * 
 * This example works together with the following two QuickBooks_API examples 
 * and the QuickBooks Web Connector to response to requests queued up by the 
 * OOP QuickBooks_API classes: 
 * 	- quickbooks_api_client.php
 * 	- quickbooks_api_client_canadian.php
 * 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// PHP throws warnings if you don't set you default timezone
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

// Include path
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks');

// Turn on all error reporting
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

/**
 * QuickBooks base classes
 */
require_once 'QuickBooks.php';

// Database DSN-style connection string which stores the queue and logging tables
$dsn = 'mysql://root:root@localhost/quickbooks_api';

// This should match the user you used to queue things up with in the QuickBooks_API client
$user = 'api';

// You can ignore these for now... 
$map = array();
$onerror = array();
$hooks = array();

// Logging level
$log_level = QUICKBOOKS_LOG_DEVELOP;
//$log_level = QUICKBOOKS_LOG_VERBOSE;
//$log_level = QUICKBOOKS_LOG_NORMAL;
//$log_level = QUICKBOOKS_LOG_NONE;

// Create the server instance and handle any requests  
$Server = new QuickBooks_Server_API(
	$dsn, 
	$user, 
	$map, 
	$onerror, 
	$hooks, 
	$log_level);
$Server->handle(true, true);

// The QuickBooks API will call your callback functions when the action or 
//	event is processed by QuickBooks. As shown in the 
//	docs/example_api_client*.php examples, whenever you make an API call you 
//	provide the name of a callback function. Here, we define those callback 
//	functions and make them operate on the data that is returned from 
//	QuickBooks.

/**
 * This callback gets called when we fetch a customer by name 
 * 
 * This callback is attached to the API method $API->getCustomerByName(...) in 
 * the docs/example_api_client_canadian.php script. 
 * 
 * @param string $method	
 * @param string $action	The action type of method being executed (CustomerQuery)
 * @param mixed $ID			The primary key of the customer you tried to fetch
 * @param string $err		If an error occurs, you should pass back the error message here
 * @param string $qbxml		The raw qbXML response from QuickBooks
 * @param QuickBooks_API_Iterator
 * @param resource $resource	
 * @return void
 */
function _quickbooks_ca_customer_getbyname_callback($method, $action, $ID, &$err, $qbxml, $Iterator, $resource)
{
	global $dsn;
	global $user;
	
	if (is_object($Iterator) and 
		$Iterator->count() > 0)
	{
		// We found a record matching this name, let's build a mapping of the 
		//	primary key in QuickBooks to the primary key in our own application 
		//	
		//	The primary key in QuickBooks for anything transaction related 
		//	(invoices, sales receipts, payments, etc.) is "TxnID", while the 
		//	primary key in QuickBooks for anything non-transaction related 
		//	(customers, sales tax codes, items, vendors, etc.) is "ListID"
		
		// Fetch the first item from the Iterator
		$Customer = $Iterator->next();
		
		// Build your own mapping...
		// mysql_query("INSERT INTO my_mapping_table ( qbType, qbListID_or_TxnID, application_primary_key ) VALUES ( 'Customer', '" . mysql_real_escape_string($Customer->getListID()) . "', " . (int) $ID . " ) ");
		
		// ... or use the built-in mapping methods
		QuickBooks_Utilities::createMapping(
			$dsn, 
			$user, 
			QUICKBOOKS_OBJECT_CUSTOMER, 
			$Customer->getListID(), 
			$ID, 
			$Customer->getEditSequence());
	}
	else
	{
		// No customer with that name was found
	}
}

/** 
 * Handle a list of returned customers from QuickBooks 
 * 
 * This function gets called with a set of customers returned from QuickBooks 
 * as a result of the ->searchCustomers(...) method call in 
 * example_api_client_canadian.php. 
 * 
 * QuickBooks will call this function to pass back a list of customers which 
 * matched the search critera. 
 */
function _quickbooks_ca_customer_search_callback($method, $action, $ID, &$err, $qbxml, $Iterator, $resource)
{
	global $dsn;
	
	if (is_object($Iterator))
	{
		while ($Customer = $Iterator->next())
		{
			QuickBooks_Utilities::log($dsn, 'Import customer: ' . print_r($Customer, true));
			
			$arr = array(
				'ListID' => $Customer->getListID(), 
				'TimeCreated' => $Customer->getTimeCreated(), 
				'TimeModified' => $Customer->getTimeModified(), 
				'Name' => $Customer->getName(), 
				'FullName' => $Customer->getFullName(), 
				'Contact' => $Customer->getContact(), 
				'ShipAddress_Addr1' => $Customer->getShipAddress('Addr1'), 
				'ShipAddress_Addr2' => $Customer->getShipAddress('Addr2'), 
				'ShipAddress_City' => $Customer->getShipAddress('City'),
				'ShipAddress_Province' => $Customer->getShipAddress('Province'), 
				'ShipAddress_PostalCode' => $Customer->getShipAddress('PostalCode'), 
				);
			
			foreach ($arr as $key => $value)
			{
				$arr[$key] = mysql_real_escape_string($value);
			}
			
			$sql = "
				REPLACE INTO 
					qb_example_customer 
				( 
					" . implode(', ', array_keys($arr)) . " 
				) VALUES ( 
					'" . implode("', '", array_values($arr)) . "' 
				) ";
				
			mysql_query($sql) or die(trigger_error(mysql_error()));
		}
		
		return true;
	}
	
	return false;
}

/**
 * Handle a list of returned invoices from QuickBooks 
 * 
 * This function gets called with a set of invoices returned from QuickBooks as 
 * a result of the ->searchInvoices(...) method call in 
 * example_api_client_canadian.php. 
 * 
 * QuickBooks will call this function to pass back a list of invoices which 
 * matched the search critera. 
 */
function _quickbooks_ca_invoice_search_callback($method, $action, $ID, &$err, $qbxml, $Iterator, $resource)
{
	global $dsn;
	
	if (is_object($Iterator))
	{
		// Loop through the list of invoices 
		while ($Invoice = $Iterator->next())
		{
			QuickBooks_Utilities::log($dsn, 'Import invoice: ' . print_r($Invoice, true));
			
			$arr = array(
				'TxnID' => $Invoice->getTxnID(), 
				'TimeCreated' => $Invoice->getTimeCreated(), 
				'TimeModified' => $Invoice->getTimeModified(), 
				'RefNumber' => $Invoice->getRefNumber(), 
				'Customer_ListID' => $Invoice->getCustomerListID(), 
				'Customer_FullName' => $Invoice->getCustomerName(), 
				'ShipAddress_Addr1' => $Invoice->getShipAddress('Addr1'), 
				'ShipAddress_Addr2' => $Invoice->getShipAddress('Addr2'), 
				'ShipAddress_City' => $Invoice->getShipAddress('City'),
				'ShipAddress_Province' => $Invoice->getShipAddress('Province'), 
				'ShipAddress_PostalCode' => $Invoice->getShipAddress('PostalCode'), 
				'BalanceRemaining' => $Invoice->getBalanceRemaining(), 
				);
			
			foreach ($arr as $key => $value)
			{
				$arr[$key] = mysql_real_escape_string($value);
			}
			
			// Stuff the invoices into a our MySQL database
			$sql = "
				REPLACE INTO 
					qb_example_invoice
				( 
					" . implode(', ', array_keys($arr)) . " 
				) VALUES ( 
					'" . implode("', '", array_values($arr)) . "' 
				) ";
				
			mysql_query($sql) or die(trigger_error(mysql_error()));
			
			mysql_query("DELETE FROM qb_example_invoice_lineitem WHERE TxnID = '" . $arr['RefNumber'] . "' ") or die(trigger_error(mysql_error()));
			foreach ($Invoice->listInvoiceLines() as $InvoiceLine)
			{
				QuickBooks_Utilities::log($dsn, 'Line item for invoice #' . $arr['RefNumber'] . ': ' . print_r($InvoiceLine, true));
				
				$line = array(
					'TxnID' => $arr['RefNumber'], 
					'TxnLineID' => $InvoiceLine->getTxnLineID(), 
					'Item_ListID' => $InvoiceLine->getItemListID(), 
					'Item_FullName' => $InvoiceLine->getItemName(), 
					'Descrip' => $InvoiceLine->getDescription(), 
					'Quantity' => $InvoiceLine->getQuantity(), 
					'Rate' => $InvoiceLine->getRate(), 
					);
				
				foreach ($line as $key => $value)
				{
					$line[$key] = mysql_real_escape_string($value);
				}
				
				$sql = "
					INSERT INTO 
						qb_example_invoice_lineitem 
					( 
						" . implode(', ', array_keys($line)) . "
					) VALUES ( 
						'" . implode("', '", array_values($line)) . "'
					) ";
				mysql_query($sql) or die(trigger_error(mysql_error()));
			}
		}
		
		return true;
	}
	
	return false;
}

/**
 * This function is called as a result of an ->addInvoice() method call
 *
 */
function _quickbooks_ca_journalentry_add_callback($method, $action, $ID, &$err, $qbxml, $JournalEntry, $resource)
{
	global $dsn;
	QuickBooks_Utilities::log($dsn, 'Added journal entry: ' . print_r($JournalEntry, true));
}

/**
 * This function is called as a result of an ->addInvoice() method call
 *
 */
function _quickbooks_ca_estimate_add_callback($method, $action, $ID, &$err, $qbxml, $Estimate, $resource)
{
	global $dsn;
	QuickBooks_Utilities::log($dsn, 'Added estimate: ' . print_r($Estimate, true));
}


/**
 * This function is called as a result of an ->addInvoice() method call
 *
 */
function _quickbooks_ca_invoice_add_callback($method, $action, $ID, &$err, $qbxml, $Invoice, $resource)
{
	global $dsn;
	QuickBooks_Utilities::log($dsn, 'Added invoice: ' . print_r($Invoice, true));
}

/**
 * This function is called as a result of an ->addCustomer() method call
 * 
 *
 */
function _quickbooks_ca_customer_add_callback($method, $action, $ID, &$err, $qbxml, $Customer, $resource)
{
	global $dsn;
	QuickBooks_Utilities::log($dsn, 'Added customer: ' . print_r($Customer, true));
}

/**
 * This function is called as a result of an ->addReceivePayment() method call
 *
 *
 */
function _quickbooks_ca_payment_add_callback($method, $action, $ID, &$err, $qbxml, $Payment, $resource)
{
	global $dsn;
	QuickBooks_Utilities::log($dsn, 'Added payment: ' . print_r($Payment, true));
}

/**
 * 
 */
function _quickbooks_customer_add_callback($method, $action, $ID, $err, $qbxml, $qbobject, $qbres)
{
	if (is_object($qbobject))
	{
		$fp = fopen('/home/kpalmer/logs/customer_add.log', 'w+');
		fwrite($fp, var_export($qbobject, true));
		fclose($fp);
		
		return true;
	}
	
	return false;
}

/**
 * 
 */
function _quickbooks_bill_add_callback($method, $action, $ID, $err, $qbxml, $qbobject, $qbres)
{
	if (is_object($qbobject))
	{
		$fp = fopen('/Users/keithpalmerjr/logs/bill_add.log', 'w+');
		fwrite($fp, var_export($qbobject, true));
		fclose($fp);
		
		return true;
	}
	
	return false;
}

function _quickbooks_customer_get_callback($method, $action, $ID, $err, $qbxml, $qbiterator, $qbres)
{
	if (is_object($qbiterator))
	{
		$fp = fopen('/home/kpalmer/logs/customer_get.log', 'w+');
		fwrite($fp, var_export($qbiterator, true));
		fclose($fp);
		
		return true;
	}
	
	return false;
}

//QuickBooks_Utilities::createUser($dsn, 'api', 'password');

?>