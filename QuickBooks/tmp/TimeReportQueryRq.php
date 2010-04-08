<?php

/**
 * Schema object for: TimeReportQueryRq
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
class QuickBooks_QBXML_Schema_Object_TimeReportQueryRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'TimeReportType' => 'ENUMTYPE',
  'DisplayReport' => 'BOOLTYPE',
  'ReportPeriod FromReportDate' => 'DATETYPE',
  'ReportPeriod ToReportDate' => 'DATETYPE',
  'ReportDateMacro' => 'ENUMTYPE',
  'ReportEntityFilter EntityTypeFilter' => 'ENUMTYPE',
  'ReportEntityFilter ListID' => 'IDTYPE',
  'ReportEntityFilter FullName' => 'STRTYPE',
  'ReportEntityFilter ListIDWithChildren' => 'IDTYPE',
  'ReportEntityFilter FullNameWithChildren' => 'STRTYPE',
  'ReportItemFilter ItemTypeFilter' => 'ENUMTYPE',
  'ReportItemFilter ListID' => 'IDTYPE',
  'ReportItemFilter FullName' => 'STRTYPE',
  'ReportItemFilter ListIDWithChildren' => 'IDTYPE',
  'ReportItemFilter FullNameWithChildren' => 'STRTYPE',
  'ReportClassFilter ListID' => 'IDTYPE',
  'ReportClassFilter FullName' => 'STRTYPE',
  'ReportClassFilter ListIDWithChildren' => 'IDTYPE',
  'ReportClassFilter FullNameWithChildren' => 'STRTYPE',
  'SummarizeColumnsBy' => 'ENUMTYPE',
  'IncludeSubcolumns' => 'BOOLTYPE',
  'ReportCalendar' => 'ENUMTYPE',
  'ReturnRows' => 'ENUMTYPE',
  'ReturnColumns' => 'ENUMTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'TimeReportType' => 0,
  'DisplayReport' => 0,
  'ReportPeriod FromReportDate' => 0,
  'ReportPeriod ToReportDate' => 0,
  'ReportDateMacro' => 0,
  'ReportEntityFilter EntityTypeFilter' => 0,
  'ReportEntityFilter ListID' => 0,
  'ReportEntityFilter FullName' => 0,
  'ReportEntityFilter ListIDWithChildren' => 0,
  'ReportEntityFilter FullNameWithChildren' => 0,
  'ReportItemFilter ItemTypeFilter' => 0,
  'ReportItemFilter ListID' => 0,
  'ReportItemFilter FullName' => 0,
  'ReportItemFilter ListIDWithChildren' => 0,
  'ReportItemFilter FullNameWithChildren' => 0,
  'ReportClassFilter ListID' => 0,
  'ReportClassFilter FullName' => 0,
  'ReportClassFilter ListIDWithChildren' => 0,
  'ReportClassFilter FullNameWithChildren' => 0,
  'SummarizeColumnsBy' => 0,
  'IncludeSubcolumns' => 0,
  'ReportCalendar' => 0,
  'ReturnRows' => 0,
  'ReturnColumns' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'TimeReportType' => false,
  'DisplayReport' => true,
  'ReportPeriod FromReportDate' => true,
  'ReportPeriod ToReportDate' => true,
  'ReportDateMacro' => false,
  'ReportEntityFilter EntityTypeFilter' => false,
  'ReportEntityFilter ListID' => false,
  'ReportEntityFilter FullName' => false,
  'ReportEntityFilter ListIDWithChildren' => false,
  'ReportEntityFilter FullNameWithChildren' => false,
  'ReportItemFilter ItemTypeFilter' => false,
  'ReportItemFilter ListID' => false,
  'ReportItemFilter FullName' => false,
  'ReportItemFilter ListIDWithChildren' => false,
  'ReportItemFilter FullNameWithChildren' => false,
  'ReportClassFilter ListID' => false,
  'ReportClassFilter FullName' => false,
  'ReportClassFilter ListIDWithChildren' => false,
  'ReportClassFilter FullNameWithChildren' => false,
  'SummarizeColumnsBy' => true,
  'IncludeSubcolumns' => true,
  'ReportCalendar' => true,
  'ReturnRows' => true,
  'ReturnColumns' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'TimeReportType' => 999.99,
  'DisplayReport' => 3,
  'ReportPeriod FromReportDate' => 999.99,
  'ReportPeriod ToReportDate' => 999.99,
  'ReportDateMacro' => 999.99,
  'ReportEntityFilter EntityTypeFilter' => 999.99,
  'ReportEntityFilter ListID' => 999.99,
  'ReportEntityFilter FullName' => 999.99,
  'ReportEntityFilter ListIDWithChildren' => 999.99,
  'ReportEntityFilter FullNameWithChildren' => 999.99,
  'ReportItemFilter ItemTypeFilter' => 999.99,
  'ReportItemFilter ListID' => 999.99,
  'ReportItemFilter FullName' => 999.99,
  'ReportItemFilter ListIDWithChildren' => 999.99,
  'ReportItemFilter FullNameWithChildren' => 999.99,
  'ReportClassFilter ListID' => 999.99,
  'ReportClassFilter FullName' => 999.99,
  'ReportClassFilter ListIDWithChildren' => 999.99,
  'ReportClassFilter FullNameWithChildren' => 999.99,
  'SummarizeColumnsBy' => 999.99,
  'IncludeSubcolumns' => 999.99,
  'ReportCalendar' => 999.99,
  'ReturnRows' => 999.99,
  'ReturnColumns' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'TimeReportType' => false,
  'DisplayReport' => false,
  'ReportPeriod FromReportDate' => false,
  'ReportPeriod ToReportDate' => false,
  'ReportDateMacro' => false,
  'ReportEntityFilter EntityTypeFilter' => false,
  'ReportEntityFilter ListID' => true,
  'ReportEntityFilter FullName' => true,
  'ReportEntityFilter ListIDWithChildren' => false,
  'ReportEntityFilter FullNameWithChildren' => false,
  'ReportItemFilter ItemTypeFilter' => false,
  'ReportItemFilter ListID' => true,
  'ReportItemFilter FullName' => true,
  'ReportItemFilter ListIDWithChildren' => false,
  'ReportItemFilter FullNameWithChildren' => false,
  'ReportClassFilter ListID' => true,
  'ReportClassFilter FullName' => true,
  'ReportClassFilter ListIDWithChildren' => false,
  'ReportClassFilter FullNameWithChildren' => false,
  'SummarizeColumnsBy' => false,
  'IncludeSubcolumns' => false,
  'ReportCalendar' => false,
  'ReturnRows' => false,
  'ReturnColumns' => false,
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
  0 => 'TimeReportType',
  1 => 'DisplayReport',
  2 => 'ReportPeriod FromReportDate',
  3 => 'ReportPeriod ToReportDate',
  4 => 'ReportDateMacro',
  5 => 'ReportEntityFilter EntityTypeFilter',
  6 => 'ReportEntityFilter ListID',
  7 => 'ReportEntityFilter FullName',
  8 => 'ReportEntityFilter ListIDWithChildren',
  9 => 'ReportEntityFilter FullNameWithChildren',
  10 => 'ReportItemFilter ItemTypeFilter',
  11 => 'ReportItemFilter ListID',
  12 => 'ReportItemFilter FullName',
  13 => 'ReportItemFilter ListIDWithChildren',
  14 => 'ReportItemFilter FullNameWithChildren',
  15 => 'ReportClassFilter ListID',
  16 => 'ReportClassFilter FullName',
  17 => 'ReportClassFilter ListIDWithChildren',
  18 => 'ReportClassFilter FullNameWithChildren',
  19 => 'SummarizeColumnsBy',
  20 => 'IncludeSubcolumns',
  21 => 'ReportCalendar',
  22 => 'ReturnRows',
  23 => 'ReturnColumns',
);
			
		return $paths;
	}
}

?>