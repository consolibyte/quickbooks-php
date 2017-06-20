<?php

/**
 * QuickBooks SetCredit object class
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
 * QuickBooks invoice class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Invoice.php');

/**
 * QuickBooks SetCredit class for Invoices
 */
class QuickBooks_QBXML_Object_Invoice_SetCreditLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks Invoice SetCredit object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	public function getCreditTxnID()
	{
		return $this->get('CreditTxnID');
	}
	
	public function setCreditTxnID($LineID)
	{
		return $this->set('CreditTxnID', $LineID);
	}
	
	/**
	 * Set the AppliedAmount for this SetCredit
	 * 
	 * @param amount $amount
	 * @return boolean
	 */
	public function setAppliedAmount($amount)
	{
		return $this->setAmountType('AppliedAmount', $amount);
	}
	
	/**
	 * Get the AppliedAmount for this SetCredit
	 *
	 * @return boolean
	 */
	public function getAppliedAmount()
	{
		return $this->getAmountType('AppliedAmount');
	}
	
	/**
	 * Set the Override for this SetCredit
	 *
	 * @param boolean $override
	 * @return boolean
	 */
	public function setOverride($override)
	{
		return $this->setBooleanType('Override', $override);
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
		
		$root = "SetCredit";
		$parent = null;
		
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
	public function asQBXML($request, $todo_for_empty_elements = QuickBooks_QBXML_Object::XML_DROP, $indent = "\t", $root = null)
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
		return 'SetCredit';
	}
}
