<?php

/**
 * Client adapter base class
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
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
