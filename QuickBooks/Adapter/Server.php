<?php

/**
 * QuickBooks Server-Adapter interface
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * SOAP servers and clients within the QuickBooks class are not accessed 
 * directly, but instead via Adapter classes so that we can support more than 
 * one PHP SOAP server and client type (nuSOAP, PEAR SOAP, PHP ext/soap, etc.)
 * 
 * This is the interface for the server adapters. All supported SOAP servers 
 * must implement this interface to function with the QuickBooks framework. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Adapter
 */

/**
 * QuickBooks server adapter interface
 */
interface QuickBooks_Adapter_Server
{
	/**
	 * Create a new instance of the server adapter
	 * 
	 * @param string $wsdl			The path to the WSDL
	 * @param array $soap_options	Any SOAP configuration options to pass to the server class
	 */
	public function __construct($wsdl, $soap_options);
	
	/**
	 * Handle a SOAP request
	 * 
	 * @param string $raw_http_input
	 * @return boolean
	 */
	public function handle($raw_http_input);
	
	/**
	 * Return a list of implemented SOAP methods/functions
	 * 
	 * @return array
	 */
	public function getFunctions();
	
	/**
	 * Set a class whose methods will handle various SOAP methods/functions
	 * 
	 * @param string $class					The name of the class
	 * @param string $dsn_or_conn	
	 * @param array $map
	 * @param array $onerror
	 * @param array $hooks
	 * @param integer $log_level
	 * @param string $raw_http_input
	 * @param array $handler_options
	 * @param array $driver_options
	 * @param array $callback_options
	 * @return boolean
	 */
	public function setClass($class, $dsn_or_conn, $map, $onerror, $hooks, $log_level, $raw_http_input, $handler_options, $driver_options, $callback_options);
}
