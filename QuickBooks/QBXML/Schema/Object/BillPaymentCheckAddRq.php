<?php

/**
 * Schema object for: BillPaymentCheckAddRq
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
class QuickBooks_QBXML_Schema_Object_BillPaymentCheckAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'BillPaymentCheckAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
			'PayeeEntityRef ListID' => 'IDTYPE',
			'PayeeEntityRef FullName' => 'STRTYPE',
			'APAccountRef ListID' => 'IDTYPE',
			'APAccountRef FullName' => 'STRTYPE',
			'TxnDate' => 'DATETYPE',
			'BankAccountRef ListID' => 'IDTYPE',
			'BankAccountRef FullName' => 'STRTYPE',
			'IsToBePrinted' => 'BOOLTYPE',
			'RefNumber' => 'STRTYPE',
			'Memo' => 'STRTYPE',
			'AppliedToTxnAdd TxnID' => 'IDTYPE',
			'AppliedToTxnAdd PaymentAmount' => 'AMTTYPE',
			'AppliedToTxnAdd TxnLineDetail TxnLineID' => 'IDTYPE',
			'AppliedToTxnAdd TxnLineDetail Amount' => 'AMTTYPE',
			'AppliedToTxnAdd SetCredit CreditTxnID' => 'IDTYPE',
			'AppliedToTxnAdd SetCredit TxnLineID' => 'IDTYPE',
			'AppliedToTxnAdd SetCredit AppliedAmount' => 'AMTTYPE',
			'AppliedToTxnAdd DiscountAmount' => 'AMTTYPE',
			'AppliedToTxnAdd DiscountAccountRef ListID' => 'IDTYPE',
			'AppliedToTxnAdd DiscountAccountRef FullName' => 'STRTYPE',
			'IncludeRetElement' => 'STRTYPE',
		);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
			'PayeeEntityRef ListID' => 0,
			'PayeeEntityRef FullName' => 209,
			'APAccountRef ListID' => 0,
			'APAccountRef FullName' => 209,
			'TxnDate' => 0,
			'BankAccountRef ListID' => 0,
			'BankAccountRef FullName' => 209,
			'IsToBePrinted' => 0,
			'RefNumber' => 11,
			'Memo' => 4095,
			'AppliedToTxnAdd TxnID' => 0,
			'AppliedToTxnAdd PaymentAmount' => 0,
			'AppliedToTxnAdd TxnLineDetail TxnLineID' => 0,
			'AppliedToTxnAdd TxnLineDetail Amount' => 0,
			'AppliedToTxnAdd SetCredit CreditTxnID' => 0,
			'AppliedToTxnAdd SetCredit TxnLineID' => 0,
			'AppliedToTxnAdd SetCredit AppliedAmount' => 0,
			'AppliedToTxnAdd DiscountAmount' => 0,
			'AppliedToTxnAdd DiscountAccountRef ListID' => 0,
			'AppliedToTxnAdd DiscountAccountRef FullName' => 209,
			'IncludeRetElement' => 50,
			);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
			'PayeeEntityRef ListID' => true,
			'PayeeEntityRef FullName' => true,
			'APAccountRef ListID' => true,
			'APAccountRef FullName' => true,
			'TxnDate' => true,
			'BankAccountRef ListID' => true,
			'BankAccountRef FullName' => true,
			'IsToBePrinted' => false,
			'RefNumber' => false,
			'Memo' => true,
			'AppliedToTxnAdd TxnID' => false,
			'AppliedToTxnAdd PaymentAmount' => true,
			'AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
			'AppliedToTxnAdd TxnLineDetail Amount' => false,
			'AppliedToTxnAdd SetCredit CreditTxnID' => false,
			'AppliedToTxnAdd SetCredit TxnLineID' => false,
			'AppliedToTxnAdd SetCredit AppliedAmount' => false,
			'AppliedToTxnAdd DiscountAmount' => true,
			'AppliedToTxnAdd DiscountAccountRef ListID' => true,
			'AppliedToTxnAdd DiscountAccountRef FullName' => true,
			'IncludeRetElement' => true,
			);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
			'PayeeEntityRef ListID' => 999.99,
			'PayeeEntityRef FullName' => 999.99,
			'APAccountRef ListID' => 999.99,
			'APAccountRef FullName' => 999.99,
			'TxnDate' => 999.99,
			'BankAccountRef ListID' => 999.99,
			'BankAccountRef FullName' => 999.99,
			'IsToBePrinted' => 999.99,
			'RefNumber' => 999.99,
			'Memo' => 3,
			'AppliedToTxnAdd TxnID' => 0,
			'AppliedToTxnAdd PaymentAmount' => 999.99,
			'AppliedToTxnAdd TxnLineDetail TxnLineID' => 999.99,
			'AppliedToTxnAdd TxnLineDetail Amount' => 999.99,
			'AppliedToTxnAdd SetCredit CreditTxnID' => 0,
			'AppliedToTxnAdd SetCredit TxnLineID' => 999.99,
			'AppliedToTxnAdd SetCredit AppliedAmount' => 999.99,
			'AppliedToTxnAdd DiscountAmount' => 999.99,
			'AppliedToTxnAdd DiscountAccountRef ListID' => 999.99,
			'AppliedToTxnAdd DiscountAccountRef FullName' => 999.99,
			'IncludeRetElement' => 4,
			);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
			'PayeeEntityRef ListID' => false,
			'PayeeEntityRef FullName' => false,
			'APAccountRef ListID' => false,
			'APAccountRef FullName' => false,
			'TxnDate' => false,
			'BankAccountRef ListID' => false,
			'BankAccountRef FullName' => false,
			'IsToBePrinted' => false,
			'RefNumber' => false,
			'Memo' => false,
			'AppliedToTxnAdd TxnID' => false,
			'AppliedToTxnAdd PaymentAmount' => false,
			'AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
			'AppliedToTxnAdd TxnLineDetail Amount' => false,
			'AppliedToTxnAdd SetCredit CreditTxnID' => false,
			'AppliedToTxnAdd SetCredit TxnLineID' => false,
			'AppliedToTxnAdd SetCredit AppliedAmount' => false,
			'AppliedToTxnAdd DiscountAmount' => false,
			'AppliedToTxnAdd DiscountAccountRef ListID' => false,
			'AppliedToTxnAdd DiscountAccountRef FullName' => false,
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
			'PayeeEntityRef',
			'PayeeEntityRef ListID',
			'PayeeEntityRef FullName',
			'APAccountRef ListID',
			'APAccountRef FullName',
			'TxnDate',
			'BankAccountRef ListID',
			'BankAccountRef FullName',
			'IsToBePrinted',
			'RefNumber',
			'Memo',
			'AppliedToTxnAdd', 
			'AppliedToTxnAdd TxnID',
			'AppliedToTxnAdd PaymentAmount',
			'AppliedToTxnAdd TxnLineDetail TxnLineID',
			'AppliedToTxnAdd TxnLineDetail Amount',
			'AppliedToTxnAdd SetCredit CreditTxnID',
			'AppliedToTxnAdd SetCredit TxnLineID',
			'AppliedToTxnAdd SetCredit AppliedAmount',
			'AppliedToTxnAdd DiscountAmount',
			'AppliedToTxnAdd DiscountAccountRef ListID',
			'AppliedToTxnAdd DiscountAccountRef FullName',
			'IncludeRetElement',
		);
			
		return $paths;
	}
}
