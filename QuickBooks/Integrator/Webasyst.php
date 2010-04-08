<?php

/**
 * QuickBooks WebAsyst Integrator
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
class QuickBooks_Integrator_WebAsyst extends QuickBooks_Integrator
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
				SC_customers.customerID AS CustomerID, 
				CONCAT(SC_customers.first_name, ' ', SC_customers.last_name) AS Name, 
				SC_customers.Email AS Email, 
				SC_customers.first_name AS FirstName, 
				SC_customers.last_name AS LastName, 
				SC_customers.login AS Username, 
				SC_customers.cust_password AS Password, 
				CONCAT(SC_customers.first_name, ' ', SC_customers.last_name) AS Contact, 
				
				CONCAT(SC_customer_addresses.first_name, ' ', SC_customer_addresses.first_name) AS BillAddress_Addr1,
				SC_customer_addresses.address AS BillAddress_Addr2, 
				'' AS BillAddress_Addr3, 
				SC_customer_addresses.city AS BillAddress_City, 
				SC_customer_addresses.state AS BillAddress_State, 
				SC_customer_addresses.zip AS BillAddress_PostalCode, 
				SC_customer_addresses.city AS BillAddress_City, 
				SC_countries.country_name_en AS BillAddress_Country, 
				
				CONCAT(SC_customer_addresses.first_name, ' ', SC_customer_addresses.first_name) AS ShipAddress_Addr1,
				SC_customer_addresses.address AS ShipAddress_Addr2, 
				'' AS ShipAddress_Addr3, 
				SC_customer_addresses.city AS ShipAddress_City, 
				SC_customer_addresses.state AS ShipAddress_State, 
				SC_customer_addresses.zip AS ShipAddress_PostalCode, 
				SC_customer_addresses.city AS ShipAddress_City, 
				SC_countries.country_name_en AS ShipAddress_Country, 
				
				SC_Phone.reg_field_value AS Phone
			FROM 
				SC_customers
			LEFT JOIN SC_customer_addresses 
				ON SC_customers.addressID = SC_customer_addresses.addressID
			LEFT JOIN SC_countries
				ON SC_customer_addresses.countryID = SC_countries.countryID
			LEFT JOIN SC_customer_reg_fields_values AS SC_Phone
				ON (SC_customers.customerID = SC_Phone.customerID AND SC_Phone.reg_field_ID = 1)
			WHERE
				SC_customers.customerID = " . (int) $CustomerID, $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			$format = '$FirstName $LastName';
			$arr['Name'] = $this->_applyFormat($format, $arr);
			
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
			else if (!$arr['BillAddress_Addr1'] and 
				!$arr['BillAddress_City'])
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
				orderID 
			FROM 
				SC_orders 
			WHERE 
				order_time > '" . $datetime . "' ", $errnum, $errmsg);
		
		while ($arr = $Driver->fetch($res))
		{
			$list[] = $arr['orderID'];
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
				SC_orders.orderID AS OrderID,
				SC_orders.orderID AS RefNumber,
				SC_orders.customerID AS CustomerID,
				SC_orders.order_time AS TxnDate,
				
				SC_orders.billing_address AS BillAddress_Addr1,
				'' AS BillAddress_Addr2, 
				'' AS BillAddress_Addr3, 
				SC_orders.billing_city AS BillAddress_City,
				SC_orders.billing_state AS BillAddress_State,
				SC_orders.billing_country AS BillAddress_Country,
				SC_orders.billing_zip AS BillAddress_PostalCode,
				
				SC_orders.shipping_address AS ShipAddress_Addr1,
				'' AS ShipAddress_Addr2, 
				'' AS ShipAddress_Addr3, 
				SC_orders.shipping_city AS ShipAddress_City,
				SC_orders.shipping_state AS ShipAddress_State,
				SC_orders.shipping_country AS ShipAddress_Country,
				SC_orders.shipping_zip AS ShipAddress_PostalCode,
				
				SC_shipping_methods.SID AS ShipMethod_ID,
				SC_shipping_methods.Name_en AS ShipMethod_FullName
			FROM
				SC_orders
			LEFT JOIN SC_shipping_methods
				ON SC_shipping_methods.module_id = SC_orders.shipping_module_id
			LEFT JOIN SC_customers
				ON SC_customers.customerID = SC_orders.customerID
			WHERE
				SC_orders.orderID = " . (int) $OrderID . " ", $errnum, $errmsg);
		
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
				SC_shopping_cart_items.productID AS ProductID,
				SC_ordered_carts.name AS Name,				
				SC_products.description_en AS Descrip,
				Quantity,
				SC_ordered_carts.Price AS Rate,
				( SC_ordered_carts.Price * Quantity ) AS Amount
			FROM
				SC_ordered_carts
			LEFT JOIN SC_shopping_cart_items
				ON SC_shopping_cart_items.itemID = SC_ordered_carts.itemID
			LEFT JOIN SC_products
				ON SC_products.productID = SC_shopping_cart_items.productID
			WHERE
				SC_ordered_carts.orderID = " . (int) $OrderID, $errnum, $errmsg);
			
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
				SC_products.productID AS ListID,
				SC_products.name_en AS Name,
				SC_products.brief_description_en AS Descrip, 
				SC_products.enabled AS IsActive,
				SC_products.description_en AS SalesOrPurchase_Desc,
				SC_products.Price AS SalesOrPurchase_Price,
				SC_products.in_stock AS QuantityOnHand
			FROM 
				SC_products
			WHERE
				SC_products.productID = " . (int) $ProductID . " ", $errnum, $errmsg);
		
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
