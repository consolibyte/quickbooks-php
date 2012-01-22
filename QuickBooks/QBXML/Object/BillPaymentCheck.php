<?php

/**
 * QuickBooks ReceivePayment object container
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * Base object class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 * Dependency class (applied payment)
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/BillPaymentCheck/AppliedToTxn.php');

/**
 * QuickBooks ReceivePayment object 
 */
class QuickBooks_QBXML_Object_BillPaymentCheck extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_ReceivePayment object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Set the TxnID of the Class
	 * 
	 * @param string $TxnID
	 * @return boolean
	 */
	public function setTxnID($TxnID)
	{
		return $this->set('TxnID', $TxnID);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_ReceivePayment::setTxnID()}
	 */
	public function setTransactionID($TxnID)
	{
		return $this->setTxnID($TxnID);
	}
	
	/**
	 * Get the ListID of the Class
	 * 
	 * @return string
	 */
	public function getTxnID()
	{
		return $this->get('TxnID');
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_ReceivePayment::getTxnID()}
	 */
	public function getTransactionID()
	{
		return $this->getTxnID();
	}
	
	/**
	 * Set the customer ListID
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setPayeeEntityListID($ListID)
	{
		return $this->set('PayeeEntityRef ListID' , $ListID);
	}
	
	/**
	 * Set the customer ApplicationID (auto-replaced by the API with a ListID)
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	public function setPayeeEntityApplicationID($value)
	{
		return $this->set('PayeeEntityRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_VENDOR, QUICKBOOKS_LISTID, $value));
	}
	
	
	public function getPayeeEntityApplicationID()
	{
		return $this->get('PayeeEntityRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	/**
	 * Set the customer name
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setPayeeEntityFullName($name)
	{
		return $this->set('PayeeEntityRef FullName', $name);
	}
	
	/**
	 * Get the customer ListID
	 * 
	 * @return string
	 */
	public function getPayeeEntityListID()
	{
		return $this->get('PayeeEntityRef ListID');
	}
	
	/**
	 * Get the customer name
	 * 
	 * @return string
	 */
	public function getPayeeEntityFullName()
	{
		return $this->get('PayeeEntityRef FullName');
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
	 * @return string
	 */
	public function getTxnDate($format = 'Y-m-d')
	{
		return $this->getDateType('TxnDate');
	}
	
	public function setIsToBePrinted($bool)
	{
		return $this->setBooleanType('IsToBePrinted', $bool);
	}
	
	public function getIsToBePrinted()
	{
		return $this->getBooleanType('IsToBePrinted');
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
	
	/**
	 * Alias of {@link QuickBooks_Object_ReceivePayment::addAppliedToTxn()}
	 */
	public function addAppliedToTransaction($obj)
	{
		return $this->addAppliedToTxn($obj);
	}
	
	/**
	 * 
	 * 
	 */
	public function addAppliedToTxn($obj)
	{
		/*
		$lines = $this->get('AppliedToTxn');
		
		if (!is_array($lines))
		{
			$lines = array();
		}
		
		//
		$lines[] = $obj;
		
		return $this->set('AppliedToTxn', $lines);*/
		
		return $this->addListItem('AppliedToTxn', $obj);
	}
	
	/**
	 * Alias of {@link QuickBooks_Object_Invoice::getTxnDate()}
	 */
	public function getTransactionDate($format = 'Y-m-d')
	{
		return $this->getDateType('TxnDate', $format);
	}
	
	/**
	 * Set the total amount of the received payment
	 * 
	 * @param float $amount
	 * @return boolean
	 */
	public function setTotalAmount($amount)
	{
		return $this->setAmountType('TotalAmount', $amount);
	}
	
	/**
	 * Get the total amount of the received payment
	 * 
	 * @return float
	 */
	public function getTotalAmount()
	{
		return $this->getAmountType('TotalAmount');
	}
	
	public function setAPAccountListID($ListID)
	{
		return $this->set('APAccountRef ListID', $ListID);
	}
	
	public function setAPAccountFullName($name)
	{
		return $this->set('APAccountRef FullName', $name);
	}
	
	public function setAPAccountApplicationID($value)
	{
		return $this->set('APAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getAPAccountApplicationID()
	{
		return $this->get('APAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getAPAccountListID()
	{
		return $this->get('APAccountRef ListID');
	}
	
	public function getAPAccountFullName()
	{
		return $this->get('APAccountRef FullName');
	}
		
	public function setBankAccountListID($ListID)
	{
		return $this->set('BankAccountRef ListID', $ListID);
	}
	
	public function setBankAccountFullName($name)
	{
		return $this->set('BankAccountRef FullName', $name);
	}
	
	public function setBankAccountApplicationID($value)
	{
		return $this->set('BankAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getBankAccountApplicationID()
	{
		return $this->get('BankAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getBankAccountListID()
	{
		return $this->get('BankAccountRef ListID');
	}
	
	public function getBankAccountFullName()
	{
		return $this->get('BankAccountRef FullName');
	}
	
	public function setMemo($memo)
	{
		return $this->set('Memo', $memo);
	}
	
	public function getMemo()
	{
		return $this->get('Memo');
	}
		
	/**
	 * Perform any needed clean-up of the object data members
	 * 
	 * @return boolean
	 */
	protected function _cleanup()
	{
		return true;
	}
	
	/**
	 * Get an array representation of this Class object
	 * 
	 * @param string $request
	 * @param boolean $nest
	 * @return array
	 */
	/*public function asArray($request, $nest = true)
	{
		$this->_cleanup();
		
		return parent::asArray($request, $nest);
	}*/
	
	public function asList($request)
	{
		switch ($request)
		{
			case 'BillPaymentCheckAddRq':
				
				if (isset($this->_object['AppliedToTxn']))
				{
					$this->_object['AppliedToTxnAdd'] = $this->_object['AppliedToTxn'];
				}
				
				break;
			case 'BillPaymentCheckModRq':
				
				if (isset($this->_object['AppliedToTxn']))
				{
					$this->_object['AppliedToTxnMod'] = $this->_object['AppliedToTxn'];	
				}
				
				break;
		}
		
		return parent::asList($request);
	}
	
	public function asXML($root = null, $parent = null, $object = null)
	{
		if (is_null($object))
		{
			$object = $this->_object;
		}
				
		switch ($root)
		{
			case QUICKBOOKS_ADD_BILLPAYMENTCHECK:
				
				/*
				if (isset($this->_object['AppliedToTxn']))
				{
					$this->_object['AppliedToTxnAdd'] = $this->_object['AppliedToTxn'];
				}
				*/
				
				if ($this->exists('AppliedToTxnAdd'))
				{
					foreach ($object['AppliedToTxnAdd'] as $key => $obj)
					{
						$obj->setOverride('AppliedToTxnAdd');
					}
				}
				
				break;
			case QUICKBOOKS_MOD_BILLPAYMENTCHECK:
				
				// finish me!
				
				break;
		}
		
		return parent::asXML($root, $parent, $object);
	}
	
	/**
	 * Convert this object to a valid qbXML request
	 * 
	 * @param string $request					The type of request to convert this to (examples: CustomerAddRq, CustomerModRq, CustomerQueryRq)
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent
	 * @param string $root
	 * @return string
	 */
	/*
	public function asQBXML($request, $todo_for_empty_elements = QUICKBOOKS_OBJECT_XML_DROP, $indent = "\t", $root = null)
	{
		$this->_cleanup();
		
		return parent::asQBXML($request, $todo_for_empty_elements, $indent, $root);
	}
	*/
	
	/**
	 * Tell what type of object this is 
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_BILLPAYMENTCHECK;
	}
}
