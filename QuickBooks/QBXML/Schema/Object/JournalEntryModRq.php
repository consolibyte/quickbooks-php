<?php

/**
 * Schema object for: JournalEntryModRq
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
class QuickBooks_QBXML_Schema_Object_JournalEntryModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'JournalEntryMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TxnID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
  'TxnDate' => 'DATETYPE',
  'RefNumber' => 'STRTYPE',
  'IsAdjustment' => 'BOOLTYPE',
  'JournalLineMod TxnLineID' => 'IDTYPE',
  'JournalLineMod JournalLineType' => 'ENUMTYPE',
  'JournalLineMod AccountRef ListID' => 'IDTYPE',
  'JournalLineMod AccountRef FullName' => 'STRTYPE',
  'JournalLineMod Amount' => 'AMTTYPE',
  'JournalLineMod Memo' => 'STRTYPE',
  'JournalLineMod EntityRef ListID' => 'IDTYPE',
  'JournalLineMod EntityRef FullName' => 'STRTYPE',
  'JournalLineMod ClassRef ListID' => 'IDTYPE',
  'JournalLineMod ClassRef FullName' => 'STRTYPE',
  'JournalLineMod ItemSalesTaxRef ListID' => 'IDTYPE',
  'JournalLineMod ItemSalesTaxRef FullName' => 'STRTYPE',
  'JournalLineMod BillableStatus' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TxnID' => 0,
  'EditSequence' => 16,
  'TxnDate' => 0,
  'RefNumber' => 11,
  'IsAdjustment' => 0,
  'JournalLineMod TxnLineID' => 0,
  'JournalLineMod JournalLineType' => 0,
  'JournalLineMod AccountRef ListID' => 0,
  'JournalLineMod AccountRef FullName' => 159,
  'JournalLineMod Amount' => 0,
  'JournalLineMod Memo' => 4095,
  'JournalLineMod EntityRef ListID' => 0,
  'JournalLineMod EntityRef FullName' => 159,
  'JournalLineMod ClassRef ListID' => 0,
  'JournalLineMod ClassRef FullName' => 159,
  'JournalLineMod ItemSalesTaxRef ListID' => 0,
  'JournalLineMod ItemSalesTaxRef FullName' => 159,
  'JournalLineMod BillableStatus' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TxnID' => false,
  'EditSequence' => false,
  'TxnDate' => true,
  'RefNumber' => true,
  'IsAdjustment' => true,
  'JournalLineMod TxnLineID' => false,
  'JournalLineMod JournalLineType' => true,
  'JournalLineMod AccountRef ListID' => true,
  'JournalLineMod AccountRef FullName' => true,
  'JournalLineMod Amount' => true,
  'JournalLineMod Memo' => true,
  'JournalLineMod EntityRef ListID' => true,
  'JournalLineMod EntityRef FullName' => true,
  'JournalLineMod ClassRef ListID' => true,
  'JournalLineMod ClassRef FullName' => true,
  'JournalLineMod ItemSalesTaxRef ListID' => true,
  'JournalLineMod ItemSalesTaxRef FullName' => true,
  'JournalLineMod BillableStatus' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnID' => 999.99,
  'EditSequence' => 999.99,
  'TxnDate' => 999.99,
  'RefNumber' => 999.99,
  'IsAdjustment' => 999.99,
  'JournalLineMod TxnLineID' => 999.99,
  'JournalLineMod JournalLineType' => 999.99,
  'JournalLineMod AccountRef ListID' => 999.99,
  'JournalLineMod AccountRef FullName' => 999.99,
  'JournalLineMod Amount' => 999.99,
  'JournalLineMod Memo' => 999.99,
  'JournalLineMod EntityRef ListID' => 999.99,
  'JournalLineMod EntityRef FullName' => 999.99,
  'JournalLineMod ClassRef ListID' => 999.99,
  'JournalLineMod ClassRef FullName' => 999.99,
  'JournalLineMod ItemSalesTaxRef ListID' => 999.99,
  'JournalLineMod ItemSalesTaxRef FullName' => 999.99,
  'JournalLineMod BillableStatus' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TxnID' => false,
  'EditSequence' => false,
  'TxnDate' => false,
  'RefNumber' => false,
  'IsAdjustment' => false,
  'JournalLineMod TxnLineID' => false,
  'JournalLineMod JournalLineType' => false,
  'JournalLineMod AccountRef ListID' => false,
  'JournalLineMod AccountRef FullName' => false,
  'JournalLineMod Amount' => false,
  'JournalLineMod Memo' => false,
  'JournalLineMod EntityRef ListID' => false,
  'JournalLineMod EntityRef FullName' => false,
  'JournalLineMod ClassRef ListID' => false,
  'JournalLineMod ClassRef FullName' => false,
  'JournalLineMod ItemSalesTaxRef ListID' => false,
  'JournalLineMod ItemSalesTaxRef FullName' => false,
  'JournalLineMod BillableStatus' => false,
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
  0 => 'TxnID',
  1 => 'EditSequence',
  2 => 'TxnDate',
  3 => 'RefNumber',
  4 => 'IsAdjustment',
  5 => 'JournalLineMod TxnLineID',
  6 => 'JournalLineMod JournalLineType',
  7 => 'JournalLineMod AccountRef ListID',
  8 => 'JournalLineMod AccountRef FullName',
  9 => 'JournalLineMod Amount',
  10 => 'JournalLineMod Memo',
  11 => 'JournalLineMod EntityRef ListID',
  12 => 'JournalLineMod EntityRef FullName',
  13 => 'JournalLineMod ClassRef ListID',
  14 => 'JournalLineMod ClassRef FullName',
  15 => 'JournalLineMod ItemSalesTaxRef ListID',
  16 => 'JournalLineMod ItemSalesTaxRef FullName',
  17 => 'JournalLineMod BillableStatus',
  18 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>