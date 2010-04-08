<?php

/**
 * Schema object for: ItemGroupModRq
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
class QuickBooks_QBXML_Schema_Object_ItemGroupModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemGroupMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'ItemDesc' => 'STRTYPE',
  'UnitOfMeasureSetRef ListID' => 'IDTYPE',
  'UnitOfMeasureSetRef FullName' => 'STRTYPE',
  'ForceUOMChange' => 'BOOLTYPE',
  'IsPrintItemsInGroup' => 'BOOLTYPE',
  'ClearItemsInGroup' => 'BOOLTYPE',
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
  'ListID' => 0,
  'EditSequence' => 16,
  'Name' => 31,
  'IsActive' => 0,
  'ItemDesc' => 4095,
  'UnitOfMeasureSetRef ListID' => 0,
  'UnitOfMeasureSetRef FullName' => 31,
  'ForceUOMChange' => 0,
  'IsPrintItemsInGroup' => 0,
  'ClearItemsInGroup' => 0,
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
  'ListID' => false,
  'EditSequence' => false,
  'Name' => true,
  'IsActive' => true,
  'ItemDesc' => true,
  'UnitOfMeasureSetRef ListID' => false,
  'UnitOfMeasureSetRef FullName' => true,
  'ForceUOMChange' => true,
  'IsPrintItemsInGroup' => true,
  'ClearItemsInGroup' => false,
  'ItemGroupLine ItemRef ListID' => false,
  'ItemGroupLine ItemRef FullName' => true,
  'ItemGroupLine Quantity' => true,
  'ItemGroupLine UnitOfMeasure' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ListID' => 999.99,
  'EditSequence' => 999.99,
  'Name' => 999.99,
  'IsActive' => 999.99,
  'ItemDesc' => 999.99,
  'UnitOfMeasureSetRef ListID' => 999.99,
  'UnitOfMeasureSetRef FullName' => 999.99,
  'ForceUOMChange' => 7,
  'IsPrintItemsInGroup' => 999.99,
  'ClearItemsInGroup' => 999.99,
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
  'ListID' => false,
  'EditSequence' => false,
  'Name' => false,
  'IsActive' => false,
  'ItemDesc' => false,
  'UnitOfMeasureSetRef ListID' => false,
  'UnitOfMeasureSetRef FullName' => false,
  'ForceUOMChange' => false,
  'IsPrintItemsInGroup' => false,
  'ClearItemsInGroup' => false,
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
  0 => 'ListID',
  1 => 'EditSequence',
  2 => 'Name',
  3 => 'IsActive',
  4 => 'ItemDesc',
  5 => 'UnitOfMeasureSetRef ListID',
  6 => 'UnitOfMeasureSetRef FullName',
  7 => 'ForceUOMChange',
  8 => 'IsPrintItemsInGroup',
  9 => 'ClearItemsInGroup',
  10 => 'ItemGroupLine',
  11 => 'ItemGroupLine ItemRef',
  12 => 'ItemGroupLine ItemRef ListID',
  13 => 'ItemGroupLine ItemRef FullName',
  14 => 'ItemGroupLine Quantity',
  15 => 'ItemGroupLine UnitOfMeasure',
  16 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>