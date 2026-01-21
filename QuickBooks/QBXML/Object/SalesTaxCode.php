<?php

/**
 * QuickBooks SalesTaxCode object container
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
class QuickBooks_QBXML_Object_SalesTaxCode extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Class object
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
	 * Set this Class active or not
	 * 
	 * @param boolean $value
	 * @return boolean
	 */
	public function setIsActive($value)
	{
		return $this->setBooleanType('IsActive', $value);
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
	
	public function setIsTaxable($boolean)
	{
		return $this->setBooleanType('IsTaxable', $boolean);
	}
	
	public function getIsTaxable()
	{
		return $this->getBooleanType('IsTaxable', true);
	}
	
	public function setDescription($Desc)
	{
		return $this->set('Desc', $Desc);
	}
	
	public function getDescription()
	{
		return $this->get('Desc');
	}
		
	/**
	 * Tell what type of object this is 
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_SALESTAXCODE;
	}
}
