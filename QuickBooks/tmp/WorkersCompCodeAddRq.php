<?php

/**
 * Schema object for: WorkersCompCodeAddRq
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
class QuickBooks_QBXML_Schema_Object_WorkersCompCodeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'WorkersCompCodeAdd Name' => 'STRTYPE',
  'WorkersCompCodeAdd IsActive' => 'BOOLTYPE',
  'WorkersCompCodeAdd Desc' => 'STRTYPE',
  'WorkersCompCodeAdd RateEntry Rate' => 'PRICETYPE',
  'WorkersCompCodeAdd RateEntry EffectiveDate' => 'DATETYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'WorkersCompCodeAdd Name' => 13,
  'WorkersCompCodeAdd IsActive' => 0,
  'WorkersCompCodeAdd Desc' => 31,
  'WorkersCompCodeAdd RateEntry Rate' => 0,
  'WorkersCompCodeAdd RateEntry EffectiveDate' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'WorkersCompCodeAdd Name' => false,
  'WorkersCompCodeAdd IsActive' => true,
  'WorkersCompCodeAdd Desc' => true,
  'WorkersCompCodeAdd RateEntry Rate' => false,
  'WorkersCompCodeAdd RateEntry EffectiveDate' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'WorkersCompCodeAdd Name' => 999.99,
  'WorkersCompCodeAdd IsActive' => 999.99,
  'WorkersCompCodeAdd Desc' => 999.99,
  'WorkersCompCodeAdd RateEntry Rate' => 999.99,
  'WorkersCompCodeAdd RateEntry EffectiveDate' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'WorkersCompCodeAdd Name' => false,
  'WorkersCompCodeAdd IsActive' => false,
  'WorkersCompCodeAdd Desc' => false,
  'WorkersCompCodeAdd RateEntry Rate' => false,
  'WorkersCompCodeAdd RateEntry EffectiveDate' => false,
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
  0 => 'WorkersCompCodeAdd Name',
  1 => 'WorkersCompCodeAdd IsActive',
  2 => 'WorkersCompCodeAdd Desc',
  3 => 'WorkersCompCodeAdd RateEntry Rate',
  4 => 'WorkersCompCodeAdd RateEntry EffectiveDate',
  5 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>