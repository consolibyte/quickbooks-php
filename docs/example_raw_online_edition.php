<?php

/**
 * Example of connecting to QuickBooks Online Edition using PHP
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 */

// This just makes debugging easier... 
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

// 
header('Content-Type: text/plain');

define('QBOE_GATEWAY', 'https://webapps.quickbooks.com/j/AppGateway');

define('QBOE_CONNECTION', '');
define('QBOE_APPLICATIONID', '');
define('QBOE_APPLICATIONLOGIN', '');

// Set the timezone so PHP doesn't throw warnings
if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

$debug = true;

// There are two stages to every QBOE connection:
//	1. Establish a session
//	2. Send 1 or more actual requests

// This is our XML to establish the session
$signon_xml = '<?xml version="1.0" ?>
<?qbxml version="6.0"?> 
<QBXML>
	<SignonMsgsRq>
		<SignonDesktopRq>
			<ClientDateTime>' . date('Y-m-d') . 'T' . date('H:i:s') . '</ClientDateTime> 
			<ApplicationLogin>' . QBOE_APPLICATIONLOGIN . '</ApplicationLogin> 
			<ConnectionTicket>' . QBOE_CONNECTION . '</ConnectionTicket> 
			<Language>English</Language> 
			<AppID>' . QBOE_APPLICATIONID . '</AppID> 
			<AppVer>1</AppVer> 
		</SignonDesktopRq> 
	</SignonMsgsRq> 
</QBXML>';

// Send the request
$response = _request($signon_xml, null, $debug);

// Extract the session ticket
$session = _session($response);

// This is the request we're going to send
$customerquery_xml = '<?xml version="1.0" ?>
<?qbxml version="6.0"?>
<QBXML>
	<SignonMsgsRq>
		<SignonTicketRq>
			<ClientDateTime>' . date('Y-m-d') . 'T' . date('H:i:s') . '</ClientDateTime>
			<SessionTicket>' . $session . '</SessionTicket>
			<Language>English</Language>
			<AppID>' . QBOE_APPLICATIONID . '</AppID>
			<AppVer>1</AppVer>
		</SignonTicketRq>
	</SignonMsgsRq>
	<QBXMLMsgsRq onError="stopOnError">
		<CustomerQueryRq>
		</CustomerQueryRq>	
	</QBXMLMsgsRq>
</QBXML>';

// Send the request
$response = _request($customerquery_xml, null, $debug);

// Print the response
print($response);

/**
 * Extract the session ticket from the XML response
 */
function _session($data)
{
	$tag = 'SessionTicket';
	
	// SessionTicket
	if (false !== strpos($data, '<' . $tag . '>') and 
		false !== strpos($data, '</' . $tag . '>'))
	{
		$data = strstr($data, '<' . $tag . '>');
		$end = strpos($data, '</' . $tag . '>');
		
		return substr($data, strlen($tag) + 2, $end - (strlen($tag) + 2));
	}
	
	return null;
}

/**
 * Log a message (for debugging)
 */
function _log($msg, $debug)
{
	if ($debug)
	{
		print(date('Y-m-d H:i:s') . ': ' . $msg . "\n");
	}
}

/**
 * Send a request to QBOE
 * 
 * @param string $xml			The XML request to send
 * @param string $certificate	The full path to the certificate (for HOSTED model)
 * @param boolean $debug		Whether or not to show debugging information
 * @return string				The XML response from QBOE
 */
function _request($xml, $certificate = null, $debug = false)
{
	$ch = curl_init(); 
	
	$header[] = 'Content-Type: application/x-qbxml'; 
	$header[] = 'Content-Length: ' . strlen($xml); 
	
	$params = array();
	$params[CURLOPT_HTTPHEADER] = $header; 
	$params[CURLOPT_POST] = true; 
	$params[CURLOPT_RETURNTRANSFER] = true; 
	$params[CURLOPT_URL] = QBOE_GATEWAY; 
	$params[CURLOPT_TIMEOUT] = 30; 
	$params[CURLOPT_POSTFIELDS] = $xml; 
	$params[CURLOPT_VERBOSE] = $debug; 
	$params[CURLOPT_HEADER] = true;
	
	// This is only for the HOSTED security model
	if (file_exists($certificate))
	{
		$params[CURLOPT_SSL_VERIFYPEER] = false; 
		$params[CURLOPT_SSLCERT] = $certificate; 
	}
	
	// Some Windows servers will fail with SSL errors unless we turn this off
	$params[CURLOPT_SSL_VERIFYPEER] = false;
	$params[CURLOPT_SSL_VERIFYHOST] = 0;		
	
	// Diagnostic information: https://merchantaccount.quickbooks.com/j/diag/http
	// curl_setopt($ch, CURLOPT_INTERFACE, '<myipaddress>');
	
	$ch = curl_init();
	curl_setopt_array($ch, $params);
	$response = curl_exec($ch);
	
	_log('CURL options: ' . print_r($params, true), $debug);
	
	// @todo Strip credit card numbers from logged XML... (or should this be within the _log() method?)
	
	_log('Outgoing QBOE request: ' . $xml, $debug);
	_log('Incoming QBOE response: ' . $response, $debug);
	
	if (curl_errno($ch)) 
	{
		$errnum = curl_errno($ch);
		$errmsg = curl_error($ch);
		
		_log('CURL error: ' . $errnum . ': ' . $errmsg, $debug);
		
		return false;
	} 
	
	// Close the connection 
	@curl_close($ch);
	
	// Remove the HTTP headers from the response
	$pos = strpos($response, "\r\n\r\n");
	$response = ltrim(substr($response, $pos));
	
	return $response;		
}
