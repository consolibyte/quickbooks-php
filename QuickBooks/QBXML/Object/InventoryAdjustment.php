<?php

/**
 * QuickBooks InventoryAdjustment object container
 *
 * @todo Verify the get/set methods on this one... it was copied from InventoryItem
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
 * InventoryAdjustmentLine lines for InventoryAdjustments
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/InventoryAdjustment/InventoryAdjustmentLine.php');

/**
 * Quickbooks InventoryAdjustment definition
 */
class QuickBooks_QBXML_Object_InventoryAdjustment extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks InventoryAdjustment object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	/**
	 * Gets the Account ListID
	 */
	public function getAccountListID()
	{
		return $this->get('AccountRef ListID');
	}

	/**
	 * Set the Account ListID
	 *
	 * @param string ListID
	 * @return boolean
	 */
	public function setAccountListID($value)
	{
		return $this->set('AccountRef ListID', $value);
	}

	/**
	 * Gets the Account Name
	 */
	public function getAccountName()
	{
		return $this->get('AccountRef FullName');
	}

	/**
	 * Set the account Name
	 *
	 * @param string name
	 * @return boolean
	 */
	public function setAccountName($value)
	{
		return $this->set('AccountRef FullName', $value);
	}

	/**
	 * Gets the transaction date
	 */
	public function getTxnDate()
	{
		return $this->get('TxnDate');
	}

	/**
	 * Set the transaction date
	 *
	 * @param string
	 * @return boolean
	 */
	public function setTxnDate($value)
	{
		return $this->set('TxnDate', $value);
	}

	/**
	 * Gets the RefNumber
	 */
	public function getRefNumber()
	{
		return $this->get('RefNumber');
	}

	/**
	 * Set the RefNumber
	 *
	 * @return boolean
	 */
	public function setRefNumber($value)
	{
		return $this->set('RefNumber', $value);
	}

	/**
	 * Gets the Memo
	 */
	public function getMemo()
	{
		return $this->get('Memo');
	}

	/**
	 * Set the Memo
	 *
	 * @param string
	 * @return boolean
	 */
	public function setMemo($value)
	{
		return $this->set('Memo', $value);
	}

	/**
	 * Gets the Customer ListID
	 */
	public function getCustomerListID()
	{
		return $this->get('CustomerRef ListID');
	}

	/**
	 * Set the Customer ListID
	 *
	 * @param string $ListID
	 * @return boolean
	 */
	public function setCustomerListID($ListID)
	{
		return $this->set('CustomerRef ListID', $ListID);
	}

	/**
	 * Gets the Customer Name
	 */
	public function getCustomerName()
	{
		return $this->get('CustomerRef FullName');
	}

	/**
	 * Set the Customer Name
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function setCustomerName($name)
	{
			return $this->set('CustomerRef FullName', $name);
	}

	/**
	 * Gets the Class ListID
	 */
	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}

	/**
	 * Set the class ListID
	 *
	 * @param string $ListID
	 * @return boolean
	 */
	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}

	/**
	 * Gets the Class Name
	 */
	public function getClassName()
	{
		return $this->get('ClassRef FullName');
	}

	/**
	 * Set the class name
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function setClassName($name)
	{
		return $this->set('ClassRef Name', $name);
	}

	public function addInventoryAdjustmentLine($obj)
	{
		return $this->addListItem('InventoryAdjustmentLine', $obj);
	}

	/**
	 * Gets the InventoryAdjustmentLine at @param $i
	 *
	 * @param $i a number between 0 and added Lines-1
	 */
	public function getInventoryAdjustmentLine($i)
	{
		return $this->getListItem('InventoryAdjustmentLine', $i);
	}

	/**
	 * Gets a list of all InventoryAdjustment Lines
	 */
	public function getInventoryAdjustmentLines()
	{
		return $this->getList('InventoryAdjustmentLine');
	}

	/********* Query ************/
