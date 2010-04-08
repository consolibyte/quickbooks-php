<?php

/**
 * Schema object for: ItemSubtotalAddRq
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
class QuickBooks_QBXML_Schema_Object_ItemSubtotalAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemSubtotalAdd Name' => 'STRTYPE',
  'ItemSubtotalAdd IsActive' => 'BOOLTYPE',
  'ItemSubtotalAdd ItemDesc' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemSubtotalAdd Name' => 31,
  'ItemSubtotalAdd IsActive' => 0,
  'ItemSubtotalAdd ItemDesc' => 4095,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemSubtotalAdd Name' => false,
  'ItemSubtotalAdd IsActive' => true,
  'ItemSubtotalAdd ItemDesc' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemSubtotalAdd Name' => 999.99,
  'ItemSubtotalAdd IsActive' => 999.99,
  'ItemSubtotalAdd ItemDesc' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemSubtotalAdd Name' => false,
  'ItemSubtotalAdd IsActive' => false,
  'ItemSubtotalAdd ItemDesc' => false,
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
  0 => 'ItemSubtotalAdd Name',
  1 => 'ItemSubtotalAdd IsActive',
  2 => 'ItemSubtotalAdd ItemDesc',
  3 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>