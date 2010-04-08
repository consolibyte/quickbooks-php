<?php

/**
 * Schema object for: DateDrivenTermsAddRq
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
class QuickBooks_QBXML_Schema_Object_DateDrivenTermsAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'DateDrivenTermsAdd Name' => 'STRTYPE',
  'DateDrivenTermsAdd IsActive' => 'BOOLTYPE',
  'DateDrivenTermsAdd DayOfMonthDue' => 'INTTYPE',
  'DateDrivenTermsAdd DueNextMonthDays' => 'INTTYPE',
  'DateDrivenTermsAdd DiscountDayOfMonth' => 'INTTYPE',
  'DateDrivenTermsAdd DiscountPct' => 'PERCENTTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'DateDrivenTermsAdd Name' => 31,
  'DateDrivenTermsAdd IsActive' => 0,
  'DateDrivenTermsAdd DayOfMonthDue' => 0,
  'DateDrivenTermsAdd DueNextMonthDays' => 0,
  'DateDrivenTermsAdd DiscountDayOfMonth' => 0,
  'DateDrivenTermsAdd DiscountPct' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'DateDrivenTermsAdd Name' => false,
  'DateDrivenTermsAdd IsActive' => true,
  'DateDrivenTermsAdd DayOfMonthDue' => false,
  'DateDrivenTermsAdd DueNextMonthDays' => true,
  'DateDrivenTermsAdd DiscountDayOfMonth' => true,
  'DateDrivenTermsAdd DiscountPct' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'DateDrivenTermsAdd Name' => 999.99,
  'DateDrivenTermsAdd IsActive' => 999.99,
  'DateDrivenTermsAdd DayOfMonthDue' => 0,
  'DateDrivenTermsAdd DueNextMonthDays' => 999.99,
  'DateDrivenTermsAdd DiscountDayOfMonth' => 0,
  'DateDrivenTermsAdd DiscountPct' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'DateDrivenTermsAdd Name' => false,
  'DateDrivenTermsAdd IsActive' => false,
  'DateDrivenTermsAdd DayOfMonthDue' => false,
  'DateDrivenTermsAdd DueNextMonthDays' => false,
  'DateDrivenTermsAdd DiscountDayOfMonth' => false,
  'DateDrivenTermsAdd DiscountPct' => false,
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
  0 => 'DateDrivenTermsAdd Name',
  1 => 'DateDrivenTermsAdd IsActive',
  2 => 'DateDrivenTermsAdd DayOfMonthDue',
  3 => 'DateDrivenTermsAdd DueNextMonthDays',
  4 => 'DateDrivenTermsAdd DiscountDayOfMonth',
  5 => 'DateDrivenTermsAdd DiscountPct',
  6 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>