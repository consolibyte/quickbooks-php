<?php

/**
 * QuickBooks SubtotalItem object container
 * 
 * SubtotalItem are pretty basic, they sum up the items above them. You wouldn't really need to import/export new ones, but this object ensures you can parse them from the item query response 
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
class QuickBooks_QBXML_Object_SubtotalItem extends QuickBooks_QBXML_Object
{
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Set the ListID for this item
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setListID($ListID)
	{
		return $this->set('ListID', $ListID);
	}
	
	/**
	 * Get the ListID for this item
	 * 
	 * @return string
	 */
	public function getListID()
	{
		return $this->get('ListID');
	}
	
	/**
	 * Set the name for this item
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setName($name)
	{
		return $this->set('Name', $name);
	}
	
	/**
	 * Get the name for this item
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->get('Name');
	}
	
	/**
	 * Set the active status of this item
	 *
	 * @param boolean $active
	 * @return boolean
	 */
	public function setIsActive($active)
	{
		if (strtolower($active) == 'true' or
				(is_bool($active) and $active))
		{
			return $this->set('IsActive', 'true');
		}
	
		return $this->set('IsActive', 'false');
	}
	
	public function getIsActive()
	{
		$active = $this->get('IsActive');
	
		return strtolower($active) == 'true' or
		(is_bool($active) and $active);
	}
	
	public function setParentApplicationID($value)
	{
		return $this->set('ParentRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SUBTOTALITEM, QUICKBOOKS_LISTID, $value));
	}

	public function getParentApplicationID()
	{
		return $this->get('ParentRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
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
	
	public function setDescription($desc)
	{
		return $this->set('ItemDesc', $desc);
	}
	
	public function getDescription()
	{
		return $this->get('ItemDesc');
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
	 * Convert this object to a valid qbXML request
	 * 
	 * @param string $request					The type of request to convert this to (examples: CustomerAddRq, CustomerModRq, CustomerQueryRq)
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent
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
		return QUICKBOOKS_OBJECT_SUBTOTALITEM;
	}
}

