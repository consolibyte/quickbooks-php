<?php

/**
 * Schema object for: PayrollItemWageAddRq
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
class QuickBooks_QBXML_Schema_Object_PayrollItemWageAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'PayrollItemWageAdd Name' => 'STRTYPE',
  'PayrollItemWageAdd IsActive' => 'BOOLTYPE',
  'PayrollItemWageAdd WageType' => 'ENUMTYPE',
  'PayrollItemWageAdd ExpenseAccountRef ListID' => 'IDTYPE',
  'PayrollItemWageAdd ExpenseAccountRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'PayrollItemWageAdd Name' => 31,
  'PayrollItemWageAdd IsActive' => 0,
  'PayrollItemWageAdd WageType' => 0,
  'PayrollItemWageAdd ExpenseAccountRef ListID' => 0,
  'PayrollItemWageAdd ExpenseAccountRef FullName' => 159,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'PayrollItemWageAdd Name' => false,
  'PayrollItemWageAdd IsActive' => true,
  'PayrollItemWageAdd WageType' => false,
  'PayrollItemWageAdd ExpenseAccountRef ListID' => true,
  'PayrollItemWageAdd ExpenseAccountRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'PayrollItemWageAdd Name' => 999.99,
  'PayrollItemWageAdd IsActive' => 999.99,
  'PayrollItemWageAdd WageType' => 999.99,
  'PayrollItemWageAdd ExpenseAccountRef ListID' => 999.99,
  'PayrollItemWageAdd ExpenseAccountRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'PayrollItemWageAdd Name' => false,
  'PayrollItemWageAdd IsActive' => false,
  'PayrollItemWageAdd WageType' => false,
  'PayrollItemWageAdd ExpenseAccountRef ListID' => false,
  'PayrollItemWageAdd ExpenseAccountRef FullName' => false,
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
  0 => 'PayrollItemWageAdd Name',
  1 => 'PayrollItemWageAdd IsActive',
  2 => 'PayrollItemWageAdd WageType',
  3 => 'PayrollItemWageAdd ExpenseAccountRef ListID',
  4 => 'PayrollItemWageAdd ExpenseAccountRef FullName',
  5 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>