/*
	public function getTxnID()
	{
		return $this->get('TxnID');
	}
	
	public function setTxnID($TxnID)
	{
		return $this->set('TxnID', $TxnID);
	}

	public function getRefNumberCaseSensitive()
	{
		return $this->get('RefNumberCaseSensitive');
	}
	
	public function setRefNumberCaseSensitive($value)
	{
		return $this->set('RefNumberCaseSensitive', $value);
	}
	
	public function getMaxReturned()
	{
		return $this->get('MaxReturned');
	}
	
	public function setMaxReturned($max)
	{
		return $this->set('MaxReturned', $max);
	}

	public function getFromModifiedDate()
	{
		return $this->get('ModifiedDateRangeFilter FromModifiedDate');
	}
	
	public function setFromModifiedDate($date)
	{
		return $this->set('ModifiedDateRangeFilter FromModifiedDate', $date);
	}
	
	public function getToModifiedDate()
	{
		return $this->get('ModifiedDateRangeFilter ToModifiedDate');
	}
	
	public function setToModifiedDate($date)
	{
		return $this->set('ModifiedDateRangeFilter ToModifiedDate', $date);
	}
	
	public function getFromTxnDate()
	{
		return $this->get('TxnDateRangeFilter FromTxnDate');
	}
	
	public function setFromTxnDate($date)
	{
		return $this->set('TxnDateRangeFilter FromTxnDate', $date);
	}
	
	public function getToTxnDate()
	{
		return $this->get('TxnDateRangeFilter ToTxnDate');
	}
	
	public function setToTxnDate($date)
	{
		return $this->set('TxnDateRangeFilter ToTxnDate', $date);
	}
	
	public function getDateMacro()
	{
		return $this->get('TxnDateRangeFilter DateMacro');
	}
	
	public function setDateMacro($macro)
	{
		return $this->set('TxnDateRangeFilter DateMacro', $macro);
	}

	public function getEntityListID()
	{
		return $this->get('EntityFilter ListID');
	}
	
	public function setEntityListID($listid)
	{
		return $this->set('EntityFilter ListID', $listid);
	}
	
	public function getEntityFullName()
	{
		return $this->get('EntityFilter FullName');
	}
	
	public function setEntityFullName($name)
	{
		return $this->set('EntityFilter FullName', $name);
	}
	
	public function getEntityListIDWithChildren()
	{
		return $this->get('EntityFilter ListIDWithChildren');
	}
	
	public function setEntityListIDWithChildren($listid)
	{
		return $this->set('EntityFilter ListIDWithChildren', $listid);
	}
	
	public function getEntityFullNameWithChildren()
	{
		return $this->get('EntityFilter FullNameWithChildren');
	}
	
	public function setEntityFullNameWithChildren($name)
	{
		return $this->set('EntityFilter FullNameWithChildren', $name);
	}

	public function getFilterAccountListID()
	{
		return $this->get('AccountFilter ListID');
	}
	
	public function setFilterAccountListID($listid)
	{
		return $this->set('AccountFilter ListID', $listid);
	}
	
	public function getFilterAccountFullName()
	{
		return $this->get('AccountFilter FullName');
	}
	
	public function setFilterAccountFullName($name)
	{
		return $this->set('AccountFilter FullName', $name);
	}
	
	public function getFilterAccountListIDWithChildren()
	{
		return $this->get('AccountFilter ListIDWithChildren');
	}
	
	public function setFilterAccountListIDWithChildren($listid)
	{
		return $this->set('AccountFilter ListIDWithChildren', $listid);
	}
	
	public function getFilterAccountFullNameWithChildren()
	{
		return $this->get('AccountFilter FullNameWithChildren');
	}
	
	public function setFilterAccountFullNameWithChildren($name)
	{
		return $this->set('AccountFilter FullNameWithChildren', $name);
	}

	public function getFilterItemListID()
	{
		return $this->get('ItemFilter ListID');
	}
	
	public function setFilterItemListID($listid)
	{
		return $this->set('ItemFilter ListID', $listid);
	}
	
	public function getFilterItemName()
	{
		return $this->get('ItemFilter FullName');
	}
	
	public function setFilterItemName($name)
	{
		return $this->set('ItemFilter FullName', $name);
	}
	
	public function getFilterItemListIDWithChildren()
	{
		return $this->get('ItemFilter ListIDWithChildren');
	}
	
	public function setFilterItemListIDWithChildren($listid)
	{
		return $this->set('ItemFilter ListIDWithChildren', $listid);
	}
	
	public function getFilterItemFullNameWithChildren()
	{
		return $this->get('ItemFilter FullNameWithChildren');
	}
	
	public function setFilterItemFullNameWithChildren($name)
	{
		return $this->set('ItemFilter FullNameWithChildren', $name);
	}

	public function getFilterRefNumberMatchCriterion()
	{
		return $this->get('RefNumberFilter MatchCriterion');
	}
	
	public function setFilterRefNumberMatchCriterion($refnumber)
	{
		return $this->set('RefNumberFilter MatchCriterion', $refnumber);
	}
	
	public function getFilterRefNumberRefNumber()
	{
		return $this->get('RefNumberFilter RefNumber');
	}
	
	public function setFilterRefNumberRefNumber($refnumber)
	{
		return $this->set('RefNumberFilter RefNumber', $refnumber);
	}
	
	public function getFilterRefNumberRangeFromRefNumber()
	{
		return $this->get('RefNumberRangeFilter FromRefNumber');
	}
	
	public function setFilterRefNumberRangeFromRefNumber($refnumber)
	{
		return $this->set('RefNumberRangeFilter FromRefNumber', $refnumber);
	}
	
	public function getFilterRefNumberRangeToRefNumber()
	{
		return $this->get('RefNumberRangeFilter ToRefNumber');
	}
	
	public function setFilterRefNumberRangeToRefNumber($refnumber)
	{
		return $this->set('RefNumberRangeFilter ToRefNumber', $refnumber);
	}
*/
// Are these needed or useful to include?
/*
	public function getIncludeLineItems()
	{
		return $this->get('IncludeLineItems');
	}
	
	public function setIncludeLineItems($)
	{
		return $this->set('IncludeLineItems', $);
	}
	
	public function getIncludeRetElement()
	{
		return $this->get('IncludeRetElement');
	}
	
	public function setIncludeRetElement($)
	{
		return $this->set('IncludeRetElement', $);
	}
	
	public function getOwnerID()
	{
		return $this->get('OwnerID');
	}
	
	public function setOwnerID($)
	{
		return $this->set('OwnerID', $);
	}
*/

	/**
	 *
	 *
	 * @return boolean
	 */
	protected function _cleanup()
	{
		return true;
	}

	public function asList($request)
	{
		switch ($request)
		{
			case QUICKBOOKS_ADD_INVENTORYADJUSTMENT . 'Rq':

				if (isset($this->_object['InventoryAdjustmentLine']))
				{
					$this->_object['InventoryAdjustmentLineAdd'] = $this->_object['InventoryAdjustmentLine'];
				}
				break;
		}

		return parent::asList($request);
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
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		switch ($root)
		{
			case QUICKBOOKS_ADD_INVENTORYADJUSTMENT:
				foreach ($object['InventoryAdjustmentLineAdd'] as $key => $obj)
				{
					$obj->setOverride('InventoryAdjustmentLineAdd');
				}
				$parent = null;
				break;
		}

		return parent::asXML($root, $parent, $object);
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
		return QUICKBOOKS_OBJECT_INVENTORYADJUSTMENT;
	}
}

