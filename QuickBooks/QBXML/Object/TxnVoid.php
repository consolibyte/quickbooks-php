<?php

/**
 * QuickBooks TxnVoid object container
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
class QuickBooks_QBXML_Object_TxnVoid extends QuickBooks_QBXML_Object
{
	
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Set the transaction ID of the transaction object
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
	 * Set the type of item being voided
	 *
	 * @param string $TxnVoidType
	 * @return boolean
	 */
	public function setTxnVoidType($TxnVoidType)
	{
		return $this->set('TxnVoidType', $TxnVoidType);
	}
	
	public function getTxnVoidType()
	{
		return $this->get('TxnVoidType');
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
	
	/**
	 * Convert this object to a valid qbXML request
	 * 
	 * @param string $request					The type of request to convert this to (examples: CustomerAddRq, CustomerModRq, CustomerQueryRq)
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
		return QUICKBOOKS_VOID_TRANSACTION;
	}
}

?>
