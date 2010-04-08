<?php

/**
 * Foxycart Server Integrator for the QuickBooks Web Connector
 * 
 * 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * 
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_MODULE_FOXYCART', 'foxycart');

/**
 * Enabled status - user is enabled
 * @var string
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_STATUS_ENABLED', 'e');

/**
 * Disabled status - user is disabled
 * @var string
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_STATUS_DISABLED', 'd');

/**
 * Hold status - used when we may fetch accounts, sales tax items, ship methods, etc. from Foxycart, but not send any transactions to it
 * @var string
 */
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_STATUS_HOLD', 'h');

define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_USER', 'qb_foxycart_user');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_LOG', 'qb_foxycart_log');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_DATAFEED', 'qb_foxycart_datafeed');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER', 'qb_foxycart_customer');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_PRODUCT', 'qb_foxycart_product');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION', 'qb_foxycart_transaction');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDETAIL', 'qb_foxycart_transaction_detail');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDISCOUNT', 'qb_foxycart_transaction_discount');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONCUSTOMFIELD', 'qb_foxycart_transaction_customfield');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDETAILOPTION', 'qb_foxycart_transaction_detail_option');

define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTCUSTOMER', 'QuickBooks_Server_Integrator_Foxycart::insertCustomer');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_UPDATECUSTOMER', 'QuickBooks_Server_Integrator_Foxycart::updateCustomer');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTORDER', 'QuickBooks_Server_Integrator_Foxycart::insertOrder');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_UPDATEORDER', 'QuickBooks_Server_Integrator_Foxycart::updateOrder');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTORDERLINE', 'QuickBooks_Server_Integrator_Foxycart::insertOrderLine');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_UPDATEORDERLINE', 'QuickBooks_Server_Integrator_Foxycart::updateOrderLine');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTPRODUCT', 'QuickBooks_Server_Integrator_Foxycart::insertProduct');
define('QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_UPDATEPRODUCT', 'QuickBooks_Server_Integrator_Foxycart::updateProduct');

/**
 * QuickBooks server integrator base class
 */
QuickBooks_Loader::load('/QuickBooks/Server/Integrator.php');

/**
 * Encryption factory because Foxycart sends it's data RC4 encrypted
 */
QuickBooks_Loader::load('/QuickBooks/Encryption/Factory.php');

/**
 * 
 */
class QuickBooks_Server_Integrator_FoxyCart extends QuickBooks_Server_Integrator
{
	/**
	 * 
	 * @var object
	 */
	protected $_api;
	
	/**
	 * 
	 * @var object
	 */
	protected $_integrator;
	
	/** 
	 * 
	 * @var array
	 */
	protected $_foxycart_options;
	
	/**
	 * Create and return an instance of the iterator
	 * 
	 * FoxyCart uses a database instance class to cache data received from the 
	 * FoxyCart data feeds, so we also create a database instance class and 
	 * send that to the iterator. 
	 * 
	 * @param string $integrator_dsn_or_conn
	 * @param array $integrator_options
	 * @return QuickBooks_Integrator_*
	 */
	protected function _integratorFactory($integrator_dsn_or_conn, $integrator_options, $API)
	{
		$Driver = QuickBooks_Driver_Factory::create($integrator_dsn_or_conn, $integrator_options);
		return new QuickBooks_Integrator_Foxycart($Driver, $integrator_options, $API);
	}
	
	/**
	 * Handle a SOAP request *or* a FoxyCart Datafeed message
	 * 
	 * If this method detects a SOAP request, it will act as a FoxyCart web 
	 * service integration using the Web Connector. If it detects a FoxyCart 
	 * data feed, it will process the data feed and store it in database tables 
	 * for sending to QuickBooks later. 
	 * 
	 * @param boolean $return
	 * @param boolean $debug
	 * @return mixed
	 */
	public function handle($return = false, $debug = false, $die = true)
	{
		if (isset($_POST['FoxyData']))
		{
			return $this->_handleFoxycartData($this->_api, $this->_integrator, $this->_integrator_config, $_POST['FoxyData'], $die);
		}
		else
		{
			return parent::handle($return, $debug);
		}
	}
	
