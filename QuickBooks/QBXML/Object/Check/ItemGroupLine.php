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
class QuickBooks_QBXML_Object_Check_ItemGroupLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Check_ItemGroupLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	// Path: ItemGroupRef ListID, datatype: 
	
	/**
	 * Set the ItemGroupRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setItemGroupListID($ListID)
	{
		return $this->set('ItemGroupRef ListID', $ListID);
	}

	/**
	 * Get the ItemGroupRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getItemGroupListID()
	{
		return $this->get('ItemGroupRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setItemGroupApplicationID($value)
	{
		return $this->set('ItemGroupRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ITEMGROUP, QUICKBOOKS_LISTID, $value));
	}

	// Path: ItemGroupRef FullName, datatype: 
	
	/**
	 * Set the ItemGroupRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setItemGroupName($FullName)
	{
		return $this->set('ItemGroupRef FullName', $FullName);
	}

	/**
	 * Get the ItemGroupRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getItemGroupName()
	{
		return $this->get('ItemGroupRef FullName');
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
	 * @see QuickBooks_Object_Check_ItemGroupLineAdd::setDesc()
	 */
	public function setDescription($value)
	{
		$this->setDesc($value); 
	}

	/**
	 * @see QuickBooks_Object_Check_ItemGroupLineAdd::getDesc()
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

	public function object()
	{
		return 'ItemGroupLine';
	}
}

