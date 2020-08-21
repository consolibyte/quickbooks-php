<?php

/**
 * Schema object for: DepartmentAddRq
 * 
 * @author Thomas Rientjes
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
class QuickBooks_QBXML_Schema_Object_DepartmentAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'DepartmentAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
			'Name' => 'STRTYPE',
			'IsActive' => 'BOOLTYPE',
			'ParentRef ListID' => 'IDTYPE',
			'ParentRef FullName' => 'STRTYPE',
			'IncludeRetElement' => 'STRTYPE',
		);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
			'Name' => 31,
			'IsActive' => 0,
			'ParentRef ListID' => 0,
			'ParentRef FullName' => 0,
			'IncludeRetElement' => 50,
		);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
			'Name' => false,
			'IsActive' => true,
			'ParentRef ListID' => true,
			'ParentRef FullName' => true,
			'IncludeRetElement' => true,
		);

		return $paths;
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
			'Name' => 999.99,
			'IsActive' => 999.99,
			'ParentRef ListID' => 999.99,
			'ParentRef FullName' => 999.99,
			'IncludeRetElement' => 4,
		);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
			'Name' => false,
			'IsActive' => false,
			'ParentRef ListID' => false,
			'ParentRef FullName' => false,
			'IncludeRetElement' => true,
		);
			
		return $paths;
	}

	protected function &_reorderPathsPaths()
	{
		static $paths = array (
			0 => 'Name',
			1 => 'IsActive',
			2 => 'ParentRef ListID',
			3 => 'ParentRef FullName',
			4 => 'IncludeRetElement',
		);
			
		return $paths;
	}
}
