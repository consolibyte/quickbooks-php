<?php

/**
 * Example QuickBooks SOAP Server / Web Service
 * 
 * This is an example Web Service which imports inventory levels and item 
 * information from QuickBooks. It communicates with QuickBooks via the 
 * QuickBooks Web Connector.  
 * 
 * If you have not already looked at the more basic docs/example_server.php, 
 * you may want to consider looking at that example before you dive into this 
 * example, as the requests and processing are a bit simpler and the 
 * documentation a bit more verbose.
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// I always program in E_STRICT error mode... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// Support URL
if (!empty($_GET['support']))
{
	header('Location: http://www.consolibyte.com/');
	exit;
}

// We need to make sure the correct timezone is set, or some PHP installations will complain
if (function_exists('date_default_timezone_set'))
{
	// * MAKE SURE YOU SET THIS TO THE CORRECT TIMEZONE! *
	// List of valid timezones is here: http://us3.php.net/manual/en/timezones.php
	date_default_timezone_set('America/New_York');
}

// Include path for the QuickBooks library
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks/');

// Require the framework
require_once 'QuickBooks.php';

// A username and password you'll use in: 
//	a) Your .QWC file
//	b) The Web Connector
//	c) The QuickBooks framework
//
// 	NOTE: This has *no relationship* with QuickBooks usernames, Windows usernames, etc. 
// 		It is *only* used for the Web Connector and SOAP server! 
// 
// If you wanted to allow others to log in, you'd create a .QWC file for each 
//	individual user, and add each individual user to the auth database with the 
//	QuickBooks_Utilities::createUser($dsn, $username, $password); static method.
$user = 'quickbooks';
$pass = 'password';

/**
 * Maximum number of customers/invoices returned at a time when doing the import
 */
define('QB_QUICKBOOKS_MAX_RETURNED', 3);

/**
 * Send error notices to this e-mail address
 */
define('QB_QUICKBOOKS_MAILTO', 'example@example.com');

// The next three parameters, $map, $errmap, and $hooks, are callbacks which 
//	will be called when certain actions/events/requests/responses occur within 
//	the framework.

// Map QuickBooks actions to handler functions
$map = array(
	QUICKBOOKS_IMPORT_ITEM => array( '_quickbooks_item_import_request', '_quickbooks_item_import_response' ), 
	);

// Error handlers
$errmap = array(
	500 => '_quickbooks_error_e500_notfound', 			// Catch errors caused by searching for things not present in QuickBooks
	1 => '_quickbooks_error_e500_notfound', 
	'*' => '_quickbooks_error_catchall', 				// Catch any other errors that might occur
	);

// An array of callback hooks
$hooks = array(
	QuickBooks_Handlers::HOOK_LOGINSUCCESS => '_quickbooks_hook_loginsuccess', 	// call this whenever a successful login occurs
	);

// Logging level
//$log_level = QUICKBOOKS_LOG_NORMAL;
//$log_level = QUICKBOOKS_LOG_VERBOSE;
//$log_level = QUICKBOOKS_LOG_DEBUG;				// Use this level until you're sure everything works!!!
$log_level = QUICKBOOKS_LOG_DEVELOP;

// What SOAP server you're using 
//$soapserver = QUICKBOOKS_SOAPSERVER_PHP;			// The PHP SOAP extension, see: www.php.net/soap
$soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;		// A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)

$soap_options = array(			// See http://www.php.net/soap
	);

$handler_options = array(		// See the comments in the QuickBooks/Server/Handlers.php file
	);		

$driver_options = array(		// See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
	);

$callback_options = array(
	);

