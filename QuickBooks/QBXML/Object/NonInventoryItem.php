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
	
	public function setSalesTaxCodeListID($ListID)
	{
		return $this->set('SalesTaxCodeRef ListID', $ListID);
	}
	
	public function setSalesTaxCodeName($name)
	{
		return $this->set('SalesTaxCodeRef FullName', $name);
	}
	
	public function setSalesTaxCodeApplicationID($value)
	{
		return $this->set('SalesTaxCodeRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SALESTAXCODE, QUICKBOOKS_LISTID, $value));
	}
	
	public function getSalesTaxCodeListID()
	{
		return $this->get('SalesTaxCodeRef ListID');
	}
	
	public function getSalesTaxCodeName()
	{
		return $this->get('SalesTaxCodeRef FullName');
	}
	
	
	/**
	 * Set the active status of this item
	 *
	 * @param boolean $active
	 * @return boolean
	 */
	public function setIsActive($active)
	{
		if (strtolower($active) == 'true' or 
			(is_bool($active) and $active))
		{
			return $this->set('IsActive', 'true');
		}
		
		return $this->set('IsActive', 'false');
	}
	
	public function getIsActive()
	{
		$active = $this->get('IsActive');
		
		return strtolower($active) == 'true' or 
			(is_bool($active) and $active);
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
		$this->set('SalesOrPurchaseMod Desc', $descrip);
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
		$this->remove('SalesOrPurchaseMod PricePercent');
		
		$this->set('SalesOrPurchaseMod Price', sprintf('%01.2f', (float) $price));
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
		$this->remove('SalesOrPurchaseMod Price');
		
		$this->set('SalesOrPurchaseMod PricePercent', $percent);
		return $this->set('SalesOrPurchase PricePercent', $percent);
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
		$this->set('SalesOrPurchaseMod AccountRef ListID', $ListID);
		return $this->set('SalesOrPurchase AccountRef ListID', $ListID);
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function setAccountName($name)
	{
		$this->set('SalesOrPurchaseMod AccountRef FullName', $name);
		return $this->set('SalesOrPurchase AccountRef FullName', $name);
	}
	
	public function setAccountFullName($name)
	{
		$this->set('SalesOrPurchaseMod AccountRef FullName', $name);
		return $this->set('SalesOrPurchase AccountRef FullName', $name);
	}
	
	/**
	 * (Sales OR Purchase)
	 */
	public function setAccountApplicationID($value)
	{
		$this->set('SalesOrPurchaseMod AccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
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
		$this->set('SalesAndPurchaseMod SalesDesc', $descrip);
		return $this->set('SalesAndPurchase SalesDesc', $descrip);
	}
	
	public function getSalesDescription()
	{
		return $this->get('SalesAndPurchase SalesDesc');
	}
	
	public function setSalesPrice($price)
	{
		$this->set('SalesAndPurchaseMod SalesPrice', sprintf('%01.2f', (float) $price));
		return $this->set('SalesAndPurchase SalesPrice', sprintf('%01.2f', (float) $price));
	}
	
	public function getSalesPrice()
	{
		return $this->get('SalesAndPurchase SalesPrice');
	}
	
	public function setIncomeAccountListID($ListID)
	{
		$this->set('SalesAndPurchaseMod IncomeAccountRef ListID', $ListID);
		return $this->set('SalesAndPurchase IncomeAccountRef ListID', $ListID);
	}
	
	public function getIncomeAccountListID()
	{
		return $this->get('SalesAndPurchase IncomeAccountRef ListID');
	}
	
	public function setIncomeAccountName($name)
	{
		$this->set('SalesAndPurchaseMod IncomeAccountRef FullName', $name);
		return $this->set('SalesAndPurchase IncomeAccountRef FullName', $name);
	}

	public function getIncomeAccountFullName()
	{
		return $this->get('SalesAndPurchase IncomeAccountRef FullName');
	}
	
	/**
	 * @deprecated
	 */
	public function getIncomeAccountName()
	{
		return $this->get('SalesAndPurchase IncomeAccountRef FullName');
	}
	
	public function setIncomeAccountApplicationID($value)
	{
		$this->set('SalesAndPurchaseMod IncomeAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
		return $this->set('SalesAndPurchase IncomeAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	public function getIncomeAccountApplicationID()
	{
		return $this->get('SalesAndPurchase IncomeAccountRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function setPurchaseDescription($descrip)
	{
		$this->set('SalesAndPurchaseMod PurchaseDesc', $descrip);
		return $this->set('SalesAndPurchase PurchaseDesc', $descrip);
	}
	
	public function getPurchaseDescription()
	{
		return $this->get('SalesAndPurchase PurchaseDesc');
	}
	
	public function setPurchaseCost($cost)
	{
		$this->set('SalesAndPurchaseMod PurchaseCost', sprintf('%01.2f', (float) $cost));
		return $this->set('SalesAndPurchase PurchaseCost', sprintf('%01.2f', (float) $cost));
	}
	
	public function getPurchaseCost()
	{
		return $this->get('SalesAndPurchase PurchaseCost');
	}
	
	public function setExpenseAccountListID($ListID)
	{
		$this->set('SalesAndPurchaseMod ExpenseAccountRef ListID', $ListID);
		return $this->set('SalesAndPurchase ExpenseAccountRef ListID', $ListID);
	}
	
	public function setExpenseAccountName($name)
	{
		$this->set('SalesAndPurchaseMod ExpenseAccountRef FullName', $name);
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
	public function asQBXML($request, $version = null, $locale = null, $root = null)
	{
		$this->_cleanup();
		
		return parent::asQBXML($request, $version, $locale, $root);
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
