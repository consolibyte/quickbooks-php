<?php

/**
 * Schema object for: VendorModRq
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
class QuickBooks_QBXML_Schema_Object_VendorModRq extends QuickBooks_QBXML_Schema_Object
{
	protected function &_qbxmlWrapper()
	{
		static $wrapper = 'VendorMod';
		
		return $wrapper;
	}
	
	protected function &_dataTypePaths()
	{
		static $paths = array (
  'ListID' => 'IDTYPE',
  'EditSequence' => 'STRTYPE',
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
  'BillingRateRef ListID' => 'IDTYPE',
  'BillingRateRef FullName' => 'STRTYPE',
  'IncludeRetElement' => 'STRTYPE',
);
		
		return $paths;
	}
	
	protected function &_maxLengthPaths()
	{
		static $paths = array (
  'ListID' => 0,
  'EditSequence' => 16,
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
  'BillingRateRef ListID' => 0,
  'BillingRateRef FullName' => 159,
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
  'VendorTypeRef ListID' => false,
  'VendorTypeRef FullName' => true,
  'TermsRef ListID' => false,
  'TermsRef FullName' => true,
  'CreditLimit' => true,
  'VendorTaxIdent' => true,
  'IsVendorEligibleFor1099' => true,
  'BillingRateRef ListID' => false,
  'BillingRateRef FullName' => true,
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
  'CreditLimit' => 3,
  'VendorTaxIdent' => 3,
  'IsVendorEligibleFor1099' => 3,
  'BillingRateRef ListID' => 999.99,
  'BillingRateRef FullName' => 999.99,
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
  0 => 'ListID',
  1 => 'EditSequence',
  2 => 'Name',
  3 => 'IsActive',
  4 => 'CompanyName',
  5 => 'Salutation',
  6 => 'FirstName',
  7 => 'MiddleName',
  8 => 'LastName',
  9 => 'Suffix',
  10 => 'VendorAddress Addr1',
  11 => 'VendorAddress Addr2',
  12 => 'VendorAddress Addr3',
  13 => 'VendorAddress Addr4',
  14 => 'VendorAddress Addr5',
  15 => 'VendorAddress City',
  16 => 'VendorAddress State',
  17 => 'VendorAddress PostalCode',
  18 => 'VendorAddress Country',
  19 => 'VendorAddress Note',
  20 => 'Phone',
  21 => 'Mobile',
  22 => 'Pager',
  23 => 'AltPhone',
  24 => 'Fax',
  25 => 'Email',
  26 => 'Contact',
  27 => 'AltContact',
  28 => 'NameOnCheck',
  29 => 'AccountNumber',
  30 => 'Notes',
  31 => 'VendorTypeRef ListID',
  32 => 'VendorTypeRef FullName',
  33 => 'TermsRef ListID',
  34 => 'TermsRef FullName',
  35 => 'CreditLimit',
  36 => 'VendorTaxIdent',
  37 => 'IsVendorEligibleFor1099',
  38 => 'BillingRateRef ListID',
  39 => 'BillingRateRef FullName',
  40 => 'IncludeRetElement',
);
			
		return $paths;
	}
}

?>