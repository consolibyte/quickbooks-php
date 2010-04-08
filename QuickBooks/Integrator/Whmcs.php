<?php

/**
 * QuickBooks WHMCS Integrator
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Integrator
 */

/** 
 * QuickBooks Integrator base class
 */
QuickBooks_Loader::load('/QuickBooks/Integrator.php');

/**
 *
 * 
 */
class QuickBooks_Integrator_Whmcs extends QuickBooks_Integrator
{		
	/**
	 *
	 * @var string
	 */
	protected $_whmcs_user;
	
	/**
	 *
	 * @var string
	 */
	protected $_whmcs_pass;
	
	/**
	 * 
	 * 
	 * @param string $str
	 * @return string
	 */
	protected function _wrapAndEscape($str)
	{
		return $str;
	}
	
	/** 
	 * Configuration defaults for Interspire
	 * 
	 * @param array $config
	 * @return array
	 */
	protected function _defaults($config)
	{
		$defaults = parent::_defaults($config);
		
		$config = array_merge($defaults, $config);
		
		foreach ($defaults as $key => $value)
		{
			if (is_array($value) and !is_array($config[$key]))
			{
				$config[$key] = array( $config[$key] ); 
			}
		}
		
		return $config;
	}
		
	/**
	 * 
	 * 
	 * @return string
	 */
	public function _defaultGetCustomerQuery()
	{
		return '';
	}

	/**
	 * Get a list of orders that are new since a specific date 
	 * 
	 * @return string
	 */
	protected function _defaultListNewOrdersSinceQuery()
	{
		return '';
	}
		
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	protected function _getCustomerExtras($CustomerID, $from = null, $line = null)
	{
		return array();
	}
	
	protected function _setCustomer($CustomerID, $Customer)
	{
		return false;
	}
	
	protected function _setEstimate($EstimateID, $Estimate, $from = null, $line = null)
	{
		return false;
	}
	
	/**
	 * Get a customer by ID value
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_Customer
	 */
	protected function _getCustomer($CustomerID, $from = null, $line = null)
	{
		// Fetch data from SOAP magento call
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = null;
		$res = $Driver->query("
			SELECT
				client_id AS CustomerID, 
				client_firstname AS FirstName, 
				client_lastname AS LastName, 
				client_companyname AS CompanyName, 
				client_companyname AS BillAddress_Addr1, 
				client_address1 AS BillAddress_Addr2, 
				client_address2 AS BillAddress_Addr3, 
				client_city AS BillAddress_City, 
				client_state AS BillAddress_State, 
				client_postcode AS BillAddress_PostalCode, 
				client_countryname AS BillAddress_Country
			FROM
				qb_whmcs_client
			WHERE
				client_id = " . (int) $CustomerID . " AND 
				whmcs_client_user = '" . $Driver->escape($this->_api->user()) . "' ", $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			$format = $this->_whmcsConfig('whmcs_user_customer_format');
			if (!$format)
			{
				$format = '$FirstName $LastName';
			}
			
			$arr['Name'] = $this->_applyFormat($format, $arr);
			
			// Sometimes WebAsyst sends us blank shipping information, in which 
			//	case we want to default it to using the billing information as 
			//	the ship to address
			if (empty($arr['ShipAddress_Addr1']) and 
				empty($arr['ShipAddress_City']))
			{
				// Fill the shipping address info from the billing address info
				$arr['ShipAddress_Addr1'] = $arr['BillAddress_Addr1'];
				$arr['ShipAddress_Addr2'] = $arr['BillAddress_Addr2'];
				$arr['ShipAddress_Addr3'] = $arr['BillAddress_Addr3'];
				$arr['ShipAddress_City'] = $arr['BillAddress_City'];
				$arr['ShipAddress_State'] = $arr['BillAddress_State'];
				$arr['ShipAddress_PostalCode'] = $arr['BillAddress_PostalCode'];
				$arr['ShipAddress_Country'] = $arr['BillAddress_Country'];
			}
			else if (empty($arr['BillAddress_Addr1']) and 
				empty($arr['BillAddress_City']))
			{
				// Fill the billing address info from the shipping address info
				$arr['BillAddress_Addr1'] = $arr['ShipAddress_Addr1'];
				$arr['BillAddress_Addr2'] = $arr['ShipAddress_Addr2'];
				$arr['BillAddress_Addr3'] = $arr['ShipAddress_Addr3'];
				$arr['BillAddress_City'] = $arr['ShipAddress_City'];
				$arr['BillAddress_State'] = $arr['ShipAddress_State'];
				$arr['BillAddress_PostalCode'] = $arr['ShipAddress_PostalCode'];
				$arr['BillAddress_Country'] = $arr['ShipAddress_Country'];				
			}
			
			return $this->_customerFromArray($arr);
		}
		
		return null;
	}
	
