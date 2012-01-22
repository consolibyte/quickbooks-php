<?php

/**
 * QuickBooks Vendor object container
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
class QuickBooks_QBXML_Object_Vendor extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Account object
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
		return $this->get('IsActive');
	}
	
	public function setCompanyName($name)
	{
		return $this->set('CompanyName', $name);
	}
	
	public function getCompanyName()
	{
		return $this->get('CompanyName');
	}
	
	/**
	 * 
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setFirstName($fname)
	{
		return $this->set('FirstName', $fname);
	}
	
	/**
	 * 
	 * 
	 * @return string
	 */
	public function getFirstName()
	{
		return $this->get('FirstName');
	}
	
	/**
	 * 
	 * 
	 * @param string $lname
	 * @return boolean
	 */
	public function setLastName($lname)
	{
		return $this->set('LastName', $lname);
	}
	
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
	
	public function getVendorAddress($part = null, $defaults = array())
	{
		return $this->_getXYZAddress('Vendor', '', $part, $defaults);
	}
	
	public function setVendorAddress($addr1, $addr2 = '', $addr3 = '', $addr4 = '', $addr5 = '', $city = '', $state = '', $postalcode = '', $country = '', $note = '')
	{
		return $this->_setXYZAddress('Vendor', '', $addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $postalcode, $country, $note);	
	}
	
	protected function _setXYZAddress($pre, $post, $addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $postalcode, $country, $note)
	{
		for ($i = 1; $i <= 5; $i++)
		{
			$this->set($pre . 'Address' . $post . ' Addr' . $i, ${'addr' . $i});
		}
		
		$this->set($pre . 'Address' . $post . ' City', $city);
		$this->set($pre . 'Address' . $post . ' State', $state);
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
	 * Set the contact person for this customer
	 * 
	 * @param string $contact
	 * @return boolean
	 */
	public function setContact($contact)
	{
		return $this->set('Contact', $contact);
	}

	public function getContact()
	{
		return $this->get('Contact');
	}
	
	/**
	 * Set the alternate contact for this customer
	 * 
	 * @param string $contact
	 * @return boolean
	 */
	public function setAltContact($contact)
	{
		return $this->set('AltContact', $contact);
	}

	public function getAltContact()
	{
		return $this->get('AltContact');
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
		return QUICKBOOKS_OBJECT_VENDOR;
	}
}

?>
