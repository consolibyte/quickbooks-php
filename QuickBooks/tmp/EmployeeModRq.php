<?php

/**
 * Schema object for: EmployeeModRq
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
class QuickBooks_QBXML_Schema_Object_EmployeeModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'EmployeeMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'Salutation' => 'STRTYPE',
  'FirstName' => 'STRTYPE',
  'MiddleName' => 'STRTYPE',
  'LastName' => 'STRTYPE',
  'Suffix' => 'STRTYPE',
  'EmployeeAddress Addr1' => 'STRTYPE',
  'EmployeeAddress Addr2' => 'STRTYPE',
  'EmployeeAddress Addr3' => 'STRTYPE',
  'EmployeeAddress Addr4' => 'STRTYPE',
  'EmployeeAddress City' => 'STRTYPE',
  'EmployeeAddress State' => 'STRTYPE',
  'EmployeeAddress PostalCode' => 'STRTYPE',
  'EmployeeAddress Country' => 'STRTYPE',
  'PrintAs' => 'STRTYPE',
  'Phone' => 'STRTYPE',
  'Mobile' => 'STRTYPE',
  'Pager' => 'STRTYPE',
  'PagerPIN' => 'STRTYPE',
  'AltPhone' => 'STRTYPE',
  'Fax' => 'STRTYPE',
  'Email' => 'STRTYPE',
  'BirthDate' => 'DATETYPE',
  'AccountNumber' => 'STRTYPE',
  'Notes' => 'STRTYPE',
  'BillingRateRef ListID' => 'IDTYPE',
  'BillingRateRef FullName' => 'STRTYPE',
  'EmployeePayrollInfoMod PayPeriod' => 'ENUMTYPE',
  'EmployeePayrollInfoMod ClassRef ListID' => 'IDTYPE',
  'EmployeePayrollInfoMod ClassRef FullName' => 'STRTYPE',
  'EmployeePayrollInfoMod ClearEarnings' => 'BOOLTYPE',
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef ListID' => 'IDTYPE',
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef FullName' => 'STRTYPE',
  'EmployeePayrollInfoMod Earnings Rate' => 'PRICETYPE',
  'EmployeePayrollInfoMod Earnings RatePercent' => 'PERCENTTYPE',
  'EmployeePayrollInfoMod UseTimeDataToCreatePaychecks' => 'ENUMTYPE',
  'EmployeePayrollInfoMod SickHours HoursAvailable' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod SickHours AccrualPeriod' => 'ENUMTYPE',
  'EmployeePayrollInfoMod SickHours HoursAccrued' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod SickHours MaximumHours' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod SickHours IsResettingHoursEachNewYear' => 'BOOLTYPE',
  'EmployeePayrollInfoMod SickHours HoursUsed' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod SickHours AccrualStartDate' => 'DATETYPE',
  'EmployeePayrollInfoMod VacationHours HoursAvailable' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod VacationHours AccrualPeriod' => 'ENUMTYPE',
  'EmployeePayrollInfoMod VacationHours HoursAccrued' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod VacationHours MaximumHours' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod VacationHours IsResettingHoursEachNewYear' => 'BOOLTYPE',
  'EmployeePayrollInfoMod VacationHours HoursUsed' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfoMod VacationHours AccrualStartDate' => 'DATETYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ListID' => 0,
  'EditSequence' => 16,
  'Name' => 100,
  'IsActive' => 0,
  'Salutation' => 15,
  'FirstName' => 25,
  'MiddleName' => 5,
  'LastName' => 25,
  'Suffix' => 10,
  'EmployeeAddress Addr1' => 41,
  'EmployeeAddress Addr2' => 41,
  'EmployeeAddress Addr3' => 500,
  'EmployeeAddress Addr4' => 500,
  'EmployeeAddress City' => 31,
  'EmployeeAddress State' => 21,
  'EmployeeAddress PostalCode' => 13,
  'EmployeeAddress Country' => 255,
  'PrintAs' => 41,
  'Phone' => 21,
  'Mobile' => 21,
  'Pager' => 21,
  'PagerPIN' => 10,
  'AltPhone' => 21,
  'Fax' => 21,
  'Email' => 1023,
  'BirthDate' => 0,
  'AccountNumber' => 99,
  'Notes' => 4095,
  'BillingRateRef ListID' => 0,
  'BillingRateRef FullName' => 31,
  'EmployeePayrollInfoMod PayPeriod' => 0,
  'EmployeePayrollInfoMod ClassRef ListID' => 0,
  'EmployeePayrollInfoMod ClassRef FullName' => 31,
  'EmployeePayrollInfoMod ClearEarnings' => 0,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef ListID' => 0,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef FullName' => 31,
  'EmployeePayrollInfoMod Earnings Rate' => 0,
  'EmployeePayrollInfoMod Earnings RatePercent' => 0,
  'EmployeePayrollInfoMod UseTimeDataToCreatePaychecks' => 0,
  'EmployeePayrollInfoMod SickHours HoursAvailable' => 0,
  'EmployeePayrollInfoMod SickHours AccrualPeriod' => 0,
  'EmployeePayrollInfoMod SickHours HoursAccrued' => 0,
  'EmployeePayrollInfoMod SickHours MaximumHours' => 0,
  'EmployeePayrollInfoMod SickHours IsResettingHoursEachNewYear' => 0,
  'EmployeePayrollInfoMod SickHours HoursUsed' => 0,
  'EmployeePayrollInfoMod SickHours AccrualStartDate' => 0,
  'EmployeePayrollInfoMod VacationHours HoursAvailable' => 0,
  'EmployeePayrollInfoMod VacationHours AccrualPeriod' => 0,
  'EmployeePayrollInfoMod VacationHours HoursAccrued' => 0,
  'EmployeePayrollInfoMod VacationHours MaximumHours' => 0,
  'EmployeePayrollInfoMod VacationHours IsResettingHoursEachNewYear' => 0,
  'EmployeePayrollInfoMod VacationHours HoursUsed' => 0,
  'EmployeePayrollInfoMod VacationHours AccrualStartDate' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'ListID' => false,
  'EditSequence' => false,
  'Name' => true,
  'IsActive' => true,
  'Salutation' => true,
  'FirstName' => true,
  'MiddleName' => true,
  'LastName' => true,
  'Suffix' => true,
  'EmployeeAddress Addr1' => true,
  'EmployeeAddress Addr2' => true,
  'EmployeeAddress Addr3' => true,
  'EmployeeAddress Addr4' => true,
  'EmployeeAddress City' => true,
  'EmployeeAddress State' => true,
  'EmployeeAddress PostalCode' => true,
  'EmployeeAddress Country' => true,
  'PrintAs' => true,
  'Phone' => true,
  'Mobile' => true,
  'Pager' => true,
  'PagerPIN' => true,
  'AltPhone' => true,
  'Fax' => true,
  'Email' => true,
  'BirthDate' => true,
  'AccountNumber' => true,
  'Notes' => true,
  'BillingRateRef ListID' => false,
  'BillingRateRef FullName' => true,
  'EmployeePayrollInfoMod PayPeriod' => true,
  'EmployeePayrollInfoMod ClassRef ListID' => false,
  'EmployeePayrollInfoMod ClassRef FullName' => true,
  'EmployeePayrollInfoMod ClearEarnings' => false,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef ListID' => false,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef FullName' => true,
  'EmployeePayrollInfoMod Earnings Rate' => false,
  'EmployeePayrollInfoMod Earnings RatePercent' => false,
  'EmployeePayrollInfoMod UseTimeDataToCreatePaychecks' => true,
  'EmployeePayrollInfoMod SickHours HoursAvailable' => true,
  'EmployeePayrollInfoMod SickHours AccrualPeriod' => true,
  'EmployeePayrollInfoMod SickHours HoursAccrued' => true,
  'EmployeePayrollInfoMod SickHours MaximumHours' => true,
  'EmployeePayrollInfoMod SickHours IsResettingHoursEachNewYear' => true,
  'EmployeePayrollInfoMod SickHours HoursUsed' => true,
  'EmployeePayrollInfoMod SickHours AccrualStartDate' => true,
  'EmployeePayrollInfoMod VacationHours HoursAvailable' => true,
  'EmployeePayrollInfoMod VacationHours AccrualPeriod' => true,
  'EmployeePayrollInfoMod VacationHours HoursAccrued' => true,
  'EmployeePayrollInfoMod VacationHours MaximumHours' => true,
  'EmployeePayrollInfoMod VacationHours IsResettingHoursEachNewYear' => true,
  'EmployeePayrollInfoMod VacationHours HoursUsed' => true,
  'EmployeePayrollInfoMod VacationHours AccrualStartDate' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'ListID' => 999.99,
  'EditSequence' => 999.99,
  'Name' => 999.99,
  'IsActive' => 3,
  'Salutation' => 999.99,
  'FirstName' => 999.99,
  'MiddleName' => 999.99,
  'LastName' => 999.99,
  'Suffix' => 999.99,
  'EmployeeAddress Addr1' => 999.99,
  'EmployeeAddress Addr2' => 999.99,
  'EmployeeAddress Addr3' => 999.99,
  'EmployeeAddress Addr4' => 2,
  'EmployeeAddress City' => 999.99,
  'EmployeeAddress State' => 999.99,
  'EmployeeAddress PostalCode' => 999.99,
  'EmployeeAddress Country' => 999.99,
  'PrintAs' => 999.99,
  'Phone' => 999.99,
  'Mobile' => 2.1,
  'Pager' => 2.1,
  'PagerPIN' => 2.1,
  'AltPhone' => 999.99,
  'Fax' => 2.1,
  'Email' => 999.99,
  'BirthDate' => 2,
  'AccountNumber' => 999.99,
  'Notes' => 3,
  'BillingRateRef ListID' => 999.99,
  'BillingRateRef FullName' => 999.99,
  'EmployeePayrollInfoMod PayPeriod' => 999.99,
  'EmployeePayrollInfoMod ClassRef ListID' => 999.99,
  'EmployeePayrollInfoMod ClassRef FullName' => 999.99,
  'EmployeePayrollInfoMod ClearEarnings' => 999.99,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef ListID' => 999.99,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef FullName' => 999.99,
  'EmployeePayrollInfoMod Earnings Rate' => 999.99,
  'EmployeePayrollInfoMod Earnings RatePercent' => 999.99,
  'EmployeePayrollInfoMod UseTimeDataToCreatePaychecks' => 3,
  'EmployeePayrollInfoMod SickHours HoursAvailable' => 999.99,
  'EmployeePayrollInfoMod SickHours AccrualPeriod' => 999.99,
  'EmployeePayrollInfoMod SickHours HoursAccrued' => 999.99,
  'EmployeePayrollInfoMod SickHours MaximumHours' => 999.99,
  'EmployeePayrollInfoMod SickHours IsResettingHoursEachNewYear' => 999.99,
  'EmployeePayrollInfoMod SickHours HoursUsed' => 5,
  'EmployeePayrollInfoMod SickHours AccrualStartDate' => 5,
  'EmployeePayrollInfoMod VacationHours HoursAvailable' => 999.99,
  'EmployeePayrollInfoMod VacationHours AccrualPeriod' => 999.99,
  'EmployeePayrollInfoMod VacationHours HoursAccrued' => 999.99,
  'EmployeePayrollInfoMod VacationHours MaximumHours' => 999.99,
  'EmployeePayrollInfoMod VacationHours IsResettingHoursEachNewYear' => 999.99,
  'EmployeePayrollInfoMod VacationHours HoursUsed' => 5,
  'EmployeePayrollInfoMod VacationHours AccrualStartDate' => 5,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'ListID' => false,
  'EditSequence' => false,
  'Name' => false,
  'IsActive' => false,
  'Salutation' => false,
  'FirstName' => false,
  'MiddleName' => false,
  'LastName' => false,
  'Suffix' => false,
  'EmployeeAddress Addr1' => false,
  'EmployeeAddress Addr2' => false,
  'EmployeeAddress Addr3' => false,
  'EmployeeAddress Addr4' => false,
  'EmployeeAddress City' => false,
  'EmployeeAddress State' => false,
  'EmployeeAddress PostalCode' => false,
  'EmployeeAddress Country' => false,
  'PrintAs' => false,
  'Phone' => false,
  'Mobile' => false,
  'Pager' => false,
  'PagerPIN' => false,
  'AltPhone' => false,
  'Fax' => false,
  'Email' => false,
  'BirthDate' => false,
  'AccountNumber' => false,
  'Notes' => false,
  'BillingRateRef ListID' => false,
  'BillingRateRef FullName' => false,
  'EmployeePayrollInfoMod PayPeriod' => false,
  'EmployeePayrollInfoMod ClassRef ListID' => false,
  'EmployeePayrollInfoMod ClassRef FullName' => false,
  'EmployeePayrollInfoMod ClearEarnings' => false,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef ListID' => false,
  'EmployeePayrollInfoMod Earnings PayrollItemWageRef FullName' => false,
  'EmployeePayrollInfoMod Earnings Rate' => false,
  'EmployeePayrollInfoMod Earnings RatePercent' => false,
  'EmployeePayrollInfoMod UseTimeDataToCreatePaychecks' => false,
  'EmployeePayrollInfoMod SickHours HoursAvailable' => false,
  'EmployeePayrollInfoMod SickHours AccrualPeriod' => false,
  'EmployeePayrollInfoMod SickHours HoursAccrued' => false,
  'EmployeePayrollInfoMod SickHours MaximumHours' => false,
  'EmployeePayrollInfoMod SickHours IsResettingHoursEachNewYear' => false,
  'EmployeePayrollInfoMod SickHours HoursUsed' => false,
  'EmployeePayrollInfoMod SickHours AccrualStartDate' => false,
  'EmployeePayrollInfoMod VacationHours HoursAvailable' => false,
  'EmployeePayrollInfoMod VacationHours AccrualPeriod' => false,
  'EmployeePayrollInfoMod VacationHours HoursAccrued' => false,
  'EmployeePayrollInfoMod VacationHours MaximumHours' => false,
  'EmployeePayrollInfoMod VacationHours IsResettingHoursEachNewYear' => false,
  'EmployeePayrollInfoMod VacationHours HoursUsed' => false,
  'EmployeePayrollInfoMod VacationHours AccrualStartDate' => false,
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
  0 => 'ListID',
  1 => 'EditSequence',
  2 => 'Name',
  3 => 'IsActive',
  4 => 'Salutation',
  5 => 'FirstName',
  6 => 'MiddleName',
  7 => 'LastName',
  8 => 'Suffix',
  9 => 'EmployeeAddress Addr1',
  10 => 'EmployeeAddress Addr2',
  11 => 'EmployeeAddress Addr3',
  12 => 'EmployeeAddress Addr4',
  13 => 'EmployeeAddress City',
  14 => 'EmployeeAddress State',
  15 => 'EmployeeAddress PostalCode',
  16 => 'EmployeeAddress Country',
  17 => 'PrintAs',
  18 => 'Phone',
  19 => 'Mobile',
  20 => 'Pager',
  21 => 'PagerPIN',
  22 => 'AltPhone',
  23 => 'Fax',
  24 => 'Email',
  25 => 'BirthDate',
  26 => 'AccountNumber',
  27 => 'Notes',
  28 => 'BillingRateRef ListID',
  29 => 'BillingRateRef FullName',
  30 => 'EmployeePayrollInfoMod PayPeriod',
  31 => 'EmployeePayrollInfoMod ClassRef ListID',
  32 => 'EmployeePayrollInfoMod ClassRef FullName',
  33 => 'EmployeePayrollInfoMod ClearEarnings',
  34 => 'EmployeePayrollInfoMod',
  35 => 'EmployeePayrollInfoMod Earnings',
  36 => 'EmployeePayrollInfoMod Earnings PayrollItemWageRef',
  37 => 'EmployeePayrollInfoMod Earnings PayrollItemWageRef ListID',
  38 => 'EmployeePayrollInfoMod Earnings PayrollItemWageRef FullName',
  39 => 'EmployeePayrollInfoMod Earnings Rate',
  40 => 'EmployeePayrollInfoMod Earnings RatePercent',
  41 => 'EmployeePayrollInfoMod UseTimeDataToCreatePaychecks',
  42 => 'EmployeePayrollInfoMod SickHours HoursAvailable',
  43 => 'EmployeePayrollInfoMod SickHours AccrualPeriod',
  44 => 'EmployeePayrollInfoMod SickHours HoursAccrued',
  45 => 'EmployeePayrollInfoMod SickHours MaximumHours',
  46 => 'EmployeePayrollInfoMod SickHours IsResettingHoursEachNewYear',
  47 => 'EmployeePayrollInfoMod SickHours HoursUsed',
  48 => 'EmployeePayrollInfoMod SickHours AccrualStartDate',
  49 => 'EmployeePayrollInfoMod VacationHours HoursAvailable',
  50 => 'EmployeePayrollInfoMod VacationHours AccrualPeriod',
  51 => 'EmployeePayrollInfoMod VacationHours HoursAccrued',
  52 => 'EmployeePayrollInfoMod VacationHours MaximumHours',
  53 => 'EmployeePayrollInfoMod VacationHours IsResettingHoursEachNewYear',
  54 => 'EmployeePayrollInfoMod VacationHours HoursUsed',
  55 => 'EmployeePayrollInfoMod VacationHours AccrualStartDate',
  56 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>