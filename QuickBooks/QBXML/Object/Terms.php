<?php

/**
 * QuickBooks Terms object container
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
class QuickBooks_QBXML_Object_Terms extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Terms object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Set the ListID of the Class
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setListID($ListID)
	{
		return $this->set('ListID', $ListID);
	}
	
	/**
	 * Get the ListID of the Class
	 * 
	 * @return string
	 */
	public function getListID()
	{
		return $this->get('ListID');
	}
	
	/**
	 * 
	 */
	public function setParentListID($ListID)
	{
		return $this->set('ParentRef ListID', $ListID);
	}
	
	public function getParentListID()
	{
		return $this->get('ParentRef ListID');
	}
	
	public function setParentName($name)
	{
		return $this->set('ParentRef FullName', $name);
	}
	
	public function getParentName()
	{
		return $this->get('ParentRef FullName');
	}
	
	public function getParentFullName()
	{
		return $this->get('ParentRef FullName');
	}
	
	public function setParentApplicationID($value)
	{
		return $this->set('ParentRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_TERMS, QUICKBOOKS_LISTID, $value));
	}
	
	public function getParentApplicationID()
	{
		return $this->get('ParentRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	/**
	 * Set the name of the class
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setName($name)
	{
		return $this->set('Name', $name);
	}
	
	/**
	 * Get the name of the class
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->get('Name');
	}
	
	/**
	 * 
	 */
	public function getFullName()
	{
		return $this->get('FullName');
	}

	public function setFullName($name)
	{
		return $this->set('FullName', $name);
	}
	
	/**
	 * Set this Class active or not
	 * 
	 * @param boolean $value
	 * @return boolean
	 */
	public function setIsActive($value)
	{
		return $this->set('IsActive', (boolean) $value);
	}
	
	/**
	 * Tell whether or not this class object is active
	 * 
	 * @return boolean
	 */
	public function getIsActive()
	{
		return $this->getBooleanType('IsActive');
	}
	
	public function setStdDueDays($number)
	{
		return $this->set('StdDueDays', $number);
	}
	
	public function getStdDueDays()
	{
		return $this->get('StdDueDays');
	}
	
	public function setStdDiscountDays($number)
	{
		return $this->set('StdDiscountDays', $number);
	}
	
	public function getStdDiscountDays()
	{
		return $this->get('StdDiscountDays');
	}
	
	public function setDiscountPct($number)
	{
		return $this->set('DiscountPct', $number);
	}
	
	public function getDiscountPct()
	{
		return $this->get('DiscountPct');
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
	 * Get an array representation of this Class object
	 * 
	 * @param string $request
	 * @param boolean $nest
	 * @return array
	 */
	public function asArray($request, $nest = true)
	{
		$this->_cleanup();
		
		return parent::asArray($request, $nest);
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
		return QUICKBOOKS_OBJECT_TERMS;
	}
}
