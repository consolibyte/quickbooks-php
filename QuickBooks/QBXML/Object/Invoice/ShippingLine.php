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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/SalesReceipt.php');

/**
 *
 *
 */
class QuickBooks_QBXML_Object_Invoice_ShippingLine extends QuickBooks_QBXML_Object
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

	public function asXML($root = null, $parent = null, $object = null)
	{
		switch ($parent)
		{
			case QUICKBOOKS_ADD_INVOICE:
				$root = 'ShippingLineAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_INVOICE:
				$root = 'ShippingLineMod';
				$parent = null;
				break;
		}

		return parent::asXML($root, $parent, $object);
	}

	/**
	 * Tell the type of object this is
	 *
	 * @return string
	 */
	public function object()
	{
		return 'ShippingLine';
	}
}
