<?php

/**
 * XML constants (and backward compat. class)
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
 * Node class
 */
QuickBooks_Loader::load('/QuickBooks/XML/Node.php');

/**
 * Document class
 */
QuickBooks_Loader::load('/QuickBooks/XML/Document.php');

/**
 * XML parser
 */
QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

/**
 * XML backend interface
 */
QuickBooks_Loader::load('/QuickBooks/XML/Backend.php');

/**
 * XML parser backends
 */
QuickBooks_Loader::import('/QuickBooks/XML/Backend');

/**
 * QuickBooks XML base class
 */
class QuickBooks_XML
{
	/**
	 * Indicates an error *did not* occur
	 * @var integer
	 */
	const ERROR_OK = 0;
	
	/**
	 * Alias of QUICKBOOKS_XML_ERROR_OK
	 */
	const OK = 0;
	
	/**
	 * Indicates a tag mismatch/bad tag order
	 * @var integer
	 */
	const ERROR_MISMATCH = 1;
	
	/**
	 * Indicates garbage somewhere in the XML stream 
	 * @var integer
	 */
	const ERROR_GARBAGE = 2;
	
	/**
	 * Indicates a bad XML entity
	 * @var integer
	 */
	const ERROR_ENTITY = 3;
	
	/**
	 * Indicates a dangling XML attribute after parsing
	 * @var integer
	 */
	const ERROR_DANGLING = 4;
	
	/**
	 * Internal XML parser error
	 * @var integer
	 */
	const ERROR_INTERNAL = 5;
	
	/**
	 * No content to parse error
	 * @var integer
	 */
	const ERROR_CONTENT = 6;
	
	/**
	 * 
	 */
	const PARSER_BUILTIN = 'builtin';
	
	/**
	 * 
	 */
	const PARSER_SIMPLEXML = 'simplexml';
	
	/**
	 * <code>
	 * $xml = '
	 * 	<Person>
	 * 		<Name type="firstname">Keith</Name>
	 * 	</Person>
	 * ';
	 * 
	 * $arr = array(
	 * 	'Person' => array(
	 * 		'Name' => 'Keith', 
	 * 		), 
	 * 	);
	 * </code>
	 */
	const ARRAY_NOATTRIBUTES = 'no-attrs';
	
	/**
	 * 
	 * <code>
	 * $arr = array(
	 * 	'Person' => array(
	 * 		'Name' => 'Keith',
	 * 		'Name_type' => 'firstname', 
	 * 		), 
	 * 	);
	 * </code>
	 * 
	 */
	const ARRAY_EXPANDATTRIBUTES = 'child-attrs';
	
	/**
	 * <code>
	 * $arr = array(
	 * 	0 => array(
	 * 		'name' => 'Person', 
	 * 		'attributes' => array( ),
	 * 		'children' => array(
	 * 			0 => array(
	 * 				'name' => 'Name', 
	 * 				'attributes' => array( 
	 * 					'type' => 'firstname', 
	 * 				), 
	 * 				'children' => array(  ), 
	 * 				'data' => 'Keith', 
	 * 			),  
	 * 		), 
	 * 		'data' => null, 
	 * 	), 	
	 * );
	 * </code>
	 */
	const ARRAY_BRANCHED = 'branched';
	
	/**
	 * 
	 * <code>
	 * $arr = array(
	 * 	'Person Name' => 'Keith', 
	 * 	);
	 * </code>
	 * 
	 */
	const ARRAY_PATHS = 'paths';
	
	/**
	 * Flag to compress empty XML elements
	 * 
	 * <Customer>
	 * 	<FirstName>Keith</FirstName>
	 * 	<LastName />
	 * </Customer>
	 * 
	 * @note Defined as an integer for backwards compat.
	 * @var integer 
	 */
	const XML_COMPRESS = 1;
	
	/**
	 * Flag to drop empty XML elements
	 * 
	 * <Customer>
	 * 	<FirstName>Keith</FirstName>
	 * </Customer>
	 * 
	 * @note Defined as an integer for backwards compat.
	 * @var integer
	 */
	const XML_DROP = -1;

	/**
	 * Flag to preserve empty elements
	 * 
	 * <Customer>
	 * 	<FirstName>Keith</FirstName>
	 * 	<LastName></LastName>
	 * </Customer>
	 * 
	 * @note Defined as an integer for backwards compat.
	 * @var integer
	 */
	const XML_PRESERVE = 0;
	
	/**
	 * Extract the contents from a particular XML tag in an XML string
	 * 
	 * <code>
	 * $xml = '<document><stuff>bla bla</stuff><other>ble ble</other></document>';
	 * $contents = QuickBooks_Utilities::_extractTagContents('stuff', $xml);
	 * print($contents); 	// prints "bla bla"
	 * </code>
	 * 
	 * @param string $tag		The XML tag to extract the contents from 
	 * @param string $data		The XML document
	 * @return string			The contents of the tag
	 */	
	static public function extractTagContents($tag, $data)
	{
		$tag = trim($tag, '<> ');
		
		if (false !== strpos($data, '<' . $tag . '>') and 
			false !== strpos($data, '</' . $tag . '>'))
		{
			$data = strstr($data, '<' . $tag . '>');
			$end = strpos($data, '</' . $tag . '>');
			
			return substr($data, strlen($tag) + 2, $end - (strlen($tag) + 2));
		}
		
		return null;
	}		
	
