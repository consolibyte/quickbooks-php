<?php

/**
 * Schema object for: ClassAddRq
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
class QuickBooks_QBXML_Schema_Object_ClassAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ClassAdd Name' => 'STRTYPE',
  'ClassAdd IsActive' => 'BOOLTYPE',
  'ClassAdd ParentRef ListID' => 'IDTYPE',
  'ClassAdd ParentRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ClassAdd Name' => 31,
  'ClassAdd IsActive' => 0,
  'ClassAdd ParentRef ListID' => 0,
  'ClassAdd ParentRef FullName' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ClassAdd Name' => false,
  'ClassAdd IsActive' => true,
  'ClassAdd ParentRef ListID' => true,
  'ClassAdd ParentRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ClassAdd Name' => 999.99,
  'ClassAdd IsActive' => 999.99,
  'ClassAdd ParentRef ListID' => 999.99,
  'ClassAdd ParentRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ClassAdd Name' => false,
  'ClassAdd IsActive' => false,
  'ClassAdd ParentRef ListID' => false,
  'ClassAdd ParentRef FullName' => false,
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
  0 => 'ClassAdd Name',
  1 => 'ClassAdd IsActive',
  2 => 'ClassAdd ParentRef ListID',
  3 => 'ClassAdd ParentRef FullName',
  4 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>