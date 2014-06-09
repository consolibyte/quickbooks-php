<?php

/**
 * QuickBooks object container
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
class QuickBooks_QBXML_Object_Item extends QuickBooks_QBXML_Object
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
   * Set the name of this customer
   * 
   * NOTE: This will be auto-set to ->getFirstName() ->getLastName() if you 
   * don't set it explicitly.
   * 
   * @param string $name
   * @return boolean
   */
  public function setName($name)
  {
    return $this->set('Name', $name);
  }

  /**                                                         
   * Sets the name as first and last.                         
   *                                                          
   * @return boolean                                          
   */     
  public function setNameAsFirstLast() {     
    $first = $this->getFirstName();     
    $last = $this->getLastName();     
    if (is_null($first)) { $first = ''; }     
    if (is_null($last)) { $last = ''; }     
     
    return $this->set('Name', $first .' '. $last);     
  }

  /**
   * Get the name of this customer
   * 
   * @return string
   */
  public function getName()
  {
    if (!$this->exists('Name'))
    { 
      if (!is_null($this->getFirstName()) || !is_null($this->getLastName())) {
        $this->setNameAsFirstLast();
      } 
    } 

    return $this->get('Name');
  }

  /**
   * Set the full name of this customer (full name)
   * 
   * NOTE: This will be auto-set to ->getName() if you don't set it 
   * explicitly.
   * 
   * @param string $name
   * @return boolean
   */
  public function setFullName($name)
  {
    if (is_null($name)) {
      $name = $this->getName();
    }

    return $this->set('FullName', $name);
  }

  /**
   * Get the name of this customer (full name)
   * 
   * @return string
   */
  public function getFullName()
  {
    if (!$this->exists('FullName'))
    {
      $this->setFullName($this->get('Name'));
    }

    return $this->get('FullName');
  }

  /**
   * Set the first name of this customer
   * 
   * @param string $name
   * @return boolean
   */
  public function setFirstName($fname)
  {
    return $this->set('FirstName', $fname);
  }

  /**
   * Get the first name of this customer
   * 
   * @return string
   */
  public function getFirstName()
  {
    return $this->get('FirstName');
  }

  /**
   * Set the last name of this customer
   * 
   * @param string $lname
   * @return boolean
   */
  public function setLastName($lname)
  {
    return $this->set('LastName', $lname);
  }

  /**
   * Get the last name of this customer
   * 
   * @return string
   */
  public function getLastName()
  {
    return $this->get('LastName');
  }





	public function getFromModifiedDate()
	{
		
	}
	
	public function setFromModifiedDate($date)
	{
		
	}
	
	public function getToModifiedDate()
	{
		
	}
	
	public function setToModifiedDate($date)
	{
		
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
		return QUICKBOOKS_OBJECT_ITEM;
	}
}
