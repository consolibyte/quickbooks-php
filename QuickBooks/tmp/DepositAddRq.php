<?php

/**
 * Schema object for: DepositAddRq
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
class QuickBooks_QBXML_Schema_Object_DepositAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'DepositAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TxnDate' => 'DATETYPE',
  'DepositToAccountRef ListID' => 'IDTYPE',
  'DepositToAccountRef FullName' => 'STRTYPE',
  'Memo' => 'STRTYPE',
  'CashBackInfoAdd AccountRef ListID' => 'IDTYPE',
  'CashBackInfoAdd AccountRef FullName' => 'STRTYPE',
  'CashBackInfoAdd Memo' => 'STRTYPE',
  'CashBackInfoAdd Amount' => 'AMTTYPE',
  'DepositLineAdd PaymentTxnID' => 'IDTYPE',
  'DepositLineAdd PaymentTxnLineID' => 'IDTYPE',
  'DepositLineAdd EntityRef ListID' => 'IDTYPE',
  'DepositLineAdd EntityRef FullName' => 'STRTYPE',
  'DepositLineAdd AccountRef ListID' => 'IDTYPE',
  'DepositLineAdd AccountRef FullName' => 'STRTYPE',
  'DepositLineAdd Memo' => 'STRTYPE',
  'DepositLineAdd CheckNumber' => 'STRTYPE',
  'DepositLineAdd PaymentMethodRef ListID' => 'IDTYPE',
  'DepositLineAdd PaymentMethodRef FullName' => 'STRTYPE',
  'DepositLineAdd ClassRef ListID' => 'IDTYPE',
  'DepositLineAdd ClassRef FullName' => 'STRTYPE',
  'DepositLineAdd Amount' => 'AMTTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TxnDate' => 0,
  'DepositToAccountRef ListID' => 0,
  'DepositToAccountRef FullName' => 159,
  'Memo' => 4095,
  'CashBackInfoAdd AccountRef ListID' => 0,
  'CashBackInfoAdd AccountRef FullName' => 159,
  'CashBackInfoAdd Memo' => 4095,
  'CashBackInfoAdd Amount' => 0,
  'DepositLineAdd PaymentTxnID' => 0,
  'DepositLineAdd PaymentTxnLineID' => 0,
  'DepositLineAdd EntityRef ListID' => 0,
  'DepositLineAdd EntityRef FullName' => 159,
  'DepositLineAdd AccountRef ListID' => 0,
  'DepositLineAdd AccountRef FullName' => 159,
  'DepositLineAdd Memo' => 4095,
  'DepositLineAdd CheckNumber' => 11,
  'DepositLineAdd PaymentMethodRef ListID' => 0,
  'DepositLineAdd PaymentMethodRef FullName' => 159,
  'DepositLineAdd ClassRef ListID' => 0,
  'DepositLineAdd ClassRef FullName' => 159,
  'DepositLineAdd Amount' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TxnDate' => true,
  'DepositToAccountRef ListID' => true,
  'DepositToAccountRef FullName' => true,
  'Memo' => true,
  'CashBackInfoAdd AccountRef ListID' => true,
  'CashBackInfoAdd AccountRef FullName' => true,
  'CashBackInfoAdd Memo' => true,
  'CashBackInfoAdd Amount' => true,
  'DepositLineAdd PaymentTxnID' => false,
  'DepositLineAdd PaymentTxnLineID' => true,
  'DepositLineAdd EntityRef ListID' => true,
  'DepositLineAdd EntityRef FullName' => true,
  'DepositLineAdd AccountRef ListID' => true,
  'DepositLineAdd AccountRef FullName' => true,
  'DepositLineAdd Memo' => true,
  'DepositLineAdd CheckNumber' => true,
  'DepositLineAdd PaymentMethodRef ListID' => true,
  'DepositLineAdd PaymentMethodRef FullName' => true,
  'DepositLineAdd ClassRef ListID' => true,
  'DepositLineAdd ClassRef FullName' => true,
  'DepositLineAdd Amount' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnDate' => 999.99,
  'DepositToAccountRef ListID' => 999.99,
  'DepositToAccountRef FullName' => 999.99,
  'Memo' => 999.99,
  'CashBackInfoAdd AccountRef ListID' => 999.99,
  'CashBackInfoAdd AccountRef FullName' => 999.99,
  'CashBackInfoAdd Memo' => 999.99,
  'CashBackInfoAdd Amount' => 999.99,
  'DepositLineAdd PaymentTxnID' => 0,
  'DepositLineAdd PaymentTxnLineID' => 0,
  'DepositLineAdd EntityRef ListID' => 999.99,
  'DepositLineAdd EntityRef FullName' => 999.99,
  'DepositLineAdd AccountRef ListID' => 999.99,
  'DepositLineAdd AccountRef FullName' => 999.99,
  'DepositLineAdd Memo' => 999.99,
  'DepositLineAdd CheckNumber' => 999.99,
  'DepositLineAdd PaymentMethodRef ListID' => 999.99,
  'DepositLineAdd PaymentMethodRef FullName' => 999.99,
  'DepositLineAdd ClassRef ListID' => 999.99,
  'DepositLineAdd ClassRef FullName' => 999.99,
  'DepositLineAdd Amount' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TxnDate' => false,
  'DepositToAccountRef ListID' => false,
  'DepositToAccountRef FullName' => false,
  'Memo' => false,
  'CashBackInfoAdd AccountRef ListID' => false,
  'CashBackInfoAdd AccountRef FullName' => false,
  'CashBackInfoAdd Memo' => false,
  'CashBackInfoAdd Amount' => false,
  'DepositLineAdd PaymentTxnID' => false,
  'DepositLineAdd PaymentTxnLineID' => false,
  'DepositLineAdd EntityRef ListID' => false,
  'DepositLineAdd EntityRef FullName' => false,
  'DepositLineAdd AccountRef ListID' => false,
  'DepositLineAdd AccountRef FullName' => false,
  'DepositLineAdd Memo' => false,
  'DepositLineAdd CheckNumber' => false,
  'DepositLineAdd PaymentMethodRef ListID' => false,
  'DepositLineAdd PaymentMethodRef FullName' => false,
  'DepositLineAdd ClassRef ListID' => false,
  'DepositLineAdd ClassRef FullName' => false,
  'DepositLineAdd Amount' => false,
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
  0 => 'TxnDate',
  1 => 'DepositToAccountRef ListID',
  2 => 'DepositToAccountRef FullName',
  3 => 'Memo',
  4 => 'CashBackInfoAdd',
  5 => 'CashBackInfoAdd AccountRef',
  6 => 'CashBackInfoAdd AccountRef ListID',
  7 => 'CashBackInfoAdd AccountRef FullName',
  8 => 'CashBackInfoAdd Memo',
  9 => 'CashBackInfoAdd Amount',
  10 => 'DepositLineAdd PaymentTxnID',
  11 => 'DepositLineAdd PaymentTxnLineID',
  12 => 'DepositLineAdd EntityRef ListID',
  13 => 'DepositLineAdd EntityRef FullName',
  14 => 'DepositLineAdd AccountRef ListID',
  15 => 'DepositLineAdd AccountRef FullName',
  16 => 'DepositLineAdd Memo',
  17 => 'DepositLineAdd CheckNumber',
  18 => 'DepositLineAdd PaymentMethodRef ListID',
  19 => 'DepositLineAdd PaymentMethodRef FullName',
  20 => 'DepositLineAdd ClassRef ListID',
  21 => 'DepositLineAdd ClassRef FullName',
  22 => 'DepositLineAdd Amount',
  23 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>