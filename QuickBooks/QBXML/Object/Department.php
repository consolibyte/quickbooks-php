<?php

/**
 * QuickBooks Department object container
 * 
 * @author Thomas Rientjes
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
class QuickBooks_QBXML_Object_Department extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Department object
	 *
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Set the ListID of the department
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setListID($ListID)
	{
		return $this->set('ListID', $ListID);
	}
	
	/**
	 * Get the ListID of the department
	 * 
	 * @return string
	 */
	public function getListID()
	{
		return $this->get('ListID');
	}
	
	/**
	 * @param string $ListID
	 * @return boolean
	 */
	public function setParentListID($ListID)
	{
		return $this->set('ParentRef ListID', $ListID);
	}

	/**
	 * @return string
     */
	public function getParentListID()
	{
		return $this->get('ParentRef ListID');
	}

	/**
	 * Set the name of the department
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setName($name)
	{
		return $this->set('Name', $name);
	}
	
	/**
	 * Get the name of the department
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->get('Name');
	}

	/**
	 * Get the full name of the department
	 *
	 * @return string
	 */
	public function getFullName()
	{
		return $this->get('FullName');
	}

	/**
	 * Set the full name of the department
	 *
	 * @param string $name
	 * @return boolean
	 */
	public function setFullName($name)
	{
		return $this->set('FullName', $name);
	}
	
	/**
	 * Set this department active or not
	 * 
	 * @param boolean $value
	 * @return boolean
	 */
	public function setIsActive($value)
	{
		return $this->set('IsActive', (boolean) $value);
	}
	
	/**
	 * Tell whether or not this department object is active
	 * 
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->get('IsActive');
	}
	
	/**
	 * Perform any needed clean-up of the object data members
	 * 
	 * @return boolean
	 */
	protected function _cleanup()
	{
		return true;
	}
	
	/**
	 * Get an array representation of this department object
	 * 
	 * @param string $request
	 * @param boolean $nest
	 * @return array
	 */
	public function asArray($request, $nest = true)
	{
		$this->_cleanup();

		// @TODO implement parent::asArray
		return array();
	}

	/**
	 * Convert this object to a valid qbXML request
	 *
	 * @param string $request The type of request to convert this to (examples: CustomerAddRq, CustomerModRq, CustomerQueryRq)
	 * @param string $version
	 * @param string $locale
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
		return QUICKBOOKS_OBJECT_DEPARTMENT;
	}
}
