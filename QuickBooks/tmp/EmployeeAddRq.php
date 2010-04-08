<?php

/**
 * Schema object for: EmployeeAddRq
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
class QuickBooks_QBXML_Schema_Object_EmployeeAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'EmployeeAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
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
  'SSN' => 'STRTYPE',
  'Email' => 'STRTYPE',
  'EmployeeType' => 'ENUMTYPE',
  'Gender' => 'ENUMTYPE',
  'HiredDate' => 'DATETYPE',
  'ReleasedDate' => 'DATETYPE',
  'BirthDate' => 'DATETYPE',
  'AccountNumber' => 'STRTYPE',
  'Notes' => 'STRTYPE',
  'BillingRateRef ListID' => 'IDTYPE',
  'BillingRateRef FullName' => 'STRTYPE',
  'EmployeePayrollInfo PayPeriod' => 'ENUMTYPE',
  'EmployeePayrollInfo ClassRef ListID' => 'IDTYPE',
  'EmployeePayrollInfo ClassRef FullName' => 'STRTYPE',
  'EmployeePayrollInfo ClearEarnings' => 'BOOLTYPE',
  'EmployeePayrollInfo Earnings PayrollItemWageRef ListID' => 'IDTYPE',
  'EmployeePayrollInfo Earnings PayrollItemWageRef FullName' => 'STRTYPE',
  'EmployeePayrollInfo Earnings Rate' => 'PRICETYPE',
  'EmployeePayrollInfo Earnings RatePercent' => 'PERCENTTYPE',
  'EmployeePayrollInfo UseTimeDataToCreatePaychecks' => 'ENUMTYPE',
  'EmployeePayrollInfo SickHours HoursAvailable' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo SickHours AccrualPeriod' => 'ENUMTYPE',
  'EmployeePayrollInfo SickHours HoursAccrued' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo SickHours MaximumHours' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo SickHours IsResettingHoursEachNewYear' => 'BOOLTYPE',
  'EmployeePayrollInfo SickHours HoursUsed' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo SickHours AccrualStartDate' => 'DATETYPE',
  'EmployeePayrollInfo VacationHours HoursAvailable' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo VacationHours AccrualPeriod' => 'ENUMTYPE',
  'EmployeePayrollInfo VacationHours HoursAccrued' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo VacationHours MaximumHours' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo VacationHours IsResettingHoursEachNewYear' => 'BOOLTYPE',
  'EmployeePayrollInfo VacationHours HoursUsed' => 'TIMEINTERVALTYPE',
  'EmployeePayrollInfo VacationHours AccrualStartDate' => 'DATETYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
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
  'SSN' => 15,
  'Email' => 1023,
  'EmployeeType' => 0,
  'Gender' => 0,
  'HiredDate' => 0,
  'ReleasedDate' => 0,
  'BirthDate' => 0,
  'AccountNumber' => 99,
  'Notes' => 4095,
  'BillingRateRef ListID' => 0,
  'BillingRateRef FullName' => 31,
  'EmployeePayrollInfo PayPeriod' => 0,
  'EmployeePayrollInfo ClassRef ListID' => 0,
  'EmployeePayrollInfo ClassRef FullName' => 31,
  'EmployeePayrollInfo ClearEarnings' => 0,
  'EmployeePayrollInfo Earnings PayrollItemWageRef ListID' => 0,
  'EmployeePayrollInfo Earnings PayrollItemWageRef FullName' => 31,
  'EmployeePayrollInfo Earnings Rate' => 0,
  'EmployeePayrollInfo Earnings RatePercent' => 0,
  'EmployeePayrollInfo UseTimeDataToCreatePaychecks' => 0,
  'EmployeePayrollInfo SickHours HoursAvailable' => 0,
  'EmployeePayrollInfo SickHours AccrualPeriod' => 0,
  'EmployeePayrollInfo SickHours HoursAccrued' => 0,
  'EmployeePayrollInfo SickHours MaximumHours' => 0,
  'EmployeePayrollInfo SickHours IsResettingHoursEachNewYear' => 0,
  'EmployeePayrollInfo SickHours HoursUsed' => 0,
  'EmployeePayrollInfo SickHours AccrualStartDate' => 0,
  'EmployeePayrollInfo VacationHours HoursAvailable' => 0,
  'EmployeePayrollInfo VacationHours AccrualPeriod' => 0,
  'EmployeePayrollInfo VacationHours HoursAccrued' => 0,
  'EmployeePayrollInfo VacationHours MaximumHours' => 0,
  'EmployeePayrollInfo VacationHours IsResettingHoursEachNewYear' => 0,
  'EmployeePayrollInfo VacationHours HoursUsed' => 0,
  'EmployeePayrollInfo VacationHours AccrualStartDate' => 0,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
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
  'SSN' => true,
  'Email' => true,
  'EmployeeType' => true,
  'Gender' => true,
  'HiredDate' => true,
  'ReleasedDate' => true,
  'BirthDate' => true,
  'AccountNumber' => true,
  'Notes' => true,
  'BillingRateRef ListID' => true,
  'BillingRateRef FullName' => true,
  'EmployeePayrollInfo PayPeriod' => true,
  'EmployeePayrollInfo ClassRef ListID' => true,
  'EmployeePayrollInfo ClassRef FullName' => true,
  'EmployeePayrollInfo ClearEarnings' => false,
  'EmployeePayrollInfo Earnings PayrollItemWageRef ListID' => true,
  'EmployeePayrollInfo Earnings PayrollItemWageRef FullName' => true,
  'EmployeePayrollInfo Earnings Rate' => false,
  'EmployeePayrollInfo Earnings RatePercent' => false,
  'EmployeePayrollInfo UseTimeDataToCreatePaychecks' => true,
  'EmployeePayrollInfo SickHours HoursAvailable' => true,
  'EmployeePayrollInfo SickHours AccrualPeriod' => true,
  'EmployeePayrollInfo SickHours HoursAccrued' => true,
  'EmployeePayrollInfo SickHours MaximumHours' => true,
  'EmployeePayrollInfo SickHours IsResettingHoursEachNewYear' => true,
  'EmployeePayrollInfo SickHours HoursUsed' => true,
  'EmployeePayrollInfo SickHours AccrualStartDate' => true,
  'EmployeePayrollInfo VacationHours HoursAvailable' => true,
  'EmployeePayrollInfo VacationHours AccrualPeriod' => true,
  'EmployeePayrollInfo VacationHours HoursAccrued' => true,
  'EmployeePayrollInfo VacationHours MaximumHours' => true,
  'EmployeePayrollInfo VacationHours IsResettingHoursEachNewYear' => true,
  'EmployeePayrollInfo VacationHours HoursUsed' => true,
  'EmployeePayrollInfo VacationHours AccrualStartDate' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Name' => 999.99,
  'IsActive' => 999.99,
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
  'SSN' => 999.99,
  'Email' => 999.99,
  'EmployeeType' => 999.99,
  'Gender' => 999.99,
  'HiredDate' => 999.99,
  'ReleasedDate' => 999.99,
  'BirthDate' => 2,
  'AccountNumber' => 999.99,
  'Notes' => 3,
  'BillingRateRef ListID' => 999.99,
  'BillingRateRef FullName' => 999.99,
  'EmployeePayrollInfo PayPeriod' => 999.99,
  'EmployeePayrollInfo ClassRef ListID' => 999.99,
  'EmployeePayrollInfo ClassRef FullName' => 999.99,
  'EmployeePayrollInfo ClearEarnings' => 999.99,
  'EmployeePayrollInfo Earnings PayrollItemWageRef ListID' => 999.99,
  'EmployeePayrollInfo Earnings PayrollItemWageRef FullName' => 999.99,
  'EmployeePayrollInfo Earnings Rate' => 999.99,
  'EmployeePayrollInfo Earnings RatePercent' => 999.99,
  'EmployeePayrollInfo UseTimeDataToCreatePaychecks' => 3,
  'EmployeePayrollInfo SickHours HoursAvailable' => 999.99,
  'EmployeePayrollInfo SickHours AccrualPeriod' => 999.99,
  'EmployeePayrollInfo SickHours HoursAccrued' => 999.99,
  'EmployeePayrollInfo SickHours MaximumHours' => 999.99,
  'EmployeePayrollInfo SickHours IsResettingHoursEachNewYear' => 999.99,
  'EmployeePayrollInfo SickHours HoursUsed' => 5,
  'EmployeePayrollInfo SickHours AccrualStartDate' => 5,
  'EmployeePayrollInfo VacationHours HoursAvailable' => 999.99,
  'EmployeePayrollInfo VacationHours AccrualPeriod' => 999.99,
  'EmployeePayrollInfo VacationHours HoursAccrued' => 999.99,
  'EmployeePayrollInfo VacationHours MaximumHours' => 999.99,
  'EmployeePayrollInfo VacationHours IsResettingHoursEachNewYear' => 999.99,
  'EmployeePayrollInfo VacationHours HoursUsed' => 5,
  'EmployeePayrollInfo VacationHours AccrualStartDate' => 5,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
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
  'SSN' => false,
  'Email' => false,
  'EmployeeType' => false,
  'Gender' => false,
  'HiredDate' => false,
  'ReleasedDate' => false,
  'BirthDate' => false,
  'AccountNumber' => false,
  'Notes' => false,
  'BillingRateRef ListID' => false,
  'BillingRateRef FullName' => false,
  'EmployeePayrollInfo PayPeriod' => false,
  'EmployeePayrollInfo ClassRef ListID' => false,
  'EmployeePayrollInfo ClassRef FullName' => false,
  'EmployeePayrollInfo ClearEarnings' => false,
  'EmployeePayrollInfo Earnings PayrollItemWageRef ListID' => false,
  'EmployeePayrollInfo Earnings PayrollItemWageRef FullName' => false,
  'EmployeePayrollInfo Earnings Rate' => false,
  'EmployeePayrollInfo Earnings RatePercent' => false,
  'EmployeePayrollInfo UseTimeDataToCreatePaychecks' => false,
  'EmployeePayrollInfo SickHours HoursAvailable' => false,
  'EmployeePayrollInfo SickHours AccrualPeriod' => false,
  'EmployeePayrollInfo SickHours HoursAccrued' => false,
  'EmployeePayrollInfo SickHours MaximumHours' => false,
  'EmployeePayrollInfo SickHours IsResettingHoursEachNewYear' => false,
  'EmployeePayrollInfo SickHours HoursUsed' => false,
  'EmployeePayrollInfo SickHours AccrualStartDate' => false,
  'EmployeePayrollInfo VacationHours HoursAvailable' => false,
  'EmployeePayrollInfo VacationHours AccrualPeriod' => false,
  'EmployeePayrollInfo VacationHours HoursAccrued' => false,
  'EmployeePayrollInfo VacationHours MaximumHours' => false,
  'EmployeePayrollInfo VacationHours IsResettingHoursEachNewYear' => false,
  'EmployeePayrollInfo VacationHours HoursUsed' => false,
  'EmployeePayrollInfo VacationHours AccrualStartDate' => false,
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
  2 => 'Salutation',
  3 => 'FirstName',
  4 => 'MiddleName',
  5 => 'LastName',
  6 => 'Suffix',
  7 => 'EmployeeAddress Addr1',
  8 => 'EmployeeAddress Addr2',
  9 => 'EmployeeAddress Addr3',
  10 => 'EmployeeAddress Addr4',
  11 => 'EmployeeAddress City',
  12 => 'EmployeeAddress State',
  13 => 'EmployeeAddress PostalCode',
  14 => 'EmployeeAddress Country',
  15 => 'PrintAs',
  16 => 'Phone',
  17 => 'Mobile',
  18 => 'Pager',
  19 => 'PagerPIN',
  20 => 'AltPhone',
  21 => 'Fax',
  22 => 'SSN',
  23 => 'Email',
  24 => 'EmployeeType',
  25 => 'Gender',
  26 => 'HiredDate',
  27 => 'ReleasedDate',
  28 => 'BirthDate',
  29 => 'AccountNumber',
  30 => 'Notes',
  31 => 'BillingRateRef ListID',
  32 => 'BillingRateRef FullName',
  33 => 'EmployeePayrollInfo PayPeriod',
  34 => 'EmployeePayrollInfo ClassRef ListID',
  35 => 'EmployeePayrollInfo ClassRef FullName',
  36 => 'EmployeePayrollInfo ClearEarnings',
  37 => 'EmployeePayrollInfo',
  38 => 'EmployeePayrollInfo Earnings',
  39 => 'EmployeePayrollInfo Earnings PayrollItemWageRef',
  40 => 'EmployeePayrollInfo Earnings PayrollItemWageRef ListID',
  41 => 'EmployeePayrollInfo Earnings PayrollItemWageRef FullName',
  42 => 'EmployeePayrollInfo Earnings Rate',
  43 => 'EmployeePayrollInfo Earnings RatePercent',
  44 => 'EmployeePayrollInfo UseTimeDataToCreatePaychecks',
  45 => 'EmployeePayrollInfo SickHours HoursAvailable',
  46 => 'EmployeePayrollInfo SickHours AccrualPeriod',
  47 => 'EmployeePayrollInfo SickHours HoursAccrued',
  48 => 'EmployeePayrollInfo SickHours MaximumHours',
  49 => 'EmployeePayrollInfo SickHours IsResettingHoursEachNewYear',
  50 => 'EmployeePayrollInfo SickHours HoursUsed',
  51 => 'EmployeePayrollInfo SickHours AccrualStartDate',
  52 => 'EmployeePayrollInfo VacationHours HoursAvailable',
  53 => 'EmployeePayrollInfo VacationHours AccrualPeriod',
  54 => 'EmployeePayrollInfo VacationHours HoursAccrued',
  55 => 'EmployeePayrollInfo VacationHours MaximumHours',
  56 => 'EmployeePayrollInfo VacationHours IsResettingHoursEachNewYear',
  57 => 'EmployeePayrollInfo VacationHours HoursUsed',
  58 => 'EmployeePayrollInfo VacationHours AccrualStartDate',
  59 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>