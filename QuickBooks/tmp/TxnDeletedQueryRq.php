<?php

/**
 * Schema object for: TxnDeletedQueryRq
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
class QuickBooks_QBXML_Schema_Object_TxnDeletedQueryRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TxnDelType' => 'ENUMTYPE',
  'DeletedDateRangeFilter FromDeletedDate' => 'DATETIMETYPE',
  'DeletedDateRangeFilter ToDeletedDate' => 'DATETIMETYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TxnDelType' => 0,
  'DeletedDateRangeFilter FromDeletedDate' => 0,
  'DeletedDateRangeFilter ToDeletedDate' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TxnDelType' => false,
  'DeletedDateRangeFilter FromDeletedDate' => true,
  'DeletedDateRangeFilter ToDeletedDate' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TxnDelType' => 999.99,
  'DeletedDateRangeFilter FromDeletedDate' => 999.99,
  'DeletedDateRangeFilter ToDeletedDate' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TxnDelType' => true,
  'DeletedDateRangeFilter FromDeletedDate' => false,
  'DeletedDateRangeFilter ToDeletedDate' => false,
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
  0 => 'TxnDelType',
  1 => 'DeletedDateRangeFilter FromDeletedDate',
  2 => 'DeletedDateRangeFilter ToDeletedDate',
  3 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>