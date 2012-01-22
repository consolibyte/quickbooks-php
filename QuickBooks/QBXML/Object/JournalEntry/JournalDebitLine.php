<?php 
/**
 * JournalEntry class for QuickBooks 
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
class QuickBooks_QBXML_Object_JournalEntry_JournalDebitLine extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_JournalEntry_JournalDebitLine object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	// Path: TxnLineID, datatype: 
	
	/**
	 * Set the TxnLineID for the JournalEntry
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setTxnLineID($value)
	{
		return $this->set('TxnLineID', $value);
	}

	/**
	 * Get the TxnLineID for the JournalEntry
	 * 
	 * @return string
	 */
	public function getTxnLineID()
	{
		return $this->get('TxnLineID');
	}

	// Path: AccountRef ListID, datatype: 
	
	/**
	 * Set the AccountRef ListID for the JournalEntry
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setAccountListID($ListID)
	{
		return $this->set('AccountRef ListID', $ListID);
	}

	/**
	 * Get the AccountRef ListID for the JournalEntry
	 * 
	 * @return string
	 */
	public function getAccountListID()
	{
		return $this->get('AccountRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the JournalEntry
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
	 * Set the AccountRef FullName for the JournalEntry
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setAccountName($FullName)
	{
		return $this->set('AccountRef FullName', $FullName);
	}

	/**
	 * Get the AccountRef FullName for the JournalEntry
	 * 
	 * @return string
	 */
	public function getAccountName()
	{
		return $this->get('AccountRef FullName');
	}

	// Path: Amount, datatype: 
	
	/**
	 * Set the Amount for the JournalEntry
	 * 
	 * @param float $value
	 * @return boolean
	 */
	public function setAmount($value)
	{
		return $this->setAmountType('Amount', $value);
	}

	/**
	 * Get the Amount for the JournalEntry
	 * 
	 * @return float
	 */
	public function getAmount()
	{
		return $this->getAmountType('Amount');
	}

	// Path: Memo, datatype: STRTYPE
	
	/**
	 * Set the Memo for the JournalEntry
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setMemo($value)
	{
		return $this->set('Memo', $value);
	}

	/**
	 * Get the Memo for the JournalEntry
	 * 
	 * @return string
	 */
	public function getMemo()
	{
		return $this->get('Memo');
	}

	// Path: EntityRef ListID, datatype: STRTYPE
	
	/**
	 * Set the EntityRef ListID for the JournalEntry
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setEntityListID($ListID)
	{
		return $this->set('EntityRef ListID', $ListID);
	}

	/**
	 * Get the EntityRef ListID for the JournalEntry
	 * 
	 * @return string
	 */
	public function getEntityListID()
	{
		return $this->get('EntityRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the JournalEntry
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setEntityApplicationID($value)
	{
		return $this->set('EntityRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ENTITY, QUICKBOOKS_LISTID, $value));
	}

	// Path: EntityRef FullName, datatype: STRTYPE
	
	/**
	 * Set the EntityRef FullName for the JournalEntry
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setEntityName($FullName)
	{
		return $this->set('EntityRef FullName', $FullName);
	}

	/**
	 * Get the EntityRef FullName for the JournalEntry
	 * 
	 * @return string
	 */
	public function getEntityName()
	{
		return $this->get('EntityRef FullName');
	}

	// Path: ClassRef ListID, datatype: STRTYPE
	
	/**
	 * Set the ClassRef ListID for the JournalEntry
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setClassListID($ListID)
	{
		return $this->set('ClassRef ListID', $ListID);
	}

	/**
	 * Get the ClassRef ListID for the JournalEntry
	 * 
	 * @return string
	 */
	public function getClassListID()
	{
		return $this->get('ClassRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the JournalEntry
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setClassApplicationID($value)
	{
		return $this->set('ClassRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_CLASS, QUICKBOOKS_LISTID, $value));
	}

	// Path: ClassRef FullName, datatype: STRTYPE
	
	/**
	 * Set the ClassRef FullName for the JournalEntry
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setClassName($FullName)
	{
		return $this->set('ClassRef FullName', $FullName);
	}

	/**
	 * Get the ClassRef FullName for the JournalEntry
	 * 
	 * @return string
	 */
	public function getClassName()
	{
		return $this->get('ClassRef FullName');
	}

	// Path: ItemSalesTaxRef ListID, datatype: STRTYPE
	
	/**
	 * Set the ItemSalesTaxRef ListID for the JournalEntry
	 * 
	 * @param string $ListID		The ListID of the record to reference
	 * @return boolean
	 */
	public function setItemSalesTaxListID($ListID)
	{
		return $this->set('ItemSalesTaxRef ListID', $ListID);
	}

	/**
	 * Get the ItemSalesTaxRef ListID for the JournalEntry
	 * 
	 * @return string
	 */
	public function getItemSalesTaxListID()
	{
		return $this->get('ItemSalesTaxRef ListID');
	}

	/**
	 * Set the primary key for the related record within your own application for the JournalEntry
	 * 
	 * @param mixed $value			The primary key within your own application
	 * @return string
	 */
	public function setItemSalesTaxApplicationID($value)
	{
		return $this->set('ItemSalesTaxRef ' . QUICKBOOKS_API_APPLICATIONID, $this->encodeApplicationID(QUICKBOOKS_OBJECT_ITEMSALESTAX, QUICKBOOKS_LISTID, $value));
	}

	// Path: ItemSalesTaxRef FullName, datatype: STRTYPE
	
	/**
	 * Set the ItemSalesTaxRef FullName for the JournalEntry
	 * 
	 * @param string $FullName		The FullName of the record to reference
	 * @return boolean
	 */
	public function setItemSalesTaxName($FullName)
	{
		return $this->set('ItemSalesTaxRef FullName', $FullName);
	}

	/**
	 * Get the ItemSalesTaxRef FullName for the JournalEntry
	 * 
	 * @return string
	 */
	public function getItemSalesTaxName()
	{
		return $this->get('ItemSalesTaxRef FullName');
	}

	// Path: BillableStatus, datatype: 
	
	/**
	 * Set the BillableStatus for the JournalEntry
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setBillableStatus($value)
	{
		return $this->set('BillableStatus', $value);
	}

	/**
	 * Get the BillableStatus for the JournalEntry
	 * 
	 * @return string
	 */
	public function getBillableStatus()
	{
		return $this->get('BillableStatus');
	}
		
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return 'JournalDebitLine';
	}

}

