<?php

/**
 * Schema object for: VendorTypeAddRq
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
class QuickBooks_QBXML_Schema_Object_VendorTypeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'VendorTypeAdd Name' => 'STRTYPE',
  'VendorTypeAdd IsActive' => 'BOOLTYPE',
  'VendorTypeAdd ParentRef ListID' => 'IDTYPE',
  'VendorTypeAdd ParentRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'VendorTypeAdd Name' => 31,
  'VendorTypeAdd IsActive' => 0,
  'VendorTypeAdd ParentRef ListID' => 0,
  'VendorTypeAdd ParentRef FullName' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'VendorTypeAdd Name' => false,
  'VendorTypeAdd IsActive' => true,
  'VendorTypeAdd ParentRef ListID' => true,
  'VendorTypeAdd ParentRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'VendorTypeAdd Name' => 999.99,
  'VendorTypeAdd IsActive' => 999.99,
  'VendorTypeAdd ParentRef ListID' => 999.99,
  'VendorTypeAdd ParentRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'VendorTypeAdd Name' => false,
  'VendorTypeAdd IsActive' => false,
  'VendorTypeAdd ParentRef ListID' => false,
  'VendorTypeAdd ParentRef FullName' => false,
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
  0 => 'VendorTypeAdd Name',
  1 => 'VendorTypeAdd IsActive',
  2 => 'VendorTypeAdd ParentRef ListID',
  3 => 'VendorTypeAdd ParentRef FullName',
  4 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>