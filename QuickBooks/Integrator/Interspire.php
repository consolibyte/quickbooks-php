<?php

/**
 * QuickBooks IMSCart Integrator
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
 * QuickBooks IMSCart Integrator class
 * 
 * IMSCart integration is accomplished by implementing a class extending the 
 * QuickBooks_Integrator class. Methods are implemented which each return an 
 * object instance (QuickBooks_Object_*) or list of instances. 
 */
class QuickBooks_Integrator_Interspire extends QuickBooks_Integrator
{
	/** 
	 * Configuration defaults for Interspire
	 * 
	 * @param array $config
	 * @return array
	 */
	protected function _defaults($config)
	{
		$config = parent::_defaults($config);
		
		$defaults = array(
			'currency' => 'USD', 
			'tax_agency' => 'Internal Revenue Service',
			'order_status' => 'C',  
			'additional_order_queries' => array(), 
			'additional_product_queries' => array(), 
			'additional_customer_queries' => array(), 
			'additional_shipmethod_queries' => array(), 
			'additional_paymentmethod_queries' => array(), 
			'additional_discount_queries' => array(), 
			'additional_shipping_queries' => array(), 
			'additional_handling_queries' => array(), 
			'additional_coupon_queries' => array(), 
			'additional_salestax_queries' => array(), 
			'additional_orderitem_queries' => array(), 
			'additional_payment_queries' => array(), 
			'encryption_token' => '', 
		);
		
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
	
	protected function _decrypt($cardno)
	{
		$CCEnc = $cardno;
		$encryption_token = $this->_config['encryption_token'];
		
		if (function_exists('mcrypt_get_iv_size'))
		{
			$CCEnc = base64_decode($CCEnc);
			$iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			$decrypt = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_token, $CCEnc, MCRYPT_MODE_ECB, $iv);
			$decrypt = rtrim($decrypt, "\0");
			return $decrypt;
		}
		
		return 'Error: mcrypt_get_iv_size() does not exist.';
	}

	protected function _setEstimate($EstimateID, $Estimate, $from = null, $line = null)
	{
		return false;
	}
	
	protected function _setCustomer($CustomerID, $Customer)
	{
		return false;
	}
	
