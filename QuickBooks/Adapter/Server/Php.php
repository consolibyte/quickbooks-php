<?php

/**
 * Adapter class for the PHP SOAP ext/soap SOAP server
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
QuickBooks_Loader::load('/QuickBooks/Adapter/Server.php');

/**
 * 
 */
class QuickBooks_Adapter_Server_PHP implements QuickBooks_Adapter_Server
{
	protected $_server;
	
	public function __construct($wsdl, $soap_options)
	{
		$this->_server = new SoapServer($wsdl, $soap_options);
	}
	
	public function handle($raw_http_input)
	{
		return $this->_server->handle($raw_http_input);
	}
	
	public function setClass($class, $dsn_or_conn, $map, $onerror, $hooks, $log_level, $raw_http_input, $handler_options, $driver_options, $callback_options)
	{
		return $this->_server->setClass($class, $dsn_or_conn, $map, $onerror, $hooks, $log_level, $raw_http_input, $handler_options, $driver_options, $callback_options);
	}
	
	public function getFunctions()
	{
		return $this->_server->getFunctions();
	}
}
