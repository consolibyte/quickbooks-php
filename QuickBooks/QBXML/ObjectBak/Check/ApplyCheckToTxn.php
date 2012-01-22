<?php 

/**
 * Check class for QuickBooks 
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
 * Check base class
 */
QuickBooks_Loader::load('/QuickBooks/QBXML/Object/Check.php');

/**
 * 
 */
class QuickBooks_QBXML_Object_Check_ApplyCheckToTxn extends QuickBooks_QBXML_Object
{
	/**
	 * Create a new QuickBooks_Object_Check_ApplyCheckToTxnAdd object
	 * 
	 * @param array $arr
	 */
	public function __construct($arr = array())
	{
		parent::__construct($arr);
	}

	// Path: TxnID, datatype: 
	
	/**
	 * Set the TxnID for the Check
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function setTxnID($value)
	{
		return $this->set('TxnID', $value);
	}

	/**
	 * Get the TxnID for the Check
	 * 
	 * @return string
	 */
	public function getTxnID()
	{
		return $this->get('TxnID');
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
	
	public function object()
	{
		return 'ApplyCheckToTxn';
	}
}