	/**
	 * Load a configuration variable from the WHMCS user table
	 * 
	 * @param string $key		The key for the configuration value to load
	 * @param mixed $set		If you want to also *set* the value, pass in the value to set here
	 * @return mixed			The configuration key
	 */
	protected function _foxycartConfig($key)
	{
		$API = $this->_api;
		
		static $cache = null;
		
		// Get the username... 
		$user = $API->user();

		// Get the SQL driver
		$Database = $this->_integrator;
		
		if (is_null($cache))
		{
			$errnum = null;
			$errmsg = null;
			$res = $Database->query("SELECT * FROM " . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_USER . " WHERE foxycart_user_name = '" . $Database->escape($user) . "' ", $errnum, $errmsg);
			if ($arr = $Database->fetch($res))
			{
				$cache = $arr;
			}
		}
		
		if ($cache and 
			isset($cache[$key]))
		{
			return $cache[$key];
		}
		
		return null;
	}		
	
	/**
	 * Log a message to the FoxyCart log table
	 * 
	 * 
	 */
	protected function _foxycartLog($message, $user, $feed = null)
	{
		if ($feed)
		{
			$feed = " '" . $this->_integrator->escape($feed) . "' ";
		}
		else
		{
			$feed = " NULL ";
		}
		
		$errnum = 0;
		$errmsg = null;
		return $this->_integrator->query("
			INSERT INTO
				" . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_LOG . "
			(
				foxycart_log_msg, 
				foxycart_log_user, 
				foxycart_log_datafeed, 
				foxycart_log_datetime
			) VALUES (
				'" . $this->_integrator->escape($message) . "', 
				'" . $this->_integrator->escape($user) . "', 
				" . $feed . ", 
				'" . date('Y-m-d H:i:s') . "' 
			)", $errnum, $errmsg);
	}
	
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	protected function _handleFoxycartData($API, $Integrator, $foxycart_config, $foxydata, $die = true)
	{
		$FOXYCART_FEED = date('Y-m-d H:i:s');
		$FOXYCART_NOW = date('Y-m-d H:i:s');
		$FOXYCART_USER = $API->user();
		$FOXYCART_KEY = null;
		$FOXYCART_ENABLED = null;
		
		// Check the username
		$errnum = null;
		$errmsg = null;
		$foxycart_status = $this->_foxycartConfig('foxycart_user_status');
		$foxycart_enabled = $this->_foxycartConfig('foxycart_user_enabled_datetime');
		
		if (!$foxycart_status)
		{
			$msg = 'Could not locate a user account for: [' . $FOXYCART_USER . ']';
			$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
			die($msg);
		}
		else if ($foxycart_status == QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_STATUS_ENABLED)
		{
			if (strtotime($foxycart_enabled) > strtotime('2009-01-01'))	// Check to make sure we know *when* it was enabled
			{
				// Good to go, set this variable and continue
				$FOXYCART_ENABLED = $foxycart_enabled;
			}
			else
			{
				$msg = 'The user account [' . $FOXYCART_USER . '] is enabled but has the invalid enabled-datetiem of [' . $foxycart_enabled . ']. Please contact us at [' . QUICKBOOKS_PACKAGE_AUTHOR . '].';
				$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
				die($msg);									
			}
		}
		else if ($foxycart_status == QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_STATUS_DISABLED)
		{
			$msg = 'The user account [' . $FOXYCART_USER . '] has been disabled; transactions will not be processed. Please contact us at [' . QUICKBOOKS_PACKAGE_AUTHOR . '].';
			$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
			die($msg);					
		}
		else if ($foxycart_status == QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_STATUS_HOLD)
		{
			$msg = 'The user account [' . $FOXYCART_USER . '] is on hold; transactions will not be processed until the account is enabled. Please contact us at [' . QUICKBOOKS_PACKAGE_AUTHOR . '].';
			$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
			die($msg);		
		}
		else
		{
			$msg = 'An unknown user status [' . $foxycart_status . '] was encounted for user: [' . $FOXYCART_USER . ']';
			$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
			die($msg);			
		}
		
		// An extra check in case I screw something up...
		if (!$FOXYCART_ENABLED or strtotime($FOXYCART_ENABLED) < strtotime('2009-01-01'))
		{
			$msg = 'The user account [' . $FOXYCART_USER . '] has a missing enabled-datetime. Please contact us at [' . QUICKBOOKS_PACKAGE_AUTHOR . '].';
			$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
			die($msg);									
		}
		
		$foxycart_secret = $this->_foxycartConfig('foxycart_secret_key');
		
		if (empty($foxycart_secret))
		{
			// Look it up from the QuickBooks config table
			// @todo Ecccchhhh should I be doing this? 
			$tmp1 = null;
			$tmp2 = null;
			$FOXYCART_KEY = $API->configRead(QUICKBOOKS_SERVER_INTEGRATOR_MODULE_FOXYCART, 'foxycart_secret_key', $tmp1, $tmp2);
			
			// If not found, look it up in the foxycart_user table
			if (!$FOXYCART_KEY)
			{
				$errnum = 0;
				$errmsg = null;
				//$res = $Integrator->query("SELECT * FROM " . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_USER . " WHERE foxycart_user_name = '" . $Integrator->escape($FOXYCART_USER) . "' ", $errnum, $errmsg);
				//$arr = $Integrator->fetch($res);
				
				//$FOXYCART_KEY = $arr['foxycart_user_key'];
				$FOXYCART_KEY = $this->_foxycartConfig('foxycart_user_key');
			}
		}
		else
		{
			//$FOXYCART_KEY = $foxycart_config['foxycart_secret_key'];
			$FOXYCART_CONFIG = $this->_foxycartConfig('foxycart_user_key');
		}
		
		if (substr(urldecode($foxydata), 0, 6) == '<?xml ')
		{
			// This handles cases where the data is sent to us unencrypted
			$xml = $foxydata;
		}
		else if ($FOXYCART_KEY)
		{
			// The data is encrypted
			//$xml = rc4crypt::decrypt(FOXY_SECRET_KEY, urldecode($_POST['FoxyData']));
			$crypt = QuickBooks_Encryption_Factory::create('RC4');
			$xml = $crypt->decrypt($FOXYCART_KEY, urldecode($foxydata));
		}
		else
		{
			// There is something wrong with the data or decryption key... 
			//$xml = urldecode($foxydata);
			
			$msg = 'Could not locate a decryption key.';
			$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
			die($msg);
		}
		
		if ($xml[0] != '<')
		{
			$msg = 'Could not process data with key: [' . $FOXYCART_KEY . '], data: ' . $xml;
			$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
			die($msg);
		}
		
		$map = array(
			'customer_id' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ),
			'customer_first_name' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'customer_last_name' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ),  
			'customer_company' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'customer_address1' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'customer_address2' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'customer_city' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'customer_state' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'customer_postal_code' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ),  
			'customer_country' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			
			'customer_phone' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER ), 
			'customer_email' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER ), 
			'customer_ip' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, ), 
			'shipping_first_name' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_last_name' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ),
			'shipping_company' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ),  
			'shipping_address1' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_address2' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_city' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_state' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_postal_code' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_country' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER, QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_phone' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER ), 
			'shipto_shipping_service_description' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ),
			
			'id' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'transaction_date' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'purchase_order' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			
			'cc_number_masked' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'cc_type' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'cc_exp_month' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'cc_exp_year' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			
			'product_total' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'tax_total' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'shipping_total' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'order_total' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'processor_response' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ), 
			'payment_gateway_type' => array( QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION ),
			);
		
		$primaries = array(
			QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER => 'customer_id', 
			QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION => 'id', 
			);
		
		$foxyusers = array(
			QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER => 'foxycart_customer_user', 
			QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION => 'foxycart_transaction_user', 			
			);
		
		// Parse the XML
		$errnum = null;
		$errmsg = null;
		$Parser = new QuickBooks_XML_Parser($xml);
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			//print_r($Doc);
			//exit;
			
			$Root = $Doc->getRoot();
			
			// Log what we're doing
			$this->_foxycartLog('Incoming Foxycart data feed!', $FOXYCART_USER, $FOXYCART_FEED);
			
			// Log the datafeed
			$record = array(
				'foxydata' => $xml, 
				'datafeed_version' => $Root->getChildDataAt('foxydata datafeed_version'), 
				'foxycart_datafeed_datetime' => $FOXYCART_FEED, 
				'foxycart_datafeed_user' => $FOXYCART_USER
				);
			$Integrator->insert(QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_DATAFEED, $record, false);
			
			// Loop through all of the transactions
			$Transactions = $Root->getChildAt('foxydata transactions');
			
			foreach ($Transactions->children() as $Transaction)
			{
				// Foxycart sends us *all* unfed transactions (i.e. the last 3 years worth if we've never used the data feed)
				//	when we first activate it. Rather than send over 13 bajillion orders which are probably already in QuickBooks, 
				//	we skip anything that's way older than the date the user signed up
				
				// Get the transaction date
				$trans_id = $Transaction->getChildDataAt('transaction id');
				$trans_date = $Transaction->getChildDataAt('transaction transaction_date');
				
				if (!$trans_id or !$trans_date)
				{
					$msg = 'Transaction in feed [' . $FOXYCART_FEED . '] was skipped due to a missing transaction id or transaction date...?';
					$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);					
					continue;
				} 
				else if (strtotime($trans_date) < strtotime($FOXYCART_ENABLED) - (60 * 60 * 3))		// Just a little bit of look-back...
				{
					$msg = 'Transaction [' . $trans_id . '] was skipped; transaction date transaction:' . $trans_date . ' < enabled:' . $FOXYCART_ENABLED;
					$this->_foxycartLog($msg, $FOXYCART_USER, $FOXYCART_FEED);
					continue;
				}			
				
				$tables = array(
					QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER => array(), 
					QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION => array(), 
					);
				
				// Go through all the fields, stuffing the fields into arrays
				foreach ($Transaction->children() as $Data)
				{
					$name = $Data->name();
					if (isset($map[$name]))
					{
						foreach ($map[$name] as $table)
						{
							$tables[$table][$name] = $Data->data();
						}
						
						
					}
				}
				
				// Check for the lack of a shipping address in the main data 
				//	and the present of a shipping address inside the 'shipto_addresses' node
				if (empty($tables[QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION]['shipping_address1']) and 
					strlen($Transaction->getChildDataAt('transaction shipto_addresses shipto_address address_id')) > 0)
				{
					// This happens for MULTI-SHIP shipments, but we can only support a single address in QuickBooks
					$ShipTo = $Transaction->getChildAt('transaction shipto_addresses shipto_address');
					
					$shipto_map = array(
						'shipto_first_name' => 'shipping_first_name', 
						'shipto_last_name' => 'shipping_last_name', 
						'shipto_company' => 'shipping_company', 
						'shipto_address1' => 'shipping_address1', 
						'shipto_address2' => 'shipping_address2', 
						'shipto_city' => 'shipping_city', 
						'shipto_state' => 'shipping_state', 
						'shipto_postal_code' => 'shipping_postal_code', 
						'shipto_country' => 'shipping_country', 
						);
					
					$do = array(
						QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER => empty($tables[QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER]['']), 
						QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION => empty($tables[QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION]['']), 
						);
					
					$tmp = array();
					foreach ($ShipTo->children() as $AddressBit)
					{
						$key = $AddressBit->name();
						if (isset($shipto_map[$key]))
						{
							// DO EACH OF THESE TABLES
							
						}
					}
				}
				
				print_r($tables);
				exit;
				
				// Parenting is disabled... 
				$fix_parentings = array(
					'customer_first_name', 
					'customer_last_name', 
					'customer_company', 
					);
				
				foreach ($fix_parentings as $fix_parenting)
				{
					if (isset($tables[QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER][$fix_parenting]))
					{
						$tables[QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER][$fix_parenting] = str_replace(':', '-', $tables[QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER][$fix_parenting]);
					}
				}
				
				// Each $table is an array record with a bunch of table data in it
				foreach ($tables as $table => $data)
				{
					$key = $primaries[$table];
					$foxyuser = $foxyusers[$table];
					
					if ($record = $Integrator->get($table, array( $key => $tables[$table][$key], $foxyuser => $FOXYCART_USER )))
					{
						// Update
						//print('update');
						//exit;
						
						switch ($table)
						{
							case QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER:
								
								// Log what we're doing
								$this->_foxycartLog('EXISTING customer found: ' . $data['customer_id'], $FOXYCART_USER, $FOXYCART_FEED);
								
								
								
								break;
							case QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION:
								
								break;
						}
						
					}
					else
					{
						// Insert the data into the storage tables
						//print_r($data);
						//exit;
						
						switch ($table)
						{
							case QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_CUSTOMER:
								
								// Log what we're doing
								$this->_foxycartLog('NEW customer found: ' . $data['customer_id'], $FOXYCART_USER, $FOXYCART_FEED);
								
								$data['foxycart_customer_discovered_datetime'] = $FOXYCART_NOW;
								$data['foxycart_customer_discovered_datafeed'] = $FOXYCART_FEED;
								$data['foxycart_customer_user'] = $FOXYCART_USER;
								
								// Call a hook to indicate a new customer has been found
								$hook_data = array(
									'customer' => $data, 
									);
								
								$err = null;
								$this->_callHooks(
									QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTCUSTOMER, 
									null, 
									$FOXYCART_USER, 
									null, 
									$err, 
									$hook_data);
								
								break;
							case QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTION:
								
								// Log what we're doing
								$this->_foxycartLog('NEW order found: ' . $data['id'], $FOXYCART_USER, $FOXYCART_FEED);
								
								$data['foxycart_transaction_discovered_datetime'] = $FOXYCART_NOW;
								$data['foxycart_transaction_discovered_datafeed'] = $FOXYCART_FEED;
								$data['foxycart_transaction_user'] = $FOXYCART_USER;
								
								// We need to set this flag so that we can call the order hook later
								$hook_data = array(
									'order' => $data, 
									);
								
								$err = null;
								$this->_callHooks(
									QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTORDER, 
									null, 
									$FOXYCART_USER, 
									null, 
									$err, 
									$hook_data);
									
								break;
						}
						
						$Integrator->insert($table, $data, false);
					}
				}
				
				// Delete any current line items (and line item options)
				$errnum = 0;
				$errmsg = '';
				$res = $Integrator->query("
					SELECT 
						_id
					FROM 
						" . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDETAIL . " 
					WHERE
						transaction_id = " . (int) $Transaction->getChildDataAt('transaction id') . " AND
						foxycart_transaction_detail_user = '" . $Integrator->escape($FOXYCART_USER) . "' ", $errnum, $errmsg);
				
				while ($arr = $Integrator->fetch($res))
				{
					// Delete the options
					$Integrator->query("DELETE FROM " . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDETAILOPTION . " WHERE transaction_detail__id = " . $arr['_id'], $errnum, $errmsg);
					
					// Delete the detail item
					$Integrator->query("DELETE FROM " . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDETAIL . " WHERE _id = " . $arr['_id'], $errnum, $errmsg);
				}
				
				// Also delete any custom fields...
				$errnum = 0;
				$errmsg = '';
				$Integrator->query("
					DELETE FROM
						" . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONCUSTOMFIELD . "
					WHERE
						transaction_id = " . (int) $Transaction->getChildDataAt('transaction id') . " AND 
						foxycart_transaction_customfield_user = '" . $Integrator->escape($FOXYCART_USER) . "' ", $errnum, $errmsg);
				
				// And delete any discounts
				$errnum = 0;
				$errmsg = '';
				$Integrator->query("
					DELETE FROM
						" . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDISCOUNT . "
					WHERE
						transaction_id = " . (int) $Transaction->getChildDataAt('transaction id') . " AND 
						foxycart_transaction_discount_user = '" . $Integrator->escape($FOXYCART_USER) . "' ", $errnum, $errmsg);				
				
				// Now, process the transaction line details
				foreach ($Transaction->children() as $Node)
				{
					if ($Node->name() == 'discounts')
					{
						foreach ($Node->children() as $Discount)
						{
							/*
							<discount>
								<code>MM</code>
								<name>McMahon Medical</name>
								<amount>-149.99</amount>
								<display>-149.99</display>
								<coupon_discount_type>price_amount</coupon_discount_type>
								<coupon_discount_details>149.99-149.99, 99-0</coupon_discount_details>
							</discount>
							*/
							
							$discount = array(
								'transaction_id' => $Transaction->getChildDataAt('transaction id'), 
								'discount_code' => $Discount->getChildDataAt('discount code'), 
								'discount_name' => $Discount->getChildDataAt('discount name'), 
								'discount_amount' => (float) $Discount->getChildDataAt('discount amount'), 
								'discount_display' => $Discount->getChildDataAt('discount display'), 
								'discount_coupon_discount_type' => $Discount->getChildDataAt('discount coupon_discount_type'), 
								'discount_coupon_discount_details' => $Discount->getChildDataAt('discount coupon_discount_details'), 
								'foxycart_transaction_discount_user' => $FOXYCART_USER, 
								);
							
							//print_r($details);
							$Integrator->insert(QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDISCOUNT, $discount, false);
							$_id = $Integrator->last();
						}
					}
					else if ($Node->name() == 'custom_fields')
					{
						foreach ($Node->children() as $CustomField)
						{
							/*
							<custom_field>
								<custom_field_name>Comments</custom_field_name>
								<custom_field_value>JO145</custom_field_value>
							</custom_field>
							*/
							
							$customfield = array(
								'transaction_id' => $Transaction->getChildDataAt('transaction id'), 
								'customfield_custom_field_name' => $CustomField->getChildDataAt('custom_field custom_field_name'), 
								'customfield_custom_field_value' => $CustomField->getChildDataAt('custom_field custom_field_value'), 
								'foxycart_transaction_customfield_user' => $FOXYCART_USER, 
								);
							
							//print_r($details);
							$Integrator->insert(QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONCUSTOMFIELD, $customfield, false);
							$_id = $Integrator->last();
						}						
					}
					else if ($Node->name() == 'transaction_details')
					{
						foreach ($Node->children() as $TransactionDetail)
						{
							$product_name = $TransactionDetail->getChildDataAt('transaction_detail product_name');
							
							// If parenting is disabled, remove any : because these cause FullName/Parent references
							if (!$this->_foxycartConfig('foxycart_user_item_parenting'))
							{
								$product_name = str_replace(':', '-', $product_name);
							}
							
							// If we're sending them to QuickBooks with a format of {$_code}, then we need to allow multiple
							//	products that have the same {$_name}, but NOT the same {$_code}
							$and_code = '';
							$product_code = $TransactionDetail->getChildDataAt('transaction_detail product_code');
							if ($product_code)
							{
								$and_code = " _code = '" . $Integrator->escape($product_code) . "' AND ";
							}
							
							// Let's see if we've already seen this type of product before... 
							$errnum = 0;
							$errmsg = '';
							$res_product = $Integrator->query("
								SELECT 
									_id 
								FROM 
									" . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_PRODUCT . " 
								WHERE 
									_name = '" . $Integrator->escape($product_name) . "' AND 
									" . $and_code . "
									foxycart_product_user = '" . $Integrator->escape($FOXYCART_USER) . "' ", $errnum, $errmsg);
							  
							if ($arr_product = $Integrator->fetch($res_product))
							{
								// Do an UPDATE if the code is different

								$tmp = array(
									'_name' => $product_name, 
									);
								
								// Log what we're doing
								$this->_foxycartLog('EXISTING product found: ' . $tmp['_name'], $FOXYCART_USER, $FOXYCART_FEED);
								
								// @TODO call the hook for the product update
								
								// Update the product
								$tmp = array(
									'_price' => (float) $TransactionDetail->getChildDataAt('transaction_detail product_price'), 
									'_weight' => (float) $TransactionDetail->getChildDataAt('transaction_detail product_weight'), 
									'_code' => $TransactionDetail->getChildDataAt('transaction_detail product_code'), 
									'_category_code' => $TransactionDetail->getChildDataAt('transaction_detail category_code'), 
									'_category_description' => $TransactionDetail->getChildDataAt('transaction_detail category_description'), 
									'foxycart_product_refreshed_datetime' => $FOXYCART_NOW,
									'foxycart_product_refreshed_datafeed' => $FOXYCART_FEED,
									);
								
								$where = array(
									array( '_id' => $arr_product['_id'] ),
									);
								
								// Update the record
								$Integrator->update(QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_PRODUCT, $tmp, $where, false, false, false);
								
								$product_id = $arr_product['_id'];
							}
							else
							{
								// Product doesn't exist yet, create it
								
								// @TODO Categories should be an entirely separate table, not a free-form field here
								$tmp = array(
									'_name' => $product_name, 
									'_price' => (float) $TransactionDetail->getChildDataAt('transaction_detail product_price'), 
									'_weight' => (float) $TransactionDetail->getChildDataAt('transaction_detail product_weight'), 
									'_code' => $TransactionDetail->getChildDataAt('transaction_detail product_code'), 
									'_category_code' => $TransactionDetail->getChildDataAt('transaction_detail category_code'), 
									'_category_description' => $TransactionDetail->getChildDataAt('transaction_detail category_description'), 
									'foxycart_product_discovered_datetime' => $FOXYCART_NOW,
									'foxycart_product_discovered_datafeed' => $FOXYCART_FEED,
									'foxycart_product_user' => $FOXYCART_USER, 
									);
									
								// Log what we're doing
								$this->_foxycartLog('NEW product found: ' . $tmp['_name'], $FOXYCART_USER, $FOXYCART_FEED);
								
								// Insert the product record
								$Integrator->insert(QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_PRODUCT, $tmp, false);
								$product_id = $Integrator->last();

								// Call the hook to indicate we're adding a product
								$hook_data = array(
									'product' => $tmp, 
									);
								
								$err = null;
								$this->_callHooks(
									QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTPRODUCT, 
									null, 
									$FOXYCART_USER, 
									null, 
									$err, 
									$hook_data);
							}
							
							$details = array(
								'transaction_id' => $Transaction->getChildDataAt('transaction id'), 
								'product__id' => $product_id, 
								'product_name' => $product_name, 
								'product_price' => $TransactionDetail->getChildDataAt('transaction_detail product_price'), 
								'product_quantity' => $TransactionDetail->getChildDataAt('transaction_detail product_quantity'), 
								'product_weight' => $TransactionDetail->getChildDataAt('transaction_detail product_weight'), 
								'product_code' => $TransactionDetail->getChildDataAt('transaction_detail product_code'), 
								'downloadable_url' => $TransactionDetail->getChildDataAt('transaction_detail downloadable_url'), 
								'subscription_frequency' => $TransactionDetail->getChildDataAt('transaction_detail subscription_frequency'), 
								'subscription_startdate' => $TransactionDetail->getChildDataAt('transaction_detail subscription_startdate'), 
								'product_delivery_type' => $TransactionDetail->getChildDataAt('transaction_detail product_delivery_type'), 
								'category_code' => $TransactionDetail->getChildDataAt('transaction_detail category_code'), 
								'category_description' => $TransactionDetail->getChildDataAt('transaction_detail category_description'), 
								'foxycart_transaction_detail_user' => $FOXYCART_USER, 
								);
							
							// Call the hook to indicate we're adding a new line item
							$hook_data = array(
								'orderline' => $details, 
								);
							
							$err = null;
							$this->_callHooks(
								QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_HOOK_INSERTORDERLINE, 
								null, 
								$FOXYCART_USER, 
								null, 
								$err, 
								$hook_data);
								
							//print_r($details);
							$Integrator->insert(QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDETAIL, $details, false);
							$_id = $Integrator->last();
							
							// Now, handle the options for each line item
							foreach ($TransactionDetail->children() as $Node2)
							{
								if ($Node2->name() == 'transaction_detail_options')
								{
									foreach ($Node2->children() as $TransactionDetailOption)
									{
										$details = array(
											'transaction_detail__id' => $_id, 
											'product_option_name' => $TransactionDetailOption->getChildDataAt('transaction_detail_option product_option_name'), 
											'product_option_value' => $TransactionDetailOption->getChildDataAt('transaction_detail_option product_option_value'),  
											'price_mod' => $TransactionDetailOption->getChildDataAt('transaction_detail_option price_mod'),  
											'weight_mod' => $TransactionDetailOption->getChildDataAt('transaction_detail_option weight_mod'),  
											);
										
										$Integrator->insert(QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_TRANSACTIONDETAILOPTION, $details, false);							
									}
								}
							}
						}
					}
				}
			}
		}
		
		// If this server is configured to relay data to another server, do the 
		//	relaying here.
		$res = $Integrator->query("SELECT foxycart_user_relay FROM " . QUICKBOOKS_SERVER_INTEGRATOR_FOXYCART_TABLE_USER . " WHERE foxycart_user_name = '" . $Integrator->escape($FOXYCART_USER) . "' ", $errnum, $errmsg);
		$arr = $Integrator->fetch($res);
						
		if (!empty($arr['foxycart_user_relay']))
		{
			// @todo Can we support something other than HTTP/HTTPS here (SMTP?)? Is there a need for it?
			
			$this->_relayFoxycartData($FOXYCART_USER, $FOXYCART_FEED, $arr['foxycart_user_relay'], $_POST);
		}
		
		// 
		if ($die)
		{
			die('foxy');
		}
		else
		{
			print('foxy');
		}
	}
	
	/**
	 * Relay Foxycart HTTP POST data to another URL
	 * 
	 * @param string $FOXYCART_USER
	 * @param string $FOXYCART_FEED
	 * @param string $relay_to
	 * @param array $http_post_values
	 * @return boolean
	 */
	protected function _relayFoxycartData($FOXYCART_USER, $FOXYCART_FEED, $relay_to, $http_post_values)
	{
		$HTTP = new QuickBooks_HTTP($relay_to);
		$HTTP->setPOSTValues($http_post_values);
		
		// Log what we're doing...
		$message = 'Relay: Relaying FoxyData to URL: ' . $relay_to;
		$this->_foxycartLog($message, $FOXYCART_USER, $FOXYCART_FEED);
		
		// Enable debug mode?
		//$debug_mode = true;
		//$HTTP->useDebugMode($debug_mode);
		
		// Send the data
		$HTTP->POST();
		
		// Get some diagnostic information
		$request = $HTTP->lastRequest();
		$response = $HTTP->lastResponse();
		
		$message = 'Relay: Received response: ' . $response;
		$this->_foxycartLog($message, $FOXYCART_USER, $FOXYCART_FEED);
		
		return true;
	}
}
