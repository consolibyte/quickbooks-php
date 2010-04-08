<?php

/**
 * Schema object for: BuildAssemblyQueryRq
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
class QuickBooks_QBXML_Schema_Object_BuildAssemblyQueryRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TxnID' => 'IDTYPE',
  'RefNumber' => 'STRTYPE',
  'RefNumberCaseSensitive' => 'STRTYPE',
  'MaxReturned' => 'INTTYPE',
  'ModifiedDateRangeFilter FromModifiedDate' => 'DATETIMETYPE',
  'ModifiedDateRangeFilter ToModifiedDate' => 'DATETIMETYPE',
  'TxnDateRangeFilter FromTxnDate' => 'DATETYPE',
  'TxnDateRangeFilter ToTxnDate' => 'DATETYPE',
  'TxnDateRangeFilter DateMacro' => 'ENUMTYPE',
  'ItemFilter ListID' => 'IDTYPE',
  'ItemFilter FullName' => 'STRTYPE',
  'ItemFilter ListIDWithChildren' => 'IDTYPE',
  'ItemFilter FullNameWithChildren' => 'STRTYPE',
  'RefNumberFilter MatchCriterion' => 'ENUMTYPE',
  'RefNumberFilter RefNumber' => 'STRTYPE',
  'RefNumberRangeFilter FromRefNumber' => 'STRTYPE',
  'RefNumberRangeFilter ToRefNumber' => 'STRTYPE',
  'PendingStatus' => 'ENUMTYPE',
  'IncludeComponentLineItems' => 'BOOLTYPE',
  'IncludeRetElement' => 'STRTYPE',
  'OwnerID' => 'GUIDTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TxnID' => 0,
  'RefNumber' => 0,
  'RefNumberCaseSensitive' => 0,
  'MaxReturned' => 0,
  'ModifiedDateRangeFilter FromModifiedDate' => 0,
  'ModifiedDateRangeFilter ToModifiedDate' => 0,
  'TxnDateRangeFilter FromTxnDate' => 0,
  'TxnDateRangeFilter ToTxnDate' => 0,
  'TxnDateRangeFilter DateMacro' => 0,
  'ItemFilter ListID' => 0,
  'ItemFilter FullName' => 159,
  'ItemFilter ListIDWithChildren' => 0,
  'ItemFilter FullNameWithChildren' => 159,
  'RefNumberFilter MatchCriterion' => 0,
  'RefNumberFilter RefNumber' => 0,
  'RefNumberRangeFilter FromRefNumber' => 0,
  'RefNumberRangeFilter ToRefNumber' => 0,
  'PendingStatus' => 0,
  'IncludeComponentLineItems' => 0,
  'IncludeRetElement' => 50,
  'OwnerID' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TxnID' => false,
  'RefNumber' => false,
  'RefNumberCaseSensitive' => false,
  'MaxReturned' => true,
  'ModifiedDateRangeFilter FromModifiedDate' => true,
  'ModifiedDateRangeFilter ToModifiedDate' => true,
  'TxnDateRangeFilter FromTxnDate' => true,
  'TxnDateRangeFilter ToTxnDate' => true,
  'TxnDateRangeFilter DateMacro' => false,
  'ItemFilter ListID' => false,
  'ItemFilter FullName' => false,
  'ItemFilter ListIDWithChildren' => false,
  'ItemFilter FullNameWithChildren' => false,
  'RefNumberFilter MatchCriterion' => false,
  'RefNumberFilter RefNumber' => false,
  'RefNumberRangeFilter FromRefNumber' => true,
  'RefNumberRangeFilter ToRefNumber' => true,
  'PendingStatus' => true,
  'IncludeComponentLineItems' => true,
  'IncludeRetElement' => true,
  'OwnerID' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnID' => 999.99,
  'RefNumber' => 999.99,
  'RefNumberCaseSensitive' => 999.99,
  'MaxReturned' => 0,
  'ModifiedDateRangeFilter FromModifiedDate' => 999.99,
  'ModifiedDateRangeFilter ToModifiedDate' => 999.99,
  'TxnDateRangeFilter FromTxnDate' => 999.99,
  'TxnDateRangeFilter ToTxnDate' => 999.99,
  'TxnDateRangeFilter DateMacro' => 999.99,
  'ItemFilter ListID' => 999.99,
  'ItemFilter FullName' => 999.99,
  'ItemFilter ListIDWithChildren' => 999.99,
  'ItemFilter FullNameWithChildren' => 999.99,
  'RefNumberFilter MatchCriterion' => 999.99,
  'RefNumberFilter RefNumber' => 999.99,
  'RefNumberRangeFilter FromRefNumber' => 999.99,
  'RefNumberRangeFilter ToRefNumber' => 999.99,
  'PendingStatus' => 999.99,
  'IncludeComponentLineItems' => 999.99,
  'IncludeRetElement' => 999.99,
  'OwnerID' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TxnID' => true,
  'RefNumber' => true,
  'RefNumberCaseSensitive' => true,
  'MaxReturned' => false,
  'ModifiedDateRangeFilter FromModifiedDate' => false,
  'ModifiedDateRangeFilter ToModifiedDate' => false,
  'TxnDateRangeFilter FromTxnDate' => false,
  'TxnDateRangeFilter ToTxnDate' => false,
  'TxnDateRangeFilter DateMacro' => false,
  'ItemFilter ListID' => true,
  'ItemFilter FullName' => true,
  'ItemFilter ListIDWithChildren' => false,
  'ItemFilter FullNameWithChildren' => false,
  'RefNumberFilter MatchCriterion' => false,
  'RefNumberFilter RefNumber' => true,
  'RefNumberRangeFilter FromRefNumber' => false,
  'RefNumberRangeFilter ToRefNumber' => false,
  'PendingStatus' => false,
  'IncludeComponentLineItems' => false,
  'IncludeRetElement' => true,
  'OwnerID' => true,
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
  1 => 'RefNumber',
  2 => 'RefNumberCaseSensitive',
  3 => 'MaxReturned',
  4 => 'ModifiedDateRangeFilter FromModifiedDate',
  5 => 'ModifiedDateRangeFilter ToModifiedDate',
  6 => 'TxnDateRangeFilter FromTxnDate',
  7 => 'TxnDateRangeFilter ToTxnDate',
  8 => 'TxnDateRangeFilter DateMacro',
  9 => 'ItemFilter ListID',
  10 => 'ItemFilter FullName',
  11 => 'ItemFilter ListIDWithChildren',
  12 => 'ItemFilter FullNameWithChildren',
  13 => 'RefNumberFilter MatchCriterion',
  14 => 'RefNumberFilter RefNumber',
  15 => 'RefNumberRangeFilter FromRefNumber',
  16 => 'RefNumberRangeFilter ToRefNumber',
  17 => 'PendingStatus',
  18 => 'IncludeComponentLineItems',
  19 => 'IncludeRetElement',
  20 => 'OwnerID',
);
			
		return $paths;
	}
}

?>