<?php

/**
 * Schema object for: UnitOfMeasureSetAddRq
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
class QuickBooks_QBXML_Schema_Object_UnitOfMeasureSetAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'UnitOfMeasureSetAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'UnitOfMeasureType' => 'ENUMTYPE',
  'BaseUnit Name' => 'STRTYPE',
  'BaseUnit Abbreviation' => 'STRTYPE',
  'RelatedUnit Name' => 'STRTYPE',
  'RelatedUnit Abbreviation' => 'STRTYPE',
  'RelatedUnit ConversionRatio' => 'PRICETYPE',
  'DefaultUnit UnitUsedFor' => 'ENUMTYPE',
  'DefaultUnit Unit' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Name' => 31,
  'IsActive' => 0,
  'UnitOfMeasureType' => 0,
  'BaseUnit Name' => 31,
  'BaseUnit Abbreviation' => 31,
  'RelatedUnit Name' => 31,
  'RelatedUnit Abbreviation' => 31,
  'RelatedUnit ConversionRatio' => 0,
  'DefaultUnit UnitUsedFor' => 0,
  'DefaultUnit Unit' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => true,
  'UnitOfMeasureType' => false,
  'BaseUnit Name' => false,
  'BaseUnit Abbreviation' => false,
  'RelatedUnit Name' => false,
  'RelatedUnit Abbreviation' => false,
  'RelatedUnit ConversionRatio' => false,
  'DefaultUnit UnitUsedFor' => false,
  'DefaultUnit Unit' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Name' => 999.99,
  'IsActive' => 999.99,
  'UnitOfMeasureType' => 999.99,
  'BaseUnit Name' => 999.99,
  'BaseUnit Abbreviation' => 999.99,
  'RelatedUnit Name' => 999.99,
  'RelatedUnit Abbreviation' => 999.99,
  'RelatedUnit ConversionRatio' => 0,
  'DefaultUnit UnitUsedFor' => 999.99,
  'DefaultUnit Unit' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => false,
  'UnitOfMeasureType' => false,
  'BaseUnit Name' => false,
  'BaseUnit Abbreviation' => false,
  'RelatedUnit' => true, 
  'RelatedUnit Name' => false,
  'RelatedUnit Abbreviation' => false,
  'RelatedUnit ConversionRatio' => false,
  'DefaultUnit' => true, 
  'DefaultUnit UnitUsedFor' => false,
  'DefaultUnit Unit' => false,
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
  0 => 'Name',
  1 => 'IsActive',
  2 => 'UnitOfMeasureType',
  3 => 'BaseUnit Name',
  4 => 'BaseUnit Abbreviation',
  5 => 'RelatedUnit', 
  6 => 'RelatedUnit Name',
  7 => 'RelatedUnit Abbreviation',
  8 => 'RelatedUnit ConversionRatio',
  9 => 'DefaultUnit', 
  10 => 'DefaultUnit UnitUsedFor',
  11 => 'DefaultUnit Unit',
  12 => 'IncludeRetElement',
);
			
		return $paths;
	}
}
