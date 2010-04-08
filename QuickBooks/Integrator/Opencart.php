<?php

/**
 * QuickBooks OpenCart Integrator
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
class QuickBooks_Integrator_Opencart extends QuickBooks_Integrator
{		
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
	
	public function query($sql, $errnum, $errmsg)
	{
		return $this->_driver->query($sql, $errnum, $errmsg);
	}
	
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
	 * Get a customer by ID value
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_Customer
	 */
	protected function _getCustomer($CustomerID, $from = null, $line = null)
	{
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = null;
		$res = $Driver->query("
			SELECT 
				customer.customer_id AS Customer_ID, 
				CONCAT(customer.firstname, ' ', customer.lastname) AS Name, 
				customer.firstname AS FirstName, 
				customer.lastname AS LastName, 
				email AS Email,
				telephone AS Phone,
				fax AS Fax,
				customer.address_id, 
				CONCAT(address.firstname, ' ', address.lastname) AS BillAddress_Addr1, 
				address_1 AS BillAddress_Addr2, 
				address_2 AS BillAddress_Addr3, 
				'' AS BillAddress_Addr4, 
				'' AS BillAddress_Addr5, 
				city AS BillAddress_City, 
				postcode AS BillAddress_PostalCode, 
				'' AS BillAddress_State, 
				'' AS BillAddress_Country,
				'' AS ShipAddress_Addr1, 
				'' AS ShipAddress_Addr2, 
				'' AS ShipAddress_Addr3, 
				'' AS ShipAddress_Addr4, 
				'' AS ShipAddress_Addr5, 
				'' AS ShipAddress_City,
				'' AS ShipAddress_State,
				'' AS ShipAddress_PostalCode,
				'' AS ShipAddress_Country
			FROM 
				customer 
			LEFT JOIN
				address ON address.address_id = customer.address_id
			WHERE 
				customer.customer_id = " . (int) $CustomerID, $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			$format = '$FirstName $LastName';
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
		$list = array();
		
		return $list;
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
		
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT 
				order_id 
			FROM 
				`order` 
			WHERE 
				date_added > '" . $datetime . "' ", $errnum, $errmsg);
		
		while ($arr = $Driver->fetch($res))
		{
			$list[] = $arr['order_id'];
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
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT 
				order_id AS RefNumber, 
				date_added AS TxnDate, 
				customer_id AS CustomerID, 
				CONCAT(shipping_firstname, ' ', shipping_lastname) AS ShipAddress_Addr1, 
				shipping_address_1 AS ShipAddress_Addr2,
				shipping_address_2 AS ShipAddress_Addr3, 
				shipping_city AS ShipAddress_City,  
				shipping_postcode AS ShipAddress_PostalCode, 
				shipping_country AS ShipAddress_Country,
				shipping_method AS ShipMethod_FullName, 
				CONCAT(payment_firstname, ' ', payment_lastname) AS BillAddress_Addr1, 
				payment_address_1 AS BillAddress_Addr2, 
				payment_address_2 AS BillAddress_Addr3, 
				payment_city AS BillAddress_City,
				payment_postcode AS BillAddress_PostalCode, 
				payment_country AS BillAddress_Country,
				payment_method AS PaymentMethod_FullName,
				total 
			FROM 
				`order` 
			WHERE 
				order_id = " . (int) $OrderID . " ", $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			// Sometimes WebAsyst sends us blank shipping information, in which 
			//	case we want to default it to using the billing information as 
			//	the ship to address
			if (!$arr['ShipAddress_Addr1'] and 
				!$arr['ShipAddress_City'])
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
			
			if (!count($items))
			{
				return null;
			}
			
			// shipping
			$shipping = null;
			
			// handling
			$handling = null;
			
			// Get a list of discounts for this order
			$discount = null;
						
			// Create the order
			return $this->_orderFromArray($arr, $items, $shipping, $handling, $discount);	
		}
		
		return null;
	}
	
	protected function _getPayment($ID)
	{
		return null;
	}
	
	protected function _getOrderItems($OrderID)
	{
		$Driver = $this->_driver;
		
		// Now, fetch a list of items 
		$errnum = null;
		$errmsg = null;
		$res2 = $Driver->query("
			SELECT 
				product_id AS Product_ID,
				name AS Name, 
				model AS Descrip, 
				price AS Rate, 
				quantity AS Quantity 
			FROM 
				order_product 
			WHERE 
				order_id = " . (int) $OrderID, $errnum, $errmsg);
			
		// ... and turn those details into order line items
		$items = array();
		while ($arr2 = $Driver->fetch($res2))
		{
			$item = $this->_orderItemFromArray($arr2);
			
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
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT 
				product_id AS Product_ID, 
				product_name AS Name, 
				price AS SalesOrPurchase_Price, 
				model, 
				sku, 
				date_available, 
				date_added, 
				tax
			FROM 
				product 
			WHERE 
				product_id = " . (int) $ProductID . " ", $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			$income_account = null; 
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
	
	/**
	 *
	 * 
	 * @note This overrides the base class implementation of _getGenericShipping()
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
		
		$income_account = null;
		if ($income_account)
		{
			$arr['SalesOrPurchase_AccountName'] = $income_account;
		}
		
		$Item = $this->_productFromArray($arr, $this->_config['push_shipping_as']);
		
		return $Item;		
	}
	
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
		
		$discount_account = null;
		if ($discount_account)
		{
			$arr['SalesOrPurchase_AccountName'] = $discount_account;
		}
		
		$Item = $this->_productFromArray($arr, $this->_config['push_shipping_as']);
		
		return $Item;
	}
	
	protected function _defaultGetGiftCertificateQuery()
	{
		return null;		
	}
	
	protected function _defaultGetProductQuery()
	{
		return null;
	}
}
