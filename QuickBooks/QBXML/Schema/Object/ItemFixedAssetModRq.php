<?php

/**
 * Schema object for: ItemFixedAssetModRq
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
class QuickBooks_QBXML_Schema_Object_ItemFixedAssetModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'ItemFixedAssetMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'AcquiredAs' => 'ENUMTYPE',
  'PurchaseDesc' => 'STRTYPE',
  'PurchaseDate' => 'DATETYPE',
  'PurchaseCost' => 'PRICETYPE',
  'VendorOrPayeeName' => 'STRTYPE',
  'AssetAccountRef ListID' => 'IDTYPE',
  'AssetAccountRef FullName' => 'STRTYPE',
  'FixedAssetSalesInfoMod SalesDesc' => 'STRTYPE',
  'FixedAssetSalesInfoMod SalesDate' => 'DATETYPE',
  'FixedAssetSalesInfoMod SalesPrice' => 'PRICETYPE',
  'FixedAssetSalesInfoMod SalesExpense' => 'PRICETYPE',
  'AssetDesc' => 'STRTYPE',
  'Location' => 'STRTYPE',
  'PONumber' => 'STRTYPE',
  'SerialNumber' => 'STRTYPE',
  'WarrantyExpDate' => 'DATETYPE',
  'Notes' => 'STRTYPE',
  'AssetNumber' => 'STRTYPE',
  'CostBasis' => 'AMTTYPE',
  'YearEndAccumulatedDepreciation' => 'AMTTYPE',
  'YearEndBookValue' => 'AMTTYPE',
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
  'AcquiredAs' => 0,
  'PurchaseDesc' => 50,
  'PurchaseDate' => 0,
  'PurchaseCost' => 0,
  'VendorOrPayeeName' => 50,
  'AssetAccountRef ListID' => 0,
  'AssetAccountRef FullName' => 159,
  'FixedAssetSalesInfoMod SalesDesc' => 50,
  'FixedAssetSalesInfoMod SalesDate' => 0,
  'FixedAssetSalesInfoMod SalesPrice' => 0,
  'FixedAssetSalesInfoMod SalesExpense' => 0,
  'AssetDesc' => 50,
  'Location' => 50,
  'PONumber' => 30,
  'SerialNumber' => 30,
  'WarrantyExpDate' => 0,
  'Notes' => 4095,
  'AssetNumber' => 10,
  'CostBasis' => 0,
  'YearEndAccumulatedDepreciation' => 0,
  'YearEndBookValue' => 0,
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
  'AcquiredAs' => true,
  'PurchaseDesc' => true,
  'PurchaseDate' => true,
  'PurchaseCost' => true,
  'VendorOrPayeeName' => true,
  'AssetAccountRef ListID' => false,
  'AssetAccountRef FullName' => true,
  'FixedAssetSalesInfoMod SalesDesc' => true,
  'FixedAssetSalesInfoMod SalesDate' => true,
  'FixedAssetSalesInfoMod SalesPrice' => true,
  'FixedAssetSalesInfoMod SalesExpense' => true,
  'AssetDesc' => true,
  'Location' => true,
  'PONumber' => true,
  'SerialNumber' => true,
  'WarrantyExpDate' => true,
  'Notes' => true,
  'AssetNumber' => true,
  'CostBasis' => true,
  'YearEndAccumulatedDepreciation' => true,
  'YearEndBookValue' => true,
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
  'AcquiredAs' => 999.99,
  'PurchaseDesc' => 999.99,
  'PurchaseDate' => 999.99,
  'PurchaseCost' => 999.99,
  'VendorOrPayeeName' => 999.99,
  'AssetAccountRef ListID' => 999.99,
  'AssetAccountRef FullName' => 999.99,
  'FixedAssetSalesInfoMod SalesDesc' => 999.99,
  'FixedAssetSalesInfoMod SalesDate' => 999.99,
  'FixedAssetSalesInfoMod SalesPrice' => 999.99,
  'FixedAssetSalesInfoMod SalesExpense' => 999.99,
  'AssetDesc' => 999.99,
  'Location' => 999.99,
  'PONumber' => 999.99,
  'SerialNumber' => 999.99,
  'WarrantyExpDate' => 999.99,
  'Notes' => 999.99,
  'AssetNumber' => 999.99,
  'CostBasis' => 999.99,
  'YearEndAccumulatedDepreciation' => 999.99,
  'YearEndBookValue' => 999.99,
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
  'AcquiredAs' => false,
  'PurchaseDesc' => false,
  'PurchaseDate' => false,
  'PurchaseCost' => false,
  'VendorOrPayeeName' => false,
  'AssetAccountRef ListID' => false,
  'AssetAccountRef FullName' => false,
  'FixedAssetSalesInfoMod SalesDesc' => false,
  'FixedAssetSalesInfoMod SalesDate' => false,
  'FixedAssetSalesInfoMod SalesPrice' => false,
  'FixedAssetSalesInfoMod SalesExpense' => false,
  'AssetDesc' => false,
  'Location' => false,
  'PONumber' => false,
  'SerialNumber' => false,
  'WarrantyExpDate' => false,
  'Notes' => false,
  'AssetNumber' => false,
  'CostBasis' => false,
  'YearEndAccumulatedDepreciation' => false,
  'YearEndBookValue' => false,
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
  4 => 'AcquiredAs',
  5 => 'PurchaseDesc',
  6 => 'PurchaseDate',
  7 => 'PurchaseCost',
  8 => 'VendorOrPayeeName',
  9 => 'AssetAccountRef ListID',
  10 => 'AssetAccountRef FullName',
  11 => 'FixedAssetSalesInfoMod SalesDesc',
  12 => 'FixedAssetSalesInfoMod SalesDate',
  13 => 'FixedAssetSalesInfoMod SalesPrice',
  14 => 'FixedAssetSalesInfoMod SalesExpense',
  15 => 'AssetDesc',
  16 => 'Location',
  17 => 'PONumber',
  18 => 'SerialNumber',
  19 => 'WarrantyExpDate',
  20 => 'Notes',
  21 => 'AssetNumber',
  22 => 'CostBasis',
  23 => 'YearEndAccumulatedDepreciation',
  24 => 'YearEndBookValue',
  25 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>