<?php

/**
 * Schema object for: JournalEntryAddRq
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
class QuickBooks_QBXML_Schema_Object_JournalEntryAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'JournalEntryAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TxnDate' => 'DATETYPE',
  'RefNumber' => 'STRTYPE',
  'Memo' => 'STRTYPE',
  'IsAdjustment' => 'BOOLTYPE',
  'JournalDebitLine TxnLineID' => 'IDTYPE',
  'JournalDebitLine AccountRef ListID' => 'IDTYPE',
  'JournalDebitLine AccountRef FullName' => 'STRTYPE',
  'JournalDebitLine Amount' => 'AMTTYPE',
  'JournalDebitLine Memo' => 'STRTYPE',
  'JournalDebitLine EntityRef ListID' => 'IDTYPE',
  'JournalDebitLine EntityRef FullName' => 'STRTYPE',
  'JournalDebitLine ClassRef ListID' => 'IDTYPE',
  'JournalDebitLine ClassRef FullName' => 'STRTYPE',
  'JournalDebitLine ItemSalesTaxRef ListID' => 'IDTYPE',
  'JournalDebitLine ItemSalesTaxRef FullName' => 'STRTYPE',
  'JournalDebitLine BillableStatus' => 'ENUMTYPE',
  'JournalCreditLine TxnLineID' => 'IDTYPE',
  'JournalCreditLine AccountRef ListID' => 'IDTYPE',
  'JournalCreditLine AccountRef FullName' => 'STRTYPE',
  'JournalCreditLine Amount' => 'AMTTYPE',
  'JournalCreditLine Memo' => 'STRTYPE',
  'JournalCreditLine EntityRef ListID' => 'IDTYPE',
  'JournalCreditLine EntityRef FullName' => 'STRTYPE',
  'JournalCreditLine ClassRef ListID' => 'IDTYPE',
  'JournalCreditLine ClassRef FullName' => 'STRTYPE',
  'JournalCreditLine ItemSalesTaxRef ListID' => 'IDTYPE',
  'JournalCreditLine ItemSalesTaxRef FullName' => 'STRTYPE',
  'JournalCreditLine BillableStatus' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TxnDate' => 0,
  'RefNumber' => 11,
  'Memo' => 4000,
  'IsAdjustment' => 0,
  'JournalDebitLine TxnLineID' => 0,
  'JournalDebitLine AccountRef ListID' => 0,
  'JournalDebitLine AccountRef FullName' => 159,
  'JournalDebitLine Amount' => 0,
  'JournalDebitLine Memo' => 4000,
  'JournalDebitLine EntityRef ListID' => 0,
  'JournalDebitLine EntityRef FullName' => 159,
  'JournalDebitLine ClassRef ListID' => 0,
  'JournalDebitLine ClassRef FullName' => 159,
  'JournalDebitLine ItemSalesTaxRef ListID' => 0,
  'JournalDebitLine ItemSalesTaxRef FullName' => 159,
  'JournalDebitLine BillableStatus' => 0,
  'JournalCreditLine TxnLineID' => 0,
  'JournalCreditLine AccountRef ListID' => 0,
  'JournalCreditLine AccountRef FullName' => 159,
  'JournalCreditLine Amount' => 0,
  'JournalCreditLine Memo' => 4000,
  'JournalCreditLine EntityRef ListID' => 0,
  'JournalCreditLine EntityRef FullName' => 159,
  'JournalCreditLine ClassRef ListID' => 0,
  'JournalCreditLine ClassRef FullName' => 159,
  'JournalCreditLine ItemSalesTaxRef ListID' => 0,
  'JournalCreditLine ItemSalesTaxRef FullName' => 159,
  'JournalCreditLine BillableStatus' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TxnDate' => true,
  'RefNumber' => true,
  'Memo' => true,
  'IsAdjustment' => true,
  'JournalDebitLine TxnLineID' => true,
  'JournalDebitLine AccountRef ListID' => true,
  'JournalDebitLine AccountRef FullName' => true,
  'JournalDebitLine Amount' => true,
  'JournalDebitLine Memo' => true,
  'JournalDebitLine EntityRef ListID' => true,
  'JournalDebitLine EntityRef FullName' => true,
  'JournalDebitLine ClassRef ListID' => true,
  'JournalDebitLine ClassRef FullName' => true,
  'JournalDebitLine ItemSalesTaxRef ListID' => true,
  'JournalDebitLine ItemSalesTaxRef FullName' => true,
  'JournalDebitLine BillableStatus' => true,
  'JournalCreditLine TxnLineID' => true,
  'JournalCreditLine AccountRef ListID' => true,
  'JournalCreditLine AccountRef FullName' => true,
  'JournalCreditLine Amount' => true,
  'JournalCreditLine Memo' => true,
  'JournalCreditLine EntityRef ListID' => true,
  'JournalCreditLine EntityRef FullName' => true,
  'JournalCreditLine ClassRef ListID' => true,
  'JournalCreditLine ClassRef FullName' => true,
  'JournalCreditLine ItemSalesTaxRef ListID' => true,
  'JournalCreditLine ItemSalesTaxRef FullName' => true,
  'JournalCreditLine BillableStatus' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnDate' => 999.99,
  'RefNumber' => 999.99,
  'Memo' => 999.99,
  'IsAdjustment' => 3,
  'JournalDebitLine TxnLineID' => 999.99,
  'JournalDebitLine AccountRef ListID' => 999.99,
  'JournalDebitLine AccountRef FullName' => 999.99,
  'JournalDebitLine Amount' => 999.99,
  'JournalDebitLine Memo' => 999.99,
  'JournalDebitLine EntityRef ListID' => 999.99,
  'JournalDebitLine EntityRef FullName' => 999.99,
  'JournalDebitLine ClassRef ListID' => 999.99,
  'JournalDebitLine ClassRef FullName' => 999.99,
  'JournalDebitLine ItemSalesTaxRef ListID' => 999.99,
  'JournalDebitLine ItemSalesTaxRef FullName' => 999.99,
  'JournalDebitLine BillableStatus' => 3,
  'JournalCreditLine TxnLineID' => 999.99,
  'JournalCreditLine AccountRef ListID' => 999.99,
  'JournalCreditLine AccountRef FullName' => 999.99,
  'JournalCreditLine Amount' => 999.99,
  'JournalCreditLine Memo' => 999.99,
  'JournalCreditLine EntityRef ListID' => 999.99,
  'JournalCreditLine EntityRef FullName' => 999.99,
  'JournalCreditLine ClassRef ListID' => 999.99,
  'JournalCreditLine ClassRef FullName' => 999.99,
  'JournalCreditLine ItemSalesTaxRef ListID' => 999.99,
  'JournalCreditLine ItemSalesTaxRef FullName' => 999.99,
  'JournalCreditLine BillableStatus' => 3,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TxnDate' => false,
  'RefNumber' => false,
  'Memo' => false,
  'IsAdjustment' => false,
  'JournalDebitLine TxnLineID' => false,
  'JournalDebitLine AccountRef ListID' => false,
  'JournalDebitLine AccountRef FullName' => false,
  'JournalDebitLine Amount' => false,
  'JournalDebitLine Memo' => false,
  'JournalDebitLine EntityRef ListID' => false,
  'JournalDebitLine EntityRef FullName' => false,
  'JournalDebitLine ClassRef ListID' => false,
  'JournalDebitLine ClassRef FullName' => false,
  'JournalDebitLine ItemSalesTaxRef ListID' => false,
  'JournalDebitLine ItemSalesTaxRef FullName' => false,
  'JournalDebitLine BillableStatus' => false,
  'JournalCreditLine TxnLineID' => false,
  'JournalCreditLine AccountRef ListID' => false,
  'JournalCreditLine AccountRef FullName' => false,
  'JournalCreditLine Amount' => false,
  'JournalCreditLine Memo' => false,
  'JournalCreditLine EntityRef ListID' => false,
  'JournalCreditLine EntityRef FullName' => false,
  'JournalCreditLine ClassRef ListID' => false,
  'JournalCreditLine ClassRef FullName' => false,
  'JournalCreditLine ItemSalesTaxRef ListID' => false,
  'JournalCreditLine ItemSalesTaxRef FullName' => false,
  'JournalCreditLine BillableStatus' => false,
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
  1 => 'RefNumber',
  2 => 'Memo',
  3 => 'IsAdjustment',
  4 => 'JournalDebitLine TxnLineID',
  5 => 'JournalDebitLine AccountRef ListID',
  6 => 'JournalDebitLine AccountRef FullName',
  7 => 'JournalDebitLine Amount',
  8 => 'JournalDebitLine Memo',
  9 => 'JournalDebitLine EntityRef ListID',
  10 => 'JournalDebitLine EntityRef FullName',
  11 => 'JournalDebitLine ClassRef ListID',
  12 => 'JournalDebitLine ClassRef FullName',
  13 => 'JournalDebitLine ItemSalesTaxRef ListID',
  14 => 'JournalDebitLine ItemSalesTaxRef FullName',
  15 => 'JournalDebitLine BillableStatus',
  16 => 'JournalCreditLine TxnLineID',
  17 => 'JournalCreditLine AccountRef ListID',
  18 => 'JournalCreditLine AccountRef FullName',
  19 => 'JournalCreditLine Amount',
  20 => 'JournalCreditLine Memo',
  21 => 'JournalCreditLine EntityRef ListID',
  22 => 'JournalCreditLine EntityRef FullName',
  23 => 'JournalCreditLine ClassRef ListID',
  24 => 'JournalCreditLine ClassRef FullName',
  25 => 'JournalCreditLine ItemSalesTaxRef ListID',
  26 => 'JournalCreditLine ItemSalesTaxRef FullName',
  27 => 'JournalCreditLine BillableStatus',
  28 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>