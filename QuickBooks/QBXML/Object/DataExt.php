<?php

/**
 * QuickBooks DataExt object container
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
class QuickBooks_QBXML_Object_DataExt extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_DataExt object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	/**
	 * Set the OwnerID
	 *
	 * @param string $OwnerID
	 * @return boolean
	 */
	public function setOwnerID($OwnerID)
	{
		return $this->set('OwnerID', $OwnerID);
	}

	/**
	 * Get the OwnerID
	 *
	 * @return string
	 */
	public function getOwnerID()
	{
		return $this->get('OwnerID');
	}

	public function setDataExtName($name)
	{
		return $this->set('DataExtName', $name);
	}

	public function getDataExtName()
	{
		return $this->get('DataExtName');
	}

	public function setListDataExtType($type)
	{
		return $this->set('ListDataExtType', $type);
	}

	public function getListDataExtType()
	{
		return $this->get('ListDataExtType');
	}

	public function setListObjListID($ListID)
	{
		return $this->set('ListObjRef ListID', $ListID);
	}

	public function getListObjListID()
	{
		return $this->get('ListObjRef ListID');
	}

	public function setListObjName($name)
	{
		return $this->set('ListObjRef FullName', $name);
	}

	public function getListObjName()
	{
		return $this->get('ListObjRef FullName');
	}

	public function setListObjApplicationID($value, $type)
	{
		return $this->set('ListObjRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID($type, QUICKBOOKS_LISTID, $value));
	}

	public function getListObjApplicationID()
	{
		return $this->get('ListObjRef ' . QUICKBOOKS_API_APPLICATIONID);
	}

	public function setTxnDataExtType($type)
	{
		return $this->set('TxnDataExtType', $type);
	}

	public function getTxnDataExtType()
	{
		return $this->get('TxnDataExtType');
	}

	public function setTxnID($TxnID)
	{
		return $this->set('TxnID', $TxnID);
	}

	public function getTxnID()
	{
		return $this->get('TxnID');
	}

	public function setTxnApplicationID($value)
	{
		return $this->set(QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_TRANSACTION, QUICKBOOKS_TXNID, $value));
	}

	public function getTxnApplicationID()
	{
		return $this->get(QUICKBOOKS_API_APPLICATIONID);
	}

	public function setTxnLineID($value)
	{
		return $this->set('TxnLineID', $value);
	}

	public function getTxnLineID()
	{
		return $this->get('TxnLineID');
	}

	public function setOtherDataExtType($type)
	{
		return $this->set('OtherDataExtType', $type);
	}

	public function getOtherDataExtType()
	{
		return $this->get('OtherDataExtType');
	}

	public function setDataExtValue($value)
	{
		return $this->set('DataExtValue', $value);
	}

	public function getDataExtValue()
	{
		return $this->get('DataExtValue');
	}

	/**
	 * Tell what type of object this is
	 *
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_DATAEXT;
	}
}
