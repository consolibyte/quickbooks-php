<?php

/**
 * XML parser interface
 * 
 * Copyright (c) 2010-04-16 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @package QuickBooks
 * @subpackage XML
 */

/**
 * XML parser interface
 * 
 * 
 */
interface QuickBooks_XML_Backend
{
	/**
	 * Create the XML parser
	 * 
	 * @param string $xml
	 */
	public function __construct($xml);
	
	/**
	 * Validate the XML string
	 * 
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return boolean
	 */
	public function validate(&$errnum, &$errmsg);
	
	/**
	 * Parse an XML string
	 * 
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return QuickBooks_XML_Document
	 */
	public function parse(&$errnum, &$errmsg);
	
	/**
	 * Load a new string to parse
	 * 
	 * @param string $str
	 * @return boolean
	 */
	public function load($str);
}

