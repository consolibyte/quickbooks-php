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
		static $wrapper = '';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'UnitOfMeasureSetAdd Name' => 'STRTYPE',
  'UnitOfMeasureSetAdd IsActive' => 'BOOLTYPE',
  'UnitOfMeasureSetAdd UnitOfMeasureType' => 'ENUMTYPE',
  'UnitOfMeasureSetAdd BaseUnit Name' => 'STRTYPE',
  'UnitOfMeasureSetAdd BaseUnit Abbreviation' => 'STRTYPE',
  'UnitOfMeasureSetAdd RelatedUnit Name' => 'STRTYPE',
  'UnitOfMeasureSetAdd RelatedUnit Abbreviation' => 'STRTYPE',
  'UnitOfMeasureSetAdd RelatedUnit ConversionRatio' => 'PRICETYPE',
  'UnitOfMeasureSetAdd DefaultUnit UnitUsedFor' => 'ENUMTYPE',
  'UnitOfMeasureSetAdd DefaultUnit Unit' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'UnitOfMeasureSetAdd Name' => 31,
  'UnitOfMeasureSetAdd IsActive' => 0,
  'UnitOfMeasureSetAdd UnitOfMeasureType' => 0,
  'UnitOfMeasureSetAdd BaseUnit Name' => 31,
  'UnitOfMeasureSetAdd BaseUnit Abbreviation' => 31,
  'UnitOfMeasureSetAdd RelatedUnit Name' => 31,
  'UnitOfMeasureSetAdd RelatedUnit Abbreviation' => 31,
  'UnitOfMeasureSetAdd RelatedUnit ConversionRatio' => 0,
  'UnitOfMeasureSetAdd DefaultUnit UnitUsedFor' => 0,
  'UnitOfMeasureSetAdd DefaultUnit Unit' => 31,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'UnitOfMeasureSetAdd Name' => false,
  'UnitOfMeasureSetAdd IsActive' => true,
  'UnitOfMeasureSetAdd UnitOfMeasureType' => false,
  'UnitOfMeasureSetAdd BaseUnit Name' => false,
  'UnitOfMeasureSetAdd BaseUnit Abbreviation' => false,
  'UnitOfMeasureSetAdd RelatedUnit Name' => false,
  'UnitOfMeasureSetAdd RelatedUnit Abbreviation' => false,
  'UnitOfMeasureSetAdd RelatedUnit ConversionRatio' => false,
  'UnitOfMeasureSetAdd DefaultUnit UnitUsedFor' => false,
  'UnitOfMeasureSetAdd DefaultUnit Unit' => false,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'UnitOfMeasureSetAdd Name' => 999.99,
  'UnitOfMeasureSetAdd IsActive' => 999.99,
  'UnitOfMeasureSetAdd UnitOfMeasureType' => 999.99,
  'UnitOfMeasureSetAdd BaseUnit Name' => 999.99,
  'UnitOfMeasureSetAdd BaseUnit Abbreviation' => 999.99,
  'UnitOfMeasureSetAdd RelatedUnit Name' => 999.99,
  'UnitOfMeasureSetAdd RelatedUnit Abbreviation' => 999.99,
  'UnitOfMeasureSetAdd RelatedUnit ConversionRatio' => 0,
  'UnitOfMeasureSetAdd DefaultUnit UnitUsedFor' => 999.99,
  'UnitOfMeasureSetAdd DefaultUnit Unit' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'UnitOfMeasureSetAdd Name' => false,
  'UnitOfMeasureSetAdd IsActive' => false,
  'UnitOfMeasureSetAdd UnitOfMeasureType' => false,
  'UnitOfMeasureSetAdd BaseUnit Name' => false,
  'UnitOfMeasureSetAdd BaseUnit Abbreviation' => false,
  'UnitOfMeasureSetAdd RelatedUnit Name' => false,
  'UnitOfMeasureSetAdd RelatedUnit Abbreviation' => false,
  'UnitOfMeasureSetAdd RelatedUnit ConversionRatio' => false,
  'UnitOfMeasureSetAdd DefaultUnit UnitUsedFor' => false,
  'UnitOfMeasureSetAdd DefaultUnit Unit' => false,
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
  0 => 'UnitOfMeasureSetAdd Name',
  1 => 'UnitOfMeasureSetAdd IsActive',
  2 => 'UnitOfMeasureSetAdd UnitOfMeasureType',
  3 => 'UnitOfMeasureSetAdd BaseUnit Name',
  4 => 'UnitOfMeasureSetAdd BaseUnit Abbreviation',
  5 => 'UnitOfMeasureSetAdd RelatedUnit Name',
  6 => 'UnitOfMeasureSetAdd RelatedUnit Abbreviation',
  7 => 'UnitOfMeasureSetAdd RelatedUnit ConversionRatio',
  8 => 'UnitOfMeasureSetAdd DefaultUnit UnitUsedFor',
  9 => 'UnitOfMeasureSetAdd DefaultUnit Unit',
  10 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>