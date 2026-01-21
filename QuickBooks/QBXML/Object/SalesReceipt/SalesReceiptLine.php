<?php

/**
 * 
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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/SalesReceipt.php');

/**
 * 
 * 
 */
class QuickBooks_QBXML_Object_SalesReceipt_SalesReceiptLine extends QuickBooks_QBXML_Object
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
	
	/**
	 * Set the Item ListID for this InvoiceLine
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setItemListID($ListID)
	{
		return $this->set('ItemRef ListID', $ListID);
	}
	
	/** 
	 * Set the item application ID for this invoice line 
	 * 
	 * @param mixed $value
	 * @return boolean
	 */
	public function setItemApplicationID($value)
	{
		return $this->set('ItemRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ITEM, QUICKBOOKS_LISTID, $value));
	}
	
	/**
	 * Set the item name for this invoice line
	 * @deprecated
	 * @param string $name
	 * @return boolean
	 */
	public function setItemName($name)
	{
		return $this->set('ItemRef FullName', $name);
	}
	
	public function setItemFullName($FullName)
	{
		return $this->setFullNameType('ItemRef FullName', null, null, $FullName);
	}
	
	/**
	 * Get the ListID for this item
	 * 
	 * @return string
	 */
	public function getItemListID()
	{
		return $this->get('ItemRef ListID');
	}
	
	/**
	 * Get the item application ID
	 * 
	 * @return mixed
	 */
	public function getItemApplicationID()
	{
		//print($this->get('ItemRef ' . QUICKBOOKS_API_APPLICATIONID) . '<br />');
		
		return $this->extractApplicationID($this->get('ItemRef ' . QUICKBOOKS_API_APPLICATIONID));
	}
	
	/**
	 * Get the name of the item for this invoice line item
	 * @deprecated
	 * @return string
	 */
	public function getItemName()
	{
		return $this->get('ItemRef FullName');
	}
	
	public function getItemFullName()
	{
		return $this->get('ItemRef FullName');
	}
	
	public function setDesc($descrip)
	{
		return $this->set('Desc', $descrip);	
	}
	
	public function setDescription($descrip)
	{
		return $this->setDesc($descrip);
	}
	
	public function setQuantity($quan)
	{
		return $this->set('Quantity', (float) $quan);
	}
	
	public function setRate($rate)
	{
		return $this->set('Rate', sprintf('%01.2f', (float) $rate));
	}
	
	public function setAmount($amount)
	{
		return $this->setAmountType('Amount', $amount);
	}
	
	public function setUnitOfMeasure($uom)
	{
		return $this->set('UnitOfMeasure', $uom);
	}
	
	public function getUnitOfMeasure()
	{
		return $this->get('UnitOfMeasure');
	}
			
	public function setTaxable()
	{
		return $this->setSalesTaxCodeName(QUICKBOOKS_TAXABLE);
	}
	
	public function setNonTaxable()
	{
		return $this->setSalesTaxCodeName(QUICKBOOKS_NONTAXABLE);
	}
	
	public function setSalesTaxCodeName($name)
	{
		return $this->setSalesTaxCodeFullName($name);
	}
	
	public function setSalesTaxCodeFullName($FullName)
	{
		return $this->setFullNameType('SalesTaxCodeRef FullName', null, null, $FullName);
	}
	
	public function setSalesTaxCodeListID($ListID)
	{
		return $this->set('SalesTaxCodeRef ListID', $ListID);
	}
	
	public function getSalesTaxCodeName()
	{
		return $this->get('SalesTaxCodeRef FullName');
	}
	
	public function getSalesTaxCodeListID()
	{
		return $this->get('SalesTaxCodeRef ListID');
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
			case QUICKBOOKS_ADD_SALESRECEIPT:
				$root = 'SalesReceiptLineAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_SALESRECEIPT:
				$root = 'SalesReceiptLineMod';
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
	/*public function asQBXML($request, $todo_for_empty_elements = QUICKBOOKS_OBJECT_XML_DROP, $indent = "\t", $root = null)
	{
		$this->_cleanup();
		
		
		
		return parent::asQBXML($request, $todo_for_empty_elements, $indent, $root);
	}*/
	
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return 'SalesReceiptLine';
	}
}
