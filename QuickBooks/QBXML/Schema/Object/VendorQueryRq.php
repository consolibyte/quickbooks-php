<?php

/**
 * Schema object for: VendorQueryRq
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
class QuickBooks_QBXML_Schema_Object_VendorQueryRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'FullName' => 'STRTYPE',
  'MaxReturned' => 'INTTYPE',
  'ActiveStatus' => 'ENUMTYPE',
  'FromModifiedDate' => 'DATETIMETYPE',
  'ToModifiedDate' => 'DATETIMETYPE',
  'NameFilter MatchCriterion' => 'ENUMTYPE',
  'NameFilter Name' => 'STRTYPE',
  'NameRangeFilter FromName' => 'STRTYPE',
  'NameRangeFilter ToName' => 'STRTYPE',
  'TotalBalanceFilter Operator' => 'ENUMTYPE',
  'TotalBalanceFilter Amount' => 'AMTTYPE',
  'IncludeRetElement' => 'STRTYPE',
  'OwnerID' => 'GUIDTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ListID' => 0,
  'FullName' => 0,
  'MaxReturned' => 0,
  'ActiveStatus' => 0,
  'FromModifiedDate' => 0,
  'ToModifiedDate' => 0,
  'NameFilter MatchCriterion' => 0,
  'NameFilter Name' => 0,
  'NameRangeFilter FromName' => 0,
  'NameRangeFilter ToName' => 0,
  'TotalBalanceFilter Operator' => 0,
  'TotalBalanceFilter Amount' => 0,
  'IncludeRetElement' => 50,
  'OwnerID' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ListID' => false,
  'FullName' => false,
  'MaxReturned' => true,
  'ActiveStatus' => true,
  'FromModifiedDate' => true,
  'ToModifiedDate' => true,
  'NameFilter MatchCriterion' => false,
  'NameFilter Name' => false,
  'NameRangeFilter FromName' => true,
  'NameRangeFilter ToName' => true,
  'TotalBalanceFilter Operator' => false,
  'TotalBalanceFilter Amount' => false,
  'IncludeRetElement' => true,
  'OwnerID' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ListID' => 999.99,
  'FullName' => 999.99,
  'MaxReturned' => 0,
  'ActiveStatus' => 999.99,
  'FromModifiedDate' => 999.99,
  'ToModifiedDate' => 999.99,
  'NameFilter MatchCriterion' => 999.99,
  'NameFilter Name' => 999.99,
  'NameRangeFilter FromName' => 999.99,
  'NameRangeFilter ToName' => 999.99,
  'TotalBalanceFilter Operator' => 999.99,
  'TotalBalanceFilter Amount' => 999.99,
  'IncludeRetElement' => 4,
  'OwnerID' => 2,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ListID' => true,
  'FullName' => true,
  'MaxReturned' => false,
  'ActiveStatus' => false,
  'FromModifiedDate' => false,
  'ToModifiedDate' => false,
  'NameFilter MatchCriterion' => false,
  'NameFilter Name' => false,
  'NameRangeFilter FromName' => false,
  'NameRangeFilter ToName' => false,
  'TotalBalanceFilter Operator' => false,
  'TotalBalanceFilter Amount' => false,
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
  0 => 'ListID',
  1 => 'FullName',
  2 => 'MaxReturned',
  3 => 'ActiveStatus',
  4 => 'FromModifiedDate',
  5 => 'ToModifiedDate',
  6 => 'NameFilter MatchCriterion',
  7 => 'NameFilter Name',
  8 => 'NameRangeFilter FromName',
  9 => 'NameRangeFilter ToName',
  10 => 'TotalBalanceFilter Operator',
  11 => 'TotalBalanceFilter Amount',
  12 => 'IncludeRetElement',
  13 => 'OwnerID',
);
			
		return $paths;
	}
}

?>