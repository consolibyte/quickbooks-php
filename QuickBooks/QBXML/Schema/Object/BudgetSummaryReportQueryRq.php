<?php

/**
 * Schema object for: BudgetSummaryReportQueryRq
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
class QuickBooks_QBXML_Schema_Object_BudgetSummaryReportQueryRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'BudgetSummaryReportType' => 'ENUMTYPE',
  'DisplayReport' => 'BOOLTYPE',
  'FiscalYear' => 'INTTYPE',
  'BudgetCriterion' => 'ENUMTYPE',
  'SummarizeBudgetColumnsBy' => 'ENUMTYPE',
  'SummarizeBudgetRowsBy' => 'ENUMTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'BudgetSummaryReportType' => 0,
  'DisplayReport' => 0,
  'FiscalYear' => 0,
  'BudgetCriterion' => 0,
  'SummarizeBudgetColumnsBy' => 0,
  'SummarizeBudgetRowsBy' => 0,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'BudgetSummaryReportType' => false,
  'DisplayReport' => true,
  'FiscalYear' => false,
  'BudgetCriterion' => true,
  'SummarizeBudgetColumnsBy' => true,
  'SummarizeBudgetRowsBy' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'BudgetSummaryReportType' => 999.99,
  'DisplayReport' => 999.99,
  'FiscalYear' => 999.99,
  'BudgetCriterion' => 999.99,
  'SummarizeBudgetColumnsBy' => 999.99,
  'SummarizeBudgetRowsBy' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'BudgetSummaryReportType' => false,
  'DisplayReport' => false,
  'FiscalYear' => false,
  'BudgetCriterion' => false,
  'SummarizeBudgetColumnsBy' => false,
  'SummarizeBudgetRowsBy' => false,
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
  0 => 'BudgetSummaryReportType',
  1 => 'DisplayReport',
  2 => 'FiscalYear',
  3 => 'BudgetCriterion',
  4 => 'SummarizeBudgetColumnsBy',
  5 => 'SummarizeBudgetRowsBy',
);
			
		return $paths;
	}
}

?>