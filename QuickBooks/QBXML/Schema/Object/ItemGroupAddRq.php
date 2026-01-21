<?php

/**
 * Schema object for: ItemGroupAddRq
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
class QuickBooks_QBXML_Schema_Object_ItemGroupAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemGroupAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'ItemDesc' => 'STRTYPE',
  'UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'IsPrintItemsInGroup' => 'BOOLTYPE',
  'ItemGroupLine ItemRef ListID' => 'IDTYPE',
  'ItemGroupLine ItemRef FullName' => 'STRTYPE',
  'ItemGroupLine Quantity' => 'QUANTYPE',
  'ItemGroupLine UnitOfMeasure' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Name' => 31,
  'IsActive' => 0,
  'ItemDesc' => 4095,
  'UnitOfMeasureSetRef ListID' => 0,
  'UnitOfMeasureSetRef FullName' => 31,
  'IsPrintItemsInGroup' => 0,
  'ItemGroupLine ItemRef ListID' => 0,
  'ItemGroupLine ItemRef FullName' => 31,
  'ItemGroupLine Quantity' => 0,
  'ItemGroupLine UnitOfMeasure' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => true,
  'ItemDesc' => true,
  'UnitOfMeasureSetRef ListID' => true,
  'UnitOfMeasureSetRef FullName' => true,
  'IsPrintItemsInGroup' => true,
  'ItemGroupLine ItemRef ListID' => true,
  'ItemGroupLine ItemRef FullName' => true,
  'ItemGroupLine Quantity' => true,
  'ItemGroupLine UnitOfMeasure' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Name' => 999.99,
  'IsActive' => 999.99,
  'ItemDesc' => 999.99,
  'UnitOfMeasureSetRef ListID' => 999.99,
  'UnitOfMeasureSetRef FullName' => 999.99,
  'IsPrintItemsInGroup' => 999.99,
  'ItemGroupLine ItemRef ListID' => 999.99,
  'ItemGroupLine ItemRef FullName' => 999.99,
  'ItemGroupLine Quantity' => 999.99,
  'ItemGroupLine UnitOfMeasure' => 7,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => false,
  'ItemDesc' => false,
  'UnitOfMeasureSetRef ListID' => false,
  'UnitOfMeasureSetRef FullName' => false,
  'IsPrintItemsInGroup' => false,
  'ItemGroupLine ItemRef ListID' => false,
  'ItemGroupLine ItemRef FullName' => false,
  'ItemGroupLine Quantity' => false,
  'ItemGroupLine UnitOfMeasure' => false,
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
  0 => 'Name',
  1 => 'IsActive',
  2 => 'ItemDesc',
  3 => 'UnitOfMeasureSetRef ListID',
  4 => 'UnitOfMeasureSetRef FullName',
  5 => 'IsPrintItemsInGroup',
  6 => 'ItemGroupLine',
  7 => 'ItemGroupLine ItemRef',
  8 => 'ItemGroupLine ItemRef ListID',
  9 => 'ItemGroupLine ItemRef FullName',
  10 => 'ItemGroupLine Quantity',
  11 => 'ItemGroupLine UnitOfMeasure',
  12 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>