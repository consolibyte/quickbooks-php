<?php

/**
 * Schema object for: PriceLevelModRq
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
class QuickBooks_QBXML_Schema_Object_PriceLevelModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'PriceLevelMod ListID' => 'IDTYPE',
  'PriceLevelMod EditSequence' => 'STRTYPE',
  'PriceLevelMod Name' => 'STRTYPE',
  'PriceLevelMod IsActive' => 'BOOLTYPE',
  'PriceLevelMod PriceLevelFixedPercentage' => 'PERCENTTYPE',
  'PriceLevelMod PriceLevelPerItem ItemRef ListID' => 'IDTYPE',
  'PriceLevelMod PriceLevelPerItem ItemRef FullName' => 'STRTYPE',
  'PriceLevelMod PriceLevelPerItem CustomPrice' => 'PRICETYPE',
  'PriceLevelMod PriceLevelPerItem CustomPricePercent' => 'PERCENTTYPE',
  'PriceLevelMod PriceLevelPerItem AdjustPercentage' => 'PERCENTTYPE',
  'PriceLevelMod PriceLevelPerItem AdjustRelativeTo' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'PriceLevelMod ListID' => 0,
  'PriceLevelMod EditSequence' => 16,
  'PriceLevelMod Name' => 31,
  'PriceLevelMod IsActive' => 0,
  'PriceLevelMod PriceLevelFixedPercentage' => 0,
  'PriceLevelMod PriceLevelPerItem ItemRef ListID' => 0,
  'PriceLevelMod PriceLevelPerItem ItemRef FullName' => 0,
  'PriceLevelMod PriceLevelPerItem CustomPrice' => 0,
  'PriceLevelMod PriceLevelPerItem CustomPricePercent' => 0,
  'PriceLevelMod PriceLevelPerItem AdjustPercentage' => 0,
  'PriceLevelMod PriceLevelPerItem AdjustRelativeTo' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'PriceLevelMod ListID' => false,
  'PriceLevelMod EditSequence' => false,
  'PriceLevelMod Name' => true,
  'PriceLevelMod IsActive' => true,
  'PriceLevelMod PriceLevelFixedPercentage' => false,
  'PriceLevelMod PriceLevelPerItem ItemRef ListID' => false,
  'PriceLevelMod PriceLevelPerItem ItemRef FullName' => true,
  'PriceLevelMod PriceLevelPerItem CustomPrice' => false,
  'PriceLevelMod PriceLevelPerItem CustomPricePercent' => false,
  'PriceLevelMod PriceLevelPerItem AdjustPercentage' => false,
  'PriceLevelMod PriceLevelPerItem AdjustRelativeTo' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'PriceLevelMod ListID' => 999.99,
  'PriceLevelMod EditSequence' => 999.99,
  'PriceLevelMod Name' => 999.99,
  'PriceLevelMod IsActive' => 999.99,
  'PriceLevelMod PriceLevelFixedPercentage' => 999.99,
  'PriceLevelMod PriceLevelPerItem ItemRef ListID' => 999.99,
  'PriceLevelMod PriceLevelPerItem ItemRef FullName' => 999.99,
  'PriceLevelMod PriceLevelPerItem CustomPrice' => 999.99,
  'PriceLevelMod PriceLevelPerItem CustomPricePercent' => 999.99,
  'PriceLevelMod PriceLevelPerItem AdjustPercentage' => 999.99,
  'PriceLevelMod PriceLevelPerItem AdjustRelativeTo' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'PriceLevelMod ListID' => false,
  'PriceLevelMod EditSequence' => false,
  'PriceLevelMod Name' => false,
  'PriceLevelMod IsActive' => false,
  'PriceLevelMod PriceLevelFixedPercentage' => false,
  'PriceLevelMod PriceLevelPerItem ItemRef ListID' => false,
  'PriceLevelMod PriceLevelPerItem ItemRef FullName' => false,
  'PriceLevelMod PriceLevelPerItem CustomPrice' => false,
  'PriceLevelMod PriceLevelPerItem CustomPricePercent' => false,
  'PriceLevelMod PriceLevelPerItem AdjustPercentage' => false,
  'PriceLevelMod PriceLevelPerItem AdjustRelativeTo' => false,
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
  0 => 'PriceLevelMod ListID',
  1 => 'PriceLevelMod EditSequence',
  2 => 'PriceLevelMod Name',
  3 => 'PriceLevelMod IsActive',
  4 => 'PriceLevelMod PriceLevelFixedPercentage',
  5 => 'PriceLevelMod',
  6 => 'PriceLevelMod PriceLevelPerItem',
  7 => 'PriceLevelMod PriceLevelPerItem ItemRef',
  8 => 'PriceLevelMod PriceLevelPerItem ItemRef ListID',
  9 => 'PriceLevelMod PriceLevelPerItem ItemRef FullName',
  10 => 'PriceLevelMod PriceLevelPerItem CustomPrice',
  11 => 'PriceLevelMod PriceLevelPerItem CustomPricePercent',
  12 => 'PriceLevelMod PriceLevelPerItem AdjustPercentage',
  13 => 'PriceLevelMod PriceLevelPerItem AdjustRelativeTo',
  14 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>