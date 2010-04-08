<?php

/**
 * Schema object for: VehicleMileageAddRq
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
class QuickBooks_QBXML_Schema_Object_VehicleMileageAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'VehicleMileageAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'VehicleRef ListID' => 'IDTYPE',
  'VehicleRef FullName' => 'STRTYPE',
  'CustomerRef ListID' => 'IDTYPE',
  'CustomerRef FullName' => 'STRTYPE',
  'ItemRef ListID' => 'IDTYPE',
  'ItemRef FullName' => 'STRTYPE',
  'ClassRef ListID' => 'IDTYPE',
  'ClassRef FullName' => 'STRTYPE',
  'TripStartDate' => 'DATETYPE',
  'TripEndDate' => 'DATETYPE',
  'OdometerStart' => 'QUANTYPE',
  'OdometerEnd' => 'QUANTYPE',
  'TotalMiles' => 'QUANTYPE',
  'Notes' => 'STRTYPE',
  'BillableStatus' => 'ENUMTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'VehicleRef ListID' => 0,
  'VehicleRef FullName' => 31,
  'CustomerRef ListID' => 0,
  'CustomerRef FullName' => 31,
  'ItemRef ListID' => 0,
  'ItemRef FullName' => 31,
  'ClassRef ListID' => 0,
  'ClassRef FullName' => 31,
  'TripStartDate' => 0,
  'TripEndDate' => 0,
  'OdometerStart' => 0,
  'OdometerEnd' => 0,
  'TotalMiles' => 0,
  'Notes' => 4095,
  'BillableStatus' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'VehicleRef ListID' => true,
  'VehicleRef FullName' => true,
  'CustomerRef ListID' => true,
  'CustomerRef FullName' => true,
  'ItemRef ListID' => true,
  'ItemRef FullName' => true,
  'ClassRef ListID' => true,
  'ClassRef FullName' => true,
  'TripStartDate' => true,
  'TripEndDate' => true,
  'OdometerStart' => false,
  'OdometerEnd' => false,
  'TotalMiles' => false,
  'Notes' => true,
  'BillableStatus' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'VehicleRef ListID' => 999.99,
  'VehicleRef FullName' => 999.99,
  'CustomerRef ListID' => 999.99,
  'CustomerRef FullName' => 999.99,
  'ItemRef ListID' => 999.99,
  'ItemRef FullName' => 999.99,
  'ClassRef ListID' => 999.99,
  'ClassRef FullName' => 999.99,
  'TripStartDate' => 999.99,
  'TripEndDate' => 999.99,
  'OdometerStart' => 999.99,
  'OdometerEnd' => 999.99,
  'TotalMiles' => 999.99,
  'Notes' => 999.99,
  'BillableStatus' => 999.99,
  'IncludeRetElement' => 999.99,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'VehicleRef ListID' => false,
  'VehicleRef FullName' => false,
  'CustomerRef ListID' => false,
  'CustomerRef FullName' => false,
  'ItemRef ListID' => false,
  'ItemRef FullName' => false,
  'ClassRef ListID' => false,
  'ClassRef FullName' => false,
  'TripStartDate' => false,
  'TripEndDate' => false,
  'OdometerStart' => false,
  'OdometerEnd' => false,
  'TotalMiles' => false,
  'Notes' => false,
  'BillableStatus' => false,
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
  0 => 'VehicleRef ListID',
  1 => 'VehicleRef FullName',
  2 => 'CustomerRef ListID',
  3 => 'CustomerRef FullName',
  4 => 'ItemRef ListID',
  5 => 'ItemRef FullName',
  6 => 'ClassRef ListID',
  7 => 'ClassRef FullName',
  8 => 'TripStartDate',
  9 => 'TripEndDate',
  10 => 'OdometerStart',
  11 => 'OdometerEnd',
  12 => 'TotalMiles',
  13 => 'Notes',
  14 => 'BillableStatus',
  15 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>