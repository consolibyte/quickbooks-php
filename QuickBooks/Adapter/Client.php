<?php

/**
 * Client adapter base class
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Adapter
 */

/**
 * 
 */
interface QuickBooks_Adapter_Client
{
	public function __construct($endpoint, $wsdl = QUICKBOOKS_WSDL, $trace = true);
	
	public function authenticate($user, $pass);
	
	public function sendRequestXML($ticket, $hcpresponse, $companyfile, $country, $majorversion, $minorversion);
	
	public function receiveResponseXML($ticket, $response, $hresult, $message);
	
	public function getLastRequest();
	
	public function getLastResponse();
	
}
