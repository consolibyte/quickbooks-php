<?php

/**
 * 
 * 
 * 
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks/');

require_once 'QuickBooks.php';
require_once 'QuickBooks/MerchantService.php';

$MS = new QuickBooks_MerchantService(
	null, 
	'/Users/kpalmer/Projects/QuickBooks/QuickBooks/dev/test_qbms.pem', 
	'test.www.academickeys.com',
	'TGT-152-LWGj1YQUufTAlSW8DK1c6A');

$MS->useTestEnvironment(true);

$name = 'Keith Palmer';
$number = '5105105105105100';
$expyear = date('Y');
$expmonth = date('m');
$address = '56 Cowles Road';
$postalcode = '06279';
$cvv = null;

$Card = new QuickBooks_MerchantService_CreditCard($name, $number, $expyear, $expmonth, $address, $postalcode, $cvv);

//if ($Transaction = $MS->authorize($Card, 295))
if ($Transaction = $MS->charge($Card, 295))
{
	print('Card authorized!');
	
		
}
else
{
	print('An error occured: ' . $MS->errorNumber() . ': ' . $MS->errorMessage());
}

?>