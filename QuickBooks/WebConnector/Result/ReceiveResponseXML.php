<?php

/**
 * Response result for the SOAP ->receiveRequestXML() method call
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
 * Response result for the SOAP ->receiveRequestXML() method call
 */
class QuickBooks_WebConnector_Result_ReceiveResponseXML extends QuickBooks_WebConnector_Result
{
	/**
	 * Integer indicating update progress
	 * 
	 * @var integer
	 */
	public $receiveResponseXMLResult;
	
	/**
	 * Create a new ->receiveResponseXML result object
	 * 
	 * @param integer $complete		An integer between 0 and 100 indicating the percentage complete this update is *OR* a negative integer indicating an error has occured
	 */
	public function __construct($complete)
	{
		$this->receiveResponseXMLResult = $complete;
	}
}
