<?php

/**
 * Schema object for: ItemSalesTaxAddRq
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
class QuickBooks_QBXML_Schema_Object_ItemSalesTaxAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemSalesTaxAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'IsUsedOnPurchaseTransaction' => 'BOOLTYPE',
  'ItemDesc' => 'STRTYPE',
  'TaxRate' => 'PERCENTTYPE',
  'TaxVendorRef ListID' => 'IDTYPE',
  'TaxVendorRef FullName' => 'STRTYPE',
  'SalesTaxReturnLineNumber' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Name' => 31,
  'IsActive' => 0,
  'IsUsedOnPurchaseTransaction' => 0,
  'ItemDesc' => 4095,
  'TaxRate' => 0,
  'TaxVendorRef ListID' => 0,
  'TaxVendorRef FullName' => 41,
  'SalesTaxReturnLineNumber' => 79,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => true,
  'IsUsedOnPurchaseTransaction' => true,
  'ItemDesc' => true,
  'TaxRate' => true,
  'TaxVendorRef ListID' => true,
  'TaxVendorRef FullName' => true,
  'SalesTaxReturnLineNumber' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Name' => 999.99,
  'IsActive' => 999.99,
  'IsUsedOnPurchaseTransaction' => 6,
  'ItemDesc' => 999.99,
  'TaxRate' => 999.99,
  'TaxVendorRef ListID' => 999.99,
  'TaxVendorRef FullName' => 999.99,
  'SalesTaxReturnLineNumber' => 6,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => false,
  'IsUsedOnPurchaseTransaction' => false,
  'ItemDesc' => false,
  'TaxRate' => false,
  'TaxVendorRef ListID' => false,
  'TaxVendorRef FullName' => false,
  'SalesTaxReturnLineNumber' => false,
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
  2 => 'IsUsedOnPurchaseTransaction',
  3 => 'ItemDesc',
  4 => 'TaxRate',
  5 => 'TaxVendorRef ListID',
  6 => 'TaxVendorRef FullName',
  7 => 'SalesTaxReturnLineNumber',
  8 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>