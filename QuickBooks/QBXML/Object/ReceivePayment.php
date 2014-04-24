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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/ReceivePayment/AppliedToTxn.php');

/**
 * QuickBooks ReceivePayment object 
 */
class QuickBooks_QBXML_Object_ReceivePayment extends QuickBooks_QBXML_Object
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
	
	
	public function getCustomerApplicationID()
	{
		return $this->get('CustomerRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	/**
	 * @deprecated
	 */
	public function setCustomerName($name)
	{
		return $this->set('CustomerRef FullName', $name);
	}
	
	public function setCustomerFullName($name)
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
	 * @deprecated
	 */
	public function getCustomerName()
	{
		return $this->get('CustomerRef FullName');
	}
	
	public function getCustomerFullName()
	{
		return $this->get('CustomerRef FullName');
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
	
	public function getAppliedToTxn($i)
	{
		return $this->getListItem('AppliedToTxn', $i);
	}
	
	public function listAppliedToTxns()
	{
		return $this->getList('AppliedToTxn');
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
	
	public function setARAccountListID($ListID)
	{
		return $this->set('ARAccountRef ListID', $ListID);
	}
	
	/**
	 * @deprecated
	 */
	public function setARAccountName($name)
	{
		return $this->set('ARAccountRef FullName', $name);
	}

	public function setARAccountFullName($name)
	{
		return $this->set('ARAccountRef FullName', $name);
	}
	
	public function setARAccountApplicationID($value)
	{
		return $this->set('ARAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getARAccountApplicationID()
	{
		return $this->get('ARAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getARAccountListID()
	{
		return $this->get('ARAccountRef ListID');
	}
	
	/**
	 * @deprecated
	 */
	public function getARAccountName()
	{
		return $this->get('ARAccountRef FullName');
	}

	public function getARAccountFullName()
	{
		return $this->get('ARAccountRef FullName');
	}
	
	public function setPaymentMethodListID($ListID)
	{
		return $this->set('PaymentMethodRef ListID', $ListID);
	}
	
	/**
	 * @deprecated
	 */
	public function setPaymentMethodName($name)
	{
		return $this->set('PaymentMethodRef FullName', $name);
	}
	
	public function setPaymentMethodFullName($name)
	{
		return $this->set('PaymentMethodRef FullName', $name);
	}
	
	public function setPaymentMethodApplicationID($value)
	{
		return $this->set('PaymentMethodRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_PAYMENTMETHOD, QUICKBOOKS_LISTID, $value));
	}

	public function getPaymentMethodApplicationID()
	{
		return $this->get('PaymentMethodRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getPaymentMethodListID()
	{
		return $this->get('PaymentMethodRef ListID');
	}
	
	/**
	 * @deprecated
	 */
	public function getPaymentMethodName()
	{
		return $this->get('PaymentMethodRef FullName');
	}
	
	public function getPaymentMethodFullName()
	{
		return $this->get('PaymentMethodRef FullName');
	}
	
	public function setDepositToAccountListID($ListID)
	{
		return $this->set('DepositToAccountRef ListID', $ListID);
	}
	
	/**
	 * @deprecated
	 */
	public function setDepositToAccountName($name)
	{
		return $this->set('DepositToAccountRef FullName', $name);
	}
	
	public function setDepositToAccountFullName($name)
	{
		return $this->set('DepositToAccountRef FullName', $name);
	}
	
	public function setDepositToAccountApplicationID($value)
	{
		return $this->set('DepositToAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getDepositToAccountApplicationID()
	{
		return $this->get('DepositToAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getDepositToAccountListID()
	{
		return $this->get('DepositToAccountRef ListID');
	}
	
	/**
	 * @deprecated
	 */
	public function getDepositToAccountName()
	{
		return $this->get('DepositToAccountRef FullName');
	}
	
	public function getDepositToAccountFullName()
	{
		return $this->get('DepositToAccountRef FullName');
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
	 * Set whether or not this transaction is an auto-apply transaction
	 * 
	 * @param boolean $isautoapply
	 * @return boolean
	 */
	public function setIsAutoApply($isautoapply)
	{
		if ($isautoapply and strtolower($isautoapply) != 'false')
		{
			return $this->set('IsAutoApply', 'true');
		}
		else
		{
			return $this->set('IsAutoApply', 'false');
		}
	}

	/**
	 * Get whether or not this transaction is an auto-apply transaction
	 * 
	 * @return boolean
	 */
	public function getIsAutoApply()
	{
		return $this->get('IsAutoApply') != 'false';
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
			case 'ReceivePaymentAddRq':
				
				if (isset($this->_object['AppliedToTxn']))
				{
					$this->_object['AppliedToTxnAdd'] = $this->_object['AppliedToTxn'];
				}
				
				break;
			case 'ReceivePaymentModRq':
				
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
			case QUICKBOOKS_ADD_RECEIVEPAYMENT:

				if ($this->exists('AppliedToTxnAdd'))
				{
					foreach ($object['AppliedToTxnAdd'] as $key => $obj)
					{
						$obj->setOverride('AppliedToTxnAdd');
					}
				}
				
				break;
			case QUICKBOOKS_MOD_RECEIVEPAYMENT:

				if ($this->exists('AppliedToTxnMod'))
				{
					foreach ($object['AppliedToTxnMod'] as $key => $obj)
					{
						$obj->setOverride('AppliedToTxnMod');
					}
				}
				
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
		return QUICKBOOKS_OBJECT_RECEIVEPAYMENT;
	}
}
