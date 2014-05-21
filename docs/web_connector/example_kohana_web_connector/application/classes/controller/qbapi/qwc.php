<?php

/**
 * Example of generating QuickBooks *.QWC files 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Error reporting... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

/**
 * Require the utilities class
 */
require_once 'framework/QuickBooks.php';

// A name for your server (make it whatever you want)
$name = 'QBServer';				
// A description of your server 
$descrip = '';		
// This *must* be httpS:// (path to your QuickBooks SOAP server)
$appurl = 'https://backend.mywebsite/qbapi/';		
// This *must* be httpS:// and the domain name must match the domain name above
//set this to your quickbook
$appsupport = 'https://backend.mywebsite/salesforce/quickbooks/help'; 		
// This is the username you stored in the 'quickbooks_user' table by using QuickBooks_Utilities::createUser()
$username = 'Username';		
// Just make this up, but make sure it keeps that format
$fileid = '57F3B9B6-86F1-4FCC-B1FF-966DE1813D99';		
// Just make this up, but make sure it keeps that format
$ownerid = '57F3B9B6-86F1-4FCC-B1FF-166DE1813D99';		
// You can leave this as-is unless you're using QuickBooks POS
$qbtype = QUICKBOOKS_TYPE_QBFS;	
// No, we want to write data to QuickBooks
$readonly = false; 
// Run every 600 seconds (10 minutes)
$run_every_n_seconds = 600; 

// Generate the XML file
$QWC = new QuickBooks_WebConnector_QWC($name, $descrip, $appurl, $appsupport, $username, $fileid, $ownerid, $qbtype, $readonly, $run_every_n_seconds);
$xml = $QWC->generate();

// Send as a file download
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="my_quickbooks.qwc"');
print($xml);
exit;