// * MAKE SURE YOU CHANGE THE DATABASE CONNECTION STRING BELOW TO A VALID MYSQL USERNAME/PASSWORD/HOSTNAME *
// 
// This assumes that:
//	- You are connecting to MySQL with the username 'root'
//	- You are connecting to MySQL with an empty password
//	- Your MySQL server is located on the same machine as the script ( i.e.: 'localhost', if it were on another machine, you might use 'other-machines-hostname.com', or '192.168.1.5', or ... etc. )
//	- Your MySQL database name containing the QuickBooks tables is named 'quickbooks' (if the tables don't exist, they'll be created for you) 
$dsn = 'mysql://root:root@localhost/quickbooks_inventory';
//$dsn = 'mysql://testuser:testpassword@localhost/testdatabase';

/**
 * Constant for the connection string (because we'll use it in other places in the script)
 */
define('QB_QUICKBOOKS_DSN', $dsn);

// If we haven't done our one-time initialization yet, do it now!
if (!QuickBooks_Utilities::initialized($dsn))
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
	
	// Create the database tables
	QuickBooks_Utilities::initialize($dsn);
	
	// Add the default authentication username/password
	QuickBooks_Utilities::createUser($dsn, $user, $pass);
}

// Initialize the queue
QuickBooks_Queue_Singleton::initialize($dsn);

// Create a new server and tell it to handle the requests
// __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
$Server = new QuickBooks_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver, QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
$response = $Server->handle(true, true);

/*
// If you wanted, you could do something with $response here for debugging

$fp = fopen('/path/to/file.log', 'a+');
fwrite($fp, $response);
fclose($fp);
*/

/**
 * Login success hook - perform an action when a user logs in via the Web Connector
 *
 * 
 */
function _quickbooks_hook_loginsuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
{
	// Make sure the requests get queued up
	$Queue = QuickBooks_Queue_Singleton::getInstance();
	$Queue->enqueue(QUICKBOOKS_IMPORT_ITEM);
}

/**
 * Build a request to import customers already in QuickBooks into our application
 */
function _quickbooks_item_import_request($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale)
{
	// Iterator support (break the result set into small chunks)
	$attr_iteratorID = '';
	$attr_iterator = ' iterator="Start" ';
	if (empty($extra['iteratorID']))
	{
		;
	}
	else
	{
		// This is a continuation of a batch
		$attr_iteratorID = ' iteratorID="' . $extra['iteratorID'] . '" ';
		$attr_iterator = ' iterator="Continue" ';
	}
	
	// Build the request
	$xml = '<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="' . $version . '"?>
		<QBXML>
			<QBXMLMsgsRq onError="stopOnError">
				<ItemQueryRq ' . $attr_iterator . ' ' . $attr_iteratorID . '>
					<MaxReturned>' . QB_QUICKBOOKS_MAX_RETURNED . '</MaxReturned>
					<OwnerID>0</OwnerID>
				</ItemQueryRq>	
			</QBXMLMsgsRq>
		</QBXML>';
		
	return $xml;
}

/** 
 * Handle a response from QuickBooks 
 */
