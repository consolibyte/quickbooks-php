<?php

/**
 * Schema object for: BillingRateAddRq
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
class QuickBooks_QBXML_Schema_Object_BillingRateAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'BillingRateAdd Name' => 'STRTYPE',
  'BillingRateAdd FixedBillingRate' => 'PRICETYPE',
  'BillingRateAdd BillingRatePerItem ItemRef ListID' => 'IDTYPE',
  'BillingRateAdd BillingRatePerItem ItemRef FullName' => 'STRTYPE',
  'BillingRateAdd BillingRatePerItem CustomRate' => 'PRICETYPE',
  'BillingRateAdd BillingRatePerItem CustomRatePercent' => 'PERCENTTYPE',
  'BillingRateAdd BillingRatePerItem AdjustPercentage' => 'PERCENTTYPE',
  'BillingRateAdd BillingRatePerItem AdjustBillingRateRelativeTo' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'BillingRateAdd Name' => 31,
  'BillingRateAdd FixedBillingRate' => 0,
  'BillingRateAdd BillingRatePerItem ItemRef ListID' => 0,
  'BillingRateAdd BillingRatePerItem ItemRef FullName' => 0,
  'BillingRateAdd BillingRatePerItem CustomRate' => 0,
  'BillingRateAdd BillingRatePerItem CustomRatePercent' => 0,
  'BillingRateAdd BillingRatePerItem AdjustPercentage' => 0,
  'BillingRateAdd BillingRatePerItem AdjustBillingRateRelativeTo' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'BillingRateAdd Name' => false,
  'BillingRateAdd FixedBillingRate' => false,
  'BillingRateAdd BillingRatePerItem ItemRef ListID' => true,
  'BillingRateAdd BillingRatePerItem ItemRef FullName' => true,
  'BillingRateAdd BillingRatePerItem CustomRate' => false,
  'BillingRateAdd BillingRatePerItem CustomRatePercent' => false,
  'BillingRateAdd BillingRatePerItem AdjustPercentage' => false,
  'BillingRateAdd BillingRatePerItem AdjustBillingRateRelativeTo' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'BillingRateAdd Name' => 999.99,
  'BillingRateAdd FixedBillingRate' => 999.99,
  'BillingRateAdd BillingRatePerItem ItemRef ListID' => 999.99,
  'BillingRateAdd BillingRatePerItem ItemRef FullName' => 999.99,
  'BillingRateAdd BillingRatePerItem CustomRate' => 999.99,
  'BillingRateAdd BillingRatePerItem CustomRatePercent' => 999.99,
  'BillingRateAdd BillingRatePerItem AdjustPercentage' => 999.99,
  'BillingRateAdd BillingRatePerItem AdjustBillingRateRelativeTo' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'BillingRateAdd Name' => false,
  'BillingRateAdd FixedBillingRate' => false,
  'BillingRateAdd BillingRatePerItem ItemRef ListID' => false,
  'BillingRateAdd BillingRatePerItem ItemRef FullName' => false,
  'BillingRateAdd BillingRatePerItem CustomRate' => false,
  'BillingRateAdd BillingRatePerItem CustomRatePercent' => false,
  'BillingRateAdd BillingRatePerItem AdjustPercentage' => false,
  'BillingRateAdd BillingRatePerItem AdjustBillingRateRelativeTo' => false,
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
  0 => 'BillingRateAdd Name',
  1 => 'BillingRateAdd FixedBillingRate',
  2 => 'BillingRateAdd',
  3 => 'BillingRateAdd BillingRatePerItem',
  4 => 'BillingRateAdd BillingRatePerItem ItemRef',
  5 => 'BillingRateAdd BillingRatePerItem ItemRef ListID',
  6 => 'BillingRateAdd BillingRatePerItem ItemRef FullName',
  7 => 'BillingRateAdd BillingRatePerItem CustomRate',
  8 => 'BillingRateAdd BillingRatePerItem CustomRatePercent',
  9 => 'BillingRateAdd BillingRatePerItem AdjustPercentage',
  10 => 'BillingRateAdd BillingRatePerItem AdjustBillingRateRelativeTo',
  11 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>