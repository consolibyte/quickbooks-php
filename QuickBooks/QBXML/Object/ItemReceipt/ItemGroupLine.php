<?php

/**
 * QuickBooks ItemGroupLine object container
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
 * Quickbooks ItemGroupLine definition
 */
class QuickBooks_QBXML_Object_ItemReceipt_ItemGroupLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks ReceiptItem ItemGroupLine object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	public function getItemGroupListID()
	{
		return $this->get('ItemGroupRef ListID');
	}

	public function setItemGroupListID($ListID)
	{
		return $this->set('ItemGroupRef ListID', $ListID);
	}

	public function getItemGroupName()
	{
		return $this->get('ItemGroupRef FullName');
	}

	public function setItemGroupName($Name)
	{
		return $this->set('ItemGroupRef FullName', $Name);
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

	public function asXML($root = null, $parent = null, $object = null)
	{
		if (is_null($object))
		{
			$object = $this->_object;
		}

		switch ($parent)
		{
			case QUICKBOOKS_ADD_ITEMRECEIPT:
				$root = 'ItemGroupLineAdd';
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
		return "ItemGroupLine";
	}
}
