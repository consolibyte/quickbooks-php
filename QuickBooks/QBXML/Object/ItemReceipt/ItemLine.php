<?php

/**
 * QuickBooks ItemLine object container
 *
 * @todo Documentation
 *
 * @author Harley Laue <harley.laue@gmail.com>
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
 * Quickbooks ItemLine definition
 */
class QuickBooks_QBXML_Object_ItemReceipt_ItemLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks ReceiptItem ItemLine object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	public function getItemListID()
	{
		return $this->get('ItemRef ListID');
	}

	public function setItemListID($ListID)
	{
		return $this->set('ItemRef ListID', $ListID);
	}

	public function getItemName()
	{
		return $this->get('ItemRef FullName');
	}

	public function setItemName($Name)
	{
		return $this->set('ItemRef FullName', $Name);
	}

	public function getDescription()
	{
		return $this->get('Desc');
	}

	public function setDescription($Desc)
	{
		return $this->set('Desc', $Desc);
	}

	public function getQuantity()
	{
		return $this->get('Quantity');
	}

	public function setQuantity($Quantity)
	{
		return $this->set('Quantity', (float) $Quantity);
	}

	public function getUnitOfMeasure()
	{
		return $this->get('UnitOfMeasure');
	}

	public function setUnitOfMeasure($UnitOfMeasure)
	{
		return $this->set('UnitOfMeasure', $UnitOfMeasure);
	}

	public function getCost()
	{
		return $this->get('Cost');
	}

	public function setCost($Cost)
	{
		return $this->set('Cost', $Cost);
	}

	public function getAmount()
	{
		return $this->get('Amount');
	}

	public function setAmount($Amount)
	{
		return $this->set('Amount', $Amount);
	}

	public function getTaxAmount()
	{
		return $this->get('TaxAmount');
	}

	public function setTaxAmount($TaxAmount)
	{
		return $this->set('TaxAmount', $TaxAmount);
	}

	public function getCustomerListID()
	{
		return $this->get('CustomerRef ListID');
	}

	public function setCustomerListID($ListID)
	{
		return $this->set('CustomerRef ListID', $ListID);
	}

	public function getCustomerName()
	{
		return $this->get('CustomerRef FullName');
	}

	public function setCustomerName($Name)
	{
		return $this->set('CustomerRef FullName', $Name);
	}

	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}

	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}

	public function getClassName()
	{
		return $this->get('ClassRef FullName');
	}

	public function setClassName($Name)
	{
		return $this->set('ClassRef FullName', $Name);
	}

	public function getSalesTaxCodeListID()
	{
		return $this->get('SalesTaxCodeRef ListID');
	}

	public function setSalesTaxCodeListID($ListID)
	{
		return $this->set('SalesTaxCodeRef ListID', $ListID);
	}

	public function getSalesTaxCodeName()
	{
		return $this->get('SalesTaxCodeRef FullName');
	}

	public function setSalesTaxCodeName($Name)
	{
		return $this->set('SalesTaxCodeRef FullName', $Name);
	}

	public function getBillableStatus()
	{
		return $this->get('BillableStatus');
	}

	public function setBillableStatus($BillableStatus)
	{
		return $this->set('BillableStatus', $BillableStatus);
	}

	public function getOverrideItemAccountListID()
	{
		return $this->get('OverrideItemAccountRef ListID');
	}

	public function setOverrideItemAccountListID($ListID)
	{
		return $this->set('OverrideItemAccountRef ListID', $ListID);
	}

	public function getOverrideItemAccountName()
	{
		return $this->get('OverrideItemAccountRef FullName');
	}

	public function setOverrideItemAccountName($Name)
	{
		return $this->set('OverrideItemAccountRef FullName', $Name);
	}

	public function getLinkToTxnID()
	{
		return $this->getLinkToTxn('LinkToTxn TxnID');
	}

	public function setLinkToTxnID($TxnID)
	{
		return $this->set('LinkToTxn TxnID', $TxnID);
	}

	public function getLinkToTxnLineID()
	{
		return $this->get('LinkToTxn TxnLineID');
	}

	public function setLinkToTxnLineID($TxnLineID)
	{
		return $this->set('LinkToTxn TxnLineID', $TxnLineID);
	}

	public function asXML($root = null, $parent = null, $object = null)
	{
		if (is_null($object))
		{
			$object = $this->_object;
		}

		switch ($parent)
		{
			case QUICKBOOKS_ADD_ITEMRECEIPT:
				$root = 'ItemLineAdd';
				$parent = null;
				break;
// Currently unimplemented
/*
			case QUICKBOOKS_QUERY_INVENTORYADJUSTMENT:
				$root = 'ExpenseLineQuery';
				break;
*/
		}

		return parent::asXML($root, $parent, $object);
	}

	/**
	 * Tell what type of object this is
	 *
	 * @return string
	 */
	public function object()
	{
		return "ItemLine";
	}
}
