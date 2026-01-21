<?php 

/**
 * Check class for QuickBooks 
 * 
 * @author Keith Palmer Jr. <keith@ConsoliBYTE.com>
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
 * 
 */
class QuickBooks_QBXML_Object_Bill_ItemLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Check_ItemLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	// Path: ItemRef ListID, datatype: 
	
	/**
	 * Set the ItemRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setItemListID($ListID)
	{
		return $this->set('ItemRef ListID', $ListID);
	}

	/**
	 * Get the ItemRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getItemListID()
	{
		return $this->get('ItemRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setItemApplicationID($value)
	{
		return $this->set('ItemRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ITEM, QUICKBOOKS_LISTID, $value));
	}

	// Path: ItemRef FullName, datatype: 
	
	/**
	 * Set the ItemRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setItemFullName($FullName)
	{
		return $this->set('ItemRef FullName', $FullName);
	}

	/**
	 * Get the ItemRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getItemFullName()
	{
		return $this->get('ItemRef FullName');
	}

	// Path: Desc, datatype: 
	
	/**
	 * Set the Desc for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setDesc($value)
	{
		return $this->set('Desc', $value);
	}

	/**
	 * Get the Desc for the Check
	 * 
	 * @return string
	 */
	public function getDesc()
	{
		return $this->get('Desc');
	}

	/**
	 * @see QuickBooks_Object_Check_ItemLineAdd::setDesc()
	 */
	public function setDescription($value)
	{
		$this->setDesc($value); 
	}

	/**
	 * @see QuickBooks_Object_Check_ItemLineAdd::getDesc()
	 */
	public function getDescription()
	{
		$this->getDesc();
	}
	// Path: Quantity, datatype: 
	
	/**
	 * Set the Quantity for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setQuantity($value)
	{
		return $this->set('Quantity', (float) $value);
	}

	/**
	 * Get the Quantity for the Check
	 * 
	 * @return string
	 */
	public function getQuantity()
	{
		return $this->get('Quantity');
	}

	// Path: UnitOfMeasure, datatype: 
	
	/**
	 * Set the UnitOfMeasure for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setUnitOfMeasure($value)
	{
		return $this->set('UnitOfMeasure', $value);
	}

	/**
	 * Get the UnitOfMeasure for the Check
	 * 
	 * @return string
	 */
	public function getUnitOfMeasure()
	{
		return $this->get('UnitOfMeasure');
	}

	// Path: Cost, datatype: 
	
	/**
	 * Set the Cost for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setCost($value)
	{
		return $this->set('Cost', $value);
	}

	/**
	 * Get the Cost for the Check
	 * 
	 * @return string
	 */
	public function getCost()
	{
		return $this->get('Cost');
	}

	// Path: Amount, datatype: 
	
	/**
	 * Set the Amount for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setAmount($value)
	{
		return $this->set('Amount', $value);
	}

	/**
	 * Get the Amount for the Check
	 * 
	 * @return string
	 */
	public function getAmount()
	{
		return $this->get('Amount');
	}

	// Path: CustomerRef ListID, datatype: 
	
	/**
	 * Set the CustomerRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setCustomerListID($ListID)
	{
		return $this->set('CustomerRef ListID', $ListID);
	}

	/**
	 * Get the CustomerRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getCustomerListID()
	{
		return $this->get('CustomerRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setCustomerApplicationID($value)
	{
		return $this->set('CustomerRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_LISTID, $value));
	}

	// Path: CustomerRef FullName, datatype: 
	
	/**
	 * Set the CustomerRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setCustomerName($FullName)
	{
		return $this->set('CustomerRef FullName', $FullName);
	}

	/**
	 * Get the CustomerRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getCustomerName()
	{
		return $this->get('CustomerRef FullName');
	}

	// Path: ClassRef ListID, datatype: 
	
	/**
	 * Set the ClassRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}

	/**
	 * Get the ClassRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setClassApplicationID($value)
	{
		return $this->set('ClassRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CLASS, QUICKBOOKS_LISTID, $value));
	}

	// Path: ClassRef FullName, datatype: 
	
	/**
	 * Set the ClassRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setClassName($FullName)
	{
		return $this->set('ClassRef FullName', $FullName);
	}

	/**
	 * Get the ClassRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getClassName()
	{
		return $this->get('ClassRef FullName');
	}

	// Path: BillableStatus, datatype: 
	
	/**
	 * Set the BillableStatus for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setBillableStatus($value)
	{
		return $this->set('BillableStatus', $value);
	}

	/**
	 * Get the BillableStatus for the Check
	 * 
	 * @return string
	 */
	public function getBillableStatus()
	{
		return $this->get('BillableStatus');
	}

	// Path: OverrideItemAccountRef ListID, datatype: 
	
	/**
	 * Set the OverrideItemAccountRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setOverrideItemAccountListID($ListID)
	{
		return $this->set('OverrideItemAccountRef ListID', $ListID);
	}

	/**
	 * Get the OverrideItemAccountRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getOverrideItemAccountListID()
	{
		return $this->get('OverrideItemAccountRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setOverrideItemAccountApplicationID($value)
	{
		return $this->set('OverrideItemAccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_OVERRIDEITEMACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	// Path: OverrideItemAccountRef FullName, datatype: 
	
	/**
	 * Set the OverrideItemAccountRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setOverrideItemAccountName($FullName)
	{
		return $this->set('OverrideItemAccountRef FullName', $FullName);
	}

	/**
	 * Get the OverrideItemAccountRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getOverrideItemAccountName()
	{
		return $this->get('OverrideItemAccountRef FullName');
	}
	
	public function asXML($root = null, $parent = null, $object = null)
	{
		if (is_null($object))
		{
			$object = $this->_object;
		}
		
		switch ($parent)
		{
			case QUICKBOOKS_ADD_CHECK:
				$root = 'ItemLineAdd';
				$parent = null;
				break;
			case QUICKBOOKS_MOD_CHECK:
				$root = 'ItemLineMod';
				$parent = null;
				break;
		}
		
		return parent::asXML($root, $parent, $object);
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
	
	public function object()
	{
		return 'ItemLine';
	}
}