	/**
	 * Run a bunch of additional queries, and merge them with the existing result set
	 * 
	 * @param array $queries		An array of queries to run and merge together
	 * @param array $arr			The already existing result set
	 * @param array $vars			An array of variables for use in the queries
	 * @return array
	 */
	protected function _additionalQueries($queries, $arr, $vars)
	{
		return array();
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function _listNewCustomersSince($datetime)
	{
		return array();
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected function _listModifiedCustomersSince($datetime)
	{
		return array();
	}
	
	/** 
	 * Get a list of order IDs which have been created since a given date/time
	 * 
	 * @param string $datetime
	 * @return array
	 */
	protected function _listNewOrdersSince($datetime)
	{
		$list = array();
		
		// 
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT
				invoice_id 
			FROM
				qb_whmcs_invoice
			WHERE
				whmcs_invoice_discovered_datetime >= '" . $Driver->escape($datetime) . "' ", $errnum, $errmsg);
		
		while ($arr = $Driver->fetch($res))
		{
			// Add it to the list
			$list[] = $arr['invoice_id'];
			
			// Mark it as picked up
			$errnum = 0;
			$errmsg = '';
			$Driver->query("UPDATE qb_whmcs_invoice SET whmcs_invoice_pickup_datetime = '" . $Driver->escape(date('Y-m-d H:i:s')) . "' WHERE invoice_id = " . $arr['invoice_id'], $errnum, $errmsg);
		}
		
		return $list;
	}
	
	/**
	 * 
	 * 
	 * @param string $datetime
	 * @return array 
	 */
	protected function _listModifiedOrdersSince($datetime)
	{
		return array();
	}
	
	/**
	 * Get an order by ID value (returns a QuickBooks_Object_Invoice, QuickBooks_Object_SalesOrder, or QuickBooks_Object_SalesReceipt)
	 * 
	 * This function can return one of these types of objects:
	 * 	- QuickBooks_Object_Invoice
	 * 	- QuickBooks_Object_SalesOrder
	 * 	- QuickBooks_Object_SalesReceipt
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_*
	 */
	protected function _getOrder($OrderID)
	{
		// Database driver
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT
				invoice_id AS RefNumber, 
				invoice_invoiceid, 
				invoice_invoicenum, 
				qb_whmcs_invoice.client_id AS CustomerID, 
				invoice_date AS TxnDate, 
				invoice_duedate AS DueDate, 
				(invoice_tax + invoice_tax2) AS SalesTaxLineAmount, 
				invoice_notes AS Notes, 
				'' AS ShipAddress_Addr1, 
				'' AS ShipAddress_Addr2, 
				'' AS ShipAddress_Addr3, 
				'' AS ShipAddress_City, 
				'' AS ShipAddress_State, 
				'' AS ShipAddress_PostalCode, 
				'' AS ShipAddress_Country, 
				CASE 
					WHEN LENGTH(client_companyname) > 0 THEN client_companyname
					ELSE CONCAT(client_firstname, ' ', client_lastname)
				END AS BillAddress_Addr1, 
				client_address1 AS BillAddress_Addr2, 
				client_address2 AS BillAddress_Addr3, 
				client_city AS BillAddress_City, 
				client_state AS BillAddress_State, 
				client_postcode AS BillAddress_PostalCode, 
				client_countryname AS BillAddress_Country				
			FROM 
				qb_whmcs_invoice
			LEFT JOIN
				qb_whmcs_client ON 
					qb_whmcs_client.client_id = qb_whmcs_invoice.client_id AND 
					qb_whmcs_client.whmcs_client_user = '" . $Driver->escape($this->_api->user()) . "' 
			WHERE
				invoice_id = " . (int) $OrderID . " AND 
				whmcs_invoice_user = '" . $Driver->escape($this->_api->user()) . "' ", $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			// Sometimes FoxyCart sends us blank shipping information, in which 
			//	case we want to default it to using the billing information as 
			//	the ship to address
			if (!$arr['ShipAddress_Addr1'] and 
				!$arr['ShipAddress_City'] and 
				!empty($arr['BillAddress_Addr1']) and 
				!empty($arr['BillAddress_City']))
			{
				// Fill the shipping address info from the billing address info
				$arr['ShipAddress_Addr1'] = $arr['BillAddress_Addr1'];
				$arr['ShipAddress_Addr2'] = $arr['BillAddress_Addr2'];
				$arr['ShipAddress_Addr3'] = $arr['BillAddress_Addr3'];
				$arr['ShipAddress_City'] = $arr['BillAddress_City'];
				$arr['ShipAddress_State'] = $arr['BillAddress_State'];
				$arr['ShipAddress_PostalCode'] = $arr['BillAddress_PostalCode'];
				$arr['ShipAddress_Country'] = $arr['BillAddress_Country'];
			}
			
			// Fetch the order items
			$items = $this->_getOrderItems($OrderID);
			
			// Create the shipping line item
			$shipping = null;
			
			// Handling charge
			$handling = null;
			
			// Get a list of discounts for this order
			$discount = null;

			$format = $this->_whmcsConfig('whmcs_user_invoice_memo_format');
			if ($format)
			{
				$arr['Memo'] = $this->_applyFormat($format, $arr);
			}
			
			$format = $this->_whmcsConfig('whmcs_user_invoice_refnumber_format');
			if ($format)
			{
				$arr['RefNumber'] = $this->_applyFormat($format, $arr);
			}
			
			// Auto-incrementing RefNumbers
			$autoincrement = $this->_whmcsConfig('whmcs_user_invoice_autoincrement');
			if ($autoincrement)
			{
				unset($arr['RefNumber']);
			}
			
			// Class support
			$format = $this->_whmcsConfig('whmcs_user_invoice_class_format');
			if ($format)
			{
				$arr['ClassName'] = $this->_applyFormat($format, $arr);
			}
			
			$as = $this->_whmcsConfig('whmcs_user_invoice_as');
			if (!$as)
			{
				$as = QUICKBOOKS_OBJECT_INVOICE;
			}
			
			// Create the order
			return $this->_orderFromArray($arr, $items, $shipping, $handling, $discount, $as);	
		}
		
		return null;
	}
	
	protected function _getPayment($ID)
	{
		return null;
	}
	
	/**
	 * Get the order items for a given WHMCS order
	 * 
	 * @param integer $OrderID
	 * @return array
	 */
	protected function _getOrderItems($OrderID)
	{
		
		// 
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT
				CASE 
					WHEN LENGTH(item_type) > 0 THEN CONCAT('WHMCS-QB ', item_type)
					ELSE 'WHMCS-QB Billable Item' 
				END AS ProductID, 
				item_description AS Descrip, 
				item_amount AS Rate, 
				1 AS Quantity
			FROM
				qb_whmcs_invoice_item
			WHERE
				invoice_id = " . (int) $OrderID, $errnum, $errmsg);
		
		// ... and turn those details into order line items
		while ($arr = $Driver->fetch($res))
		{
			$item = $this->_orderItemFromArray($arr);
			
			if ($item)
			{
				$items[] = $item;
			}
		}
		
		return $items;
	}
	
	/** 
	 * 
	 * 
	 */
	protected function _defaultGetOrderQuery()
	{
		return null;		
	}
	
	protected function _defaultGetOrderItemsForOrderQuery()
	{
		return '';
	}
	
	/**
	 * Get a list of items for an order (Invoice, SalesReceipt, SalesOrder)
	 * 
	 * @param integer $OrderID
	 * @return array 
	 */
	protected function _getOrderItemsForOrder($OrderID)
	{
		return array();
	}

	protected function _getEstimateItemsForEstimate($EstimateID)
	{
		return false;
	}

	/** 
	 * Get a list of order IDs which have been created since a given date/time
	 * 
	 * @param string $datetime
	 * @return array
	 */
	protected function _listNewEstimatesSince($datetime)
	{
		return array();
	}
		
	/**
	 * 
	 * 
	 * @param string $datetime
	 * @return array 
	 */
	protected function _listModifiedEstimatesSince($datetime)
	{
		return $this->_listNewEstimatesSince($datetime);
	}
	
	/**
	 *
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_Estimate
	 */
	protected function _getEstimate($EstimateID)
	{
		return false;
	}
	
	/** 
	 * 
	 * 
	 */
	protected function _defaultGetEstimateQuery()
	{
		return null;		
	}
	
	protected function _defaultGetEstimateItemsForEstimateQuery()
	{
		return '';
	}
		
	/**
	 * Get a ship method object by ID
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_ShipMethod
	 */
	protected function _getShipMethod($ID)
	{
		return null;
	}
	
	protected function _defaultGetShipMethodQuery()
	{
		return null;
	}
	
	/**
	 * Get a payment method by ID value
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_PaymentMethod
	 */
	protected function _getPaymentMethod($ID)
	{
		return null;
	}
	
	/**
	 * Get a payment by Order ID
	 * 
	 * @param integer $OrderID
	 * @return QuickBooks_Object_ReceivePayment
	 */
	protected function _getPaymentForOrder($OrderID)
	{
		return null;
	}
	
	/** 
	 * 
	 * 
	 * @return 
	 */
	protected function _defaultGetPaymentForOrderQuery()
	{
		return null;
	}
	
	/**
	 * Get the order discount (if any)
	 * 
	 * @param integer $OrderID
	 * @return QuickBooks_Object_DiscountItem
	 */
	protected function _getDiscountForOrder($OrderID)
	{
		return null;
	}
	
	/**
	 * Get the coupon for this order (if any)
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_DiscountItem
	 */
	protected function _getCoupon($ID)
	{
		return null;
	}
	
	/** 
	 * Get a sales tax item by ID
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_SalesTaxItem
	 */
	protected function _getSalesTax($ID)
	{
		return null;
	}
	
	/**
	 * Get a shipping item for an order
	 * 
	 * @param integer $OrderID
	 * @return QuickBooks_Object_OtherChargeItem
	 */
	protected function _getShippingForOrder($OrderID)
	{
		return null;
	}
	
	/**
	 * 
	 * 
	 */
	protected function _getHandlingForOrder($OrderID)
	{
		return null;
	}
	
	protected function _defaultGetShippingForOrderQuery()
	{
		return null;
	}

	protected function _defaultGetHandlingForOrderQuery()
	{
		return null;
	}
	
	/**
	 * Get a product by ID number
	 * 
	 * This method can return any of the following types of objects:
	 * 	- QuickBooks_Object_ServiceItem
	 * 	- QuickBooks_Object_InventoryItem
	 * 	- QuickBooks_Object_NonInventoryItem
	 * 	- QuickBooks_Object_OtherChargeItem
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_*
	 */
	protected function _getProduct($ProductID, $from = null, $line = null)
	{
		$Driver = $this->_driver;
		
		$arr = array(
			'Name' => $ProductID, 
			'FullName' => $ProductID, 
			'Desc' => $ProductID, 
			);
			
		if ($arr)
		{
			$income_account = $this->_whmcsConfig('whmcs_user_item_account_income');
			if ($income_account)
			{
				// .... which one is it? 
				$arr['IncomeAccountName'] = $income_account;
				$arr['SalesOrPurchase_AccountName'] = $income_account;
				$arr['SalesAndPurchase_IncomeAccountName'] = $income_account;
			}
			
			return $this->_productFromArray($arr);
		}
		
		return null;
	}
		
	protected function _defaultGetGiftCertificateQuery()
	{
		return null;		
	}
	
	protected function _defaultGetProductQuery()
	{
		return null;
	}
	
	/**
	 * Get a generic shipping method 
	 * 
	 * @return QuickBooks_Object_*
	 */
	protected function _getGenericShipping()
	{
		$arr = array(
			'ProductID' => QUICKBOOKS_INTEGRATOR_SHIPPING_ID,
			'Name' => QUICKBOOKS_INTEGRATOR_SHIPPING_NAME,
			'SalesTaxCodeName' => QUICKBOOKS_NONTAXABLE,   
			'SalesOrPurchase_Desc' => QUICKBOOKS_INTEGRATOR_SHIPPING_NAME, 
			'SalesOrPurchase_Price' => 0.0, 
			'SalesOrPurchase_AccountName' => QUICKBOOKS_INTEGRATOR_NULL, 		// Pass special flag, will not overwrite defaults 
			);
		
		$income_account = $this->_whmcsConfig('whmcs_user_item_account_income');
		if ($income_account)
		{
			$arr['SalesOrPurchase_AccountName'] = $income_account;
		}
		
		$Item = $this->_productFromArray($arr, $this->_config['push_shipping_as']);
		
		return $Item;
	}
	
	/** 
	 * Get a generic discount item
	 * 
	 * @return QuickBooks_Object_*
	 */
	protected function _getGenericDiscount()
	{
		$arr = array(
			'ProductID' => QUICKBOOKS_INTEGRATOR_DISCOUNT_ID,
			'Name' => QUICKBOOKS_INTEGRATOR_DISCOUNT_NAME,
			'SalesTaxCodeName' => QUICKBOOKS_NONTAXABLE,   
			'SalesOrPurchase_Desc' => QUICKBOOKS_INTEGRATOR_DISCOUNT_NAME, 
			'SalesOrPurchase_Price' => 0.0, 
			'SalesOrPurchase_AccountName' => QUICKBOOKS_INTEGRATOR_NULL, 		// Pass special flag, will not overwrite defaults 
			);
		
		$discount_account = $this->_whmcsConfig('whmcs_user_item_account_discount');
		if ($discount_account)
		{
			$arr['SalesOrPurchase_AccountName'] = $discount_account;
		}
		
		$Item = $this->_productFromArray($arr, $this->_config['push_shipping_as']);
		
		return $Item;
	}
	
	/**
	 * Run an SQL query against the SQL database
	 * 
	 * @param string $sql
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return resource
	 */
	public function query($sql, $errnum, $errmsg)
	{
		return $this->_driver->query($sql, $errnum, $errmsg);
	}
	
	/**
	 * Escape a string to go to the database
	 * 
	 * @param string $str
	 * @return string
	 */
	public function escape($str)
	{
		return $this->_driver->escape($str);
	}
	
	public function fetch($res)
	{
		return $this->_driver->fetch($res);
	}
	
	public function insert($table, $record, $resync = true)
	{
		return $this->_driver->insert($table, $record, $resync);
	}
	
	public function update($table, $record, $where, $resync = true)
	{
		return $this->_driver->update($table, $record, $where, $resync);
	}
	
	public function get($table, $where)
	{
		return $this->_driver->get($table, $where);
	}
	
	public function last()
	{
		return $this->_driver->last();
	}

	/**
	 * Get configuration data for the WHMCS user
	 * 
	 * @param string $key		The configuration key to read
	 * @param mixed $set
	 * @return mixed	
	 */
	protected function _whmcsConfig($key, $set = null)
	{
		$API = $this->_api;
		
		static $cache = null;
		
		// Get the username... 
		$user = $API->user();

		// Get the SQL driver
		$Database = $this->_integrator;
		
		// Set the value...
		if ($set)
		{
			$sql = "
				UPDATE 
					qb_whmcs_user
				SET
					" . $key . " = '" . $set . "' 
				WHERE
					whmcs_user_name = '" . $Database->escape($user) . "' ";
			
			$errnum = null;
			$errmsg = null;
			$Database->query($sql, $errnum, $errmsg);
			
			$cache = null;
		}
		
		if (is_null($cache))
		{
			$errnum = null;
			$errmsg = null;
			$res = $Database->query("SELECT * FROM qb_whmcs_user WHERE whmcs_user_name = '" . $Database->escape($user) . "' ", $errnum, $errmsg);
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
}