	/**
	 * 
	 * 
	 * @return string
	 */
	public function _defaultGetCustomerQuery()
	{
		return '
			(
				SELECT
					$ID AS CustomerID,
					custconfirstname AS FirstName,
					custconlastname AS LastName,
					custconemail AS Email,
					custconphone AS Phone, 
					CONCAT(ordshipfirstname, \' \', ordshiplastname) AS ShipAddress_Addr1, 
					ordshipcompany AS ShipAddress_Addr2, 
					CASE 
						WHEN LENGTH(ordshipstreet1) > 0 AND LENGTH(ordshipstreet2) > 0 THEN CONCAT(ordshipstreet1, \', \', ordshipstreet2)
						ELSE ordshipstreet1 
					END AS ShipAddress_Addr3, 
					ordshipsuburb AS ShipAddress_City, 
					ordshipstate AS ShipAddress_State, 
					ordshipcountry AS ShipAddress_Country, 
					ordshipzip AS ShipAddress_PostalCode, 
					CONCAT(ordbillfirstname, \' \', ordbilllastname) AS BillAddress_Addr1, 
					ordbillcompany AS BillAddress_Addr2, 
					CASE 
						WHEN LENGTH(ordbillstreet1) > 0 AND LENGTH(ordbillstreet2) > 0 THEN CONCAT(ordbillstreet1, \', \', ordbillstreet2)
						ELSE ordbillstreet1 
					END AS BillAddress_Addr3, 
					ordbillsuburb AS BillAddress_City, 
					ordbillstate AS BillAddress_State, 
					ordbillzip AS BillAddress_PostalCode, 
					ordbillcountry AS BillAddress_Country,
					extrainfo AS Custom_ExtraInfo
				FROM
					isc_orders
				LEFT JOIN 
					isc_customers ON isc_orders.ordcustid = isc_customers.customerid
				WHERE
					ordcustid = $ID AND 
					$ID NOT LIKE \'%O:%\' 
				ORDER BY
					orddate DESC 
				LIMIT 
					1 
			) UNION (
				SELECT
					$ID AS CustomerID, 
					ordbillfirstname AS FirstName,
					ordbilllastname AS LastName,
					ordbillemail AS Email,
					ordbillphone AS Phone, 
					CONCAT(ordshipfirstname, \' \', ordshiplastname) AS ShipAddress_Addr1, 
					ordshipcompany AS ShipAddress_Addr2, 
					CASE 
						WHEN LENGTH(ordshipstreet1) > 0 AND LENGTH(ordshipstreet2) > 0 THEN CONCAT(ordshipstreet1, \', \', ordshipstreet2)
						ELSE ordshipstreet1 
					END AS ShipAddress_Addr3, 
					ordshipsuburb AS ShipAddress_City, 
					ordshipstate AS ShipAddress_State, 
					ordshipcountry AS ShipAddress_Country, 
					ordshipzip AS ShipAddress_PostalCode, 
					CONCAT(ordbillfirstname, \' \', ordbilllastname) AS BillAddress_Addr1, 
					ordbillcompany AS BillAddress_Addr2, 
					CASE 
						WHEN LENGTH(ordbillstreet1) > 0 AND LENGTH(ordbillstreet2) > 0 THEN CONCAT(ordbillstreet1, \', \', ordbillstreet2)
						ELSE ordbillstreet1 
					END AS BillAddress_Addr3, 
					ordbillsuburb AS BillAddress_City, 
					ordbillstate AS BillAddress_State, 
					ordbillzip AS BillAddress_PostalCode, 
					ordbillcountry AS BillAddress_Country,
					extrainfo AS Custom_ExtraInfo
				FROM
					isc_orders
				LEFT JOIN 
					isc_customers ON isc_orders.ordcustid = isc_customers.customerid
				WHERE
					orderid = SUBSTRING($ID, 3) AND 
					$ID LIKE \'%O:%\' 
				ORDER BY
					orddate DESC 
				LIMIT 
					1 
			)';
		
		//		-- LEFT JOIN
		//	-- 	isc_shipping_addresses ON isc_customers.customerid = isc_shipping_addresses.shipcustomerid
	}

	/**
	 * Get a list of orders that are new since a specific date 
	 * 
	 * @return string
	 */
	protected function _defaultListNewOrdersSinceQuery()
	{
		
		return '
			SELECT 
				orderid AS OrderID
			FROM
				isc_orders
			WHERE 
				ordstatus != 0 AND 
				FROM_UNIXTIME(orddate) > \'$datetime\'  ';
		
		/*
		return '
			SELECT
				orderid AS OrderID
			FROM
				isc_orders
			WHERE
				ordstatus != 0 AND
				orderid IN (
16843, 
16848, 
16852, 
16858, 
16868,
16869,
16871
				)
		';*/
	}
	
	/**
	 * Escape and wrap a value for use with an SQL database / the integrator
	 * 
	 * @param mixed $value
	 * @return mixed
	 */
	protected function _wrapAndEscape($value)
	{
		if (!strlen($value) or !is_numeric($value) or (strlen($value) and $value{0} == '0'))
		{
			return "'" . $this->_integrator->escape($value) . "'";
		}
		
		return $value;
	}
	
	/**
	 * 
	 * 
	 * 
	 * 
	 */
	protected function _getCustomerExtras($CustomerID, $from = null, $line = null)
	{
		$list = array();
		
		$errnum = 0;
		$errmsg = '';
		
		$queries = $this->_getCustomerExtrasQueries($CustomerID);
		
		foreach ($queries as $sql)
		{
			$res = $this->_integrator->query($sql, $errnum, $errmsg);
		
			while ($arr = $this->_integrator->fetch($res))
			{
				$vars = array(
					'CustomerID' => $CustomerID, 
					);
				
				$extra = $this->_extraFromArray($arr);
				
				if ($extra)
				{
					$list[] = $extra;
				}
			}
		}
		
		return $list;
	}
	
	protected function _listNewEstimatesSince($datetime)
	{
		return array();
	}
	
	protected function _listModifiedEstimatesSince($datetime)
	{
		return array();
	}

	protected function _getEstimate($EstimateID)
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
		//$this->_log(__CLASS__ . '::' . __METHOD__ . '(' . $CustomerID . ') called from: ' . $from . ':' . $line);
		
		$errnum = 0;
		$errmsg = '';
				
		$sql = $this->_getCustomerQuery($CustomerID);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		$arr = $this->_integrator->fetch($res);
		
		//print_r($arr);
		
		if (!empty($arr['Custom_ExtraInfo']) and 
			$extra = unserialize($arr['Custom_ExtraInfo']))
		{
			$defaults = array(
				'cc_name' => '', 
				'cc_cctype' => '', 
				'cc_ccno' => '', 
				'cc_ccaddress' => '', 
				'cc_ccexpm' => 0, 
				'cc_ccexpy' => 0, 
				'cc_zip' => '', 
				'cc_cvv2' => 0, 
				);
			
			$extra = array_merge($defaults, $extra);
			
			if ($extra['cc_ccexpm'] and $extra['cc_ccexpy'])
			{
				$arr['CreditCardInfo_CreditCardNumber'] = $this->_decrypt($extra['cc_ccno']);
				$arr['CreditCardInfo_ExpirationMonth'] = $extra['cc_ccexpm'];
				$arr['CreditCardInfo_ExpirationYear'] = $extra['cc_ccexpy'];
				$arr['CreditCardInfo_NameOnCard'] = $extra['cc_name'];
				$arr['CreditCardInfo_CreditCardAddress'] = $extra['cc_ccaddress'];
				$arr['CreditCardInfo_CreditCardPostalCode'] = $extra['cc_zip'];
			}
		}
		
		$vars = array(
			'ID' => $CustomerID,
			'CustomerID' => $CustomerID, 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_customer_queries'], $arr, array_merge($this->_config, $vars));
		
		return $this->_customerFromArray($arr);
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
		foreach ($queries as $query)
		{
			//print_r($query);
			//print_r($arr);
			//print_r($vars);
			//exit;
			
			$new = array();
			
			$errnum = 0;
			$errmsg = '';
			
			$query = $this->_applyFormat($query, $vars);
			
			$res = $this->_integrator->query($query, $errnum, $errmsg);
			if ($res)
			{
				$new = $this->_integrator->fetch($res);
			}
			
			/*
			print('---{');
			print('arr: '); print_r($arr);
			print('new: '); print_r($new);
			print('}---');
			*/
			
			$arr = array_merge($arr, $new);
		}
		
		return $arr;
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
		$errnum = 0;
		$errmsg = '';
		
		$list = array();
		
		$sql = $this->_listNewOrdersSinceQuery($datetime);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		
		while ($arr = $this->_integrator->fetch($res))
		{
			if (!empty($arr['order_id']))
			{
				$list[] = $arr['order_id'];
			}
			else if (!empty($arr['OrderID']))
			{
				$list[] = $arr['OrderID'];
			}
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
		$errnum = 0;
		$errmsg = '';
		
		$sql = $this->_getOrderQuery($ID);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		$arr = $this->_integrator->fetch($res);
		
		$items = $this->_getOrderItemsForOrder($ID);
		
		$shipping = $this->_getShippingForOrder($ID);
		$handling = $this->_getHandlingForOrder($ID);
		
		$vars = array(
			'ID' => $ID, 
			'OrderID' => $ID, 
			);
		
		// Run a bunch of additional queries
		$arr = $this->_additionalQueries($this->_config['additional_order_queries'], $arr, array_merge($this->_config, $vars));
		
		/*
		print('<pre>');
		print('ID: ' . $ID . "\n");
		print_r($items);
		print_r($shipping);
		print_r($handling);
		print('</pre>');
		*/
		
		return $this->_orderFromArray($arr, $items, $shipping, $handling);
	}
	
	protected function _getEstimateItemsForEstimate($EstimateID)
	{
		return array();
	}
	
	/** 
	 * 
	 * 
	 */
	protected function _defaultGetOrderQuery()
	{
		return '
			SELECT
				orderid AS OrderID, 
				orderid AS RefNumber,
				
				CASE
					WHEN ordcustid THEN ordcustid
					ELSE CONCAT(\'O:\', orderid)
				END AS CustomerID, 
				
				orddate AS TxnDate,
				CONCAT(ordbillfirstname, \' \', ordbilllastname) AS BillAddress_Address1,
				ordbillcompany AS BillAddress_Address2,
				CASE 
					WHEN LENGTH(ordbillstreet1) > 0 AND LENGTH(ordbillstreet2) > 0 THEN CONCAT(ordbillstreet1, \', \', ordbillstreet2)
					ELSE ordbillstreet1
				END AS BillAddress_Address3,
				ordbillsuburb AS BillAddress_City,
				ordbillstate AS BillAddress_State,
				ordbillzip AS BillAddress_PostalCode,
				ordbillcountry AS BillAddress_Country,
				CONCAT(ordshipfirstname, \' \', ordshiplastname) AS ShipAddress_Address1, 
				ordshipcompany AS ShipAddress_Address2, 
				CASE 
					WHEN LENGTH(ordshipstreet1) > 0 AND LENGTH(ordshipstreet2) > 0 THEN CONCAT(ordshipstreet1, \', \', ordshipstreet2)
					ELSE ordshipstreet1 
				END AS ShipAddress_Address3,
				ordshipsuburb AS ShipAddress_City,
				ordshipstate AS ShipAddress_State,
				ordshipzip AS ShipAddress_PostalCode,
				ordshipcountry As ShipAddress_Country,
				orddateshipped AS ShipDate,
				ordcustmessage AS Memo
			FROM
				isc_orders
			WHERE
				orderid = $ID ';		
	}
	
	/**
	 * Alias of {@link QuickBooks_Integrator_Imscart::getOrderItemsForOrder()}
	 */
	protected function _getOrderItems($OrderID)
	{
		return $this->_getOrderItemsForOrder($OrderID);
	}
	
	protected function _defaultGetOrderItemsForOrderQuery()
	{
		return '
			SELECT 
				CASE 
					WHEN ordprodid > 0 THEN ordprodid 
					ELSE \'giftcertificate\' 
				END AS ProductID, 

				ordprodname AS Descrip,
				ordprodcost AS Rate, 
				ordprodqty AS Quantity, 
				
				CASE 
					WHEN isc_products.prodistaxable > 0 AND isc_orders.ordtaxrate > 0 THEN \'' . QUICKBOOKS_TAXABLE . '\'
					ELSE \'' . QUICKBOOKS_NONTAXABLE . '\' 
				END AS SalesTaxCodeName, 
				
				ordprodoptions AS Custom_ProductOptions
			FROM
				isc_order_products
			LEFT JOIN
				isc_products ON isc_order_products.ordprodid = isc_products.productid 
			LEFT JOIN 
				isc_orders ON isc_order_products.orderorderid = isc_orders.orderid
			WHERE
				orderorderid = $OrderID ';
	}
	
	/**
	 * Get a list of items for an order (Invoice, SalesReceipt, SalesOrder)
	 * 
	 * @param integer $OrderID
	 * @return array 
	 */
	protected function _getOrderItemsForOrder($OrderID)
	{
		$list = array();
		
		$errnum = 0;
		$errmsg = '';
		
		$sql = $this->_getOrderItemsForOrderQuery($OrderID);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		
		while ($arr = $this->_integrator->fetch($res))
		{
			$vars = array(
				'OrderID' => $OrderID, 
				);
			
			$arr = $this->_additionalQueries($this->_config['additional_orderitem_queries'], $arr, array_merge($this->_config, $vars));
						
			if (!empty($arr['Custom_ProductOptions']) and 
				$atmp = unserialize($arr['Custom_ProductOptions']))
			{
				$stmp = '';
				foreach ($atmp as $ckey => $cvalue)
				{
					$stmp .= $ckey . ': ' . $cvalue . "\n";
				}
				
				$arr['Descrip'] .= "\n" . $stmp;
			}
			
			$item = $this->_orderItemFromArray($arr);
			
			if ($item)
			{
				$list[] = $item;
			}
		}
		
		foreach ($this->_getOrderItemsForOrderAdditionalQueries($OrderID) as $sql)
		{
			$errnum = 0;
			$errmsg = '';
			$res = $this->_integrator->query($sql, $errnum, $errmsg);
			while ($arr = $this->_integrator->fetch($res))
			{
				$vars = array(
					'OrderID' => $OrderID, 
				);
				
				$item = $this->_orderItemFromArray($arr);
				
				if ($item)
				{
					$list[] = $item;
				}
			}
		}
		
		return $list;
	}
	
	/**
	 * Get a ship method object by ID
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_ShipMethod
	 */
	protected function _getShipMethod($ID)
	{
		$errnum = 0;
		$errmsg = '';
		
		$sql = $this->_getShipMethodQuery($ID);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		$arr = $this->_integrator->fetch($res);
		
		$vars = array(
			'ID' => $this->_integrator->escape($ID), 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_shipmethod_queries'], $arr, array_merge($this->_config, $vars));
		
		return $this->_shipMethodFromArray($arr);
	}
	
	protected function _defaultGetShipMethodQuery()
	{
		return '
			SELECT
				methodmodule AS ShipMethodID, 
				methodname AS Name
			FROM
				isc_shipping_methods
			WHERE
				methodmodule = \'$ShipMethodID\' ';
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
	 * Alias of {@link QuickBooks_Integrator_Imscart::getPaymentForOrder()}
	 */
	protected function _getPayment($OrderID)
	{
		return $this->_getPaymentForOrder($OrderID);
	}
	
	/**
	 * Get a payment by Order ID
	 * 
	 * @param integer $OrderID
	 * @return QuickBooks_Object_ReceivePayment
	 */
	protected function _getPaymentForOrder($OrderID)
	{
		switch ($this->_config['push_orders_as'])
		{
			case QUICKBOOKS_OBJECT_SALESRECEIPT:		// SalesReceipts are bundled together invoices and payments, so we don't have a separate payment for them
				return null;
		}
		
		$errnum = 0;
		$errmsg = '';
		
		$sql = $this->_getPaymentForOrderQuery($OrderID);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		$arr = $this->_integrator->fetch($res);
		
		$vars = array(
			'OrderID' => $OrderID, 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_payment_queries'], $arr, array_merge($this->_config, $vars));
		
		$orders = array();
		
		return $this->_paymentFromArray($arr, $orders);
	}
	
	protected function _defaultGetPaymentForOrderQuery()
	{
		return '
			SELECT
				ordcustid AS CustomerID, 
				orderid AS RefNumber, 
				ordgatewayamount AS TotalAmount, 
				DATE(FROM_UNIXTIME(orddate)) AS TxnDate, 
				orderpaymentmodule AS PaymentMethodID,
				\'true\' AS IsAutoApply
			FROM
				isc_orders
			WHERE
				orderid = $OrderID ';
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
		$errnum = 0;
		$errmsg = '';
		
		$res = $this->_integrator->query("
			SELECT
				coupon_name AS Name, 
				CONCAT(coupon_name, ', ', coupon_number) AS ItemDesc, 
				NULL AS SalesTaxCodeID
				'" . $this->_config['tax_code_nontaxable'] . "' AS SalesTaxCodeName, 
				NULL AS SalesTaxCodeListID, 
				coupon_discount AS DiscountRate, 
				NULL AS DiscountRatePercent, 
				NULL AS AccountID, 
				NULL AS AccountListID, 
				NULL AS AccountName
			FROM
				coupon
			WHERE
				coupon_id = " . $ID, $errnum, $errmsg);
		
		$arr = $this->_integrator->fetch($res);
		
		$vars = array(
			'ID' => $ID, 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_coupon_queries'], $arr, array_merge($this->_config, $vars));
		
		return $this->_couponFromArray($arr);
	}
	
	/** 
	 * Get a sales tax item by ID
	 * 
	 * @param integer $ID
	 * @return QuickBooks_Object_SalesTaxItem
	 */
	protected function _getSalesTax($ID)
	{
		$errnum = 0;
		$errmsg = '';
		
		$res = $this->_integrator->query(" 
			SELECT
				AS TaxRateID, 
				AS ItemDesc, 
				AS TaxRate, 
				AS TaxVendorID, 
				AS TaxVendorListID, 
				AS TaxVendorName
			FROM
				tax_rate
			WHERE
				tax_rate_id = " . $ID, $errnum, $errmsg);
				
		$arr = $this->_integrator->fetch($res);
		
		$vars = array(
			'ID' => $ID, 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_salestax_queries'], $arr, array_merge($this->_config, $vars));
		
		return $this->_salesTaxFromArray($arr);
	}
	
	/**
	 * Get a shipping item for an order
	 * 
	 * @param integer $OrderID
	 * @return QuickBooks_Object_OtherChargeItem
	 */
	protected function _getShippingForOrder($OrderID)
	{
		$errnum = 0;
		$errmsg = '';
		
		$sql = $this->_getShippingForOrderQuery($OrderID);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		$arr = $this->_integrator->fetch($res);
		
		$vars = array(
			'OrderID' => $OrderID, 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_shipping_queries'], $arr, array_merge($this->_config, $vars));
		
		return $this->_shippingFromArray($arr);
	}
	
	/**
	 * 
	 * 
	 */
	protected function _getHandlingForOrder($OrderID)
	{
		$errnum = 0;
		$errmsg = '';
		
		$sql = $this->_getHandlingForOrderQuery($OrderID);
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		$arr = $this->_integrator->fetch($res);
		
		$vars = array(
			'OrderID' => $OrderID, 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_handling_queries'], $arr, array_merge($this->_config, $vars));
		
		return $this->_handlingFromArray($arr);
	}
	
	protected function _defaultGetShippingForOrderQuery()
	{
		return '
			SELECT 
				ordershipmodule AS ShipMethodID, 
				ordshipcost AS Amount,
				ordshipmethod AS Descrip,
				\'' . QUICKBOOKS_NONTAXABLE . '\' AS SalesTaxCodeName
			FROM
				isc_orders
			WHERE
				orderid = $OrderID ';
	}

	protected function _defaultGetHandlingForOrderQuery()
	{
		return '
			SELECT 
				ordhandlingcost AS Amount,
				\'Handling Charge\' AS Descrip,
				\'' . QUICKBOOKS_NONTAXABLE . '\' AS SalesTaxCodeName
			FROM
				isc_orders
			WHERE
				orderid = $OrderID ';
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
		$errnum = 0;
		$errmsg = '';
		
		//$this->_log(__CLASS__ . '::' . __METHOD__ . '(' . $ProductID . ') called from: ' . $from . ':' . $line);
		
		//print('fetching with ID: [[' . $ID . ']]');
		
		// Interspire does a strange thing where gift certificates don't have a product ID
		if ($ProductID == 'giftcertificate')
		{
			$sql = $this->_getGiftCertificateQuery($ProductID);
			
			//print_r('sql: ' . $sql . "\n");
			
			$as = $this->_config['push_giftcertificates_as'];
		}
		else
		{
			$sql = $this->_getProductQuery($ProductID);
			
			//print('prod sql: ' . $sql . "\n");
			
			$as = $this->_config['push_products_as'];
			
			//print('as: ' . $as . "\n");
		}
		
		
		
		$res = $this->_integrator->query($sql, $errnum, $errmsg);
		$arr = $this->_integrator->fetch($res);
		
		//header('Content-Type: text/plain');
		//print_r($arr);
		
		$strip = array(
			'Desc',
			'Descrip',
			'Description', 
			'SalesDesc',
			'SalesDescrip',
			'SalesDescription', 
			'PurchaseDesc', 
			);
		foreach ($strip as $key)
		{
			if (isset($arr[$key]))
			{
				$arr[$key] = $this->_cleanHTML($arr[$key]);
			}
		}
		
		//print_r($arr);
		//exit;
		
		$vars = array(
			'ID' => $ProductID,
			'ProductID' => $ProductID, 
			);
		
		$arr = $this->_additionalQueries($this->_config['additional_product_queries'], $arr, array_merge($this->_config, $vars));
		
		/*
		print($sql);
		print_r($arr);
		exit;
		*/
		
		return $this->_productFromArray($arr, $as);
	}
	
	protected function _defaultGetGiftCertificateQuery()
	{
		switch ($this->_config['push_giftcertificates_as'])
		{
			case QUICKBOOKS_OBJECT_SERVICEITEM:
				return '
					SELECT
						\'giftcertificate\' AS ProductID, 
						\'Gift Certificate\' AS Name, 
						\'Gift Certificate\' AS SalesOrPurchase_Desc,
						0.0 AS SalesOrPurchase_Price,
						\'$IncomeAccountName\' AS SalesOrPurchase_AccountName ';
			case QUICKBOOKS_OBJECT_OTHERCHARGEITEM:
				return '
					SELECT
						\'giftcertificate\' AS ProductID, 
						\'Gift Certificate\' AS Name, 
						\'Gift Certificate\' AS Descrip, 
						0.0 AS Price, 
						\'$IncomeAccountName\' AS AccountName ';
			default:
				return __FILE__ . ':' . __LINE__;
		}		
	}
	
	protected function _defaultGetProductQuery()
	{
		switch ($this->_config['push_products_as'])
		{
			case QUICKBOOKS_OBJECT_INVENTORYITEM:
				return '
					SELECT
						productid AS ProductID, 
						prodname AS Name, 
						proddesc AS SalesDescrip, 
						prodprice AS SalesPrice, 
						\'$IncomeAccountName\' AS IncomeAccountName,
						\'$COGSAccountName\' AS COGSAccountName,
						\'$AssetAccountName\' AS AssetAccountName
					FROM
						isc_products
					WHERE
						productid = $ProductID ';
			case QUICKBOOKS_OBJECT_SERVICEITEM:
			default:
				return '';
		}
	}

}
