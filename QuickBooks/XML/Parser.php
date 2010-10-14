<?php

/**
 * Simple QuickBooks XML parsing class
 * 
 * Copyright (c) 2010-04-16 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * This is intended as a simple alternative to the PHP SimpleXML or DOM 
 * extensions (some of the machines I'm working on don't have the SimpleXML 
 * extension enabled) for parsing XML documents. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage XML
 */

/**
 * XML base constants
 */
QuickBooks_Loader::load('/QuickBooks/XML.php');

/**
 * XML_Node class
 */
QuickBooks_Loader::load('/QuickBooks/XML/Node.php');

/**
 * XML_Document class
 */
QuickBooks_Loader::load('/QuickBooks/XML/Document.php');

/**
 * XML backend interface
 */
QuickBooks_Loader::load('/QuickBooks/XML/Backend.php');

/**
 * XML parser backends
 */
QuickBooks_Loader::import('/QuickBooks/XML/Backend');

/**
 * QuickBooks XML Parser
 * 
 * Create an instance of the QuickBooks_XML parser by calling the constructor 
 * with either a file-path or the contents of an XML document. 
 * <code>
 * $xml = '<Tag1><NestedTag age="25" gender="male"><AnotherTag>Keith</AnotherTag></NestedTag></Tag1>';
 * 
 * // Create the new object
 * $Parser = new QuickBooks_XML_Parser($xml);
 * 
 * // Parse the XML document
 * $errnum = 0;
 * $errmsg = '';
 * if ($Parser->validate($errnum, $errmsg))
 * {
 * 	$Doc = $Parser->parse($errnum, $errmsg);
 * 	
 * 	// Now fetch some stuff from the parsed document
 * 	print('Hello there ' . $Doc->getChildDataAt('Tag1 NestedTag AnotherTag') . "\n");
 * 	print_r($Doc->getChildAttributesAt('Tag1 NestedTag'));
 * 	print("\n");
 * 	print('Root tag name is: ' . $Doc->name() . "\n");
 * 
 * 	$NestedTag = $Doc->getChildAt('Tag1 NestedTag');
 * 	print_r($NestedTag);
 * }
 * </code>
 */
class QuickBooks_XML_Parser
{
	/**
	 * 
	 */
	protected $_xml;
	 
	/**
	 * What back-end XML parser to use
	 * @var string
	 */
	protected $_backend;
	
	/**
	 * 
	 */
	const BACKEND_SIMPLEXML = 'simplexml';
	
	/**
	 * 
	 */
	const BACKEND_BUILTIN = 'builtin';
	
	/**
	 * Create a new QuickBooks_XML parser object
	 * 
	 * @param string $xml_or_file
	 */
	public function __construct($xml_or_file = null, $use_backend = null)
	{
		$xml_or_file = $this->_read($xml_or_file);
		
		$this->_xml = $xml_or_file;
		
		if (is_null($use_backend) and 
			function_exists('simplexml_load_string'))
		{
			$use_backend = QuickBooks_XML::PARSER_SIMPLEXML;
		}
		else if (is_null($use_backend))
		{
			$use_backend = QuickBooks_XML::PARSER_BUILTIN;
		}
		
		$class = 'QuickBooks_XML_Backend_' . ucfirst(strtolower($use_backend));
		$this->_backend = new $class($xml_or_file);
	}
	
	/**
	 * Read an open file descriptor, XML file, or string
	 * 
	 * @param mixed $mixed
	 * @return string
	 */
	protected function _read($mixed)
	{
		if (empty($mixed))
		{
			return '';
		}
		else if (is_resource($mixed) and 
			get_resource_type($mixed) == 'stream')
		{
			$buffer = '';
			$tmp = '';
			while ($tmp = fread($mixed, 8192))
			{
				$buffer .= $tmp;
			}
			
			return $buffer;
		}
		else if (substr(trim($mixed), 0, 1) != '<')
		{
			return file_get_contents($mixed);
		}
		
		return $mixed;
	}
	
	/**
	 * Load the XML parser with data from a string or file
	 * 
	 * @param string $xml_or_file		An XML string or 
	 * @return integer
	 */
	public function load($xml_or_file)
	{
		$xml_or_file = $this->_read($xml_or_file);
		
		$this->_xml = $xml_or_file;
		return $this->_backend->load($xml_or_file);
	}
	
	/**
	 * Check if the XML document is valid
	 * 
	 * *** WARNING *** This does not check against the actual QuickBooks 
	 * schemas, and in reality even the XML validation stuff it *does* do is 
	 * pretty light. You should probably double check any validation you're 
	 * doing in a better XML validator.  
	 * 
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return boolean 
	 */
	public function validate(&$errnum, &$errmsg)
	{
		return $this->_backend->validate($errnum, $errmsg);
	}
	
	/**
	 * 
	 */
	public function beautify(&$errnum, &$errmsg, $compress_empty_elements = true)
	{
		$errnum = 0;
		$errmsg = '';
		
		$Node = $this->parse($errnum, $errmsg);
		
		if (!$errnum and is_object($Node))
		{
			return $Node->asXML($compress_empty_elements);
		}
		
		return false;
	}
	
	/**
	 * Parse an XML document into an XML node structure
	 * 
	 * This function returns either a QuickBooks_XML_Node on success, or false 
	 * on failure. You can use the ->validate() method first so you can tell 
	 * whether or not the parser will succeed.
	 * 
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return QuickBooks_XML_Node
	 */
	public function parse(&$errnum, &$errmsg)
	{
		if (!strlen($this->_xml))
		{
			$errnum = QuickBooks_XML::ERROR_CONTENT;
			$errmsg = 'No XML content to parse.';
			return false;
		}
		
		// first, let's remove all of the comments
		if ($this->validate($errnum, $errmsg))
		{
			return $this->_backend->parse($errnum, $errmsg);
		}
		
		return false;
	}
	
	public function backend()
	{
		$str = get_class($this->_backend);
		return str_replace('quickbooks_xml_backend_', '', strtolower($str));
	}
}
