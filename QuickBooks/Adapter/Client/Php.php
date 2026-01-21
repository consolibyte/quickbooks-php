<?php

/**
 * 
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
QuickBooks_Loader::load('/QuickBooks/Adapter/Client.php');

/**
 * 
 */
class QuickBooks_Adapter_Client_Php extends SoapClient implements QuickBooks_Adapter_Client
{
	public function __construct($endpoint, $wsdl = QUICKBOOKS_WSDL, $trace = true)
	{
		ini_set('soap.wsdl_cache_enabled', '0');
		
		$options['location'] = $endpoint;
		
		if ($trace)
		{
			$options['trace'] = 1;
		}
		
		parent::__construct($wsdl, $options);
	}
	
	/**
	 * Authenticate against a QuickBooks SOAP server
	 * 
	 * @param string $user
	 * @param string $pass
	 * @return array
	 */
	public function authenticate($user, $pass)
	{
		$req = new QuickBooks_Request_Authenticate($user, $pass);
		
		$resp = parent::__soapCall('authenticate', array( $req ));
		$tmp = current($resp);
		
		return current($tmp);
	}
	
	public function sendRequestXML($ticket, $hcpresponse, $companyfile, $country, $majorversion, $minorversion)
	{
		$req = new QuickBooks_Request_SendRequestXML($ticket, $hcpresponse, $companyfile, $country, $majorversion, $minorversion);
		
		//print("SENDING:<pre>");
		//print_r($req);
		//print('</pre>');
		
		$resp = parent::__soapCall('sendRequestXML', array( $req ));
		$tmp = current($resp);
		
		return $tmp;
	}
	
	public function receiveResponseXML($ticket, $response, $hresult, $message)
	{
		$req = new QuickBooks_Request_ReceiveResponseXML($ticket, $response, $hresult, $message);
		
		$resp = parent::__soapCall('receiveResponseXML', array( $req ));
		$tmp = current($resp);
		
		return $tmp;
	}
	
	public function getLastRequest()
	{
		return parent::__getLastRequest();
	}
	
	public function getLastResponse()
	{
		return parent::__getLastResponse();
	}
}

