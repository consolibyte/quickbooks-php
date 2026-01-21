<?php

/**
 * Schema object for: JobTypeAddRq
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
class QuickBooks_QBXML_Schema_Object_JobTypeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'JobTypeAdd Name' => 'STRTYPE',
  'JobTypeAdd IsActive' => 'BOOLTYPE',
  'JobTypeAdd ParentRef ListID' => 'IDTYPE',
  'JobTypeAdd ParentRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'JobTypeAdd Name' => 31,
  'JobTypeAdd IsActive' => 0,
  'JobTypeAdd ParentRef ListID' => 0,
  'JobTypeAdd ParentRef FullName' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'JobTypeAdd Name' => false,
  'JobTypeAdd IsActive' => true,
  'JobTypeAdd ParentRef ListID' => true,
  'JobTypeAdd ParentRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'JobTypeAdd Name' => 999.99,
  'JobTypeAdd IsActive' => 999.99,
  'JobTypeAdd ParentRef ListID' => 999.99,
  'JobTypeAdd ParentRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'JobTypeAdd Name' => false,
  'JobTypeAdd IsActive' => false,
  'JobTypeAdd ParentRef ListID' => false,
  'JobTypeAdd ParentRef FullName' => false,
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
  0 => 'JobTypeAdd Name',
  1 => 'JobTypeAdd IsActive',
  2 => 'JobTypeAdd ParentRef ListID',
  3 => 'JobTypeAdd ParentRef FullName',
  4 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>