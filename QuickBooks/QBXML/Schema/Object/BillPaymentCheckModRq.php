<?php

/**
 * Schema object for: BillPaymentCheckModRq
 * 
 * @author "Keith Palmer Jr." <Keith@ConsoliByte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage QBXML
 */

/**
 * 
 */
require_once 'QuickBooks.php';

/**
 * 
 */
require_once 'QuickBooks/QBXML/Schema/Object.php';

/**
 * 
 */
class QuickBooks_QBXML_Schema_Object_BillPaymentCheckModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'BillPaymentCheckMod TxnID' => 'IDTYPE',
  'BillPaymentCheckMod EditSequence' => 'STRTYPE',
  'BillPaymentCheckMod TxnDate' => 'DATETYPE',
  'BillPaymentCheckMod BankAccountRef ListID' => 'IDTYPE',
  'BillPaymentCheckMod BankAccountRef FullName' => 'STRTYPE',
  'BillPaymentCheckMod Amount' => 'AMTTYPE',
  'BillPaymentCheckMod IsToBePrinted' => 'BOOLTYPE',
  'BillPaymentCheckMod RefNumber' => 'STRTYPE',
  'BillPaymentCheckMod Memo' => 'STRTYPE',
  'BillPaymentCheckMod AppliedToTxnMod TxnID' => 'IDTYPE',
  'BillPaymentCheckMod AppliedToTxnMod PaymentAmount' => 'AMTTYPE',
  'BillPaymentCheckMod AppliedToTxnMod SetCredit CreditTxnID' => 'IDTYPE',
  'BillPaymentCheckMod AppliedToTxnMod SetCredit TxnLineID' => 'IDTYPE',
  'BillPaymentCheckMod AppliedToTxnMod SetCredit AppliedAmount' => 'AMTTYPE',
  'BillPaymentCheckMod AppliedToTxnMod DiscountAmount' => 'AMTTYPE',
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef ListID' => 'IDTYPE',
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'BillPaymentCheckMod TxnID' => 0,
  'BillPaymentCheckMod EditSequence' => 16,
  'BillPaymentCheckMod TxnDate' => 0,
  'BillPaymentCheckMod BankAccountRef ListID' => 0,
  'BillPaymentCheckMod BankAccountRef FullName' => 159,
  'BillPaymentCheckMod Amount' => 0,
  'BillPaymentCheckMod IsToBePrinted' => 0,
  'BillPaymentCheckMod RefNumber' => 11,
  'BillPaymentCheckMod Memo' => 4095,
  'BillPaymentCheckMod AppliedToTxnMod TxnID' => 0,
  'BillPaymentCheckMod AppliedToTxnMod PaymentAmount' => 0,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit CreditTxnID' => 0,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit TxnLineID' => 0,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit AppliedAmount' => 0,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAmount' => 0,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef ListID' => 0,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef FullName' => 159,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'BillPaymentCheckMod TxnID' => false,
  'BillPaymentCheckMod EditSequence' => false,
  'BillPaymentCheckMod TxnDate' => true,
  'BillPaymentCheckMod BankAccountRef ListID' => true,
  'BillPaymentCheckMod BankAccountRef FullName' => true,
  'BillPaymentCheckMod Amount' => true,
  'BillPaymentCheckMod IsToBePrinted' => false,
  'BillPaymentCheckMod RefNumber' => false,
  'BillPaymentCheckMod Memo' => true,
  'BillPaymentCheckMod AppliedToTxnMod TxnID' => false,
  'BillPaymentCheckMod AppliedToTxnMod PaymentAmount' => true,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit CreditTxnID' => false,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit TxnLineID' => true,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit AppliedAmount' => false,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAmount' => true,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef ListID' => true,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'BillPaymentCheckMod TxnID' => 999.99,
  'BillPaymentCheckMod EditSequence' => 999.99,
  'BillPaymentCheckMod TxnDate' => 999.99,
  'BillPaymentCheckMod BankAccountRef ListID' => 999.99,
  'BillPaymentCheckMod BankAccountRef FullName' => 999.99,
  'BillPaymentCheckMod Amount' => 999.99,
  'BillPaymentCheckMod IsToBePrinted' => 999.99,
  'BillPaymentCheckMod RefNumber' => 999.99,
  'BillPaymentCheckMod Memo' => 999.99,
  'BillPaymentCheckMod AppliedToTxnMod TxnID' => 999.99,
  'BillPaymentCheckMod AppliedToTxnMod PaymentAmount' => 999.99,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit CreditTxnID' => 0,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit TxnLineID' => 999.99,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit AppliedAmount' => 999.99,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAmount' => 999.99,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef ListID' => 999.99,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef FullName' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'BillPaymentCheckMod TxnID' => false,
  'BillPaymentCheckMod EditSequence' => false,
  'BillPaymentCheckMod TxnDate' => false,
  'BillPaymentCheckMod BankAccountRef ListID' => false,
  'BillPaymentCheckMod BankAccountRef FullName' => false,
  'BillPaymentCheckMod Amount' => false,
  'BillPaymentCheckMod IsToBePrinted' => false,
  'BillPaymentCheckMod RefNumber' => false,
  'BillPaymentCheckMod Memo' => false,
  'BillPaymentCheckMod AppliedToTxnMod TxnID' => false,
  'BillPaymentCheckMod AppliedToTxnMod PaymentAmount' => false,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit CreditTxnID' => false,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit TxnLineID' => false,
  'BillPaymentCheckMod AppliedToTxnMod SetCredit AppliedAmount' => false,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAmount' => false,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef ListID' => false,
  'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef FullName' => false,
  'IncludeRetElement' => true,
);
			
		return $paths;
	}
	
	/*
	abstract protected function &_inLocalePaths()
	{
		static $paths = array(
			'FirstName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ), 
			'LastName' => array( 'QBD', 'QBCA', 'QBUK', 'QBAU' ),
			);
		
		return $paths;
	}
	*/
	
	protected function &_reorderPathsPaths()
	{
		static $paths = array (
  0 => 'BillPaymentCheckMod TxnID',
  1 => 'BillPaymentCheckMod EditSequence',
  2 => 'BillPaymentCheckMod TxnDate',
  3 => 'BillPaymentCheckMod BankAccountRef ListID',
  4 => 'BillPaymentCheckMod BankAccountRef FullName',
  5 => 'BillPaymentCheckMod Amount',
  6 => 'BillPaymentCheckMod IsToBePrinted',
  7 => 'BillPaymentCheckMod RefNumber',
  8 => 'BillPaymentCheckMod Memo',
  9 => 'BillPaymentCheckMod AppliedToTxnMod TxnID',
  10 => 'BillPaymentCheckMod AppliedToTxnMod PaymentAmount',
  11 => 'BillPaymentCheckMod AppliedToTxnMod SetCredit CreditTxnID',
  12 => 'BillPaymentCheckMod AppliedToTxnMod SetCredit TxnLineID',
  13 => 'BillPaymentCheckMod AppliedToTxnMod SetCredit AppliedAmount',
  14 => 'BillPaymentCheckMod AppliedToTxnMod DiscountAmount',
  15 => 'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef ListID',
  16 => 'BillPaymentCheckMod AppliedToTxnMod DiscountAccountRef FullName',
  17 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>