<?php

/**
 * QuickBooks InvoiceLine object class
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
 * QuickBooks InvoiceLine class for Invoices
 */
class QuickBooks_QBXML_Object_Invoice_InvoiceLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks Invoice InvoiceLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	public function getTxnLineID()
	{
		return $this->get('TxnLineID');
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
	 * 
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
	 * 
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
	
	public function getDesc()
	{
		return $this->get('Desc');
	}
	
	public function setDescription($descrip)
	{
		return $this->setDesc($descrip);
	}
	
	public function getDescription()
	{
		return $this->getDesc();
	}
	
	public function setQuantity($quan)
	{
		return $this->set('Quantity', (float) $quan);
	}
	
	public function getQuantity()
	{
		return $this->get('Quantity');
	}
	
	public function setUnitOfMeasure($unit)
	{
		return $this->set('UnitOfMeasure', $unit);
	}
	
	public function getUnitOfMeasure()
	{
		return $this->get('UnitOfMeasure');
	}
	
	public function setRate($rate)
	{
		return $this->set('Rate', (float) $rate);
	}
	
	public function getRate()
	{
		return $this->get('Rate');
	}
	
	public function getAmount()
	{
		if ($amount = $this->get('Amount'))
		{
			return $this->get('Amount');
		}
		
		return $this->get('Rate') * $this->get('Quantity');
	}
	
	public function setRatePercent($percent)
	{
		return $this->set('RatePercent', (float) $percent);
	}
	
	public function getRatePercent()
	{
		return $this->get('RatePercent');
	}
	
	public function setPriceLevelApplicationID($value)
	{
		
	}
	
	public function setPriceLevelName($name)
	{
		return $this->set('PriceLevelRef FullName', $name);
	}
	
	public function setPriceLevelListID($ListID)
	{
		return $this->set('PriceLevelRef ListID', $ListID);
	}
	
	public function getPriceLevelName()
	{
		return $this->get('PriceLevelRef FullName');
	}
	
	public function getPriceLevelListID()
	{
		return $this->get('PriceLevelRef ListID');
	}
	
	/** 
	 * Set the class ListID for this invoice line item
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}
	
	public function setClassApplicationID($value)
	{
		
	}
	
	/** 
	 * Set the class name for this invoice line item
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setClassName($name)
	{
		return $this->set('ClassRef FullName', $name);
	}
	
	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}
	
	public function getClassName()
	{
		return $this->get('ClassRef FullName');
	}
	
	public function setAmount($amount)
	{
		return $this->setAmountType('Amount', $amount);
	}
	
	public function setServiceDate($date)
	{
		return $this->setDateType('ServiceDate', $date);
	}
	
	public function getServiceDate($format = 'Y-m-d')
	{
		return $this->getDateType('ServiceDate', $format);
	}
	
	public function setSalesTaxCodeName($name)
	{
		return $this->set('SalesTaxCodeRef FullName', $name);
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
	
	public function setTaxable()
	{
		return $this->set('SalesTaxCodeRef FullName', QUICKBOOKS_TAXABLE);
	}
	
	public function setNonTaxable()
	{
		return $this->set('SalesTaxCodeRef FullName', QUICKBOOKS_NONTAXABLE);
	}
	
	public function getTaxable()
	{
		return $this->get('SalesTaxCodeRef FullName') == QUICKBOOKS_TAXABLE;
	}
	
	/**
	 * Set the account name for this line item
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setOverrideItemAccountName($name)
	{
		return $this->set('OverrideItemAccountRef FullName', $name);
	}
	
	/** 
	 * Set the account ListID for this line item
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setOverrideItemAccountListID($ListID)
	{
		return $this->set('OverrideItemAccountRef ListID', $ListID);
	}
	
	public function setOverrideItemAccountApplicationID($value)
	{
		
	}
	
	public function getOverrideItemAccountListID()
	{
		return $this->get('OverrideItemAccountRef ListID');
	}
	
	public function getOverrideItemAccountName()
	{
		return $this->get('OverrideItemAccountRef FullName');
	}
	
	public function setOther1($value)
	{
		return $this->set('Other1', $value);
	}
	
	public function getOther1()
	{
		return $this->get('Other1');
	}
	
	public function setOther2($value)
	{
		return $this->set('Other2', $value);
	}
	
	public function getOther2()
	{
		return $this->get('Other2');
	}
	
	/**
	 * 
	 * 
	 * @return boolean
	 */
	protected function _cleanup()
	{
		if ($this->exists('Amount'))
		{
			$this->setAmountType('Amount', $this->getAmountType('Amount'));
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
	
	public function asXML($root = null, $parent = null, $object = null)
	{
		$this->_cleanup();
		
		switch ($parent)
		{
			case QUICKBOOKS_ADD_INVOICE:
				$root = 'InvoiceLineAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_INVOICE:
				$root = 'InvoiceLineMod';
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
		return 'InvoiceLine';
	}
}
