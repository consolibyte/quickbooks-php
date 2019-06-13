<?php

/**
 * Schema object for: DepositQueryRq
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
class QuickBooks_QBXML_Schema_Object_DepositQueryRq extends QuickBooks_QBXML_Schema_Object
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
  'MaxReturned' => 'INTTYPE',
  'ModifiedDateRangeFilter FromModifiedDate' => 'DATETIMETYPE',
  'ModifiedDateRangeFilter ToModifiedDate' => 'DATETIMETYPE',
  'TxnDateRangeFilter FromTxnDate' => 'DATETYPE',
  'TxnDateRangeFilter ToTxnDate' => 'DATETYPE',
  'TxnDateRangeFilter DateMacro' => 'ENUMTYPE',
  'EntityFilter ListID' => 'IDTYPE',
  'EntityFilter FullName' => 'STRTYPE',
  'EntityFilter ListIDWithChildren' => 'IDTYPE',
  'EntityFilter FullNameWithChildren' => 'STRTYPE',
  'AccountFilter ListID' => 'IDTYPE',
  'AccountFilter FullName' => 'STRTYPE',
  'AccountFilter ListIDWithChildren' => 'IDTYPE',
  'AccountFilter FullNameWithChildren' => 'STRTYPE',
  'IncludeLineItems' => 'BOOLTYPE',
  'IncludeRetElement' => 'STRTYPE',
  'OwnerID' => 'GUIDTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TxnID' => 0,
  'MaxReturned' => 0,
  'ModifiedDateRangeFilter FromModifiedDate' => 0,
  'ModifiedDateRangeFilter ToModifiedDate' => 0,
  'TxnDateRangeFilter FromTxnDate' => 0,
  'TxnDateRangeFilter ToTxnDate' => 0,
  'TxnDateRangeFilter DateMacro' => 0,
  'EntityFilter ListID' => 0,
  'EntityFilter FullName' => 0,
  'EntityFilter ListIDWithChildren' => 0,
  'EntityFilter FullNameWithChildren' => 0,
  'AccountFilter ListID' => 0,
  'AccountFilter FullName' => 0,
  'AccountFilter ListIDWithChildren' => 0,
  'AccountFilter FullNameWithChildren' => 0,
  'IncludeLineItems' => 0,
  'IncludeRetElement' => 50,
  'OwnerID' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TxnID' => false,
  'MaxReturned' => true,
  'ModifiedDateRangeFilter FromModifiedDate' => true,
  'ModifiedDateRangeFilter ToModifiedDate' => true,
  'TxnDateRangeFilter FromTxnDate' => true,
  'TxnDateRangeFilter ToTxnDate' => true,
  'TxnDateRangeFilter DateMacro' => false,
  'EntityFilter ListID' => false,
  'EntityFilter FullName' => false,
  'EntityFilter ListIDWithChildren' => false,
  'EntityFilter FullNameWithChildren' => false,
  'AccountFilter ListID' => false,
  'AccountFilter FullName' => false,
  'AccountFilter ListIDWithChildren' => false,
  'AccountFilter FullNameWithChildren' => false,
  'IncludeLineItems' => true,
  'IncludeRetElement' => true,
  'OwnerID' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnID' => 999.99,
  'MaxReturned' => 0,
  'ModifiedDateRangeFilter FromModifiedDate' => 999.99,
  'ModifiedDateRangeFilter ToModifiedDate' => 999.99,
  'TxnDateRangeFilter FromTxnDate' => 999.99,
  'TxnDateRangeFilter ToTxnDate' => 999.99,
  'TxnDateRangeFilter DateMacro' => 999.99,
  'EntityFilter ListID' => 2,
  'EntityFilter FullName' => 999.99,
  'EntityFilter ListIDWithChildren' => 2,
  'EntityFilter FullNameWithChildren' => 999.99,
  'AccountFilter ListID' => 2,
  'AccountFilter FullName' => 999.99,
  'AccountFilter ListIDWithChildren' => 2,
  'AccountFilter FullNameWithChildren' => 999.99,
  'IncludeLineItems' => 999.99,
  'IncludeRetElement' => 4,
  'OwnerID' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TxnID' => true,
  'MaxReturned' => false,
  'ModifiedDateRangeFilter FromModifiedDate' => false,
  'ModifiedDateRangeFilter ToModifiedDate' => false,
  'TxnDateRangeFilter FromTxnDate' => false,
  'TxnDateRangeFilter ToTxnDate' => false,
  'TxnDateRangeFilter DateMacro' => false,
  'EntityFilter ListID' => true,
  'EntityFilter FullName' => true,
  'EntityFilter ListIDWithChildren' => false,
  'EntityFilter FullNameWithChildren' => false,
  'AccountFilter ListID' => true,
  'AccountFilter FullName' => true,
  'AccountFilter ListIDWithChildren' => false,
  'AccountFilter FullNameWithChildren' => false,
  'IncludeLineItems' => false,
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
  1 => 'MaxReturned',
  2 => 'ModifiedDateRangeFilter FromModifiedDate',
  3 => 'ModifiedDateRangeFilter ToModifiedDate',
  4 => 'TxnDateRangeFilter FromTxnDate',
  5 => 'TxnDateRangeFilter ToTxnDate',
  6 => 'TxnDateRangeFilter DateMacro',
  7 => 'EntityFilter ListID',
  8 => 'EntityFilter FullName',
  9 => 'EntityFilter ListIDWithChildren',
  10 => 'EntityFilter FullNameWithChildren',
  11 => 'AccountFilter ListID',
  12 => 'AccountFilter FullName',
  13 => 'AccountFilter ListIDWithChildren',
  14 => 'AccountFilter FullNameWithChildren',
  15 => 'IncludeLineItems',
  16 => 'IncludeRetElement',
  17 => 'OwnerID',
);
			
		return $paths;
	}
}

?>