function _quickbooks_item_import_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	if (!empty($idents['iteratorRemainingCount']))
	{
		// Queue up another request
		
		$Queue = QuickBooks_Queue_Singleton::getInstance();
		$Queue->enqueue(QUICKBOOKS_IMPORT_ITEM, null, 0, array( 'iteratorID' => $idents['iteratorID'] ));
	}
	
	// ... Magento specific stuff ...
	$Magento = new _QuickBooks_Custom_Magento(
		'http://208.81.124.11/~testymctesterson/pointdistribution/index.php/api/soap/?wsdl', 
		'api', 
		'6rxtyHiMrMvjwF0RCChz');
	
	// Import all of the records
	$errnum = 0;
	$errmsg = '';
	$Parser = new QuickBooks_XML_Parser($xml);
	if ($Doc = $Parser->parse($errnum, $errmsg))
	{
		$Root = $Doc->getRoot();
		$List = $Root->getChildAt('QBXML/QBXMLMsgsRs/ItemQueryRs');
		
		foreach ($List->children() as $Item)
		{
			$type = substr(substr($Item->name(), 0, -3), 4);
			$ret = $Item->name();
			
			$arr = array(
				'ListID' => $Item->getChildDataAt($ret . ' ListID'),
				'TimeCreated' => $Item->getChildDataAt($ret . ' TimeCreated'),
				'TimeModified' => $Item->getChildDataAt($ret . ' TimeModified'),
				'Name' => $Item->getChildDataAt($ret . ' Name'),
				'FullName' => $Item->getChildDataAt($ret . ' FullName'),
				'Type' => $type, 
				'Parent_ListID' => $Item->getChildDataAt($ret . ' ParentRef ListID'),
				'Parent_FullName' => $Item->getChildDataAt($ret . ' ParentRef FullName'),
				'ManufacturerPartNumber' => $Item->getChildDataAt($ret . ' ManufacturerPartNumber'), 
				'SalesTaxCode_ListID' => $Item->getChildDataAt($ret . ' SalesTaxCodeRef ListID'), 
				'SalesTaxCode_FullName' => $Item->getChildDataAt($ret . ' SalesTaxCodeRef FullName'), 
				'BuildPoint' => $Item->getChildDataAt($ret . ' BuildPoint'), 
				'ReorderPoint' => $Item->getChildDataAt($ret . ' ReorderPoint'), 
				'QuantityOnHand' => (int) $Item->getChildDataAt($ret . ' QuantityOnHand'), 
				'AverageCost' => $Item->getChildDataAt($ret . ' AverageCost'), 
				'QuantityOnOrder' => $Item->getChildDataAt($ret . ' QuantityOnOrder'), 
				'QuantityOnSalesOrder' => $Item->getChildDataAt($ret . ' QuantityOnSalesOrder'),  
				'TaxRate' => $Item->getChildDataAt($ret . ' TaxRate'),  
				);
			
			$look_for = array(
				'SalesPrice' => array( 'SalesOrPurchase Price', 'SalesAndPurchase SalesPrice', 'SalesPrice' ),
				'SalesDesc' => array( 'SalesOrPurchase Desc', 'SalesAndPurchase SalesDesc', 'SalesDesc' ),
				'PurchaseCost' => array( 'SalesOrPurchase Price', 'SalesAndPurchase PurchaseCost', 'PurchaseCost' ),
				'PurchaseDesc' => array( 'SalesOrPurchase Desc', 'SalesAndPurchase PurchaseDesc', 'PurchaseDesc' ),
				'PrefVendor_ListID' => array( 'SalesAndPurchase PrefVendorRef ListID', 'PrefVendorRef ListID' ), 
				'PrefVendor_FullName' => array( 'SalesAndPurchase PrefVendorRef FullName', 'PrefVendorRef FullName' ),
				); 
			
			foreach ($look_for as $field => $look_here)
			{
				if (!empty($arr[$field]))
				{
					break;
				}
				
				foreach ($look_here as $look)
				{
					$arr[$field] = $Item->getChildDataAt($ret . ' ' . $look);
				}
			}
			
			QuickBooks_Utilities::log(QB_QUICKBOOKS_DSN, 'Importing ' . $type . ' Item ' . $arr['FullName'] . ': ' . print_r($arr, true));
			
			foreach ($arr as $key => $value)
			{
				$arr[$key] = mysql_real_escape_string($value);
			}
			
			//print_r(array_keys($arr));
			//trigger_error(print_r(array_keys($arr), true));
			
			// Store the customers in MySQL
			mysql_query("
				REPLACE INTO
					qb_example_item
				(
					" . implode(", ", array_keys($arr)) . "
				) VALUES (
					'" . implode("', '", array_values($arr)) . "'
				)") or die(trigger_error(mysql_error()));
			
			// Magento inventory update... 
			$Magento->updateInventory($arr);
			QuickBooks_Utilities::log(QB_QUICKBOOKS_DSN, 'Updating Magento with: ' . print_r($arr, true));
		}
	}
	
	return true;
}

class _QuickBooks_Custom_Magento
{
	protected $_url;
	protected $_user;
	protected $_apikey;
	
	protected $_client;
	
