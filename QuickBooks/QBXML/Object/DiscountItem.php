<?php

/**
 * QuickBooks ServiceItem object container
 * 
 * NOTE: By default, ServiceItems are created as SalesOrPurchase items, and are 
 * thus *NOT* created as SalesAndPurchase items. If you want to create an item 
 * that is sold *and* purchased, you'll need to set the type with the method:
 * 	-> {@link QuickBooks_Object_ServiceItem::isSalesAndPurchase()}
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
class QuickBooks_QBXML_Object_DiscountItem extends QuickBooks_QBXML_Object
{
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Set the ListID for this item
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setListID($ListID)
	{
		return $this->set('ListID', $ListID);
	}
	
	/**
	 * Get the ListID for this item
	 * 
	 * @return string
	 */
	public function getListID()
	{
		return $this->get('ListID');
	}
	
	/**
	 * Set the name for this item
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setName($name)
	{
		return $this->set('Name', $name);
	}
	
	/**
	 * Get the name for this item
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->get('Name');
	}
	
	public function setParentApplicationID($value)
	{
		return $this->set('ParentRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_DISCOUNTITEM, QUICKBOOKS_LISTID, $value));
	}

	public function getParentApplicationID()
	{
		return $this->get('ParentRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function setParentListID($ListID)
	{
		return $this->set('ParentRef ListID', $ListID);
	}
	
	public function getParentListID()
	{
		return $this->get('ParentRef ListID');
	}
	
	public function setParentName($name)
	{
		return $this->set('ParentRef FullName', $name);
	}
	
	public function getParentName()
	{
		return $this->get('ParentRef FullName');
	}
	
	public function setDescription($desc)
	{
		return $this->set('ItemDesc', $desc);
	}
	
	public function getDescription()
	{
		return $this->get('ItemDesc');
	}
	
	public function setSalesTaxCodeName($name)
	{
		return $this->set('SalesTaxCodeRef FullName', $name);
	}
	
	public function getSalesTaxCodeName()
	{
		return $this->get('SalesTaxCodeRef FullName');
	}
	
	/**
	 * Discount rate amount (i.e.: $20 off purchase price)
	 * 
	 * @param float $rate
	 * @return boolean 
	 */
	public function setDiscountRate($rate)
	{
		return $this->set('DiscountRate', (float) $rate);
	}
	
	/**
	 * 
	 */
	public function getDiscountRate()
	{
		return $this->get('DiscountRate');
	}
	
	/**
	 * Discount rate percentage (i.e.: 15% discount)
	 * 
	 * @param float $percent
	 * @return boolean
	 */
	public function setDiscountRatePercent($percent)
	{
		return $this->set('DiscountRatePercent', (float) $percent);
	}
	
	public function getDiscountRatePercent()
	{
		return $this->get('DiscountRatePercent');
	}
	
	public function setAccountApplicationID($value)
	{
		return $this->set('AccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getAccountApplicationID()
	{
		return $this->get('AccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function setAccountListID($ListID)
	{
		return $this->set('AccountRef ListID', $ListID);
	}
	
	public function getAccountListID()
	{
		return $this->get('AccountRef ListID');
	}
	
	public function setAccountName($name)
	{
		return $this->set('AccountRef FullName', $name);
	}
	
	public function getAccountName()
	{
		return $this->get('AccountRef FullName');
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
	 * Tell what type of object this is 
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_DISCOUNTITEM;
	}
}

