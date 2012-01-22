<?php

/**
 * QuickBooks Customer object container
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
 * QuickBooks Customer object class
 */
class QuickBooks_QBXML_Object_Customer extends QuickBooks_QBXML_Object
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
	 * Set the ListID of the parent client
	 * 
	 * @param string $ListID
	 * @return boolean
	 */
	public function setParentListID($ListID)
	{
		return $this->set('ParentRef ListID', $ListID);
	}
	
	/**
	 * Set the FullName of the parent client
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setParentName($name)
	{
		return $this->set('ParentRef FullName', $name);
	}
	
	public function setParentFullName($FullName)
	{
		return $this->set('ParentRef FullName', $FullName);
	}
	
	/**
	 * Set the application id of the parent client
	 *
	 * @param string $id
	 * @return boolean
	 */
	public function setParentApplicationID($id)
	{
		return $this->set('ParentRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_LISTID, $id));
	}
	
	/**
	 * Get the ListID of the parent client (if exists)
	 * 
	 * @return string
	 */
	public function getParentListID()
	{
		return $this->get('ParentRef ListID');
	}
	
	/**
	 * Get the FullName of the parent client (if exists)
	 * 
	 * @return string
	 */
	public function getParentName()
	{
		return $this->get('ParentRef FullName');
	}

	/**
	 * Get the application id of the parent client
	 *
	 * @return string
	 */
	public function getParentApplicationID()
	{
		return $this->get('ParentRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	/**
	 * Set the customer type list id
	 */
	public function setCustomerTypeListID($lid)
	{
		return $this->set('CustomerTypeRef ListID', $lid);
	}
	
	public function setCustomerTypeFullName($FullName)
	{
		return $this->setFullNameType('CustomerTypeRef FullName', null, null, $FullName);
	}
	
	public function setCustomerTypeName($name)
	{
		return $this->set('CustomerTypeRef FullName', $name);
	}
	
	public function setCustomerTypeApplicationID($value)
	{
		return $this->set('CustomerTypeRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CUSTOMERTYPE, QUICKBOOKS_LISTID, $value));
	}
	
	public function setTermsName($name)
	{
		return $this->set('TermsRef FullName', $name);
	}
	
	public function setTermsListID($ListID)
	{
		return $this->set('TermsRef ListID', $ListID);
	}
	
	public function setTermsApplicationID($value)
	{
		return $this->set('TermsRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_TERMS, QUICKBOOKS_LISTID, $value));
	}

	public function getTermsApplicationID()
	{
		return $this->get('TermsRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getTermsName()
	{
		return $this->get('TermsRef FullName');
	}
	
	public function getTermsListID()
	{
		return $this->get('TermsRef ListID');
	}

	public function setSalesRepName($name)
	{
		return $this->set('SalesRepRef FullName', $name);
	}
	
	public function setSalesRepListID($ListID)
	{
		return $this->set('SalesRepRef ListID', $ListID);
	}
	
	public function setSalesRepApplicationID($value)
	{
		return $this->set('SalesRepRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SALESREP, QUICKBOOKS_LISTID, $value));
	}

	public function getSalesRepApplicationID()
	{
		return $this->get('SalesRepRef ' . QUICKBOOKS_API_APPLICATIONID);
	}

	public function getSalesRepName()
	{
		return $this->get('SalesRepRef FullName');
	}
	
	public function getSalesRepListID()
	{
		return $this->get('SalesRepRef ListID');
	}	
	
	/** 
	 * Set the delivery method 
	 * 
	 * @see QUICKBOOKS_CUSTOMER_DELIVERYMETHOD_PRINT, QUICKBOOKS_CUSTOMER_DELIVERYMETHOD_EMAIL, QUICKBOOKS_CUSTOMER_DELIVERYMETHOD_FAX
	 * 
	 * Only supported by QuickBooks Online Edition as of qbXML version 7.0. 
	 * QuickBooks Online Edition has a bug where if you do not provide a 
	 * DeliveryMethod when issueing CustomerAdd or CustomerMod requests, the 
	 * CustomerAdd or CustomerMod request will take a very long time to 
	 * process (2+ minutes sometimes). The fix is to simply provide this tag, 
	 * after which requests process very quickly (2 seconds or less). 
	 * 
	 * @param string $value
	 * @return boolean 
	 */
	public function setDeliveryMethod($value)
	{
		return $this->set('DeliveryMethod', $value);
	}
	
	/**
	 * Get the delivery method 
	 * 
	 * @see QUICKBOOKS_CUSTOMER_DELIVERYMETHOD_PRINT, QUICKBOOKS_CUSTOMER_DELIVERYMETHOD_EMAIL, QUICKBOOKS_CUSTOMER_DELIVERYMETHOD_FAX
	 * 
	 * @return string
	 */
	public function getDeliveryMethod()
	{
		return $this->get('DeliveryMethod');
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
	 * Get the name of this customer
	 * 
	 * @TODO What should the behavior of this be if "Name" is not set...?
	 * 
	 * @return string
	 */
	public function getName()
	{
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
		return $this->setFullNameType('FullName', 'Name', 'ParentRef FullName', $name);
	}
	
	/**
	 * Get the name of this customer (full name)
	 * 
	 * @return string
	 */
	public function getFullName()
	{
		return $this->getFullNameType('FullName', 'Name', 'ParentRef FullName');
	}
	
	/**
	 * Set the company name of this customer
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setCompanyName($name)
	{
		return $this->set('CompanyName', $name);
	}
	
	/**
	 * Get the company name of this customer
	 * 
	 * @return string
	 */
	public function getCompanyName()
	{
		return $this->get('CompanyName');
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
	
	public function getShipAddress($part = null, $defaults = array())
	{
		return $this->_getXYZAddress('Ship', '', $part, $defaults);
	}
	
	public function setShipAddress($addr1, $addr2 = '', $addr3 = '', $addr4 = '', $addr5 = '', $city = '', $state = '', $province = '', $postalcode = '', $country = '', $note = '')
	{
		return $this->_setXYZAddress('Ship', '', $addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note);	
	}
	
	public function getBillAddress($part = null, $defaults = array())
	{
		return $this->_getXYZAddress('Bill', '', $part, $defaults);
	}
	
	public function setBillAddress(
		$addr1, 
		$addr2 = '', 
		$addr3 = '', 
		$addr4 = '', 
		$addr5 = '', 
		$city = '', 
		$state = '', 
		$province = '', 
		$postalcode = '', 
		$country = '', 
		$note = '')
	{
		return $this->_setXYZAddress('Bill', '', $addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note);	
	}

	public function getShipAddressBlock($part = null, $defaults = array())
	{
		return $this->_getXYZAddress('Ship', 'Block', $part, $defaults);
	}
	
	public function getBillAddressBlock($part = null, $defaults = array())
	{
		return $this->_getXYZAddress('Bill', 'Block', $part, $defaults);
	}
	
	protected function _setXYZAddress($pre, $post, $addr1, $addr2, $addr3, $addr4, $addr5, $city, $state, $province, $postalcode, $country, $note)
	{
		$b = FALSE;
		for ($i = 1; $i <= 5; $i++)
		{
			$b = $this->set($pre . 'Address' . $post . ' Addr' . $i, ${'addr' . $i});
		}
		
		$b = $this->set($pre . 'Address' . $post . ' City', $city);
		$b = $this->set($pre . 'Address' . $post . ' State', $state);
		$b = $this->set($pre . 'Address' . $post . ' Province', $province);
		$b = $this->set($pre . 'Address' . $post . ' PostalCode', $postalcode);
		$b = $this->set($pre . 'Address' . $post . ' Country', $country);
		$b = $this->set($pre . 'Address' . $post . ' Note', $note);		

		return $b;
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
	 * Set the contact person for this customer
	 * 
	 * @param string $contact
	 * @return boolean
	 */
	public function setContact($contact)
	{
		return $this->set('Contact', $contact);
	}
	
	/**
	 * Get the name of the contact at this company/customer
	 *
	 * @return string
	 */
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
	
	/**
	 * Get the name of the alternate contact for this customer/company
	 *
	 * @return string
	 */
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
			
	public function getCustomerTypeApplicationID()
	{
		return $this->get('CustomerTypeRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getCustomerTypeListID()
	{
		return $this->get('CustomerTypeRef ListID');
	}
	
	public function getCustomerTypeName()
	{
		return $this->get('CustomerTypeRef FullName');
	}
	
	public function setOpenBalance($balance)
	{
		return $this->set('OpenBalance', (float) $balance);
	}
	
	public function getOpenBalance()
	{
		return $this->get('OpenBalance');
	}
	
	public function setOpenBalanceDate($date)
	{
		return $this->setDateType('OpenBalanceDate', $date);
	}
	
	public function getOpenBalanceDate($format = 'Y-m-d')
	{
		return $this->getDateType('OpenBalanceDate', $format);
	}

	/**
	 * Get the balance for this customer (not including sub-customers or jobs)
	 * 
	 * @return float
	 */
	public function getBalance()
	{
		return $this->get('Balance');
	}

	public function setBalance($value)
	{
		return $this->set('Balance', $value);
	}

	/**
	 * Get the total balance for this customer and all of this customer's sub-customers/jobs
	 * 
	 * @return float
	 */
	public function getTotalBalance()
	{
		return $this->get('TotalBalance');
	}

	public function setTotalBalance($value)
	{
		return $this->set('TotalBalance', $value);
	}
	
	public function setSalesTaxCodeName($name)
	{
		return $this->set('SalesTaxCodeRef FullName', $name);
	}
	
	public function setSalesTaxCodeListID($ListID)
	{
		return $this->set('SalesTaxCodeRef ListID', $ListID);
	}
	
	public function setSalesTaxCodeApplicationID($value)
	{
		return $this->set('SalesTaxCodeRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SALESTAXCODE, QUICKBOOKS_LISTID, $value));
	}

	public function getSalesTaxCodeApplicationID()
	{
		return $this->get('SalesTaxCodeRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getSalesTaxCodeName()
	{
		return $this->get('SalesTaxCodeRef FullName');
	}
	
	public function getSalesTaxCodeListID()
	{
		return $this->get('SalesTaxCodeRef ListID');
	}
	
	/**
	 * Set the credit card information for this customer
	 * 
	 * @param string $cardno		The credit card number
	 * @param integer $expmonth		The expiration month (1 is January, 2 is February, etc.)
	 * @param integer $expyear		The expiration year 
	 * @param string $name			The name on the credit card
	 * @param string $address		The billing address for the credit card
	 * @param string $postalcode	The postal code for the credit card
	 * @return boolean
	 */
	public function setCreditCardInfo($cardno, $expmonth, $expyear, $name, $address, $postalcode)
	{
		// should probably do better checking here for failed sets.
		$b = FALSE;
		$b = $this->set('CreditCardInfo CreditCardNumber', $cardno);
		$b = $this->set('CreditCardInfo ExpirationMonth', $expmonth);
		$b = $this->set('CreditCardInfo ExpirationYear', $expyear);
		$b = $this->set('CreditCardInfo NameOnCard', $name);
		$b = $this->set('CreditCardInfo CreditCardAddress', $address);
		$b = $this->set('CreditCardInfo CreditCardPostalCode', $postalcode);
		
		return $b;
	}
	
	/**
	 * Get credit card information for this customer
	 * 
	 * @param string $part		If you just want a specific part of the card info, specify it here
	 * @param array $defaults	Defaults for the card data if you want the entire array
	 * @return mixed			If you specify a part, a string part is returned, otherwise an array of card data
	 */
	public function getCreditCardInfo($part = null, $defaults = array())
	{
		if (!is_null($part))
		{
			return $this->get('CreditCardInfo ' . $part);
		}
		
		return $this->getArray('CreditCardInfo *', $defaults);		
	}
	
	public function setNotes($notes)
	{
		return $this->set('Notes', $notes);
	}
	
	public function getNotes()
	{
		return $this->get('Notes');
	}
	
	public function setPriceLevelName($name)
	{
		return $this->set('PriceLevelRef FullName', $name);
	}
	
	public function setPriceLevelListID($ListID)
	{
		return $this->set('PriceLevelRef ListID', $ListID);
	}
	
	public function setPriceLevelApplicationID($value)
	{
		return $this->set('PriceLevelRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_PRICELEVEL, QUICKBOOKS_LISTID, $value));
	}

	public function getPriceLevelApplicationID()
	{
		return $this->get('PriceLevelRef ' . QUICKBOOKS_API_APPLICATIONID);
	}
	
	public function getPriceLevelName()
	{
		return $this->get('PriceLevelRef FullName');
	}
	

	/**
	 * Get the price level list id.
	 *
	 * @return string
	 */											
	public function getPriceLevelListID()
	{
		return $this->get('PriceLevelRef ListID');
	}

	/**
	 * Initializes the default name if one hasn't been set.
	 * 
	 * @return boolean
	 */
	protected function _cleanup()
	{
		//return $this->setNameAsFirstLast();
	}
	
	/**
	 * Returns the customer object as an array
	 *
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
	 * @param string $request The type of request to convert this to (examples: CustomerAddRq, CustomerModRq, CustomerQueryRq)
	 * @param boolean $todo_for_empty_elements A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent
	 * @param string $root
	 * @return string
	 */
	public function asQBXML($request, $version = null, $locale = null, $root = null)
	{
		$this->_cleanup();
		
		return parent::asQBXML($request, $version = null, $locale = null, $root);
	}
	
	/**
	 * Tell what type of object this is 
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_CUSTOMER;
	}
}
