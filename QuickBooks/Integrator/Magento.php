<?php

/**
 * QuickBooks Magento Integrator
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
class QuickBooks_Integrator_Magento extends QuickBooks_Integrator
{		
	/**
	 *
	 * @var string
	 */
	protected $_soap_user;
	
	/**
	 *
	 * @var string
	 */
	protected $_soap_pass;
	
	/**
	 *
	 * @var string
	 */
	protected $_soap_session;
	
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
	
	protected function _magentoCall($arg1 = null, $arg2 = null, $arg3 = null, $arg4 = null, $arg5 = null, $arg6 = null, $arg7 = null, $arg8 = null, $arg9 = null)
	{
		static $cache = array();
		
		// Our SOAP session
		$session = $this->_soap_session;
		
		// Our SOAP client
		$SOAP = $this->_driver;
		
		// Arguements
		$args = func_get_args();
		
		$hash = serialize($args);
		if (isset($cache[$hash]))
		{
			$this->_log('Loading from cache: ' . print_r($args, true), QUICKBOOKS_LOG_DEBUG);
			$this->_log('Response from cache: ' . print_r($cache[$hash], true), QUICKBOOKS_LOG_DEBUG);
			
			return $cache[$hash];
		}
		
		// 
		$this->_log('Making SOAP call: ' . print_r($args, true), QUICKBOOKS_LOG_DEBUG);
		
		// Make the SOAP call
		$soap_return = $SOAP->call(
			$session, 
			$arg1, 
			$arg2, 
			$arg3, 
			$arg4, 
			$arg5, 
			$arg6, 
			$arg7, 
			$arg8, 
			$arg9);
		
		// 
		$this->_log('Response from SOAP call: ' . print_r($soap_return, true), QUICKBOOKS_LOG_DEBUG);
		
		// Store the cached record
		$cache[$hash] = $soap_return;
		
		return $soap_return;
	}
	
	/**
	 * 
	 *  
	 * 
	 */
	protected function _magentoSplitAddressLines($type, $address_street)
	{
		$id = 1;
		$lines = explode("\n", $address_street);
		$return = array();
		
		foreach ($lines as $line) 
		{
			$return[$type . 'Address_Addr' . $id] = $line;
			$id++;
		}
		
		return $return;
	}
	
	/**
	 * Get a customer by ID value
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_Customer
	 */
	protected function _getCustomer($CustomerID, $from = null, $line = null)
	{
		// Our SOAP session
		$session = $this->_soap_session;
		
		// Our SOAP client
		$Driver = $this->_driver;
		
		// Fetch data from SOAP magento call
		$customer_data = $this->_magentoCall(
			'customer.info', 
			$CustomerID);
		
		$arr = array(
			'CustomerID' => 	$CustomerID, 
			'Name' => 			$customer_data['firstname'] . ' ' . $customer_data['lastname'],
			'Contact' => 		$customer_data['firstname'] . ' ' . $customer_data['lastname'],
			'FirstName' => 		$customer_data['firstname'],
			'MiddleName' => 	$customer_data['middlename'],
			'LastName' => 		$customer_data['lastname'],
			'Email' => 			$customer_data['email'], 
			'BillAddress_Addr1' => '', 
			'BillAddress_Addr2' => '', 
			'BillAddress_Addr3' => '', 
			'BillAddress_City' => '', 
			'BillAddress_State' => '', 
			'BillAddress_PostalCode' => '', 
			'BillAddress_Country' => '', 
			'ShipAddress_Addr1' => '', 
			'ShipAddress_Addr2' => '', 
			'ShipAddress_Addr3' => '', 
			'ShipAddress_City' => '', 
			'ShipAddress_State' => '', 
			'ShipAddress_PostalCode' => '', 
			'ShipAddress_Country' => '', 
			);
		
		// Phone defaults to Billing phone, unless there is no billing address, in which case it's Shipping's.
		//	AltPhone is only set if there is a billing address.
		
		if (isset($customer_data['default_billing'])) 
		{
			$billing_data = $this->_magentoCall(
				'customer_address.info',
				$customer_data['default_billing']);
			
			$arr = array_merge($arr, 
				$this->_magentoSplitAddressLines('Bill', $billing_data['street']),
				array(
					'BillAddress_City' => $billing_data['city'],
					'BillAddress_State' => $billing_data['region'],
					'BillAddress_PostalCode' => $billing_data['postcode'],
					'Billddress_Country' => $billing_data['country_id'],
					'Phone' => $billing_data['telephone']
				)
			);
		}
		
		if (isset($customer_data['default_shipping'])) 
		{
			$shipping_data = $this->_magentoCall(
				'customer_address.info',
				$customer_data['default_shipping']);
			
			if (!isset($customer_data['default_billing'])) 
			{
				$arr['Phone'] = $shipping_data['telephone'];
			}
			
			if (isset($customer_data['default_billing'])) 
			{
				if ($shipping_data['telephone'] != $arr['Phone'])
				{
					$arr['AltPhone'] = $shipping_data['telephone'];
				}
			}
			
			$arr = array_merge($arr, 
				$this->_magentoSplitAddressLines('Ship', $shipping_data['street']),
				array(
					'ShipAddress_City' => $shipping_data['city'],
					'ShipAddress_State' => $shipping_data['region'],
					'ShipAddress_PostalCode' => $shipping_data['postcode'],
					'ShipAddress_Country' => $shipping_data['country_id']
				)
			);
		}
		
		if ($arr)
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
		
		$Driver = $this->_driver;
		
				
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
		
		// 
		$session = $this->_soap_session;
		
		// 
		$Driver = $this->_driver;
		
		$order_list = $this->_magentoCall(
			'sales_order.list',
			array( 	// filters
				array( 'created_at' => array( 'from' => $datetime ) ) // /lib/Zend/Db/Select has a list of filters, as well as http://100101.kurodust.net/2008/10/24/magento-api-calls-filter-parameters/
				)
			);
		
		foreach($order_list as $order) 
		{
			$list[] = $order['increment_id'];
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
		// SOAP session
		$session = $this->_soap_session;
		
		// SOAP client
		$Driver = $this->_driver;
		
		// 
		$order_data = $this->_magentoCall(
			'sales_order.info',
			$OrderID);
		
		$arr = array(
			'CustomerID' => 	$order_data['customer_id'],
			'TxnDate' => 		$order_data['created_at'],
			'RefNumber' => 		$order_data['increment_id'],
			
			'BillAddress_City' => $order_data['billing_address']['city'],
			'BillAddress_State' => $order_data['billing_address']['region'],
			'BillAddress_Country' => $order_data['billing_address']['country_id'],
			'BillAddress_PostalCode' => $order_data['billing_address']['postcode'],
			
			'ShipAddress_City' => $order_data["shipping_address"]["city"],
			'ShipAddress_State' => $order_data["shipping_address"]["region"],
			'ShipAddress_Country' => $order_data["shipping_address"]["country_id"],
			'ShipAddress_PostalCode' => $order_data["shipping_address"]["postcode"],
			
			//'IsPending' => ($order_data["status"] == "pending")
		);
		
		$arr = array_merge($arr, 
			$this->_magentoSplitAddressLines('Bill', $order_data["billing_address"]["street"]),
			$this->_magentoSplitAddressLines('Ship', $order_data["shipping_address"]["street"])
		);
		
		if ($arr)
		{
			// Sometimes FoxyCart sends us blank shipping information, in which 
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
			
			// Create the shipping line item
			$shipping = null;
			
			// Handling charge
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
		// 
		$session = $this->_soap_session;
		
		// 
		$Driver = $this->_driver;

		$order_data = $this->_magentoCall(
			'sales_order.info',
			$OrderID);
		
		// ... and turn those details into order line items
		foreach($order_data['items'] as $item) 
		{
			$arr = array(
				'ProductID' => $item['product_id'], 
				'Rate' => $item['price'],
				'Quantity' => $item['qty_ordered'],
				'Name' => $item['name'],
				'Descrip' => $item['name'],
				);
			
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
		$session = $this->_soap_session;
		
		$Driver = $this->_driver;
		
		$magento_store_id = null;
		if ($magento_store_id)		// ???
		{
			$product_data = $this->_magentoCall(
				'catalog_product.info',
				array(
					$ProductID, 
					$magento_store_id
				)
			);
		}
		else 
		{
			$product_data = $this->_magentoCall(
				'catalog_product.info',
				$ProductID);
		}
		
		$inventory_data = $this->_magentoCall(
			'cataloginventory_stock_item.list',
			$product_data['sku']);
		
		$inventory_data = $inventory_data[0]; // first product
		
		$arr = array(
			"Name" => $product_data["name"],
			"IsActive" => ($product_data["status"] == 1), // Catalog/Product/Status ENABLED=1, DISABLED=2
			"SalesOrPurchase_Descrip" => $product_data["description"],
			"SalesOrPurchase_Price" => $product_data["price"],
			"QuantityOnHand" => $inventory_data["qty"]
			);	
			
		if ($arr)
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
		
	protected function _defaultGetGiftCertificateQuery()
	{
		return null;		
	}
	
	protected function _defaultGetProductQuery()
	{
		return null;
	}
}
