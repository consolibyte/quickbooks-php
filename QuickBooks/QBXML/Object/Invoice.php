<?php

/**
 * QuickBooks Invoice object container
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
 * Used for some InvoiceLine conversions
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Generic.php');

/**
 * Invoice lines for Invoices
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Invoice/InvoiceLine.php');

/**
 * Sales Receipt discount line item
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Invoice/DiscountLine.php');

/**
 * Sales Receipt shipping line item
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Invoice/ShippingLine.php');

/**
 * Sales Receipt sales tax line item
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Invoice/SalesTaxLine.php');

/**
 * QuickBooks Invoice class definition
 */
class QuickBooks_QBXML_Object_Invoice extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks Invoice object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_Invoice::setTxnID()}
	 */
	public function setTransactionID($TxnID)
	{
		return $this->setTxnID($TxnID);
	}
	
	/**
	 * Set the transaction ID of the Invoice object
	 * 
	 * @param string $TxnID
	 * @return boolean
	 */
	public function setTxnID($TxnID)
	{
		return $this->set('TxnID', $TxnID);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_Invoice::getTxnID()}
	 */
	public function getTransactionID()
	{
		return $this->getTxnID();
	}
	
	/**
	 * Get the transaction ID for this invoice
	 * 
	 * @return string
	 */
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
	public function setCustomerFullName($name)
	{
		return $this->set('CustomerRef FullName', $name);
	}

	/**
	 * @deprecated
	 */
	public function setCustomerName($name)
	{
		return $this->set('CustomerRef FullName', $name);
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
	 * Get the customer application ID
	 * 
	 * @return mixed
	 */
	public function getCustomerApplicationID()
	{
		return $this->extractApplicationID($this->get('CustomerRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	/**
	 * Get the customer name
	 * 
	 * @return string
	 */
	public function getCustomerFullName()
	{
		return $this->get('CustomerRef FullName');
	}

	/**
	 * @deprecated
	 */
	public function getCustomerName()
	{
		return $this->get('CustomerRef FullName');
	}
		
	/** 
	 * Set the class ListID for this invoice
	 * 
	 * @param string $ListID
	 * @return boolean
	 */ 
	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}
	
	/**
	 * Set the class application ID
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	public function setClassApplicationID($value)
	{
		return $this->set('ClassRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CLASS, QUICKBOOKS_LISTID, $value));
	}
	
	public function setClassName($name)
	{
		return $this->set('ClassRef FullName', $name);
	}
	
	public function getClassName()
	{
		return $this->get('ClassRef FullName');
	}
	
	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}
	
	/*
	public function getClassApplicationID()
	{
		return $this->extractApplicationID($this->get('ClassRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	public function setARAccountApplicationID($value)
	{
		return $this->set('ARAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}*/
	
	public function setARAccountListID($ListID)
	{
		return $this->set('ARAccountRef ListID', $ListID);
	}
	
	public function setARAccountName($name)
	{
		return $this->set('ARAccountRef FullName', $name);
	}
	
	public function getARAccountListID()
	{
		return $this->get('ARAccountRef ListID');
	}
	
	public function getARAccountName()
	{
		return $this->get('ARAccountRef FullName');
	}
	
	/**
	 * Get the ARAccount application ID
	 * 
	 * @return value
	 */
	public function getARAccountApplicationID()
	{
		return $this->extractApplicationID($this->get('ARAccountRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	public function setTemplateApplicationID($value)
	{
		return $this->set('TemplateRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_TEMPLATE, QUICKBOOKS_LISTID, $value));
	}
	
	public function setTemplateName($name)
	{
		return $this->set('TemplateRef FullName', $name);
	}
	
	public function setTemplateListID($ListID)
	{
		return $this->set('TemplateRef ListID', $ListID);
	}
	
	public function getTemplateName()
	{
		return $this->get('TemplateRef FullName');
	}
	
	public function getTemplateListID()
	{
		return $this->get('TemplateRef ListID');
	}
	
	/**
	 * Get the template application ID
	 * 
	 * @return value
	 */
	public function getTemplateApplicationID()
	{
		return $this->extractApplicationID($this->get('TemplateRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	/**
	 * Set the transaction date
	 * 
	 * @param string $date
	 * @return boolean
	 */
	public function setTxnDate($date)
	{
		return $this->setDateType('TxnDate', $date);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_Invoice::setTxnDate()}
	 */
	public function setTransactionDate($date)
	{
		return $this->setTxnDate($date);
	}
	
	/**
	 * Get the transaction date
	 * 
	 * @param string $format	The format you want the date in (as for {@link http://www.php.net/date})
	 * @return string
	 */
	public function getTxnDate($format = 'Y-m-d')
	{
		//return date($format, strtotime($this->get('TxnDate')));
		return $this->getDateType('TxnDate', $format);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_Invoice::getTxnDate()}
	 */
	public function getTransactionDate()
	{
		return $this->getTxnDate($format);
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
	 * Alias of {@link QuickBooks_Object_Invoice::setRefNumber()}
	 */
	public function setReferenceNumber($str)
	{
		return $this->setRefNumber($str);
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

	/**
	 * Alias of {@link QuickBooks_Object_Invoice::getRefNumber()}
	 */
	public function getReferenceNumber()
	{
		return $this->getRefNumber();
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
	
	public function setPONumber($num)
	{
		return $this->set('PONumber', $num);
	}
	
	public function getPONumber()
	{
		return $this->get('PONumber');
	}
	
	public function setTermsListID($ListID)
	{
		return $this->set('TermsRef ListID', $ListID);
	}
	
	public function setTermsApplicationID($value)
	{
		return $this->set('TermsRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_TERMS, QUICKBOOKS_LISTID, $value));
	}
	
	public function setTermsName($name)
	{
		return $this->set('TermsRef FullName', $name);
	}
	
	public function getTermsName()
	{
		return $this->get('TermsRef FullName');
	}
	
	public function getTermsListID()
	{
		return $this->get('TermsRef ListID');
	}
	
	/**
	 * Get the terms application ID for this invoice
	 * 
	 * @return value
	 */
	public function getTermsApplicationID()
	{
		return $this->extractApplicationID($this->get('TermsRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	/**
	 * Set the due date for the invoice
	 * 
	 * @param string $date
	 * @return boolean
	 */
	public function setDueDate($date)
	{
		//return $this->set('DueDate', date('Y-m-d', strtotime($date)));
		return $this->setDateType('DueDate', $date);
	}
	
	/**
	 * Get the due date for the invoice
	 * 
	 * @param string $format	The format to return the date in (as for {@link http://www.php.net/date})
	 * @return string
	 */
	public function getDueDate($format = 'Y-m-d')
	{
		//return date($format, strtotime($this->get('DueDate')));
		return $this->getDateType('DueDate', $format);
	}
	
	public function setSalesRepName($name)
	{
		return $this->set('SalesRepRef FullName', $name);
	}
	
	public function setSalesRepListID($ListID)
	{
		return $this->set('SalesRepRef ListID', $ListID);
	}
	
	public function setSalesRepApplicationID($value)
	{
		return $this->set('SalesRepRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_EMPLOYEE, QUICKBOOKS_LISTID, $value));
	}
	
	public function getSalesRepName()
	{
		return $this->get('SalesRepRef FullName');
	}
	
	public function getSalesRepListID()
	{
		return $this->get('SalesRepRef ListID');
	}
	
	public function getSalesRepApplicationID()
	{
		return $this->extractApplicationID($this->get('SalesRepRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	public function getFOB()
	{
		return $this->get('FOB');
	}
	
	public function setFOB($fob)
	{
		return $this->set('FOB', $fob);
	}
	
	public function setShipDate($date)
	{
		//return $this->set('ShipDate', date('Y-m-d', strtotime($date)));
		return $this->setDateType('ShipDate', $date);
	}
	
	public function getShipDate($format = 'Y-m-d')
	{
		/*
		if ($this->exists('ShipDate'))
		{
			return date($format, strtotime($this->get('ShipDate')));
		}
		
		return null;
		*/
		
		return $this->getDateType('ShipDate', $format);
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
	 * Get the ship method application ID
	 * 
	 * @return value
	 */
	public function getShipMethodApplicationID()
	{
		return $this->extractApplicationID($this->get('ShipMethodRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	/**
	 * Set the application ID for the payment method
	 * 
	 * @param mixed $value		The payment method primary key from your application
	 * @return 					boolean
	 */
	public function setPaymentMethodApplicationID($value)
	{
		return $this->set('PaymentMethodRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_PAYMENTMETHOD, QUICKBOOKS_LISTID, $value));
	}
	
	public function setPaymentMethodName($name)
	{
		return $this->set('PaymentMethodRef FullName', $name);
	}
	
	public function setPaymentMethodListID($ListID)
	{
		return $this->set('PaymentMethodRef ListID', $ListID);
	}
	
	public function getPaymentMethodName()
	{
		return $this->get('PaymentMethodRef FullName');
	}
	
	public function getPaymentMethodListID()
	{
		return $this->get('PaymentMethodRef ListID');
	}
	
	/**
	 * Get the payment method application ID
	 * 
	 * @return value
	 */
	public function getPaymentMethodApplicationID()
	{
		return $this->extractApplicationID($this->get('PaymentMethodRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	public function setSalesTaxItemListID($ListID)
	{
		return $this->set('ItemSalesTaxRef ListID', $ListID);
	}
	
	public function setSalesTaxItemApplicationID($value)
	{
		return $this->set('ItemSalesTaxRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SALESTAXITEM, QUICKBOOKS_LISTID, $value));
	}

	public function getSalesTaxItemApplicationID()
	{
		return $this->get('ItemSalesTaxRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	/**
	 * @deprecated
	 */
	public function setSalesTaxItemName($name)
	{
		return $this->set('ItemSalesTaxRef FullName', $name);
	}

	public function setSalesTaxItemFullName($name)
	{
		return $this->set('ItemSalesTaxRef FullName', $name);
	}
	
	public function getSalesTaxItemName()
	{
		return $this->get('ItemSalesTaxRef FullName');
	}
	
	public function getSalesTaxItemListID()
	{
		return $this->get('ItemSalesTaxRef ListID');
	}
	
	public function setMemo($memo)
	{
		return $this->set('Memo', $memo);
	}
	
	public function getMemo()
	{
		return $this->get('Memo');
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
	
	public function setCustomerSalesTaxCodeListID()
	{
		
	}
	
	public function setCustomerSalesTaxCodeName()
	{
		
	}
	
	public function getCustomerSalesTaxCodeListID()
	{
		
	}
	
	public function getCustomerSalesTaxCodeName()
	{
		
	}
	
	public function setLinkToTxnID($TxnID)
	{
		return $this->set('LinkToTxnID', $TxnID);
	}

	public function getLinkToTxnID()
	{
		return $this->get('LinkToTxnID');
	}
	
	/*
	public function getInvoiceLines()
	{
		return $this->getList('InvoiceLine');
	}
	
	public function getInvoiceLine($which)
	{
		$list = $this->getInvoiceLines();
		
		if (isset($list[$which]))
		{
			return $list[$which];
		}
		
		return null;
	}
	*/
	
	/*
	public function setInvoiceLine($i, 
	{
		
	}
	*/
	
	/**
	 * 
	 * 
	 * @param 
	 */
	public function addInvoiceLine($obj)
	{
		return $this->addListItem('InvoiceLine', $obj);
		
		/*
		$lines = $this->get('InvoiceLine');
		
		//
		$lines[] = $obj;
		
		return $this->set('InvoiceLine', $lines);
		*/
	}
	
	/*
	public function setInvoiceLineData($i, $key, $value)
	{
		$lines = $this->getInvoiceLines();
		if (isset($lines[$i]))
		{
			
		}
		
		return $this->set('InvoiceLine', $lines);
	}
	*/
	
	public function getInvoiceLine($i)
	{
		return $this->getListItem('InvoiceLine', $i);
	}
	
	public function listInvoiceLines()
	{
		return $this->getList('InvoiceLine');
	}
	
	/**
	 * Add a discount line (only supported by Online Edition as of 8.0)
	 * 
	 * @param QuickBooks_Object_Invoice_DiscountLine
	 * @return boolean
	 */
	public function addDiscountLine($obj)
	{
		return $this->addListItem('DiscountLine', $obj);
	}

	/**
	 * Add a sales tax line (only supported by Online Edition as of 8.0)
	 * 
	 * @param QuickBooks_Object_Invoice_SalesTaxLine
	 * @return boolean
	 */
	public function addSalesTaxLine($obj)
	{
		return $this->addListItem('SalesTaxLine', $obj);
	}

	/**
	 * Add a shipping line (only supported by Online Edition as of 8.0)
	 * 
	 * @param QuickBooks_Object_Invoice_ShippingLine
	 * @return boolean
	 */
	public function addShippingLine($obj)
	{
		return $this->addListItem('ShippingLine', $obj);
	}

	/**
	 * 
	 */
	public function setOther($other)
	{
		return $this->set('Other', $other);
	}
	
	public function getOther()
	{
		return $this->get('Other');
	}
	
	public function getBalanceRemaining()
	{
		return $this->getAmountType('BalanceRemaining');
	}
	
	public function setBalanceRemaining($amount)
	{
		return $this->setAmountType('BalanceRemaining', $amount);
	}	
	
	public function getAppliedAmount()
	{
		return $this->getAmountType('AppliedAmount');
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
			case 'InvoiceAddRq':
				
				if (isset($this->_object['InvoiceLine']))
				{
					$this->_object['InvoiceLineAdd'] = $this->_object['InvoiceLine'];
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
			case 'InvoiceModRq':
				
				if (isset($this->_object['InvoiceLine']))
				{
					$this->_object['InvoiceLineMod'] = $this->_object['InvoiceLine'];	
				}
				
				break;
		}
		
		return parent::asList($request);
	}
	
	public function asXML($root = null, $parent = null, $object = null)
	{
		//print('INVOICE got called asXML: ' . $root . ', ' . $parent . "\n");
		//exit;
		
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		switch ($root)
		{
			case QUICKBOOKS_ADD_INVOICE:
				
				//if (isset($this->_object['InvoiceLine']))
				//{
				//	$this->_object['InvoiceLineAdd'] = $this->_object['InvoiceLine'];
				//}
				
				foreach ($object['InvoiceLineAdd'] as $key => $obj)
				{
					$obj->setOverride('InvoiceLineAdd');
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
			case QUICKBOOKS_MOD_INVOICE:
				if (isset($object['InvoiceLine']))
				{
					$object['InvoiceLineMod'] = $object['InvoiceLine'];
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
	public function asQBXML($request, $todo_for_empty_elements = QuickBooks_QBXML_Object::XML_DROP, $indent = "\t", $root = null, $parent = null)
	{
		$this->_cleanup();
		
		return parent::asQBXML($request, $todo_for_empty_elements, $indent, $root);
	}
	
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_INVOICE;
	}
}