	// @todo Documentation
	static public function extractTagAttribute($attribute, $tag_w_attrs, $which = 0)
	{
		/*
		if (false !== ($start = strpos($tag_w_attrs, $attribute . '="')) and 
			false !== ($end = strpos($tag_w_attrs,  '"', $start + strlen($attribute) + 2)))
		{
			return substr($tag_w_attrs, $start + strlen($attribute) + 2, $end - $start - strlen($attribute) - 2);
		}
		
		return null;
		*/
		
		$attr = $attribute;
		$data = $tag_w_attrs;
		
		if ($which == 1)
		{
			$spos = strpos($data, $attr . '="');
			$data = substr($data, $spos + strlen($attr));
		}
		
		if (false !== ($spos = strpos($data, $attr . '="')) and 
			false !== ($epos = strpos($data, '"', $spos + strlen($attr) + 2)))
		{
			//print('start: ' . $spos . "\n");
			//print('end: ' . $epos . "\n");
			
			return substr($data, $spos + strlen($attr) + 2, $epos - $spos - strlen($attr) - 2);
		}
		
		return '';
	}
	
	/**
	 * Extract the attributes from a tag container
	 * 
	 * @todo Holy confusing code Batman!
	 * 
	 * @param string $tag_w_attributes
	 * @param string $tag
	 * @param array $attributes
	 * @return void
	 */
	static public function extractTagAttributes($tag_w_attrs, $return_tag_first = false)
	{
		$tag = '';
		$attributes = array();
		
		$tag_w_attrs = trim($tag_w_attrs);
		
		/*if (substr($tag_w_attrs, -1, 1) == '/')		// condensed empty tag
		{
			$tag = trim($tag_w_attrs, '/ ');
			$attributes = array();
		}
		else*/ 
		if (false !== strpos($tag_w_attrs, ' '))
		{
			$tmp = explode(' ', $tag_w_attrs);
			//$tag = trim(array_shift($tmp), " \n\r\t<>");
			$tag = trim(array_shift($tmp));
			
			$attributes = array();
			
			$attrs = trim(implode(' ', $tmp));
			$length = strlen($attrs);
			
			$key = '';
			$value = '';
			$in_key = true;
			$in_value = false;
			$expect_key = false;
			$expect_value = false;
			
			for ($i = 0; $i < $length; $i++)
			{
				if ($attrs{$i} == '=')
				{
					$in_key = false;
					$in_value = false;
					$expect_value = true;
				}
				/*
				else if ($attrs{$i} == '"' and $expect_value)
				{
					$in_value = true;
					$expect_value = false;
				}
				*/
				/*else if ($attrs{$i} == '"' and $in_value)*/
				else if (($attrs{$i} == '"' or $attrs{$i} == '\'') and $expect_value)
				{
					$in_value = true;
					$expect_value = false;
				}
				else if (($attrs{$i} == '"' or $attrs{$i} == '\'') and $in_value)
				{
					$attributes[trim($key)] = $value;
					
					$key = '';
					$value = '';
					
					$in_value = false;
					$expect_key = true;
				}
				else if ($attrs{$i} == ' ' and $expect_key)
				{
					$expect_key = false;
					$in_key = true;
				}
				else if ($in_key)
				{
					$key .= $attrs{$i};
				}
				else if ($in_value)
				{
					$value .= $attrs{$i};
				}
			}
			
			/*
			foreach ($tmp as $attribute)
			{
				if (false !== ($pos = strpos($attribute, '=')))
				{
					$key = trim(substr($attribute, 0, $pos));
					$value = trim(substr($attribute, $pos + 1), '"');
					
					$attributes[$key] = $value;
				}
			}*/
		}
		else
		{
			$tag = $tag_w_attrs;
			$attributes = array();
		}
		
		// This returns the actual tag without attributes as the first key of the array
		if ($return_tag_first)
		{
			array_unshift($attributes, $tag);
		}
		
		return $attributes;
	}
	
	/**
	 * Encode a string for use within an XML document
	 *
	 * @todo Investigate QuickBooks qbXML encoding and implement solution
	 * 
	 * @param string $str				The string to encode
	 * @param boolean $for_qbxml		
	 * @return string
	 */
	static public function encode($str, $for_qbxml = true, $double_encode = true)
	{
		$transform = array(
			'&' => '&amp;', 
			'<' => '&lt;', 
			'>' => '&gt;', 
			//'\'' => '&apos;', 
			'"' => '&quot;', 
			);
		
		$str = str_replace(array_keys($transform), array_values($transform), $str);
		
		if (!$double_encode)
		{
			$fix = array();
			foreach ($transform as $raw => $encoded)
			{
				$fix[str_replace('&', '&amp;', $encoded)] = $encoded;
			}
			
			$str = str_replace(array_keys($fix), array_values($fix), $str);
		}
		
		return $str;
	}
	
	/**
	 * Decode a string for use within an XML document
	 *
	 * @todo Investigate QuickBooks qbXML encoding and implement solution
	 * 
	 * @param string $str				The string to encode
	 * @param boolean $for_qbxml		
	 * @return string
	 */
	static public function decode($str, $for_qbxml = true)
	{
		$transform = array(
			'&lt;' => '<', 
			'&gt;' => '>', 
			'&apos;' => '\'', 
			'&quot;' => '"', 
			'&amp;' => '&', 		// Make sure that this is *the last* transformation to run, otherwise we end up double-un-encoding things
			);
			
		return str_replace(array_keys($transform), array_values($transform), $str);		
	}
}

