<?php

/**
 * Response result for the SOAP ->sendRequestXML() method call
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
 * Response result for the SOAP ->sendRequestXML() method call
 */
class QuickBooks_WebConnector_Result_SendRequestXML extends QuickBooks_WebConnector_Result
{
	/**
	 * A QBXML XML request string
	 * 
	 * @var string
	 */
	public $sendRequestXMLResult;
	
	/**
	 * Create a new result response
	 * 
	 * @param string $xml	The XML request to send to QuickBooks
	 */
	public function __construct($xml)
	{
		$this->sendRequestXMLResult = $xml;
	}
}
