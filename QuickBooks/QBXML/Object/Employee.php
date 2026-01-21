<?php

/**
 * QuickBooks Employee object container
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Object
 */

/**
 * Base object class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object.php');

/**
 * QuickBooks object class
 */
class QuickBooks_QBXML_Object_Employee extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Customer object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}
	
	/**
	 * Set the ListID of this customer record
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setListID($ListID)
	{
		return $this->set('ListID', $ListID);
	}
	
	/**
	 * Get the ListID of this customer record
	 * 
	 * @return string
	 */
	public function getListID()
	{
		return $this->get('ListID');
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

  public function setName($name)
  {
    return $this->set('Name', $name);
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

    $this->set('FullName', $name);
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
	
	public function setMiddleName($mname)
	{
		return $this->set('MiddleName', $mname);
	}
	
	public function getMiddleName()
	{
		return $this->get('MiddleName');
	}
	
	public function getEmployeeAddress($part = null, $defaults = array())
	{
		return $this->_getXYZAddress('Employee', '', $part, $defaults);
	}
	
	public function setEmployeeAddress($addr1, $addr2 = '', $addr3 = '', $addr4 = '', $addr5 = '', $city = '', $state = '', $province = '', $postalcode = '', $country = '', $note = '')
	{
		return $this->_setXYZAddress('Employee', '', $addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note);  
	}
	
	protected function _setXYZAddress($pre, $post, $addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note)
	{
		for ($i = 1; $i <= 5; $i++)
		{
			$this->set($pre . 'Address' . $post . ' Addr' . $i, ${'addr' . $i});
		}
		
		$this->set($pre . 'Address' . $post . ' City', $city);
		$this->set($pre . 'Address' . $post . ' State', $state);
		$this->set($pre . 'Address' . $post . ' Province', $province);
		$this->set($pre . 'Address' . $post . ' PostalCode', $postalcode);
		$this->set($pre . 'Address' . $post . ' Country', $country);
		$this->set($pre . 'Address' . $post . ' Note', $note);		
	}
	
	protected function _getXYZAddress($pre, $post, $part = null, $defaults = array())
	{
		if (!is_null($part))
		{
			return $this->get($pre . 'Address' . $post . ' ' . $part);
		}
		
		return $this->getArray($pre . 'Address' . $post . ' *', $defaults);
	}
	
	/**
	 * 
	 * 
	 * @param string $phone
	 * @return boolean
	 */
	public function setPhone($phone)
	{
		return $this->set('Phone', $phone);
	}

	public function getPhone()
	{
		return $this->get('Phone');
	}
	
	/**
	 * Set the alternate phone number for this customer
	 * 
	 * @param string $phone
	 * @return boolean
	 */
	public function setAltPhone($phone)
	{
		return $this->set('AltPhone', $phone);
	}

	public function getAltPhone()
	{
		return $this->get('AltPhone');
	}
	
	/**
	 * Set the fax number for this customer
	 * 
	 * @param string $fax
	 * @return boolean 
	 */
	public function setFax($fax)
	{
		return $this->set('Fax', $fax);
	}

	public function getFax()
	{
		return $this->get('Fax');
	}
	
	/**
	 * Set the e-mail address for this customer
	 * 
	 * @param string $email
	 * @return boolean
	 */
	public function setEmail($email)
	{
		return $this->set('Email', $email);
	}

	public function getEmail()
	{
		return $this->get('Email');
	}
	
	/**
	 * Set the salutation for this customer
	 * 
	 * @param string $salut
	 * @return boolean
	 */
	public function setSalutation($salut)
	{
		return $this->set('Salutation', $salut);
	}
	
	/**
	 * 
	 * 
	 * @return string
	 */
	public function getSalutation()
	{
		return $this->get('Salutation');
	}
	
	public function setNotes($notes)
	{
		return $this->set('Notes', $notes);
	}
	
	public function getNotes()
	{
		return $this->get('Notes');
	}
	
	public function setMobile($mobile)
	{
		return $this->set('Mobile', $mobile);	
	}
	
	public function getMobile()
	{
		return $this->get('Mobile');
	}
	
	public function setPager($pager)
	{
		return $this->set('Pager', $pager);
	}
	
	public function getPager()
	{
		return $this->get('Pager');
	}
	
	public function setGender($gender)
	{
		return $this->set('Gender', $gender);
	}
	
	public function getGender()
	{
		return $this->get('Gender');
	}
	
	public function setBirthDate($date)
	{
		return $this->setDateType('BirthDate', $date);
	}
	
	public function getBirthDate($format = 'Y-m-d')
	{
		return $this->getDateType('BirthDate', $format);
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
	 * @param string $request						The type of request to convert this to (examples: CustomerAddRq, CustomerModRq, CustomerQueryRq)
	 * @param boolean $todo_for_empty_elements		A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
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
		return QUICKBOOKS_OBJECT_EMPLOYEE;
	}
}

