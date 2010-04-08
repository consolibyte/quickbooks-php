<?php

/**
 * Schema object for: PriceLevelAddRq
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
class QuickBooks_QBXML_Schema_Object_PriceLevelAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'PriceLevelAdd Name' => 'STRTYPE',
  'PriceLevelAdd IsActive' => 'BOOLTYPE',
  'PriceLevelAdd PriceLevelFixedPercentage' => 'PERCENTTYPE',
  'PriceLevelAdd PriceLevelPerItem ItemRef ListID' => 'IDTYPE',
  'PriceLevelAdd PriceLevelPerItem ItemRef FullName' => 'STRTYPE',
  'PriceLevelAdd PriceLevelPerItem CustomPrice' => 'PRICETYPE',
  'PriceLevelAdd PriceLevelPerItem CustomPricePercent' => 'PERCENTTYPE',
  'PriceLevelAdd PriceLevelPerItem AdjustPercentage' => 'PERCENTTYPE',
  'PriceLevelAdd PriceLevelPerItem AdjustRelativeTo' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'PriceLevelAdd Name' => 31,
  'PriceLevelAdd IsActive' => 0,
  'PriceLevelAdd PriceLevelFixedPercentage' => 0,
  'PriceLevelAdd PriceLevelPerItem ItemRef ListID' => 0,
  'PriceLevelAdd PriceLevelPerItem ItemRef FullName' => 0,
  'PriceLevelAdd PriceLevelPerItem CustomPrice' => 0,
  'PriceLevelAdd PriceLevelPerItem CustomPricePercent' => 0,
  'PriceLevelAdd PriceLevelPerItem AdjustPercentage' => 0,
  'PriceLevelAdd PriceLevelPerItem AdjustRelativeTo' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'PriceLevelAdd Name' => false,
  'PriceLevelAdd IsActive' => true,
  'PriceLevelAdd PriceLevelFixedPercentage' => false,
  'PriceLevelAdd PriceLevelPerItem ItemRef ListID' => true,
  'PriceLevelAdd PriceLevelPerItem ItemRef FullName' => true,
  'PriceLevelAdd PriceLevelPerItem CustomPrice' => false,
  'PriceLevelAdd PriceLevelPerItem CustomPricePercent' => false,
  'PriceLevelAdd PriceLevelPerItem AdjustPercentage' => false,
  'PriceLevelAdd PriceLevelPerItem AdjustRelativeTo' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'PriceLevelAdd Name' => 999.99,
  'PriceLevelAdd IsActive' => 999.99,
  'PriceLevelAdd PriceLevelFixedPercentage' => 999.99,
  'PriceLevelAdd PriceLevelPerItem ItemRef ListID' => 999.99,
  'PriceLevelAdd PriceLevelPerItem ItemRef FullName' => 999.99,
  'PriceLevelAdd PriceLevelPerItem CustomPrice' => 999.99,
  'PriceLevelAdd PriceLevelPerItem CustomPricePercent' => 999.99,
  'PriceLevelAdd PriceLevelPerItem AdjustPercentage' => 999.99,
  'PriceLevelAdd PriceLevelPerItem AdjustRelativeTo' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'PriceLevelAdd Name' => false,
  'PriceLevelAdd IsActive' => false,
  'PriceLevelAdd PriceLevelFixedPercentage' => false,
  'PriceLevelAdd PriceLevelPerItem ItemRef ListID' => false,
  'PriceLevelAdd PriceLevelPerItem ItemRef FullName' => false,
  'PriceLevelAdd PriceLevelPerItem CustomPrice' => false,
  'PriceLevelAdd PriceLevelPerItem CustomPricePercent' => false,
  'PriceLevelAdd PriceLevelPerItem AdjustPercentage' => false,
  'PriceLevelAdd PriceLevelPerItem AdjustRelativeTo' => false,
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
  0 => 'PriceLevelAdd Name',
  1 => 'PriceLevelAdd IsActive',
  2 => 'PriceLevelAdd PriceLevelFixedPercentage',
  3 => 'PriceLevelAdd',
  4 => 'PriceLevelAdd PriceLevelPerItem',
  5 => 'PriceLevelAdd PriceLevelPerItem ItemRef',
  6 => 'PriceLevelAdd PriceLevelPerItem ItemRef ListID',
  7 => 'PriceLevelAdd PriceLevelPerItem ItemRef FullName',
  8 => 'PriceLevelAdd PriceLevelPerItem CustomPrice',
  9 => 'PriceLevelAdd PriceLevelPerItem CustomPricePercent',
  10 => 'PriceLevelAdd PriceLevelPerItem AdjustPercentage',
  11 => 'PriceLevelAdd PriceLevelPerItem AdjustRelativeTo',
  12 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>