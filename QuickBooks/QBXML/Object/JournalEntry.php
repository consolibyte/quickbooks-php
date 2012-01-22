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
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/JournalEntry/JournalCreditLine.php');

/**
 *
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/JournalEntry/JournalDebitLine.php');

/**
 * 
 */
class QuickBooks_QBXML_Object_JournalEntry extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_JournalEntry object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	// Path: TxnDate, datatype: DATETYPE
	
	/**
	 * Set the TxnDate for the JournalEntry
	 * 
	 * @param string $date
	 * @return boolean
	 */
	public function setTxnDate($date)
	{
		return $this->setDateType('TxnDate', $date);
	}

	/**
	 * Get the TxnDate for the JournalEntry
	 * 
	 * @param ? $format = null
	 * @return string
	 */
	public function getTxnDate($format = null)
	{
		return $this->getDateType('TxnDate', $format);
	}

	/**
	 * @see QuickBooks_Object_JournalEntry::setTxnDate()
	 */
	public function setTransactionDate($date)
	{
		return $this->setTxnDate($date); 
	}

	/**
	 * @see QuickBooks_Object_JournalEntry::getTxnDate()
	 */
	public function getTransactionDate($format = null)
	{
		$this->getTxnDate($format = null);
	}
	// Path: RefNumber, datatype: STRTYPE
	
	/**
	 * Set the RefNumber for the JournalEntry
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setRefNumber($value)
	{
		return $this->set('RefNumber', $value);
	}

	/**
	 * Get the RefNumber for the JournalEntry
	 * 
	 * @return string
	 */
	public function getRefNumber()
	{
		return $this->get('RefNumber');
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

	// Path: IsAdjustment, datatype: BOOLTYPE
	
	/**
	 * Set the IsAdjustment for the JournalEntry
	 * 
	 * @param boolean $bool
	 * @return boolean
	 */
	public function setIsAdjustment($bool)
	{
		return $this->setBooleanType('IsAdjustment', $bool);
	}

	/**
	 * Get the IsAdjustment for the JournalEntry
	 * 
	 * @return boolean
	 */
	public function getIsAdjustment()
	{
		return $this->getBooleanType('IsAdjustment');
	}
	
	public function addDebitLine($obj)
	{
		return $this->addListItem('JournalDebitLine', $obj);
	}
	
	public function addJournalDebitLine($obj)
	{
		return $this->addDebitLine($obj);
	}
	
	public function addCreditLine($obj)
	{
		return $this->addListItem('JournalCreditLine', $obj);	
	}
	
	public function addJournalCreditLine($obj)
	{
		return $this->addCreditLine($obj);
	}
	
	/**
	 * Tell the type of object this is
	 * 
	 * @return string
	 */
	public function object()
	{
		return QUICKBOOKS_OBJECT_JOURNALENTRY;
	}		
}

