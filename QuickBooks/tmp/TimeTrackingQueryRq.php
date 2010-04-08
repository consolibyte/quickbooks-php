<?php

/**
 * Schema object for: TimeTrackingQueryRq
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
class QuickBooks_QBXML_Schema_Object_TimeTrackingQueryRq extends QuickBooks_QBXML_Schema_Object
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
  'TimeTrackingEntityFilter ListID' => 'IDTYPE',
  'TimeTrackingEntityFilter FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
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
  'TimeTrackingEntityFilter ListID' => 0,
  'TimeTrackingEntityFilter FullName' => 0,
  'IncludeRetElement' => 50,
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
  'TimeTrackingEntityFilter ListID' => false,
  'TimeTrackingEntityFilter FullName' => false,
  'IncludeRetElement' => true,
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
  'TimeTrackingEntityFilter ListID' => 999.99,
  'TimeTrackingEntityFilter FullName' => 999.99,
  'IncludeRetElement' => 4,
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
  'TimeTrackingEntityFilter ListID' => true,
  'TimeTrackingEntityFilter FullName' => true,
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
  1 => 'MaxReturned',
  2 => 'ModifiedDateRangeFilter FromModifiedDate',
  3 => 'ModifiedDateRangeFilter ToModifiedDate',
  4 => 'TxnDateRangeFilter FromTxnDate',
  5 => 'TxnDateRangeFilter ToTxnDate',
  6 => 'TxnDateRangeFilter DateMacro',
  7 => 'TimeTrackingEntityFilter ListID',
  8 => 'TimeTrackingEntityFilter FullName',
  9 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>