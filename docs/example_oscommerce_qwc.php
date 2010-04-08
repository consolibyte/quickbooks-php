<?php

/**
 * Example of generating QuickBooks *.QWC files 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// 
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks/');

/**
 * Require the utilities class
 */
require_once 'QuickBooks.php';

$name = 'QuickBooks for osCommerce - ' . $_SERVER['HTTP_HOST'];			// A name for your server (make it whatever you want)
$descrip = 'QuickBooks for osCommerce - ' . $_SERVER['HTTP_HOST'];		// A description of your server 

//$appurl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];		// This *must* be httpS:// (path to your QuickBooks SOAP server)
//$appsupport = 'https://' . $_SERVER['HTTP_HOST'] . '/store/quickbooks/server.php?support=1'; 		// This *must* be httpS:// and the domain name must match the domain name above

// This *must* be httpS:// (path to your QuickBooks SOAP server)
$appurl = 'https://' . str_replace('//', '/', $_SERVER['HTTP_HOST'] . '' . dirname($_SERVER['REQUEST_URI']) . '/' . basename($_SERVER['PHP_SELF'], '_qwc.php') . '_server.php');
if (false !== strpos($_SERVER['HTTP_HOST'], 'localhost'))
{
	$appurl = str_replace('https://', 'http://', $appurl);
}

$appsupport = $appurl . '?support=1'; 
if (false !== strpos($appurl, '?'))
{
	// This *must* be httpS:// and the domain name must match the domain name above
	$appsupport = $appurl . '&support=1';
}

$username = 'oscommerce';		// This is the username you stored in the 'quickbooks_user' table by using QuickBooks_Utilities::createUser()

//$fileid = '57F3B9B6-86F1-4FCC-B1FF-966DE1813D20';		// Just make this up, but make sure it keeps that format
//$ownerid = '57F3B9B6-86F1-4FCC-B1FF-166DE1813D20';		// Just make this up, but make sure it keeps that format

$fileid = QuickBooks_QWC::GUID();
$ownerid = QuickBooks_QWC::GUID();

$qbtype = QUICKBOOKS_TYPE_QBFS;	// You can leave this as-is unless you're using QuickBooks POS

$readonly = false; // No, we want to write data to QuickBooks

$run_every_n_seconds = 600; // Run every 600 seconds (10 minutes)

// Generate the XML file
$QWC = new QuickBooks_QWC($name, $descrip, $appurl, $appsupport, $username, $fileid, $ownerid, $qbtype, $readonly, $run_every_n_seconds);
$xml = $QWC->generate();

// Send as a file download
//header('Content-Type: text/plain');
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="QuickBooks-for-osCommerce_' . $_SERVER['HTTP_HOST'] . '.qwc"');
print($xml);
exit;

?>
