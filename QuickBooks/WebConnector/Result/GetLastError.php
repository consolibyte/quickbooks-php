<?php

/**
 * Result container object for the SOAP ->getLastError() method call
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
 * Result base class
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result.php');

/**
 * Result container object for the SOAP ->getLastError() method call
 */
class QuickBooks_WebConnector_Result_GetLastError extends QuickBooks_WebConnector_Result
{
	/**
	 * An error message
	 * 
	 * @param string $resp
	 */
	public $getLastErrorResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $resp 		A message describing the last error that occured
	 */
	public function __construct($result)
	{
		$this->getLastErrorResult = $result;
	}
}
