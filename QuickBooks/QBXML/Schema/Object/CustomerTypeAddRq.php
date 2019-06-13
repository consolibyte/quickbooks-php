<?php

/**
 * Schema object for: CustomerTypeAddRq
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
class QuickBooks_QBXML_Schema_Object_CustomerTypeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'CustomerTypeAdd Name' => 'STRTYPE',
  'CustomerTypeAdd IsActive' => 'BOOLTYPE',
  'CustomerTypeAdd ParentRef ListID' => 'IDTYPE',
  'CustomerTypeAdd ParentRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'CustomerTypeAdd Name' => 31,
  'CustomerTypeAdd IsActive' => 0,
  'CustomerTypeAdd ParentRef ListID' => 0,
  'CustomerTypeAdd ParentRef FullName' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'CustomerTypeAdd Name' => false,
  'CustomerTypeAdd IsActive' => true,
  'CustomerTypeAdd ParentRef ListID' => true,
  'CustomerTypeAdd ParentRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'CustomerTypeAdd Name' => 999.99,
  'CustomerTypeAdd IsActive' => 999.99,
  'CustomerTypeAdd ParentRef ListID' => 999.99,
  'CustomerTypeAdd ParentRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'CustomerTypeAdd Name' => false,
  'CustomerTypeAdd IsActive' => false,
  'CustomerTypeAdd ParentRef ListID' => false,
  'CustomerTypeAdd ParentRef FullName' => false,
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
  0 => 'CustomerTypeAdd Name',
  1 => 'CustomerTypeAdd IsActive',
  2 => 'CustomerTypeAdd ParentRef ListID',
  3 => 'CustomerTypeAdd ParentRef FullName',
  4 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>