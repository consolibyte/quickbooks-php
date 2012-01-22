<?php

/**
 * QuickBooks response object for responses to the ->interactiveDone() SOAP method call
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
 * QuickBooks result base class
 */
QuickBooks_Loader::load('/QuickBooks/WebConnector/Result.php');

/**
 * QuickBooks response object for responses to the ->interactiveDone() SOAP method call
 */
class QuickBooks_WebConnector_Result_InteractiveDone extends QuickBooks_WebConnector_Result
{
	/**
	 * A string indicating the interactive session is done
	 * 
	 * @var string
	 */
	public $interactiveDoneResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $version
	 */
	public function __construct($str)
	{
		$this->interactiveDoneResult = $str;
	}
}
