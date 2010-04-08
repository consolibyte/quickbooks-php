<?php

/**
 * Schema object for: ItemSalesTaxGroupAddRq
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
class QuickBooks_QBXML_Schema_Object_ItemSalesTaxGroupAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupAdd Name' => 'STRTYPE',
  'ItemSalesTaxGroupAdd IsActive' => 'BOOLTYPE',
  'ItemSalesTaxGroupAdd ItemDesc' => 'STRTYPE',
  'ItemSalesTaxGroupAdd ItemSalesTaxRef ListID' => 'IDTYPE',
  'ItemSalesTaxGroupAdd ItemSalesTaxRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupAdd Name' => 31,
  'ItemSalesTaxGroupAdd IsActive' => 0,
  'ItemSalesTaxGroupAdd ItemDesc' => 4095,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef ListID' => 0,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef FullName' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupAdd Name' => false,
  'ItemSalesTaxGroupAdd IsActive' => true,
  'ItemSalesTaxGroupAdd ItemDesc' => true,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef ListID' => true,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupAdd Name' => 999.99,
  'ItemSalesTaxGroupAdd IsActive' => 999.99,
  'ItemSalesTaxGroupAdd ItemDesc' => 999.99,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef ListID' => 999.99,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ItemSalesTaxGroupAdd Name' => false,
  'ItemSalesTaxGroupAdd IsActive' => false,
  'ItemSalesTaxGroupAdd ItemDesc' => false,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef ListID' => false,
  'ItemSalesTaxGroupAdd ItemSalesTaxRef FullName' => false,
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
  0 => 'ItemSalesTaxGroupAdd Name',
  1 => 'ItemSalesTaxGroupAdd IsActive',
  2 => 'ItemSalesTaxGroupAdd ItemDesc',
  3 => 'ItemSalesTaxGroupAdd ItemSalesTaxRef ListID',
  4 => 'ItemSalesTaxGroupAdd ItemSalesTaxRef FullName',
  5 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>