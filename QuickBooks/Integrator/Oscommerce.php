<?php

/**
 * QuickBooks OSCommerce Integrator
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
class QuickBooks_Integrator_OSCommerce extends QuickBooks_Integrator
{		
	protected function _wrapAndEscape($str)
	{
		return "'" . $this->_driver->escape($str) . "'";
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
				c.customers_id AS CustomerID,
				CONCAT(customers_firstname, ' ', customers_lastname) AS Name,
				customers_firstname AS FirstName, 
				customers_lastname AS LastName, 
				entry_company AS Company,
				customers_firstname AS FirstName,
				customers_lastname AS LastName,
				entry_street_address AS BillAddress_Addr1,  
				entry_city AS BillAddress_City,
				entry_state AS BillAddress_State,
				entry_postcode AS BillAddress_PostalCode,
				countries_name AS BillAddress_Country,	
				customers_telephone AS Phone,
				customers_fax AS Fax,
				customers_email_address AS Email		
			FROM
				customers AS c 
			INNER JOIN 
				address_book AS ab ON c.customers_id = ab.customers_id
			INNER JOIN
				countries AS co ON co.countries_id = ab.entry_country_id
			WHERE
				c.customers_id = " . (int) $CustomerID, $errnum, $errmsg);
		
		$format = null;
		if (!$format)
		{
			$format = '$FirstName $LastName';
		}
		
		if ($arr = $Driver->fetch($res))
		{
			$arr['Name'] = $this->_applyFormat($format, $arr);
			
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
		
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT
				c.customers_id
			FROM
				customers AS c
			LEFT JOIN 
				customers_info AS i 
					ON c.customers_id = i.customers_info_id
			WHERE
				i.customers_info_date_account_created > '" . $datetime . "' ", $errnum, $errmsg);
		
		while ($arr = $Driver->fetch($res))
		{
			$list[] = $arr['customers_id'];
		}
		
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
		
		/*
		$list = array();
		
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT
				c.customers_id
			FROM
				customers
			LEFT JOIN customers_info AS i 
				 	ON c.customers_id = i.customers_id
			WHERE
				i.customers_info_date_account_last_modified > = '" . $datetime . "' ", $errnum, $errmsg);
		
		while ($arr = $Driver->fetch($res))
		{
			$list[] = $arr['customers_id'];
		}
		
		return $list;
		*/
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
				orders_id
			FROM
				orders
			WHERE
				date_purchased > '" . $datetime . "' ", $errnum, $errmsg);
		
		while ($arr = $Driver->fetch($res))
		{
			$list[] = $arr['orders_id'];
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
	protected function _getOrder($ID)
	{
		$Driver = $this->_driver;
		
		$errnum = 0;
		$errmsg = '';
		$res = $Driver->query("
			SELECT
				orders_id AS OrderID,
				orders_id AS RefNumber, 
				customers_id AS CustomerID, 
				-- customers_name AS Customer_FullName,
				billing_street_address AS BillAddress_Addr1,
				billing_city AS BillAddress_City,
				billing_state AS BillAddress_State,
				billing_postcode AS BillingAddress_PostalCode,
				billing_country AS BillAddress_Country,
				delivery_street_address AS ShipAddress_Addr1,
				delivery_city AS ShipAddress_City,
				delivery_state AS ShipAddress_State,
				delivery_postcode AS ShipAddress_PostalCode,
				delivery_country AS ShipAddress_Country,
				-- CASE orders_status 
				-- 	WHEN 1 THEN 1 
				-- 	ELSE 0 
				-- END AS IsPending,
				payment_method AS PaymentMethod_FullName
				-- cc_number AS CreditCardTxnInfo_CreditCardTxnInputInfo_CreditCardNumber,
				-- SUBSTRING(cc_expires, 1, 2) AS CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationMonth,
				-- SUBSTRING(cc_expires, 3, 2) AS CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationYear,
				-- cc_owner AS CreditCardTxnInfo_CreditCardTxnInputInfo_NameOnCard,
				-- cc_type AS CreditCardTxnInfo_CreditCardTxnInputInfo_ExpirationYear
			FROM
				orders o	
			WHERE
				o.orders_id = '" . (int) $ID . "' ", $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			// Fetch the order items
			$items = $this->_getOrderItems($ID);
			
			$shipping = null;
			/*
			// Create the shipping line item
			$arr3 = array(
				'Desc' => 'Shipping Charge', 
				'Amount' => $arr['shipping_total'], 
				);
			
			$shipping = $this->_shippingFromArray($arr3);
			*/
			
			$handling = null;
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
				orders_products_id AS OrderProductID,
				-- op.products_name AS ItemRef_FullName,
				op.products_id AS ItemID, 
				products_description AS Descrip,
				products_quantity AS Quantity,
				final_price AS Rate
			FROM
				orders_products AS op
			INNER JOIN
				products_description AS pd ON pd.products_id = op.products_id
			WHERE
				op.orders_id = " . (int) $OrderID . " ", $errnum, $errmsg);
			
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
				p.products_id AS ProductID,
				products_name AS Name,
				products_description AS Descrip,
				products_price AS Price
				-- products_quantity AS QuantityOnHand	
			FROM
				products p
			INNER JOIN 
				products_description AS pd 
					ON pd.products_id = p.products_id
			WHERE
				p.products_id = " . (int) $ProductID, $errnum, $errmsg);
		
		if ($arr = $Driver->fetch($res))
		{
			
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
}
