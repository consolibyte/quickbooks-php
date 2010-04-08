<?php

/**
 * Schema object for: BillPaymentCreditCardAddRq
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
class QuickBooks_QBXML_Schema_Object_BillPaymentCreditCardAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'BillPaymentCreditCardAdd PayeeEntityRef ListID' => 'IDTYPE',
  'BillPaymentCreditCardAdd PayeeEntityRef FullName' => 'STRTYPE',
  'BillPaymentCreditCardAdd APAccountRef ListID' => 'IDTYPE',
  'BillPaymentCreditCardAdd APAccountRef FullName' => 'STRTYPE',
  'BillPaymentCreditCardAdd TxnDate' => 'DATETYPE',
  'BillPaymentCreditCardAdd CreditCardAccountRef ListID' => 'IDTYPE',
  'BillPaymentCreditCardAdd CreditCardAccountRef FullName' => 'STRTYPE',
  'BillPaymentCreditCardAdd RefNumber' => 'STRTYPE',
  'BillPaymentCreditCardAdd Memo' => 'STRTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnID' => 'IDTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd PaymentAmount' => 'AMTTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => 'IDTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail Amount' => 'AMTTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit CreditTxnID' => 'IDTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit TxnLineID' => 'IDTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit AppliedAmount' => 'AMTTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAmount' => 'AMTTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef ListID' => 'IDTYPE',
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'BillPaymentCreditCardAdd PayeeEntityRef ListID' => 0,
  'BillPaymentCreditCardAdd PayeeEntityRef FullName' => 209,
  'BillPaymentCreditCardAdd APAccountRef ListID' => 0,
  'BillPaymentCreditCardAdd APAccountRef FullName' => 209,
  'BillPaymentCreditCardAdd TxnDate' => 0,
  'BillPaymentCreditCardAdd CreditCardAccountRef ListID' => 0,
  'BillPaymentCreditCardAdd CreditCardAccountRef FullName' => 209,
  'BillPaymentCreditCardAdd RefNumber' => 11,
  'BillPaymentCreditCardAdd Memo' => 4095,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnID' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd PaymentAmount' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail Amount' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit CreditTxnID' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit TxnLineID' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit AppliedAmount' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAmount' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef ListID' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef FullName' => 209,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'BillPaymentCreditCardAdd PayeeEntityRef ListID' => true,
  'BillPaymentCreditCardAdd PayeeEntityRef FullName' => true,
  'BillPaymentCreditCardAdd APAccountRef ListID' => true,
  'BillPaymentCreditCardAdd APAccountRef FullName' => true,
  'BillPaymentCreditCardAdd TxnDate' => true,
  'BillPaymentCreditCardAdd CreditCardAccountRef ListID' => true,
  'BillPaymentCreditCardAdd CreditCardAccountRef FullName' => true,
  'BillPaymentCreditCardAdd RefNumber' => true,
  'BillPaymentCreditCardAdd Memo' => true,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd PaymentAmount' => true,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail Amount' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit CreditTxnID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit TxnLineID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit AppliedAmount' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAmount' => true,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef ListID' => true,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'BillPaymentCreditCardAdd PayeeEntityRef ListID' => 999.99,
  'BillPaymentCreditCardAdd PayeeEntityRef FullName' => 999.99,
  'BillPaymentCreditCardAdd APAccountRef ListID' => 999.99,
  'BillPaymentCreditCardAdd APAccountRef FullName' => 999.99,
  'BillPaymentCreditCardAdd TxnDate' => 999.99,
  'BillPaymentCreditCardAdd CreditCardAccountRef ListID' => 999.99,
  'BillPaymentCreditCardAdd CreditCardAccountRef FullName' => 999.99,
  'BillPaymentCreditCardAdd RefNumber' => 999.99,
  'BillPaymentCreditCardAdd Memo' => 3,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnID' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd PaymentAmount' => 999.99,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => 999.99,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail Amount' => 999.99,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit CreditTxnID' => 0,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit TxnLineID' => 999.99,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit AppliedAmount' => 999.99,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAmount' => 999.99,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef ListID' => 999.99,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'BillPaymentCreditCardAdd PayeeEntityRef ListID' => false,
  'BillPaymentCreditCardAdd PayeeEntityRef FullName' => false,
  'BillPaymentCreditCardAdd APAccountRef ListID' => false,
  'BillPaymentCreditCardAdd APAccountRef FullName' => false,
  'BillPaymentCreditCardAdd TxnDate' => false,
  'BillPaymentCreditCardAdd CreditCardAccountRef ListID' => false,
  'BillPaymentCreditCardAdd CreditCardAccountRef FullName' => false,
  'BillPaymentCreditCardAdd RefNumber' => false,
  'BillPaymentCreditCardAdd Memo' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd PaymentAmount' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail TxnLineID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail Amount' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit CreditTxnID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit TxnLineID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit AppliedAmount' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAmount' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef ListID' => false,
  'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef FullName' => false,
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
  0 => 'BillPaymentCreditCardAdd',
  1 => 'BillPaymentCreditCardAdd PayeeEntityRef',
  2 => 'BillPaymentCreditCardAdd PayeeEntityRef ListID',
  3 => 'BillPaymentCreditCardAdd PayeeEntityRef FullName',
  4 => 'BillPaymentCreditCardAdd APAccountRef ListID',
  5 => 'BillPaymentCreditCardAdd APAccountRef FullName',
  6 => 'BillPaymentCreditCardAdd TxnDate',
  7 => 'BillPaymentCreditCardAdd CreditCardAccountRef ListID',
  8 => 'BillPaymentCreditCardAdd CreditCardAccountRef FullName',
  9 => 'BillPaymentCreditCardAdd RefNumber',
  10 => 'BillPaymentCreditCardAdd Memo',
  11 => 'BillPaymentCreditCardAdd AppliedToTxnAdd TxnID',
  12 => 'BillPaymentCreditCardAdd AppliedToTxnAdd PaymentAmount',
  13 => 'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail TxnLineID',
  14 => 'BillPaymentCreditCardAdd AppliedToTxnAdd TxnLineDetail Amount',
  15 => 'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit CreditTxnID',
  16 => 'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit TxnLineID',
  17 => 'BillPaymentCreditCardAdd AppliedToTxnAdd SetCredit AppliedAmount',
  18 => 'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAmount',
  19 => 'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef ListID',
  20 => 'BillPaymentCreditCardAdd AppliedToTxnAdd DiscountAccountRef FullName',
  21 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>