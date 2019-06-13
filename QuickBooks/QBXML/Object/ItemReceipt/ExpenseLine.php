<?php

/**
 * QuickBooks ExpenseLine object container
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
 * Quickbooks ExpenseLine definition
 */
class QuickBooks_QBXML_Object_ItemReceipt_ExpenseLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks ReceiptItem ExpenseLine object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	public function getAccountListID()
	{
		return $this->get('AccountRef ListID');
	}

	public function setAccountListID($ListID)
	{
		return $this->set('AccountRef ListID', $ListID);
	}

	public function getAccountName()
	{
		return $this->get('AccountRef FullName');
	}

	public function setAccountName($name)
	{
		return $this->set('AccountRef FullName', $name);
	}

	public function getAmount()
	{
		return $this->get('Amount');
	}

	public function setAmount($amount)
	{
		return $this->set('Amount', $amount);
	}

	public function getMemo()
	{
		return $this->get('Memo');
	}

	public function setMemo($memo)
	{
		return $this->set('Memo', $memo);
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

	public function setCustomerName($name)
	{
		return $this->set('CustomerRef FullName', $name);
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

	public function setClassName($name)
	{
		return $this->set('ClassRef FullName', $name);
	}

	public function getBillableStatus()
	{
		return $this->get('BillableStatus');
	}

	/*
	 * @param billable must be one of: Billable, NotBillable, HasBeenBilled
	 */
	public function setBillableStatus($billable)
	{
		return $this->set('BillableStatus', $billable);
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
				$root = 'ExpenseLineAdd';
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
		return "ExpenseLine";
	}
}
