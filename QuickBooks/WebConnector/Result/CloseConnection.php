<?php

/**
 * Result container object for the SOAP ->connectionError() method call
 * 
 * Copyright (c) {2010-04-16} {Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * Result interface
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result.php');

/**
 * Result class for ->closeConnection() SOAP method
 */
class QuickBooks_WebConnector_Result_CloseConnection extends QuickBooks_WebConnector_Result
{
	/**
	 * A message indicating the connection has been closed/update was successful
	 * 
	 * @var string
	 */
	public $closeConnectionResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $resp		A message indicating the connection has been closed
	 */
	public function __construct($result)
	{
		$this->closeConnectionResult = $result;
	}
}

