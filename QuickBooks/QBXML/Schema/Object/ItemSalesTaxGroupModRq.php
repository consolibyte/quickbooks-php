<?php

/**
 * Schema object for: ItemSalesTaxGroupModRq
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
class QuickBooks_QBXML_Schema_Object_ItemSalesTaxGroupModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupMod ListID' => 'IDTYPE',
  'ItemSalesTaxGroupMod EditSequence' => 'STRTYPE',
  'ItemSalesTaxGroupMod Name' => 'STRTYPE',
  'ItemSalesTaxGroupMod IsActive' => 'BOOLTYPE',
  'ItemSalesTaxGroupMod ItemDesc' => 'STRTYPE',
  'ItemSalesTaxGroupMod ItemSalesTaxRef ListID' => 'IDTYPE',
  'ItemSalesTaxGroupMod ItemSalesTaxRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupMod ListID' => 0,
  'ItemSalesTaxGroupMod EditSequence' => 16,
  'ItemSalesTaxGroupMod Name' => 31,
  'ItemSalesTaxGroupMod IsActive' => 0,
  'ItemSalesTaxGroupMod ItemDesc' => 4095,
  'ItemSalesTaxGroupMod ItemSalesTaxRef ListID' => 0,
  'ItemSalesTaxGroupMod ItemSalesTaxRef FullName' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupMod ListID' => false,
  'ItemSalesTaxGroupMod EditSequence' => false,
  'ItemSalesTaxGroupMod Name' => true,
  'ItemSalesTaxGroupMod IsActive' => true,
  'ItemSalesTaxGroupMod ItemDesc' => true,
  'ItemSalesTaxGroupMod ItemSalesTaxRef ListID' => false,
  'ItemSalesTaxGroupMod ItemSalesTaxRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupMod ListID' => 999.99,
  'ItemSalesTaxGroupMod EditSequence' => 999.99,
  'ItemSalesTaxGroupMod Name' => 999.99,
  'ItemSalesTaxGroupMod IsActive' => 999.99,
  'ItemSalesTaxGroupMod ItemDesc' => 999.99,
  'ItemSalesTaxGroupMod ItemSalesTaxRef ListID' => 999.99,
  'ItemSalesTaxGroupMod ItemSalesTaxRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupMod ListID' => false,
  'ItemSalesTaxGroupMod EditSequence' => false,
  'ItemSalesTaxGroupMod Name' => false,
  'ItemSalesTaxGroupMod IsActive' => false,
  'ItemSalesTaxGroupMod ItemDesc' => false,
  'ItemSalesTaxGroupMod ItemSalesTaxRef ListID' => false,
  'ItemSalesTaxGroupMod ItemSalesTaxRef FullName' => false,
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
  0 => 'ItemSalesTaxGroupMod ListID',
  1 => 'ItemSalesTaxGroupMod EditSequence',
  2 => 'ItemSalesTaxGroupMod Name',
  3 => 'ItemSalesTaxGroupMod IsActive',
  4 => 'ItemSalesTaxGroupMod ItemDesc',
  5 => 'ItemSalesTaxGroupMod ItemSalesTaxRef ListID',
  6 => 'ItemSalesTaxGroupMod ItemSalesTaxRef FullName',
  7 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>