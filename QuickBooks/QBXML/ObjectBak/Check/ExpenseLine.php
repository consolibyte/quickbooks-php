<?php 

/**
 * Check ExpenseLine class for QuickBooks 
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
class QuickBooks_QBXML_Object_Check_ExpenseLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Check_ExpenseLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	// Path: AccountRef ListID, datatype: 
	
	/**
	 * Set the AccountRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setAccountListID($ListID)
	{
		return $this->set('AccountRef ListID', $ListID);
	}

	/**
	 * Get the AccountRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getAccountListID()
	{
		return $this->get('AccountRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setAccountApplicationID($value)
	{
		return $this->set('AccountRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ACCOUNT, QUICKBOOKS_LISTID, $value));
	}

	// Path: AccountRef FullName, datatype: 
	
	/**
	 * Set the AccountRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setAccountName($FullName)
	{
		return $this->set('AccountRef FullName', $FullName);
	}

	/**
	 * Get the AccountRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getAccountName()
	{
		return $this->get('AccountRef FullName');
	}

	// Path: Amount, datatype: 
	
	/**
	 * Set the Amount for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setAmount($value)
	{
		return $this->set('Amount', $value);
	}

	/**
	 * Get the Amount for the Check
	 * 
	 * @return string
	 */
	public function getAmount()
	{
		return $this->get('Amount');
	}

	// Path: TaxAmount, datatype: 
	
	/**
	 * Set the TaxAmount for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setTaxAmount($value)
	{
		return $this->set('TaxAmount', $value);
	}

	/**
	 * Get the TaxAmount for the Check
	 * 
	 * @return string
	 */
	public function getTaxAmount()
	{
		return $this->get('TaxAmount');
	}

	// Path: Memo, datatype: STRTYPE
	
	/**
	 * Set the Memo for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setMemo($value)
	{
		return $this->set('Memo', $value);
	}

	/**
	 * Get the Memo for the Check
	 * 
	 * @return string
	 */
	public function getMemo()
	{
		return $this->get('Memo');
	}

	// Path: CustomerRef ListID, datatype: 
	
	/**
	 * Set the CustomerRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setCustomerListID($ListID)
	{
		return $this->set('CustomerRef ListID', $ListID);
	}

	/**
	 * Get the CustomerRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getCustomerListID()
	{
		return $this->get('CustomerRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setCustomerApplicationID($value)
	{
		return $this->set('CustomerRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_LISTID, $value));
	}

	// Path: CustomerRef FullName, datatype: 
	
	/**
	 * Set the CustomerRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setCustomerFullName($FullName)
	{
		return $this->set('CustomerRef FullName', $FullName);
	}

	/**
	 * Get the CustomerRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getCustomerFullName()
	{
		return $this->get('CustomerRef FullName');
	}

	// Path: ClassRef ListID, datatype: 
	
	/**
	 * Set the ClassRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}

	/**
	 * Get the ClassRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setClassApplicationID($value)
	{
		return $this->set('ClassRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CLASS, QUICKBOOKS_LISTID, $value));
	}

	// Path: ClassRef FullName, datatype: 
	
	/**
	 * Set the ClassRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setClassName($FullName)
	{
		return $this->set('ClassRef FullName', $FullName);
	}

	/**
	 * Get the ClassRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getClassName()
	{
		return $this->get('ClassRef FullName');
	}

	// Path: SalesTaxCodeRef ListID, datatype: 
	
	/**
	 * Set the SalesTaxCodeRef ListID for the Check
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setSalesTaxCodeListID($ListID)
	{
		return $this->set('SalesTaxCodeRef ListID', $ListID);
	}

	/**
	 * Get the SalesTaxCodeRef ListID for the Check
	 * 
	 * @return string
	 */
	public function getSalesTaxCodeListID()
	{
		return $this->get('SalesTaxCodeRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the Check
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setSalesTaxCodeApplicationID($value)
	{
		return $this->set('SalesTaxCodeRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_SALESTAXCODE, QUICKBOOKS_LISTID, $value));
	}

	// Path: SalesTaxCodeRef FullName, datatype: 
	
	/**
	 * Set the SalesTaxCodeRef FullName for the Check
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setSalesTaxCodeName($FullName)
	{
		return $this->set('SalesTaxCodeRef FullName', $FullName);
	}

	/**
	 * Get the SalesTaxCodeRef FullName for the Check
	 * 
	 * @return string
	 */
	public function getSalesTaxCodeName()
	{
		return $this->get('SalesTaxCodeRef FullName');
	}

	// Path: BillableStatus, datatype: 
	
	/**
	 * Set the BillableStatus for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setBillableStatus($value)
	{
		return $this->set('BillableStatus', $value);
	}

	/**
	 * Get the BillableStatus for the Check
	 * 
	 * @return string
	 */
	public function getBillableStatus()
	{
		return $this->get('BillableStatus');
	}

	public function object()
	{
		return 'ExpenseLine';
	}
}

