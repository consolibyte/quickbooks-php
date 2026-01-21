<?php

/**
 * QuickBooks InventoryItem object container
 * 
 * @todo Verify the get/set methods on this one... it was copied from NonInventoryItem
 * @todo Add isActive(), getIsActive(), etc. methods
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
class QuickBooks_QBXML_Object_InventoryAssemblyItem extends QuickBooks_QBXML_Object
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
	
	public function setFullName($fullname)
	{
		return $this->setFullNameType('FullName', 'Name', 'ParentRef FullName', $fullname);
	}
	
	public function getFullName()
	{
		return $this->getFullNameType('FullName', 'Name', 'ParentRef FullName');
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
	
	/**
	 * Set the description of this item
	 * 
	 * @param string $descrip
	 * @return boolean
	 */
	public function setSalesDescription($descrip)
	{
		return $this->set('SalesDesc', $descrip);
	}

	public function getSalesDescription()
	{
		return $this->get('SalesDesc');
	}
	
	/**
	 * Set the price for this item
	 * 
	 * @param string $price
	 * @return boolean
	 */
	public function setSalesPrice($price)
	{
		return $this->set('SalesPrice', sprintf('%01.2f', (float) $price));
	}
	
	/**
	 * Get the price for this item
	 */
	public function getSalesPrice()
	{
		return $this->get('SalesPrice');
	}
	
	/**
	 * Set the account ListID for this item
	 * 
	 * @param string $ListID
	 * @return string
	 */
	public function setIncomeAccountListID($ListID)
	{
		return $this->set('IncomeAccountRef ListID', $ListID);
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function setIncomeAccountName($name)
	{
		return $this->set('IncomeAccountRef FullName', $name);
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function setIncomeAccountApplicationID($value)
	{
		return $this->set('IncomeAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getIncomeAccountApplicationID()
	{
		return $this->get('IncomeAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	/**
	 * 
	 */
	public function getIncomeAccountListID()
	{
		return $this->get('IncomeAccountRef ListID');
	}
	
	/**
	 * 
	 */
	public function getIncomeAccountName()
	{
		return $this->get('IncomeAccountRef FullName');
	}
	
	public function setAssetAccountName($name)
	{
		return $this->set('AssetAccountRef FullName', $name);
	}
	
	public function getAssetAccountName()
	{
		return $this->get('AssetAccountRef FullName');
	}
	
	public function setAssetAccountListID($ListID)
	{
		return $this->set('AssetAccountRef ListID', $ListID);
	}
	
	public function getAssetAccountListID()
	{
		return $this->get('AssetAccountRef ListID');
	}
	
	public function setAssetAccountApplicationID($value)
	{
		return $this->set('AssetAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getAssetAccountApplicationID()
	{
		return $this->get('AssetAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function setPurchaseDescription($desc)
	{
		return $this->set('PurchaseDesc', $desc);
	}
	
	public function getPurchaseDescription()
	{
		return $this->get('PurchaseDesc');
	}
	
	public function setPurchaseCost($cost)
	{
		return $this->set('PurchaseCost', sprintf('%01.2f', (float) $cost));
	}
	
	public function getPurchaseCost()
	{
		return $this->get('PurchaseCost');
	}
	
	public function setCOGSAccountListID($ListID)
	{
		return $this->set('COGSAccountRef ListID', $ListID);
	}
	
	public function setCOGSAccountName($name)
	{
		return $this->set('COGSAccountRef FullName', $name);
	}
	
	public function setCOGSAccountApplicationID($value)
	{
		return $this->set('COGSAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getCOGSAccountApplicationID()
	{
		return $this->get('COGSAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getCOGSAccountListID()
	{
		return $this->get('COGSAccountRef ListID');
	}
	
	public function getCOGSAccountName()
	{
		return $this->get('COGSAccountRef FullName');
	}
	
	public function setPreferredVendorListID($ListID)
	{
		return $this->set('PrefVendorRef ListID', $ListID);
	}
	
	public function setPreferredVendorName($name)
	{
		return $this->set('PrefVendorRef FullName', $name);
	}
	
	public function setPreferredVendorApplicationID($value)
	{
		return $this->set('PrefVendorRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_VENDOR, QUICKBOOKS_LISTID, $value));
	}

	public function getPreferredVendorApplicationID()
	{
		return $this->get('PrefVendorRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getPreferredVendorListID()
	{
		return $this->get('PrefVendorRef ListID');
	}
	
	public function getPreferredVendorName()
	{
		return $this->get('PrefVendorRef FullName');
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
		return QUICKBOOKS_OBJECT_INVENTORYASSEMBLYITEM;
	}
}
