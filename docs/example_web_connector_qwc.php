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
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/keithpalmerjr/Projects/QuickBooks/');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

/**
 * Require the utilities class
 */
require_once 'QuickBooks.php';

$name = 'My QuickBooks SOAP Server';				// A name for your server (make it whatever you want)
$descrip = 'An example QuickBooks SOAP Server';		// A description of your server 

$appurl = 'https://your-domain-name/path/to/soap/server.php';		// This *must* be httpS:// (path to your QuickBooks SOAP server)
$appsupport = 'https://your-domain-name/get-help-here.php'; 		// This *must* be httpS:// and the domain name must match the domain name above

$username = 'your-quickbooks-username';		// This is the username you stored in the 'quickbooks_user' table by using QuickBooks_Utilities::createUser()

$fileid = '57F3B9B6-86F1-4FCC-B1FF-966DE1813D20';		// Just make this up, but make sure it keeps that format
$ownerid = '57F3B9B6-86F1-4FCC-B1FF-166DE1813D20';		// Just make this up, but make sure it keeps that format

$qbtype = QUICKBOOKS_TYPE_QBFS;	// You can leave this as-is unless you're using QuickBooks POS

$readonly = false; // No, we want to write data to QuickBooks

$run_every_n_seconds = 600; // Run every 600 seconds (10 minutes)

// Generate the XML file
$QWC = new QuickBooks_QWC($name, $descrip, $appurl, $appsupport, $username, $fileid, $ownerid, $qbtype, $readonly, $run_every_n_seconds);
$xml = $QWC->generate();

// Send as a file download
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="my-quickbooks-wc-file.qwc"');
print($xml);
exit;

?>
