<?php

/**
 * QuickBooks SOAP client for testing purposes
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * Unused for now, might be here for testing in later versions
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 */

// Include path modifications (relative paths within library)
ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . dirname(__FILE__) . '/../');


QuickBooks_Loader::load('/QuickBooks/Request.php');

QuickBooks_Loader::load('/QuickBooks/Request/Authenticate.php');

QuickBooks_Loader::load('/QuickBooks/Request/SendRequestXML.php');

QuickBooks_Loader::load('/QuickBooks/Request/ReceiveResponseXML.php');

/**
 * 
 * 
 */
class QuickBooks_Client
{
	/**
	 * 
	 */
	protected $_client;
	
	/**
	 * 
	 */
	public function __construct($endpoint, $wsdl = QUICKBOOKS_WSDL, $soap = QUICKBOOKS_SOAPCLIENT_PHP, $trace = true)
	{
		$this->_client = $this->_adapterFactory($soap, $endpoint, $wsdl, $trace);
	}
	
	protected function _adapterFactory($adapter, $endpoint, $wsdl, $trace)
	{
		$adapter = ucfirst(strtolower($adapter));
		
		$file = '/QuickBooks/Adapter/Client/' . $adapter . '.php';
		$class = 'QuickBooks_Adapter_Client_' . $adapter;
		
		QuickBooks_Loader::load($file);
		
		if (class_exists($class))
		{
			return new $class($endpoint, $wsdl, $trace);
		}
		
		return null;
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
		return $this->_client->authenticate($user, $pass);
	}
	
	public function sendRequestXML($ticket, $hcpresponse, $companyfile, $country, $majorversion, $minorversion)
	{
		return $this->_client->sendRequestXML($ticket, $hcpresponse, $companyfile, $country, $majorversion, $minorversion);
	}
	
	public function receiveResponseXML($ticket, $response, $hresult, $message)
	{
		return $this->_client->receiveResponseXML($ticket, $response, $hresult, $message);
	}
	
	public function getLastRequest()
	{
		return $this->_client->getLastRequest();
	}
	
	public function getLastResponse()
	{
		return $this->_client->getLastResponse();
	}
}