	protected $_session;
	
	public function __construct($url, $user, $apikey)
	{
		$this->_url = $url;
		$this->_user = $user;
		$this->_apikey = $apikey;
		
		try
		{
			$this->_client = new SoapClient($this->_url);
			$this->_session = $this->_client->login($this->_user, $this->_apikey);
		} 
		catch (Exception $e)
		{
			; 
		}
		
		//$attribute_sets = $client->call($session, 'product_attribute_set.list');
		//$set = current($attribute_sets);
	}
	
	public function updateInventory($arr)
	{
		$sku = $arr['FullName'];
		
		$this->addOrUpdateProduct($arr);
		$this->updateStock($sku, $arr['QuantityOnHand']);
	}
	
	public function getProduct($sku)
	{
		$SOAP = $this->_client;
		$session = $this->_session;
		
		try {
			$stock_data = $SOAP->call($session, 'product_stock.list', array( array( $sku ) ));
			$product_data = $SOAP->call($session, 'product.info', array( $sku ));
		} 
		catch (Exception $e) 
		{
			// Product doesn't exist
			return false;
		}
		
		return array_merge($stock_data, $product_data);		
	}
	
	public function addOrUpdateProduct($arr)
	{
		$SOAP = $this->_client;
		$session = $this->_session;
		
		$attribute_sets = $SOAP->call($session, 'product_attribute_set.list');
		$set = current($attribute_sets);
		
		$product_data = array(
			"name" => $arr["Name"],
			"websites" => array(1),
			"short_description" => $arr["SalesDesc"],
			"description" => $arr["SalesDesc"],
			"price" => $arr["SalesPrice"],
			"status" => 2 // disabled
			);
		
		$sku = $arr['FullName'];
                
		if(!$this->getProduct($sku)) 
		{
			// Product doesn't exist
			$id = $SOAP->call($session, 'product.create', array('simple', $set['set_id'], $sku, $product_data));
		}
		else 
		{
			$id = $SOAP->call($session, 'product.update', array( $sku, $product_data ));
		}
	}
	
	public function updateStock($sku, $quantity)
	{
		$SOAP = $this->_client;
		$session = $this->_session;
		
		$product_data = array(
			'qty' => $quantity,
			'is_in_stock' => ($quantity > 0)
			);
			
		try 
		{
			$result = $SOAP->call($session, 'product_stock.update', array($sku, $product_data));
		} 
		catch(Exception $e) 
		{
			return false;
		}
		
		return $result;	
	}
}

/**
 * Handle a 500 not found error from QuickBooks
 * 
 * Instead of returning empty result sets for queries that don't find any 
 * records, QuickBooks returns an error message. This handles those error 
 * messages, and acts on them by adding the missing item to QuickBooks. 
 */
function _quickbooks_error_e500_notfound($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	$Queue = QuickBooks_Queue_Singleton::getInstance();
	
	if ($action == QUICKBOOKS_IMPORT_ITEM)
	{
		return true;
	}
	
	return false;
}

/**
 * Catch any errors that occur
 * 
 * @param string $requestID			
 * @param string $action
 * @param mixed $ID
 * @param mixed $extra
 * @param string $err
 * @param string $xml
 * @param mixed $errnum
 * @param string $errmsg
 * @return void
 */
function _quickbooks_error_catchall($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
{
	$message = '';
	$message .= 'Request ID: ' . $requestID . "\r\n";
	$message .= 'User: ' . $user . "\r\n";
	$message .= 'Action: ' . $action . "\r\n";
	$message .= 'ID: ' . $ID . "\r\n";
	$message .= 'Extra: ' . print_r($extra, true) . "\r\n";
	//$message .= 'Error: ' . $err . "\r\n";
	$message .= 'Error number: ' . $errnum . "\r\n";
	$message .= 'Error message: ' . $errmsg . "\r\n";
	
	mail(QB_QUICKBOOKS_MAILTO, 
		'QuickBooks error occured!', 
		$message);
}
