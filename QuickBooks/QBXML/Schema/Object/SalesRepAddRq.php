<?php

/**
 * Schema object for: SalesRepAddRq
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
class QuickBooks_QBXML_Schema_Object_SalesRepAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'SalesRepAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Initial' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'SalesRepEntityRef ListID' => 'IDTYPE',
  'SalesRepEntityRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Initial' => 5,
  'IsActive' => 0,
  'SalesRepEntityRef ListID' => 0,
  'SalesRepEntityRef FullName' => 41,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'Initial' => false,
  'IsActive' => true,
  'SalesRepEntityRef ListID' => true,
  'SalesRepEntityRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Initial' => 999.99,
  'IsActive' => 999.99,
  'SalesRepEntityRef ListID' => 999.99,
  'SalesRepEntityRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'Initial' => false,
  'IsActive' => false,
  'SalesRepEntityRef ListID' => false,
  'SalesRepEntityRef FullName' => false,
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
  0 => 'Initial',
  1 => 'IsActive',
  2 => 'SalesRepEntityRef ListID',
  3 => 'SalesRepEntityRef FullName',
  4 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>