<?php

/**
 * 
 * 
 * @license LICENSE.txt
 * @author Keith Palmer <keith@ConsoliBYTE.com>
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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Invoice.php');

/**
 * 
 * 
 */
class QuickBooks_QBXML_Object_Invoice_DiscountLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks SalesReceipt SalesReceiptLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	public function setAmount($amount)
	{
		$amount = (float) $amount;
		
		// Discount amounts are always negative in QuickBooks 
		if ($amount > 0)
		{
			$amount = $amount * -1.0;
		}
		
		return $this->setAmountType('Amount', $amount);
	}
	
	public function setAccountListID($ListID)
	{
		return $this->set('AccountRef ListID', $ListID);
	}
	
	public function setAccountName($name)
	{
		return $this->set('AccountRef FullName', $name);
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
		switch ($parent)
		{
			case QUICKBOOKS_ADD_INVOICE:
				$root = 'DiscountLineAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_INVOICE:
				$root = 'DiscountLineMod';
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
		return 'DiscountLine';
	}
}
