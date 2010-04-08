<?php

/**
 * Schema object for: ItemSalesTaxModRq
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
class QuickBooks_QBXML_Schema_Object_ItemSalesTaxModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemSalesTaxMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
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
  'ListID' => 0,
  'EditSequence' => 16,
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
  'ListID' => false,
  'EditSequence' => false,
  'Name' => true,
  'IsActive' => true,
  'IsUsedOnPurchaseTransaction' => true,
  'ItemDesc' => true,
  'TaxRate' => true,
  'TaxVendorRef ListID' => false,
  'TaxVendorRef FullName' => true,
  'SalesTaxReturnLineNumber' => true,
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
  'ListID' => false,
  'EditSequence' => false,
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
  0 => 'ListID',
  1 => 'EditSequence',
  2 => 'Name',
  3 => 'IsActive',
  4 => 'IsUsedOnPurchaseTransaction',
  5 => 'ItemDesc',
  6 => 'TaxRate',
  7 => 'TaxVendorRef ListID',
  8 => 'TaxVendorRef FullName',
  9 => 'SalesTaxReturnLineNumber',
  10 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>