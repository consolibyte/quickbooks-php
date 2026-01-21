<?php

/**
 * QuickBooks SalesReceipt object
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * QuickBooks object base class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 * Generic object type
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Generic.php');

/**
 * Sales Receipt line item
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/SalesReceipt/SalesReceiptLine.php');

/**
 * Sales Receipt discount line item
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/SalesReceipt/DiscountLine.php');

/**
 * Sales Receipt shipping line item
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/SalesReceipt/ShippingLine.php');

/**
 * Sales Receipt sales tax line item
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/SalesReceipt/SalesTaxLine.php');

/**
 * QuickBooks Sales Receipts
 *
 * Sales receipts are like invoices and payments combined together, and are
 * usually used in cases where the purchase and payment are made at the same
 * time (store front purchases, shopping cart purchases by credit card, etc.)
 * 
 */
class QuickBooks_QBXML_Object_SalesReceipt extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks SalesReceipt object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_SalesReceipt::setTxnID()}
	 */
	public function setTransactionID($TxnID)
	{
		return $this->setTxnID($TxnID);
	}

  public function getTransactionID()
  {
    return $this->getTxnID();
  }
	
	/**
	 * Set the transaction ID of the SalesReceipt object
	 * 
	 * @param string $TxnID
	 * @return boolean
	 */
	public function setTxnID($TxnID)
	{
		return $this->set('TxnID', $TxnID);
	}

  public function getTxnID()
  {
    return $this->get('TxnID');
  }
	
	/**
	 * Set the customer ListID
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setCustomerListID($ListID)
	{
		return $this->set('CustomerRef ListID' , $ListID);
	}
	
	/**
	 * Set the customer ApplicationID (auto-replaced by the API with a ListID)
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	public function setCustomerApplicationID($value)
	{
		return $this->set('CustomerRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_LISTID, $value));
	}
	
	/**
	 * Set the customer name
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setCustomerName($name)
	{
		return $this->set('CustomerRef FullName', $name);
	}
	
	public function setCustomerFullName($FullName)
	{
		return $this->setFullNameType('CustomerRef FullName', null, null, $FullName);
	}
	
	/**
	 * Get the customer ListID
	 * 
	 * @return string
	 */
	public function getCustomerListID()
	{
		return $this->get('CustomerRef ListID');
	}
	
	/**
	 * Get the customer name
	 * 
	 * @return string
	 */
	public function getCustomerName()
	{
		return $this->get('CustomerRef FullName');
	}
	
	/**
	 * Get the customer application ID
	 * 
	 * @return mixed
	 */
	public function getCustomerApplicationID()
	{
		return $this->extractApplicationID($this->get('CustomerRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	/*
	public function setDiscountLineAmount($amount)
	{
		return $this->set('DiscountLine
	}
	
	public function setDiscountLineAccountName($name)
	{
		
	}
	
	public function setShippingLineAmount($amount)
	{
		
	}
	
	public function setShippingLineAccountName($name)
	{
		
	}
	
	public function setSalesTaxLineAmount($amount)
	{
		
	}
	
	public function setSalesTaxLineAccountName($name)
	{
		
	}
	*/
	
	public function setSalesTaxItemFullName($FullName)
	{
		return $this->setItemSalesTaxFullName($FullName);
	}
	
	public function setItemSalesTaxFullName($FullName)
	{
		return $this->setFullNameType('ItemSalesTaxRef FullName', null, null, $FullName);
	}
	
	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}

	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}
	
	public function setClassApplicationID($value)
	{
		return $this->set('ClassRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CLASS, QUICKBOOKS_LISTID, $value));
	}

	public function getClassApplicationID()
	{
		return $this->get('ClassRef ' . QUICKBOOKS_API_APPLICATIONID);
	}



	/**
	 * Set the application ID for the shipping method
	 * 
	 * @param mixed $value		The shipping method primary key from your application
	 * @return 					boolean
	 */
	public function setShipMethodApplicationID($value)
	{
		return $this->set('ShipMethodRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SHIPMETHOD, QUICKBOOKS_LISTID, $value));
	}
	
	public function setShipMethodName($name)
	{
		return $this->set('ShipMethodRef FullName', $name);
	}
	
	public function setShipMethodListID($ListID)
	{
		return $this->set('ShipMethodRef ListID', $ListID);
	}
	
	public function getShipMethodName()
	{
		return $this->get('ShipMethodRef FullName');
	}
	
	public function getShipMethodListID()
	{
		return $this->get('ShipMethodRef ListID');
	}
	
	/** 
	 * Set an invoice as pending
	 * 
	 * @param boolean $pending
	 * @return boolean
	 */
	public function setIsPending($pending)
	{
		return $this->setBooleanType('IsPending', $pending);
	}
	
	public function getIsPending()
	{
		return $this->getBooleanType('IsPending');
	}
	
	public function setCheckNumber($check)
	{
		return $this->set('CheckNumber', $check);
	}
	
	public function getCheckNumber()
	{
		return $this->get('CheckNumber');
	}
	
	public function setPaymentMethodApplicationID($value)
	{
		return $this->set('PaymentMethodRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_PAYMENTMETHOD, QUICKBOOKS_LISTID, $value));
	}

	public function getPaymentMethodApplicationID()
	{
		return $this->get('PaymentMethodRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function setPaymentMethodListID($ListID)
	{
		return $this->set('PaymentMethodRef ListID', $ListID);
	}
	
	public function setPaymentMethodName($name)
	{
		return $this->set('PaymentMethodRef FullName', $name);
	}
	
	public function getPaymentMethodListID()
	{
		return $this->get('PaymentMethodRef ListID');
	}
	
	public function getPaymentMethodName()
	{
		return $this->get('PaymentMethodRef FullName');
	}
	
	public function setDueDate($date)
	{
		return $this->setDateType('DueDate', $date);
	}
	
	public function getDueDate($format = null)
	{
		return $this->getDateType('DueDate', $format);
	}
	
	public function setSalesRepApplicationID($value)
	{
		return $this->set('SalesRepRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SALESREP, QUICKBOOKS_LISTID, $value));
	}

	public function getSalesRepApplicationID()
	{
		return $this->get('SalesRepRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function setSalesRepListID($ListID)
	{
		return $this->set('SalesRepRef ListID', $ListID);
	}
	
	public function setSalesRepName($name)
	{
		return $this->set('SalesRepRef FullName', $name);
	}
	
	public function getSalesRepListID()
	{
		return $this->get('SalesRepRef ListID');
	}
	
	public function getSalesRepName()
	{
		return $this->get('SalesRepRef FullName');
	}	
	
	
	
	public function setIsToBePrinted($printed)
	{
		return $this->setBooleanType('IsToBePrinted', $printed);
	}
	
	public function getIsToBePrinted()
	{
		return $this->getBooleanType('IsToBePrinted');
	}
	
	public function setIsToBeEmailed($emailed)
	{
		return $this->setBooleanType('IsToBeEmailed', $emailed);
	}
	
	public function getIsToBeEmailed()
	{
		return $this->getBooleanType('IsToBeEmailed');
	}
	
	/**
	 * Get the ship method application ID
	 * 
	 * @return value
	 */
	public function getShipMethodApplicationID()
	{
		return $this->extractApplicationID($this->get('ShipMethodRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	public function setDepositToAccountApplicationID($value)
	{
		return $this->set('DepositToAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}
	
	public function setDepositToAccountListID($ListID)
	{
		return $this->set('DepositToAccountRef ListID', $ListID);
	}
	
	public function setDepositToAccountName($name)
	{
		return $this->set('DepositToAccountRef FullName', $name);
	}
	
	public function getDepositToAccountListID()
	{
		return $this->get('DepositToAccountRef ListID');
	}
	
	public function getDepositToAccountName()
	{
		return $this->get('DepositToAccountRef FullName');
	}
	
	/**
	 * Get the ARAccount application ID
	 * 
	 * @return value
	 */
	public function getDepositToAccountApplicationID()
	{
		return $this->extractApplicationID($this->get('DepositToAccountRef ' . QUICKBOOKS_API_APPLICATIONID));
	}	
	
	/**
	 * Set the transaction date
	 * 
	 * @param string $date
	 * @return boolean
	 */
	public function setTxnDate($date)
	{
		/*
		if (!ereg('([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})', $date))
		{
			$date = date('Y-m-d', strtotime($date));
		}
		
		return $this->set('TxnDate', $date);
		*/
		
		return $this->setDateType('TxnDate', $date);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_Invoice::setTxnDate()}
	 */
	public function setTransactionDate($date)
	{
		return $this->setTxnDate($date);
	}

	public function getTxnDate($format = null)
	{
		return $this->getDateType('TxnDate', $format);
	}
	
	public function getTransactionDate($format = null)
	{
		return $this->getTxnDate($format);
	}

	/**
	 * Set the shipping date
	 * 
	 * @param string $date
	 * @return boolean
	 */
	public function setShipDate($date)
	{
		/*
		if (!ereg('([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})', $date))
		{
			$date = date('Y-m-d', strtotime($date));
		}
		
		return $this->set('ShipDate', $date);
		*/
		
		return $this->setDateType('ShipDate', $date);
	}
		
	/**
	 * Get the shipping date
	 * 
	 * @param string $format	The format you want the date in (as for {@link http://www.php.net/date})
	 * @return string
	 */
	public function getShipDate($format = null)
	{
		//return date($format, strtotime($this->get('ShipDate')));
		
		return $this->getDateType('ShipDate', $format);
	}
	
	/**
	 * Set the reference number
	 * 
	 * @param string $str
	 * @return boolean
	 */
	public function setRefNumber($str)
	{
		return $this->set('RefNumber', $str);
	}

	/**
	 * Get the reference number
	 * 
	 * @return string
	 */
	public function getRefNumber()
	{
		return $this->get('RefNumber');
	}
		
	public function setMemo($memo)
	{
		return $this->set('Memo', $memo);
	}
	
	public function getMemo()
	{
		return $this->get('Memo');
	}
	
	public function getFOB()
	{
		return $this->get('FOB');
	}
	
	public function setFOB($fob)
	{
		return $this->set('FOB', $fob);
	}
	
	public function setLinkToTxnID($TxnID)
	{
		return $this->set('LinkToTxnID', $TxnID);
	}

  public function getLinkToTxnID()
  {
    return $this->get('LinkToTxnID');
  }
	
	/**
	 * 
	 * 
	 * @param 
	 */
	public function addSalesReceiptLine($obj)
	{
		$lines = $this->get('SalesReceiptLine');
		$lines[] = $obj;
		
		return $this->set('SalesReceiptLine', $lines);
	}
	
	/**
	 * 
	 */
	public function getSalesReceiptLines()
	{
		return $this->getList('SalesReceiptLine');
	}
	
	/**
	 * 
	 */
	public function getSalesReceiptLine($i)
	{
		return $this->getListItem('SalesReceiptLine', $i);
	}
	
	/**
	 * Add a discount line (only supported by Online Edition as of 8.0)
	 * 
	 * @param QuickBooks_Object_SalesReceipt_DiscountLine
	 * @return boolean
	 */
	public function addDiscountLine($obj)
	{
		return $this->addListItem('DiscountLine', $obj);
	}

	/**
	 * Add a shipping line (only supported by Online Edition as of 8.0)
	 * 
	 * @param QuickBooks_Object_SalesReceipt_SalesTaxLine
	 * @return boolean
	 */
	public function addSalesTaxLine($obj)
	{
		return $this->addListItem('SalesTaxLine', $obj);
	}
	
	/**
	 * Add a shipping line (only supported by Online Edition as of 8.0)
	 * 
	 * @param QuickBooks_Object_SalesReceipt_ShippingLine
	 * @return boolean
	 */
	public function addShippingLine($obj)
	{
		return $this->addListItem('ShippingLine', $obj);
	}
		
	/**
	 * Get an shipping address as an array (or a specific portion of the address as a string)
	 * 
	 * @param string $part			A specific portion of the address to get (i.e. "Addr1" or "State")
	 * @param array $defaults		Default values if a value isn't filled in
	 * @return array				The address
	 */
	public function getShipAddress($part = null, $defaults = array())
	{
		if (!is_null($part))
		{
			return $this->get('ShipAddress ' . $part);
		}
		
		return $this->getArray('ShipAddress *', $defaults);
	}
	
	/**
	 * Set the shipping address for the invoice
	 * 
	 * @param string $addr1			Address line 1
	 * @param string $addr2			Address line 2
	 * @param string $addr3			Address line 3
	 * @param string $addr4			Address line 4
	 * @param string $addr5			Address line 5
	 * @param string $city			City
	 * @param string $state			State
	 * @param string $province		Province (Canadian editions of QuickBooks only!)
	 * @param string $postalcode	Postal code
	 * @param string $country		Country
	 * @param string $note			Notes
	 * @return void
	 */
	public function setShipAddress($addr1, $addr2 = '', $addr3 = '', $addr4 = '', $addr5 = '', $city = '', $state = '', $province = '', $postalcode = '', $country = '', $note = '')
	{
		for ($i = 1; $i <= 5; $i++)
		{
			$this->set('ShipAddress Addr' . $i, ${'addr' . $i});
		}
		
		$this->set('ShipAddress City', $city);
		$this->set('ShipAddress State', $state);
		$this->set('ShipAddress Province', $province);
		$this->set('ShipAddress PostalCode', $postalcode);
		$this->set('ShipAddress Country', $country);
		$this->set('ShipAddress Note', $note);  
	}
	
	/**
	 * Get the billing address 
	 * 
	 * @param string $part			A specific portion of the address to get (i.e. "Addr1" or "State")
	 * @param array $defaults		Default values if a value isn't filled in
	 * @return array				The address
	 */
	public function getBillAddress($part = null, $defaults = array())
	{
		if (!is_null($part))
		{
			return $this->get('BillAddress ' . $part);
		}
		
		return $this->getArray('BillAddress *', $defaults);
	}
	
	/**
	 * Set the billing address for the invoice
	 * 
	 * @param string $addr1			Address line 1
	 * @param string $addr2			Address line 2
	 * @param string $addr3			Address line 3
	 * @param string $addr4			Address line 4
	 * @param string $addr5			Address line 5
	 * @param string $city			City
	 * @param string $state			State
	 * @param string $province		Province (Canadian editions of QuickBooks only!)
	 * @param string $postalcode	Postal code
	 * @param string $country		Country
	 * @param string $note			Notes
	 * @return void
	 */
	public function setBillAddress($addr1, $addr2 = '', $addr3 = '', $addr4 = '', $addr5 = '', $city = '', $state = '', $province = '', $postalcode = '', $country = '', $note = '')
	{
		for ($i = 1; $i <= 5; $i++)
		{
			$this->set('BillAddress Addr' . $i, ${'addr' . $i});
		}
		
		$this->set('BillAddress City', $city);
		$this->set('BillAddress State', $state);
		$this->set('BillAddress Province', $province);
		$this->set('BillAddress PostalCode', $postalcode);
		$this->set('BillAddress Country', $country);
		$this->set('BillAddress Note', $note);  
	}
		
	public function setOther($other)
	{
		return $this->set('Other', $other);
	}
	
	public function getOther()
	{
		return $this->get('Other');
	}
		
	/**
	 * 
	 * 
	 * @return boolean
	 */
	protected function _cleanup()
	{
		
		return true;
	}
	
	public function asList($request)
	{
		switch ($request)
		{
			case 'SalesReceiptAddRq':
				
				if (isset($this->_object['SalesReceiptLine']))
				{
					$this->_object['SalesReceiptLineAdd'] = $this->_object['SalesReceiptLine'];
				}
				
				if (isset($this->_object['ShippingLine']))
				{
					$this->_object['ShippingLineAdd'] = $this->_object['ShippingLine'];
				}				

				if (isset($this->_object['SalesTaxLine']))
				{
					$this->_object['SalesTaxLineAdd'] = $this->_object['SalesTaxLine'];
				}				

				if (isset($this->_object['DiscountLine']))
				{
					$this->_object['DiscountLineAdd'] = $this->_object['DiscountLine'];
				}				
				
				break;
			case 'SalesReceiptModRq':
				
				if (isset($this->_object['SalesReceiptLine']))
				{
					$this->_object['SalesReceiptLineMod'] = $this->_object['SalesReceiptLine'];	
				}
				
				break;
		}
		
		return parent::asList($request);
	}
	
	public function asXML($root = null, $parent = null, $object = null)
	{
		//print('INVOICE got called asXML: ' . $root . ', ' . $parent . "\n");
		//print('sales receipt got called as: {' . $root . '}, {' . QUICKBOOKS_ADD_SALESRECEIPT . "}\n");
		//exit;
		
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		switch ($root)
		{
			case QUICKBOOKS_ADD_SALESRECEIPT:
				
				//if (isset($this->_object['InvoiceLine']))
				//{
				//	$this->_object['InvoiceLineAdd'] = $this->_object['InvoiceLine'];
				//}
				
				foreach ($object['SalesReceiptLineAdd'] as $key => $obj)
				{
					$obj->setOverride('SalesReceiptLineAdd');
				}
			
				if (!empty($object['ShippingLineAdd']))
				{
					foreach ($object['ShippingLineAdd'] as $key => $obj)
					{
						$obj->setOverride('ShippingLineAdd');
					}
				}
				
				if (!empty($object['DiscountLineAdd']))
				{
					foreach ($object['DiscountLineAdd'] as $key => $obj)
					{
						$obj->setOverride('DiscountLineAdd');
					}
				}
				
				if (!empty($object['SalesTaxLineAdd']))
				{
					foreach ($object['SalesTaxLineAdd'] as $key => $obj)
					{
						$obj->setOverride('SalesTaxLineAdd');
					}
				}
				
				break;
			case QUICKBOOKS_MOD_SALESRECEIPT:
				if (isset($object['SalesReceiptLine']))
				{
					$object['SalesReceiptLineMod'] = $object['SalesReceiptLine'];
				}
				break;
		}
		
		//print_r($this->_object);
		
		return parent::asXML($root, $parent, $object);
	}
	
	/**
	 * 
	 */
	public function asArray($request, $nest = true)
	{
		$this->_cleanup();
		
		return parent::asArray($request, $nest);
	}
	
	/**
	 * 
	 * 
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent
	 * @param string $root
	 * @return string
	 */
	public function asQBXML($request, $version = null, $locale = null, $root = null, $parent = null)
	{
		$this->_cleanup();
		
		return parent::asQBXML($request, $version, $locale, $root);
	}
	
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_SALESRECEIPT;
	}
}
