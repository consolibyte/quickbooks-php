<?php

/**
 * Schema object for: GeneralSummaryReportQueryRq
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
class QuickBooks_QBXML_Schema_Object_GeneralSummaryReportQueryRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'GeneralSummaryReportType' => 'ENUMTYPE',
  'DisplayReport' => 'BOOLTYPE',
  'ReportPeriod FromReportDate' => 'DATETYPE',
  'ReportPeriod ToReportDate' => 'DATETYPE',
  'ReportDateMacro' => 'ENUMTYPE',
  'ReportAccountFilter AccountTypeFilter' => 'ENUMTYPE',
  'ReportAccountFilter ListID' => 'IDTYPE',
  'ReportAccountFilter FullName' => 'STRTYPE',
  'ReportAccountFilter ListIDWithChildren' => 'IDTYPE',
  'ReportAccountFilter FullNameWithChildren' => 'STRTYPE',
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
  'ReportTxnTypeFilter TxnTypeFilter' => 'ENUMTYPE',
  'ReportModifiedDateRangeFilter FromReportModifiedDate' => 'DATETYPE',
  'ReportModifiedDateRangeFilter ToReportModifiedDate' => 'DATETYPE',
  'ReportModifiedDateRangeMacro' => 'ENUMTYPE',
  'ReportDetailLevelFilter' => 'ENUMTYPE',
  'ReportPostingStatusFilter' => 'ENUMTYPE',
  'SummarizeColumnsBy' => 'ENUMTYPE',
  'IncludeSubcolumns' => 'BOOLTYPE',
  'ReportCalendar' => 'ENUMTYPE',
  'ReturnRows' => 'ENUMTYPE',
  'ReturnColumns' => 'ENUMTYPE',
  'ReportBasis' => 'ENUMTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'GeneralSummaryReportType' => 0,
  'DisplayReport' => 0,
  'ReportPeriod FromReportDate' => 0,
  'ReportPeriod ToReportDate' => 0,
  'ReportDateMacro' => 0,
  'ReportAccountFilter AccountTypeFilter' => 0,
  'ReportAccountFilter ListID' => 0,
  'ReportAccountFilter FullName' => 0,
  'ReportAccountFilter ListIDWithChildren' => 0,
  'ReportAccountFilter FullNameWithChildren' => 0,
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
  'ReportTxnTypeFilter TxnTypeFilter' => 0,
  'ReportModifiedDateRangeFilter FromReportModifiedDate' => 0,
  'ReportModifiedDateRangeFilter ToReportModifiedDate' => 0,
  'ReportModifiedDateRangeMacro' => 0,
  'ReportDetailLevelFilter' => 0,
  'ReportPostingStatusFilter' => 0,
  'SummarizeColumnsBy' => 0,
  'IncludeSubcolumns' => 0,
  'ReportCalendar' => 0,
  'ReturnRows' => 0,
  'ReturnColumns' => 0,
  'ReportBasis' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'GeneralSummaryReportType' => false,
  'DisplayReport' => true,
  'ReportPeriod FromReportDate' => true,
  'ReportPeriod ToReportDate' => true,
  'ReportDateMacro' => false,
  'ReportAccountFilter AccountTypeFilter' => false,
  'ReportAccountFilter ListID' => false,
  'ReportAccountFilter FullName' => false,
  'ReportAccountFilter ListIDWithChildren' => false,
  'ReportAccountFilter FullNameWithChildren' => false,
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
  'ReportTxnTypeFilter TxnTypeFilter' => false,
  'ReportModifiedDateRangeFilter FromReportModifiedDate' => true,
  'ReportModifiedDateRangeFilter ToReportModifiedDate' => true,
  'ReportModifiedDateRangeMacro' => false,
  'ReportDetailLevelFilter' => true,
  'ReportPostingStatusFilter' => true,
  'SummarizeColumnsBy' => true,
  'IncludeSubcolumns' => true,
  'ReportCalendar' => true,
  'ReturnRows' => true,
  'ReturnColumns' => true,
  'ReportBasis' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'GeneralSummaryReportType' => 999.99,
  'DisplayReport' => 3,
  'ReportPeriod FromReportDate' => 999.99,
  'ReportPeriod ToReportDate' => 999.99,
  'ReportDateMacro' => 999.99,
  'ReportAccountFilter AccountTypeFilter' => 999.99,
  'ReportAccountFilter ListID' => 999.99,
  'ReportAccountFilter FullName' => 999.99,
  'ReportAccountFilter ListIDWithChildren' => 999.99,
  'ReportAccountFilter FullNameWithChildren' => 999.99,
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
  'ReportTxnTypeFilter TxnTypeFilter' => 999.99,
  'ReportModifiedDateRangeFilter FromReportModifiedDate' => 999.99,
  'ReportModifiedDateRangeFilter ToReportModifiedDate' => 999.99,
  'ReportModifiedDateRangeMacro' => 999.99,
  'ReportDetailLevelFilter' => 3,
  'ReportPostingStatusFilter' => 3,
  'SummarizeColumnsBy' => 999.99,
  'IncludeSubcolumns' => 999.99,
  'ReportCalendar' => 999.99,
  'ReturnRows' => 999.99,
  'ReturnColumns' => 999.99,
  'ReportBasis' => 2.1,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'GeneralSummaryReportType' => false,
  'DisplayReport' => false,
  'ReportPeriod FromReportDate' => false,
  'ReportPeriod ToReportDate' => false,
  'ReportDateMacro' => false,
  'ReportAccountFilter AccountTypeFilter' => false,
  'ReportAccountFilter ListID' => true,
  'ReportAccountFilter FullName' => true,
  'ReportAccountFilter ListIDWithChildren' => false,
  'ReportAccountFilter FullNameWithChildren' => false,
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
  'ReportTxnTypeFilter TxnTypeFilter' => true,
  'ReportModifiedDateRangeFilter FromReportModifiedDate' => false,
  'ReportModifiedDateRangeFilter ToReportModifiedDate' => false,
  'ReportModifiedDateRangeMacro' => false,
  'ReportDetailLevelFilter' => false,
  'ReportPostingStatusFilter' => false,
  'SummarizeColumnsBy' => false,
  'IncludeSubcolumns' => false,
  'ReportCalendar' => false,
  'ReturnRows' => false,
  'ReturnColumns' => false,
  'ReportBasis' => false,
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
  0 => 'GeneralSummaryReportType',
  1 => 'DisplayReport',
  2 => 'ReportPeriod FromReportDate',
  3 => 'ReportPeriod ToReportDate',
  4 => 'ReportDateMacro',
  5 => 'ReportAccountFilter AccountTypeFilter',
  6 => 'ReportAccountFilter ListID',
  7 => 'ReportAccountFilter FullName',
  8 => 'ReportAccountFilter ListIDWithChildren',
  9 => 'ReportAccountFilter FullNameWithChildren',
  10 => 'ReportEntityFilter EntityTypeFilter',
  11 => 'ReportEntityFilter ListID',
  12 => 'ReportEntityFilter FullName',
  13 => 'ReportEntityFilter ListIDWithChildren',
  14 => 'ReportEntityFilter FullNameWithChildren',
  15 => 'ReportItemFilter ItemTypeFilter',
  16 => 'ReportItemFilter ListID',
  17 => 'ReportItemFilter FullName',
  18 => 'ReportItemFilter ListIDWithChildren',
  19 => 'ReportItemFilter FullNameWithChildren',
  20 => 'ReportClassFilter ListID',
  21 => 'ReportClassFilter FullName',
  22 => 'ReportClassFilter ListIDWithChildren',
  23 => 'ReportClassFilter FullNameWithChildren',
  24 => 'ReportTxnTypeFilter TxnTypeFilter',
  25 => 'ReportModifiedDateRangeFilter FromReportModifiedDate',
  26 => 'ReportModifiedDateRangeFilter ToReportModifiedDate',
  27 => 'ReportModifiedDateRangeMacro',
  28 => 'ReportDetailLevelFilter',
  29 => 'ReportPostingStatusFilter',
  30 => 'SummarizeColumnsBy',
  31 => 'IncludeSubcolumns',
  32 => 'ReportCalendar',
  33 => 'ReturnRows',
  34 => 'ReturnColumns',
  35 => 'ReportBasis',
);
			
		return $paths;
	}
}

?>