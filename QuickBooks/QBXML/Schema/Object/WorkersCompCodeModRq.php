<?php

/**
 * Schema object for: WorkersCompCodeModRq
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
class QuickBooks_QBXML_Schema_Object_WorkersCompCodeModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'WorkersCompCodeMod ListID' => 'IDTYPE',
  'WorkersCompCodeMod EditSequence' => 'STRTYPE',
  'WorkersCompCodeMod Name' => 'STRTYPE',
  'WorkersCompCodeMod IsActive' => 'BOOLTYPE',
  'WorkersCompCodeMod Desc' => 'STRTYPE',
  'WorkersCompCodeMod RateEntry Rate' => 'PRICETYPE',
  'WorkersCompCodeMod RateEntry EffectiveDate' => 'DATETYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'WorkersCompCodeMod ListID' => 0,
  'WorkersCompCodeMod EditSequence' => 16,
  'WorkersCompCodeMod Name' => 13,
  'WorkersCompCodeMod IsActive' => 0,
  'WorkersCompCodeMod Desc' => 31,
  'WorkersCompCodeMod RateEntry Rate' => 0,
  'WorkersCompCodeMod RateEntry EffectiveDate' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'WorkersCompCodeMod ListID' => false,
  'WorkersCompCodeMod EditSequence' => false,
  'WorkersCompCodeMod Name' => true,
  'WorkersCompCodeMod IsActive' => true,
  'WorkersCompCodeMod Desc' => true,
  'WorkersCompCodeMod RateEntry Rate' => false,
  'WorkersCompCodeMod RateEntry EffectiveDate' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'WorkersCompCodeMod ListID' => 999.99,
  'WorkersCompCodeMod EditSequence' => 999.99,
  'WorkersCompCodeMod Name' => 999.99,
  'WorkersCompCodeMod IsActive' => 999.99,
  'WorkersCompCodeMod Desc' => 999.99,
  'WorkersCompCodeMod RateEntry Rate' => 999.99,
  'WorkersCompCodeMod RateEntry EffectiveDate' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'WorkersCompCodeMod ListID' => false,
  'WorkersCompCodeMod EditSequence' => false,
  'WorkersCompCodeMod Name' => false,
  'WorkersCompCodeMod IsActive' => false,
  'WorkersCompCodeMod Desc' => false,
  'WorkersCompCodeMod RateEntry Rate' => false,
  'WorkersCompCodeMod RateEntry EffectiveDate' => false,
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
  0 => 'WorkersCompCodeMod ListID',
  1 => 'WorkersCompCodeMod EditSequence',
  2 => 'WorkersCompCodeMod Name',
  3 => 'WorkersCompCodeMod IsActive',
  4 => 'WorkersCompCodeMod Desc',
  5 => 'WorkersCompCodeMod RateEntry Rate',
  6 => 'WorkersCompCodeMod RateEntry EffectiveDate',
  7 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>