<?php

/**
 * Schema object for: ItemSubtotalModRq
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
class QuickBooks_QBXML_Schema_Object_ItemSubtotalModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemSubtotalMod ListID' => 'IDTYPE',
  'ItemSubtotalMod EditSequence' => 'STRTYPE',
  'ItemSubtotalMod Name' => 'STRTYPE',
  'ItemSubtotalMod IsActive' => 'BOOLTYPE',
  'ItemSubtotalMod ItemDesc' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemSubtotalMod ListID' => 0,
  'ItemSubtotalMod EditSequence' => 16,
  'ItemSubtotalMod Name' => 31,
  'ItemSubtotalMod IsActive' => 0,
  'ItemSubtotalMod ItemDesc' => 4095,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemSubtotalMod ListID' => false,
  'ItemSubtotalMod EditSequence' => false,
  'ItemSubtotalMod Name' => true,
  'ItemSubtotalMod IsActive' => true,
  'ItemSubtotalMod ItemDesc' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemSubtotalMod ListID' => 999.99,
  'ItemSubtotalMod EditSequence' => 999.99,
  'ItemSubtotalMod Name' => 999.99,
  'ItemSubtotalMod IsActive' => 999.99,
  'ItemSubtotalMod ItemDesc' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemSubtotalMod ListID' => false,
  'ItemSubtotalMod EditSequence' => false,
  'ItemSubtotalMod Name' => false,
  'ItemSubtotalMod IsActive' => false,
  'ItemSubtotalMod ItemDesc' => false,
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
  0 => 'ItemSubtotalMod ListID',
  1 => 'ItemSubtotalMod EditSequence',
  2 => 'ItemSubtotalMod Name',
  3 => 'ItemSubtotalMod IsActive',
  4 => 'ItemSubtotalMod ItemDesc',
  5 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>