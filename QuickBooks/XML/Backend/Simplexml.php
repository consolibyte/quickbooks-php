<?php

QuickBooks_Loader::load('/QuickBooks/XML.php');

QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

QuickBooks_Loader::load('/QuickBooks/XML/Backend.php');

QuickBooks_Loader::load('/QuickBooks/XML/Node.php');

QuickBooks_Loader::load('/QuickBooks/XML/Document.php');

class QuickBooks_XML_Backend_SimpleXML implements QuickBooks_XML_Backend
{
	protected $_xml;
	protected $_root;
	
	public function __construct($xml)
	{
		$this->_xml = $xml;
	}
	
	public function load($xml)
	{
		$this->_xml = $xml;
		$this->_root = null;
		
		return strlen($xml) > 0;
	}
	
	public function validate(&$errnum, &$errmsg)
	{
		// Turn off the displayed error warnings
		$previous = libxml_use_internal_errors(true);
		libxml_clear_errors();
		
		// Parse it
		$root = simplexml_load_string($this->_xml);
		
		// Check for errors
		$errs = libxml_get_errors();

		$pcdata_chars = 'PCDATA invalid Char';
		if (count($errs) > 0 and 
			substr($errs[0]->message, 0, strlen($pcdata_chars)) == $pcdata_chars)
		{
			// Try to remove special chars, and try again
			libxml_clear_errors();

			$this->_xml = preg_replace ('/[^\x{0009}\x{000a}\x{000d}\x{0020}-\x{D7FF}\x{E000}-\x{FFFD}]+/u', ' ', $this->_xml);
			$root = simplexml_load_string($this->_xml);
			$errs = libxml_get_errors();

			//die('this ran!  ' . print_r($errs, true));
		}

		//print_r($errs);
		//exit;
		
		// Reset it to it's previous state
		libxml_clear_errors();
		libxml_use_internal_errors($previous);
		
		if (is_array($errs) and 
			count($errs))
		{
			$errnum = QuickBooks_XML::ERROR_INTERNAL;
			
			$errmsg = '';
			$tmp = array();
			foreach ($errs as $err)
			{
				$tmp[] = '{' . $err->code . ': ' . trim($err->message) . ' on line ' . $err->line . '}';
			}
			$errmsg = implode(', ', $tmp);
			
			return false;
		}
		else
		{
			$this->_root = $root;
			$errnum = QuickBooks_XML::ERROR_OK;
			return true;
		}
	}
	
	public function parse(&$errnum, &$errmsg)
	{
		if ($this->validate($errnum, $errmsg))
		{
			$Root = new QuickBooks_XML_Node($this->_root->getName());
			
			$Root = $this->_parseHelper($Root, $this->_root);
			
			//exit;
			return new QuickBooks_XML_Document($Root);
		}
		
		// Don't worry about the error code, validate() will take care of that
		return false;
	}
	
	protected function _parseHelper($Base, $simplexml_node, $data = '')
	{
		$children = $simplexml_node->children();
		
		$Base->setData($data);
		
		foreach ($children as $simplexml_child)
		{
			$children = $simplexml_child->children();
			
			$Child = new QuickBooks_XML_Node($simplexml_child->getName());
			
			$data = '';
			$children = $simplexml_child->children();
			if (count($children) == 0)
			{
				$data = $simplexml_child . '';
			}
			
			$Child = $this->_parseHelper($Child, $simplexml_child, $data);
			
			$Base->addChild($Child);
		}
		
		foreach ($simplexml_node->attributes() as $key => $value)
		{
			$Base->addAttribute($key, $value . '');
		}
		
		return $Base;
	}
}