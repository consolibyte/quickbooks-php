<?php

/**
 * Schema object for: SalesTaxCodeAddRq
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
class QuickBooks_QBXML_Schema_Object_SalesTaxCodeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'SalesTaxCodeAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'IsTaxable' => 'BOOLTYPE',
  'Desc' => 'STRTYPE',
  'ItemPurchaseTaxRef ListID' => 'IDTYPE',
  'ItemPurchaseTaxRef FullName' => 'STRTYPE',
  'ItemSalesTaxRef ListID' => 'IDTYPE',
  'ItemSalesTaxRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Name' => 3,
  'IsActive' => 0,
  'IsTaxable' => 0,
  'Desc' => 31,
  'ItemPurchaseTaxRef ListID' => 0,
  'ItemPurchaseTaxRef FullName' => 31,
  'ItemSalesTaxRef ListID' => 0,
  'ItemSalesTaxRef FullName' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => true,
  'IsTaxable' => false,
  'Desc' => true,
  'ItemPurchaseTaxRef ListID' => true,
  'ItemPurchaseTaxRef FullName' => true,
  'ItemSalesTaxRef ListID' => true,
  'ItemSalesTaxRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Name' => 999.99,
  'IsActive' => 999.99,
  'IsTaxable' => 999.99,
  'Desc' => 999.99,
  'ItemPurchaseTaxRef ListID' => 999.99,
  'ItemPurchaseTaxRef FullName' => 999.99,
  'ItemSalesTaxRef ListID' => 999.99,
  'ItemSalesTaxRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => false,
  'IsTaxable' => false,
  'Desc' => false,
  'ItemPurchaseTaxRef ListID' => false,
  'ItemPurchaseTaxRef FullName' => false,
  'ItemSalesTaxRef ListID' => false,
  'ItemSalesTaxRef FullName' => false,
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
  2 => 'IsTaxable',
  3 => 'Desc',
  4 => 'ItemPurchaseTaxRef ListID',
  5 => 'ItemPurchaseTaxRef FullName',
  6 => 'ItemSalesTaxRef ListID',
  7 => 'ItemSalesTaxRef FullName',
  8 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>