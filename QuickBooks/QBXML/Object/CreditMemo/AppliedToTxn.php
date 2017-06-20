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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/CreditMemo.php');

/**
 * 
 * 
 */
class QuickBooks_QBXML_Object_CreditMemo_AppliedToTxn extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks CreditMemo AppliedToTxn object
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
	
	// jbaldock 2016-11-28 - Added this as the AppliedToTxn object seems to have Amount, not PaymentAmount
	public function getAmount()
	{
		return $this->getAmountType('Amount');
	}
	
	public function setAmount($amount)
	{
		return $this->setAmountType('Amount', $amount);
	}
	
	public function setTxnType($type)
	{
		return $this->set('TxnType', $type);
	}
	
	public function getTxnType()
	{
		return $this->get('TxnType');
	}
	
	public function setTxnDate($txnDate)
	{
		return $this->setDateType('TxnDate', $txnDate);
	}
	
	public function getTxnDate()
	{
		return $this->getDateType('TxnDate');
	}
	
	public function setRefNumber($ref)
	{
		return $this->set('RefNumber', $ref);
	}
	
	public function getRefNumber()
	{
		return $this->get('RefNumber');
	}
	
	public function setLinkType($type)
	{
		return $this->set('RefNumber', $type);
	}
	
	public function getLinkType()
	{
		return $this->get('RefNumber');
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
		
		switch ($parent)
		{
			case QUICKBOOKS_ADD_CREDITMEMO:
				$root = 'AppliedToTxnAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_CREDITMEMO:
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
