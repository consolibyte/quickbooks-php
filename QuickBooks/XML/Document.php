<?php

/**
 * QuickBooks XML document class
 * 
 * Copyright (c) 2010-04-16 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage XML
 */

/**
 * Node class
 */
QuickBooks_Loader::load('/QuickBooks/XML/Node.php');

/**
 * QuickBooks XML document container
 * 
 * 
 */
class QuickBooks_XML_Document
{
	/**
	 * QuickBooks root node
	 * @var QuickBooks_XML_Node
	 */
	protected $_root;
	
	/**
	 * 
	 * 
	 * @param QuickBooks_XML_Node $root
	 */
	public function __construct($root)
	{
		$this->_root = $root;
	}

	/**
	 * 
	 * 
	 * @return QuickBooks_XML_Node
	 */
	public function getRoot()
	{
		return $this->_root;
	}
	
	/**
	 * Return the children of the root node (For backward compatability *only*! DO NOT use this function in new code!)
	 * 
	 * @return array
	 */
	public function children()
	{
		return $this->_root->children();
	}
	
	/**
	 * Return the XML object as an XML string
	 * 
	 * @return string
	 */
	public function asXML($todo_for_empty_elements = true, $indent = "\t")
	{
		return $this->_root->asXML();
	}
}
