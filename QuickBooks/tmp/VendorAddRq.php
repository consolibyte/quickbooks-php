<?php

/**
 * Schema object for: VendorAddRq
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
class QuickBooks_QBXML_Schema_Object_VendorAddRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'VendorAdd';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'Name' => 'STRTYPE',
  'IsActive' => 'BOOLTYPE',
  'CompanyName' => 'STRTYPE',
  'Salutation' => 'STRTYPE',
  'FirstName' => 'STRTYPE',
  'MiddleName' => 'STRTYPE',
  'LastName' => 'STRTYPE',
  'Suffix' => 'STRTYPE',
  'VendorAddress Addr1' => 'STRTYPE',
  'VendorAddress Addr2' => 'STRTYPE',
  'VendorAddress Addr3' => 'STRTYPE',
  'VendorAddress Addr4' => 'STRTYPE',
  'VendorAddress Addr5' => 'STRTYPE',
  'VendorAddress City' => 'STRTYPE',
  'VendorAddress State' => 'STRTYPE',
  'VendorAddress PostalCode' => 'STRTYPE',
  'VendorAddress Country' => 'STRTYPE',
  'VendorAddress Note' => 'STRTYPE',
  'Phone' => 'STRTYPE',
  'Mobile' => 'STRTYPE',
  'Pager' => 'STRTYPE',
  'AltPhone' => 'STRTYPE',
  'Fax' => 'STRTYPE',
  'Email' => 'STRTYPE',
  'Contact' => 'STRTYPE',
  'AltContact' => 'STRTYPE',
  'NameOnCheck' => 'STRTYPE',
  'AccountNumber' => 'STRTYPE',
  'Notes' => 'STRTYPE',
  'VendorTypeRef ListID' => 'IDTYPE',
  'VendorTypeRef FullName' => 'STRTYPE',
  'TermsRef ListID' => 'IDTYPE',
  'TermsRef FullName' => 'STRTYPE',
  'CreditLimit' => 'AMTTYPE',
  'VendorTaxIdent' => 'STRTYPE',
  'IsVendorEligibleFor1099' => 'BOOLTYPE',
  'OpenBalance' => 'AMTTYPE',
  'OpenBalanceDate' => 'DATETYPE',
  'BillingRateRef ListID' => 'IDTYPE',
  'BillingRateRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'Name' => 41,
  'IsActive' => 0,
  'CompanyName' => 41,
  'Salutation' => 15,
  'FirstName' => 25,
  'MiddleName' => 5,
  'LastName' => 25,
  'Suffix' => 10,
  'VendorAddress Addr1' => 41,
  'VendorAddress Addr2' => 41,
  'VendorAddress Addr3' => 41,
  'VendorAddress Addr4' => 41,
  'VendorAddress Addr5' => 41,
  'VendorAddress City' => 31,
  'VendorAddress State' => 21,
  'VendorAddress PostalCode' => 13,
  'VendorAddress Country' => 31,
  'VendorAddress Note' => 41,
  'Phone' => 21,
  'Mobile' => 21,
  'Pager' => 21,
  'AltPhone' => 21,
  'Fax' => 21,
  'Email' => 1023,
  'Contact' => 41,
  'AltContact' => 41,
  'NameOnCheck' => 41,
  'AccountNumber' => 99,
  'Notes' => 4095,
  'VendorTypeRef ListID' => 0,
  'VendorTypeRef FullName' => 159,
  'TermsRef ListID' => 0,
  'TermsRef FullName' => 159,
  'CreditLimit' => 0,
  'VendorTaxIdent' => 15,
  'IsVendorEligibleFor1099' => 0,
  'OpenBalance' => 0,
  'OpenBalanceDate' => 0,
  'BillingRateRef ListID' => 0,
  'BillingRateRef FullName' => 159,
  'IncludeRetElement' => 50,
);
		
		return $paths;
	}
	
	protected function &_isOptionalPaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => true,
  'CompanyName' => true,
  'Salutation' => true,
  'FirstName' => true,
  'MiddleName' => true,
  'LastName' => true,
  'Suffix' => true,
  'VendorAddress Addr1' => true,
  'VendorAddress Addr2' => true,
  'VendorAddress Addr3' => true,
  'VendorAddress Addr4' => true,
  'VendorAddress Addr5' => true,
  'VendorAddress City' => true,
  'VendorAddress State' => true,
  'VendorAddress PostalCode' => true,
  'VendorAddress Country' => true,
  'VendorAddress Note' => true,
  'Phone' => true,
  'Mobile' => true,
  'Pager' => true,
  'AltPhone' => true,
  'Fax' => true,
  'Email' => true,
  'Contact' => true,
  'AltContact' => true,
  'NameOnCheck' => true,
  'AccountNumber' => true,
  'Notes' => true,
  'VendorTypeRef ListID' => true,
  'VendorTypeRef FullName' => true,
  'TermsRef ListID' => true,
  'TermsRef FullName' => true,
  'CreditLimit' => true,
  'VendorTaxIdent' => true,
  'IsVendorEligibleFor1099' => true,
  'OpenBalance' => true,
  'OpenBalanceDate' => true,
  'BillingRateRef ListID' => true,
  'BillingRateRef FullName' => true,
  'IncludeRetElement' => true,
);
	}
	
	protected function &_sinceVersionPaths()
	{
		static $paths = array (
  'Name' => 999.99,
  'IsActive' => 999.99,
  'CompanyName' => 999.99,
  'Salutation' => 999.99,
  'FirstName' => 999.99,
  'MiddleName' => 999.99,
  'LastName' => 999.99,
  'Suffix' => 999.99,
  'VendorAddress Addr1' => 999.99,
  'VendorAddress Addr2' => 999.99,
  'VendorAddress Addr3' => 999.99,
  'VendorAddress Addr4' => 2,
  'VendorAddress Addr5' => 6,
  'VendorAddress City' => 999.99,
  'VendorAddress State' => 999.99,
  'VendorAddress PostalCode' => 999.99,
  'VendorAddress Country' => 999.99,
  'VendorAddress Note' => 6,
  'Phone' => 999.99,
  'Mobile' => 999.99,
  'Pager' => 999.99,
  'AltPhone' => 999.99,
  'Fax' => 999.99,
  'Email' => 999.99,
  'Contact' => 999.99,
  'AltContact' => 999.99,
  'NameOnCheck' => 999.99,
  'AccountNumber' => 999.99,
  'Notes' => 3,
  'VendorTypeRef ListID' => 999.99,
  'VendorTypeRef FullName' => 999.99,
  'TermsRef ListID' => 999.99,
  'TermsRef FullName' => 999.99,
  'CreditLimit' => 999.99,
  'VendorTaxIdent' => 999.99,
  'IsVendorEligibleFor1099' => 999.99,
  'OpenBalance' => 999.99,
  'OpenBalanceDate' => 999.99,
  'BillingRateRef ListID' => 999.99,
  'BillingRateRef FullName' => 999.99,
  'IncludeRetElement' => 4,
);
		
		return $paths;
	}
	
	protected function &_isRepeatablePaths()
	{
		static $paths = array (
  'Name' => false,
  'IsActive' => false,
  'CompanyName' => false,
  'Salutation' => false,
  'FirstName' => false,
  'MiddleName' => false,
  'LastName' => false,
  'Suffix' => false,
  'VendorAddress Addr1' => false,
  'VendorAddress Addr2' => false,
  'VendorAddress Addr3' => false,
  'VendorAddress Addr4' => false,
  'VendorAddress Addr5' => false,
  'VendorAddress City' => false,
  'VendorAddress State' => false,
  'VendorAddress PostalCode' => false,
  'VendorAddress Country' => false,
  'VendorAddress Note' => false,
  'Phone' => false,
  'Mobile' => false,
  'Pager' => false,
  'AltPhone' => false,
  'Fax' => false,
  'Email' => false,
  'Contact' => false,
  'AltContact' => false,
  'NameOnCheck' => false,
  'AccountNumber' => false,
  'Notes' => false,
  'VendorTypeRef ListID' => false,
  'VendorTypeRef FullName' => false,
  'TermsRef ListID' => false,
  'TermsRef FullName' => false,
  'CreditLimit' => false,
  'VendorTaxIdent' => false,
  'IsVendorEligibleFor1099' => false,
  'OpenBalance' => false,
  'OpenBalanceDate' => false,
  'BillingRateRef ListID' => false,
  'BillingRateRef FullName' => false,
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
  2 => 'CompanyName',
  3 => 'Salutation',
  4 => 'FirstName',
  5 => 'MiddleName',
  6 => 'LastName',
  7 => 'Suffix',
  8 => 'VendorAddress Addr1',
  9 => 'VendorAddress Addr2',
  10 => 'VendorAddress Addr3',
  11 => 'VendorAddress Addr4',
  12 => 'VendorAddress Addr5',
  13 => 'VendorAddress City',
  14 => 'VendorAddress State',
  15 => 'VendorAddress PostalCode',
  16 => 'VendorAddress Country',
  17 => 'VendorAddress Note',
  18 => 'Phone',
  19 => 'Mobile',
  20 => 'Pager',
  21 => 'AltPhone',
  22 => 'Fax',
  23 => 'Email',
  24 => 'Contact',
  25 => 'AltContact',
  26 => 'NameOnCheck',
  27 => 'AccountNumber',
  28 => 'Notes',
  29 => 'VendorTypeRef ListID',
  30 => 'VendorTypeRef FullName',
  31 => 'TermsRef ListID',
  32 => 'TermsRef FullName',
  33 => 'CreditLimit',
  34 => 'VendorTaxIdent',
  35 => 'IsVendorEligibleFor1099',
  36 => 'OpenBalance',
  37 => 'OpenBalanceDate',
  38 => 'BillingRateRef ListID',
  39 => 'BillingRateRef FullName',
  40 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>