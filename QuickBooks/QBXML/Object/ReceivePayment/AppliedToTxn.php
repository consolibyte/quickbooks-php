<?php

/**
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/ReceivePayment.php');

/**
 * 
 * 
 */
class QuickBooks_QBXML_Object_ReceivePayment_AppliedToTxn extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks ReceivePayment AppliedToTxn object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	public function setTxnID($TxnID)
	{
		return $this->set('TxnID', $TxnID);
	}
	
	public function setTransactionID($TxnID)
	{
		return $this->setTxnID($TxnID);
	}
	
	public function getTxnID()
	{
		return $this->get('TxnID');
	}
	
	public function getTransactionID()
	{
		return $this->getTxnID();
	}
	
	public function setTxnApplicationID($value)
	{
		return $this->set(QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_INVOICE, QUICKBOOKS_TXNID, $value));
		//return $this->set('NullRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_INVOICE, QUICKBOOKS_TXNID, $value));
	}
	
	public function getTxnApplicationID()
	{
		
	}
	
	public function getPaymentAmount($amount)
	{
		return $this->getAmountType('PaymentAmount');
	}
	
	public function setPaymentAmount($amount)
	{
		return $this->setAmountType('PaymentAmount', $amount);
	}
	
	public function setDiscountAmount($amount)
	{
		return $this->setAmountType('DiscountAmount', $amount);
	}
	
	public function getDiscountAmount()
	{
		return $this->getDiscountAmount('DiscountAmount');
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
	
	/**
	 * 
	 */
	public function asArray($request, $nest = true)
	{
		$this->_cleanup();
		
		return parent::asArray($request, $nest);
	}
	
	public function asXML($root = null, $parent = null, $object = null)
	{
		$this->_cleanup();
		
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		switch ($parent)
		{
			case QUICKBOOKS_ADD_RECEIVEPAYMENT:
				$root = 'AppliedToTxnAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_RECEIVEPAYMENT:
				$root = 'AppliedToTxnMod';
				$parent = null;
				break;
		}
		
		return parent::asXML($root, $parent, $object);
	}
	
	/**
	 * 
	 * 
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent
	 * @param string $root
	 * @return string
	 */
	public function asQBXML($request, $todo_for_empty_elements = QUICKBOOKS_OBJECT_XML_DROP, $indent = "\t", $root = null)
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
		return 'AppliedToTxn';
	}
}
