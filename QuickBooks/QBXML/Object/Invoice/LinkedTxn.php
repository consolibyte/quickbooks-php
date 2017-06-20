<?php

/**
 * QuickBooks LinkedTxn object class
 * This is a read only object that is returned only in the Invoice Response, not something you can set
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
 * QuickBooks LinkedTxn class for Invoices
 */
class QuickBooks_QBXML_Object_Invoice_LinkedTxn extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks Invoice LinkedTxn object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	public function getTxnID()
	{
		return $this->get('TxnID');
	}

	/**
	 * Get the Amount for this LinkedTxn
	 *
	 * @return boolean
	 */
	public function getAmount()
	{
		return $this->getAmountType('Amount');
	}
	
	/**
	 * Get the TxnType for this LinkedTxn
	 *
	 * @return boolean
	 */
	public function getTxnType()
	{
		return $this->get('TxnType');
	}
	
	/**
	 * Get the TxnDate for this LinkedTxn
	 *
	 * @return boolean
	 */
	public function getTxnDate()
	{
		return $this->getDateType('TxnDate');
	}
	
	/**
	 * Get the RefNumber for this LinkedTxn
	 *
	 * @return boolean
	 */
	public function getRefNumber()
	{
		return $this->get('RefNumber');
	}
	
	/**
	 * Get the LinkType for this LinkedTxn
	 *
	 * @return boolean
	 */
	public function getLinkType()
	{
		return $this->get('LinkType');
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
		
		$root = "LinkedTxn";
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
		return 'LinkedTxn';
	}
}
