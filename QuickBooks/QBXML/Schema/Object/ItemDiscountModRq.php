<?php

/**
 * Schema object for: ItemDiscountModRq
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
class QuickBooks_QBXML_Schema_Object_ItemDiscountModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemDiscountMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'ParentRef ListID' => 'IDTYPE',
  'ParentRef FullName' => 'STRTYPE',
  'ItemDesc' => 'STRTYPE',
  'SalesTaxCodeRef ListID' => 'IDTYPE',
  'SalesTaxCodeRef FullName' => 'STRTYPE',
  'DiscountRate' => 'PRICETYPE',
  'DiscountRatePercent' => 'PERCENTTYPE',
  'AccountRef ListID' => 'IDTYPE',
  'AccountRef FullName' => 'STRTYPE',
  'ApplyAccountRefToExistingTxns' => 'BOOLTYPE',
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
  'ParentRef ListID' => 0,
  'ParentRef FullName' => 0,
  'ItemDesc' => 4095,
  'SalesTaxCodeRef ListID' => 0,
  'SalesTaxCodeRef FullName' => 0,
  'DiscountRate' => 0,
  'DiscountRatePercent' => 0,
  'AccountRef ListID' => 0,
  'AccountRef FullName' => 0,
  'ApplyAccountRefToExistingTxns' => 0,
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
  'ParentRef ListID' => false,
  'ParentRef FullName' => true,
  'ItemDesc' => true,
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => true,
  'DiscountRate' => false,
  'DiscountRatePercent' => false,
  'AccountRef ListID' => false,
  'AccountRef FullName' => true,
  'ApplyAccountRefToExistingTxns' => true,
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
  'ParentRef ListID' => 999.99,
  'ParentRef FullName' => 999.99,
  'ItemDesc' => 999.99,
  'SalesTaxCodeRef ListID' => 999.99,
  'SalesTaxCodeRef FullName' => 999.99,
  'DiscountRate' => 999.99,
  'DiscountRatePercent' => 999.99,
  'AccountRef ListID' => 999.99,
  'AccountRef FullName' => 999.99,
  'ApplyAccountRefToExistingTxns' => 7,
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
  'ParentRef ListID' => false,
  'ParentRef FullName' => false,
  'ItemDesc' => false,
  'SalesTaxCodeRef ListID' => false,
  'SalesTaxCodeRef FullName' => false,
  'DiscountRate' => false,
  'DiscountRatePercent' => false,
  'AccountRef ListID' => false,
  'AccountRef FullName' => false,
  'ApplyAccountRefToExistingTxns' => false,
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
  4 => 'ParentRef ListID',
  5 => 'ParentRef FullName',
  6 => 'ItemDesc',
  7 => 'SalesTaxCodeRef ListID',
  8 => 'SalesTaxCodeRef FullName',
  9 => 'DiscountRate',
  10 => 'DiscountRatePercent',
  11 => 'AccountRef ListID',
  12 => 'AccountRef FullName',
  13 => 'ApplyAccountRefToExistingTxns',
  14 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>