<?php

/**
 * QuickBooks NonInventoryItem object container
 * 
 * NOTE: By default, NonInventoryItems are created as SalesOrPurchase items, and are 
 * thus *NOT* created as SalesAndPurchase items. If you want to create an item 
 * that is sold *and* purchased, you'll need to set the type with the method:
 * 	-> {@link QuickBooks_Object_NonInventoryItem::isSalesAndPurchase()}
 * 
 * @todo Verify the get/set methods on this one... it was copied from ServiceItem
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
class QuickBooks_QBXML_Object_NonInventoryItem extends QuickBooks_QBXML_Object
{
	protected $_is_sales_and_purchase;
	
	public function __construct($arr = array(), $is_sales_and_purchase = false)
	{
		parent::__construct($arr);
		
		if (count($this->getArray('SalesAndPurchase')) > 0)
		{
			$is_sales_and_purchase = true;
		}
		
		$this->_is_sales_and_purchase = $is_sales_and_purchase;
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

	public function getUnitOfMeasureSetListID()
	{
		return $this->get('UnitOfMeasureSetRef ListID');
	}
	
	public function getUnitOfMeasureSetFullName()
	{
		return $this->get('UnitOfMeasureSetRef FullName');
	}
	
	/**
	 * Tell (and optionally set) whether or not this item is currently for Sale *and* Purchase
	 * 
	 * @param boolean $enable
	 * @return boolean
	 */
	public function isSalesAndPurchase($enable = null)
	{
		$current = $this->_is_sales_and_purchase;
		
		if (!is_null($enable))
		{
			$this->_is_sales_and_purchase = (boolean) $enable;
		}
		
		return $current;
	}
	
	/**
	 * Tell (and optionall set) whether or not this item is currently for Sale *or* Purchase
	 * 
	 * @param boolean $enable
	 * @return boolean
	 */
	public function isSalesOrPurchase($enable = null)
	{
		$current = !$this->_is_sales_and_purchase;
		
		if (!is_null($enable))
		{
			$this->_is_sales_and_purchase = ! (boolean) $enable;
		} 
		
		return $current;
	}
	
	// Sales OR Purchase
	
	/**
	 * Set the description of this item (Sales OR Purchase)
	 * 
	 * @param string $descrip
	 * @return boolean
	 */
	public function setDescription($descrip)
	{
		return $this->set('SalesOrPurchase Desc', $descrip);
	}

	public function getDescription()
	{
		return $this->get('SalesOrPurchase Desc');
	}
	
	/**
	 * Set the price for this item (Sales OR Purchase)
	 * 
	 * @param string $price
	 * @return boolean
	 */
	public function setPrice($price)
	{
		$this->remove('SalesOrPurchase PricePercent');
		
		return $this->set('SalesOrPurchase Price', sprintf('%01.2f', (float) $price));
	}
	
	/**
	 * Get the price for this item (Sales OR Purchase)
	 */
	public function getPrice()
	{
		return $this->get('SalesOrPurchase Price');
	}
	
	/**
	 * Set the price percent for this item (Sales OR Purchase)
	 */
	public function setPricePercent($percent)
	{
		$this->remove('SalesOrPurchase Price');
		
		return $this->set('SalesOrPurchase PricePercent', (float) $percent);
	}
	
	/**
	 * Get the price percent for this item (Sales OR Purchase)
	 */
	public function getPricePercent()
	{
		return $this->get('SalesOrPurchase PricePercent');
	}
	
	/**
	 * Set the account ListID for this item (Sales OR Purchase)
	 * 
	 * @param string $ListID
	 * @return string
	 */
	public function setAccountListID($ListID)
	{
		return $this->set('SalesOrPurchase AccountRef ListID', $ListID);
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function setAccountName($name)
	{
		return $this->set('SalesOrPurchase AccountRef FullName', $name);
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function setAccountApplicationID($value)
	{
		return $this->set('SalesOrPurchase AccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getAccountApplicationID()
	{
		return $this->get('SalesOrPurchase AccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function getAccountListID()
	{
		return $this->get('SalesOrPurchase AccountRef ListID');
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function getAccountName()
	{
		return $this->get('SalesOrPurchase AccountRef FullName');
	}
	
	// Sales AND Purchase
	
	public function setSalesDescription($descrip)
	{
		return $this->set('SalesAndPurchase SalesDesc', $descrip);
	}
	
	public function getSalesDescription()
	{
		return $this->get('SalesAndPurchase SalesDesc');
	}
	
	public function setSalesPrice($price)
	{
		return $this->set('SalesAndPurchase SalesPrice', sprintf('%01.2f', (float) $price));
	}
	
	public function getSalesPrice()
	{
		return $this->get('SalesAndPurchase SalesPrice');
	}
	
	public function setIncomeAccountListID($ListID)
	{
		return $this->set('SalesAndPurchase IncomeAccountRef ListID', $ListID);
	}
	
	public function getIncomeAccountListID()
	{
		return $this->get('SalesAndPurchase IncomeAccountRef ListID');
	}
	
	public function setIncomeAccountName($name)
	{
		return $this->set('SalesAndPurchase IncomeAccountRef FullName', $name);
	}
	
	public function getIncomeAccountName()
	{
		return $this->get('SalesAndPurchase IncomeAccountRef FullName');
	}
	
	public function setIncomeAccountApplicationID($value)
	{
		return $this->set('SalesAndPurchase IncomeAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getIncomeAccountApplicationID()
	{
		return $this->get('SalesAndPurchase IncomeAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function setPurchaseDescription($descrip)
	{
		return $this->set('SalesAndPurchase PurchaseDesc', $descrip);
	}
	
	public function getPurchaseDescription()
	{
		return $this->get('SalesAndPurchase PurchaseDesc');
	}
	
	public function setPurchaseCost($cost)
	{
		return $this->set('SalesAndPurchase PurchaseCost', sprintf('%01.2f', (float) $cost));
	}
	
	public function getPurchaseCost()
	{
		return $this->get('SalesAndPurchase PurchaseCost');
	}
	
	public function setExpenseAccountListID($ListID)
	{
		return $this->set('SalesAndPurchase ExpenseAccountRef ListID', $ListID);
	}
	
	public function setExpenseAccountName($name)
	{
		return $this->set('SalesAndPurchase ExpenseAccountRef FullName', $name);
	}
	
	public function setExpenseAccountApplicationID($value)
	{
		return $this->set('SalesAndPurchase ExpenseAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getExpenseAccountApplicationID()
	{
		return $this->get('SalesAndPurchase ExpenseAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getExpenseAccountListID()
	{
		return $this->get('SalesAndPurchase ExpenseAccountRef ListID');
	}
	
	public function getExpenseAccountName()
	{
		return $this->get('SalesAndPurchase ExpenseAccountRef FullName');
	}
	
	public function setPreferredVendorListID($ListID)
	{
		return $this->set('SalesAndPurchase PrefVendorRef ListID', $ListID);
	}
	
	public function setPreferredVendorName($name)
	{
		return $this->set('SalesAndPurchase PrefVendorRef FullName', $name);
	}
	
	public function setPreferredVendorApplicationID($value)
	{
		return $this->set('SalesAndPurchase PrefVendorRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_VENDOR, QUICKBOOKS_LISTID, $value));
	}

	public function getPreferredVendorApplicationID()
	{
		return $this->get('SalesAndPurchase PrefVendorRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getPreferredVendorListID()
	{
		return $this->get('SalesAndPurchase PrefVendorRef ListID');
	}
	
	public function getPreferredVendorName()
	{
		return $this->get('SalesAndPurchase PrefVendorRef FullName');
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	protected function _cleanup()
	{
		if ($this->isSalesAndPurchase())
		{
			// Remove any SalesOrPurchase keys
			
			foreach ($this->getArray('SalesOrPurchase*') as $key => $value)
			{
				$this->remove($key);
			}
		}
		else
		{
			foreach ($this->getArray('SalesAndPurchase*') as $key => $value)
			{
				$this->remove($key);
			}
		}
		
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
		return QUICKBOOKS_OBJECT_NONINVENTORYITEM;
	}
}

?>
