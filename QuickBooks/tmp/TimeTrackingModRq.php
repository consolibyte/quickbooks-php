<?php

/**
 * Schema object for: TimeTrackingModRq
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
class QuickBooks_QBXML_Schema_Object_TimeTrackingModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'TimeTrackingMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TxnID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
  'TxnDate' => 'DATETYPE',
  'EntityRef ListID' => 'IDTYPE',
  'EntityRef FullName' => 'STRTYPE',
  'CustomerRef ListID' => 'IDTYPE',
  'CustomerRef FullName' => 'STRTYPE',
  'ItemServiceRef ListID' => 'IDTYPE',
  'ItemServiceRef FullName' => 'STRTYPE',
  'Rate' => 'PRICETYPE',
  'Duration' => 'TIMEINTERVALTYPE',
  'ClassRef ListID' => 'IDTYPE',
  'ClassRef FullName' => 'STRTYPE',
  'PayrollItemWageRef ListID' => 'IDTYPE',
  'PayrollItemWageRef FullName' => 'STRTYPE',
  'Notes' => 'STRTYPE',
  'BillableStatus' => 'ENUMTYPE',
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
  'EntityRef ListID' => 0,
  'EntityRef FullName' => 209,
  'CustomerRef ListID' => 0,
  'CustomerRef FullName' => 209,
  'ItemServiceRef ListID' => 0,
  'ItemServiceRef FullName' => 209,
  'Rate' => 0,
  'Duration' => 0,
  'ClassRef ListID' => 0,
  'ClassRef FullName' => 209,
  'PayrollItemWageRef ListID' => 0,
  'PayrollItemWageRef FullName' => 209,
  'Notes' => 4095,
  'BillableStatus' => 0,
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
  'EntityRef ListID' => true,
  'EntityRef FullName' => true,
  'CustomerRef ListID' => true,
  'CustomerRef FullName' => true,
  'ItemServiceRef ListID' => true,
  'ItemServiceRef FullName' => true,
  'Rate' => true,
  'Duration' => false,
  'ClassRef ListID' => true,
  'ClassRef FullName' => true,
  'PayrollItemWageRef ListID' => true,
  'PayrollItemWageRef FullName' => true,
  'Notes' => true,
  'BillableStatus' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnID' => 999.99,
  'EditSequence' => 999.99,
  'TxnDate' => 999.99,
  'EntityRef ListID' => 999.99,
  'EntityRef FullName' => 999.99,
  'CustomerRef ListID' => 999.99,
  'CustomerRef FullName' => 999.99,
  'ItemServiceRef ListID' => 999.99,
  'ItemServiceRef FullName' => 999.99,
  'Rate' => 999.99,
  'Duration' => 999.99,
  'ClassRef ListID' => 999.99,
  'ClassRef FullName' => 999.99,
  'PayrollItemWageRef ListID' => 999.99,
  'PayrollItemWageRef FullName' => 999.99,
  'Notes' => 999.99,
  'BillableStatus' => 999.99,
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
  'EntityRef ListID' => false,
  'EntityRef FullName' => false,
  'CustomerRef ListID' => false,
  'CustomerRef FullName' => false,
  'ItemServiceRef ListID' => false,
  'ItemServiceRef FullName' => false,
  'Rate' => false,
  'Duration' => false,
  'ClassRef ListID' => false,
  'ClassRef FullName' => false,
  'PayrollItemWageRef ListID' => false,
  'PayrollItemWageRef FullName' => false,
  'Notes' => false,
  'BillableStatus' => false,
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
  3 => 'EntityRef ListID',
  4 => 'EntityRef FullName',
  5 => 'CustomerRef ListID',
  6 => 'CustomerRef FullName',
  7 => 'ItemServiceRef ListID',
  8 => 'ItemServiceRef FullName',
  9 => 'Rate',
  10 => 'Duration',
  11 => 'ClassRef ListID',
  12 => 'ClassRef FullName',
  13 => 'PayrollItemWageRef ListID',
  14 => 'PayrollItemWageRef FullName',
  15 => 'Notes',
  16 => 'BillableStatus',
  17 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>