<?php

/**
 * QuickBooks CustomerType object container
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
class QuickBooks_QBXML_Object_CustomerType extends QuickBooks_QBXML_Object
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

	/**
	 * @deprecated
	 */
	public function setParentName($name)
	{
		return $this->set('ParentRef FullName', $name);
	}

	/**
	 * @deprecated
	 */
	public function getParentName()
	{
		return $this->get('ParentRef FullName');
	}

	public function setParentFullName($name)
	{
		return $this->set('ParentRef FullName', $name);
	}

	public function getParentFullName()
	{
		return $this->get('ParentRef FullName');
	}

	public function setParentApplicationID($value)
	{
		return $this->set('ParentRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID($this->object(), QUICKBOOKS_LISTID, $value));
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

	/**
	 * Tell what type of object this is
	 *
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_CUSTOMERTYPE;
	}
}
