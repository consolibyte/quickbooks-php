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
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'BillPaymentCheckAdd PayeeEntityRef ListID' => 'IDTYPE',
  'BillPaymentCheckAdd PayeeEntityRef FullName' => 'STRTYPE',
  'BillPaymentCheckAdd APAccountRef ListID' => 'IDTYPE',
  'BillPaymentCheckAdd APAccountRef FullName' => 'STRTYPE',
  'BillPaymentCheckAdd TxnDate' => 'DATETYPE',
  'BillPaymentCheckAdd BankAccountRef ListID' => 'IDTYPE',
  'BillPaymentCheckAdd BankAccountRef FullName' => 'STRTYPE',
  'BillPaymentCheckAdd IsToBePrinted' => 'BOOLTYPE',
  'BillPaymentCheckAdd RefNumber' => 'STRTYPE',
  'BillPaymentCheckAdd Memo' => 'STRTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd TxnID' => 'IDTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd PaymentAmount' => 'AMTTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => 'IDTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail Amount' => 'AMTTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit CreditTxnID' => 'IDTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit TxnLineID' => 'IDTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit AppliedAmount' => 'AMTTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAmount' => 'AMTTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef ListID' => 'IDTYPE',
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'BillPaymentCheckAdd PayeeEntityRef ListID' => 0,
  'BillPaymentCheckAdd PayeeEntityRef FullName' => 209,
  'BillPaymentCheckAdd APAccountRef ListID' => 0,
  'BillPaymentCheckAdd APAccountRef FullName' => 209,
  'BillPaymentCheckAdd TxnDate' => 0,
  'BillPaymentCheckAdd BankAccountRef ListID' => 0,
  'BillPaymentCheckAdd BankAccountRef FullName' => 209,
  'BillPaymentCheckAdd IsToBePrinted' => 0,
  'BillPaymentCheckAdd RefNumber' => 11,
  'BillPaymentCheckAdd Memo' => 4095,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnID' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd PaymentAmount' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail Amount' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit CreditTxnID' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit TxnLineID' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit AppliedAmount' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAmount' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef ListID' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef FullName' => 209,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'BillPaymentCheckAdd PayeeEntityRef ListID' => true,
  'BillPaymentCheckAdd PayeeEntityRef FullName' => true,
  'BillPaymentCheckAdd APAccountRef ListID' => true,
  'BillPaymentCheckAdd APAccountRef FullName' => true,
  'BillPaymentCheckAdd TxnDate' => true,
  'BillPaymentCheckAdd BankAccountRef ListID' => true,
  'BillPaymentCheckAdd BankAccountRef FullName' => true,
  'BillPaymentCheckAdd IsToBePrinted' => false,
  'BillPaymentCheckAdd RefNumber' => false,
  'BillPaymentCheckAdd Memo' => true,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd PaymentAmount' => true,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail Amount' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit CreditTxnID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit TxnLineID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit AppliedAmount' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAmount' => true,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef ListID' => true,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'BillPaymentCheckAdd PayeeEntityRef ListID' => 999.99,
  'BillPaymentCheckAdd PayeeEntityRef FullName' => 999.99,
  'BillPaymentCheckAdd APAccountRef ListID' => 999.99,
  'BillPaymentCheckAdd APAccountRef FullName' => 999.99,
  'BillPaymentCheckAdd TxnDate' => 999.99,
  'BillPaymentCheckAdd BankAccountRef ListID' => 999.99,
  'BillPaymentCheckAdd BankAccountRef FullName' => 999.99,
  'BillPaymentCheckAdd IsToBePrinted' => 999.99,
  'BillPaymentCheckAdd RefNumber' => 999.99,
  'BillPaymentCheckAdd Memo' => 3,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnID' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd PaymentAmount' => 999.99,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => 999.99,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail Amount' => 999.99,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit CreditTxnID' => 0,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit TxnLineID' => 999.99,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit AppliedAmount' => 999.99,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAmount' => 999.99,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef ListID' => 999.99,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'BillPaymentCheckAdd PayeeEntityRef ListID' => false,
  'BillPaymentCheckAdd PayeeEntityRef FullName' => false,
  'BillPaymentCheckAdd APAccountRef ListID' => false,
  'BillPaymentCheckAdd APAccountRef FullName' => false,
  'BillPaymentCheckAdd TxnDate' => false,
  'BillPaymentCheckAdd BankAccountRef ListID' => false,
  'BillPaymentCheckAdd BankAccountRef FullName' => false,
  'BillPaymentCheckAdd IsToBePrinted' => false,
  'BillPaymentCheckAdd RefNumber' => false,
  'BillPaymentCheckAdd Memo' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd PaymentAmount' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail Amount' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit CreditTxnID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit TxnLineID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd SetCredit AppliedAmount' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAmount' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef ListID' => false,
  'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef FullName' => false,
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
  0 => 'BillPaymentCheckAdd',
  1 => 'BillPaymentCheckAdd PayeeEntityRef',
  2 => 'BillPaymentCheckAdd PayeeEntityRef ListID',
  3 => 'BillPaymentCheckAdd PayeeEntityRef FullName',
  4 => 'BillPaymentCheckAdd APAccountRef ListID',
  5 => 'BillPaymentCheckAdd APAccountRef FullName',
  6 => 'BillPaymentCheckAdd TxnDate',
  7 => 'BillPaymentCheckAdd BankAccountRef ListID',
  8 => 'BillPaymentCheckAdd BankAccountRef FullName',
  9 => 'BillPaymentCheckAdd IsToBePrinted',
  10 => 'BillPaymentCheckAdd RefNumber',
  11 => 'BillPaymentCheckAdd Memo',
  12 => 'BillPaymentCheckAdd AppliedToTxnAdd TxnID',
  13 => 'BillPaymentCheckAdd AppliedToTxnAdd PaymentAmount',
  14 => 'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail TxnLineID',
  15 => 'BillPaymentCheckAdd AppliedToTxnAdd TxnLineDetail Amount',
  16 => 'BillPaymentCheckAdd AppliedToTxnAdd SetCredit CreditTxnID',
  17 => 'BillPaymentCheckAdd AppliedToTxnAdd SetCredit TxnLineID',
  18 => 'BillPaymentCheckAdd AppliedToTxnAdd SetCredit AppliedAmount',
  19 => 'BillPaymentCheckAdd AppliedToTxnAdd DiscountAmount',
  20 => 'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef ListID',
  21 => 'BillPaymentCheckAdd AppliedToTxnAdd DiscountAccountRef FullName',
  22 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>