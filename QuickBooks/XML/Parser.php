<?php

/**
 * Simple QuickBooks XML parsing class
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
	 * The complete string XML document contents
	 * @var string
	 */
	protected $_xml;
	
	/**
	 * The root node
	 * @var QuickBooks_XML_Node
	 */
	protected $_root;
	
	/**
	 * Create a new QuickBooks_XML parser object
	 * 
	 * @param string $xml_or_file
	 */
	public function __construct($xml_or_file = null)
	{
		$xml_or_file = $this->_read($xml_or_file);
		
		$this->_xml = $xml_or_file;
		$this->_root = new QuickBooks_XML_Node();
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
		else if (is_resource($mixed) and get_resource_type($mixed) == 'stream')
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
		$this->_root = new QuickBooks_XML_Node();
		
		return strlen($xml_or_file);
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
		if (!strlen($this->_xml))
		{
			return false;
		}
		
		$stack = array();
		$xml = $this->_xml;
		

		// Remove comments
		while (false !== strpos($xml, '<!--'))
		{
			$start = strpos($xml, '<!--');
			$end = strpos($xml, '-->', $start);

			if (false !== $start and false !== $end)
			{
				$xml = substr($xml, 0, $start) . substr($xml, $end + 3);
			}
			else
			{
				break;
			}
		}
		
		// Remove <![CDATA[ sections
		$has_cdata = false;
		while (false !== strpos($xml, '<![CDATA['))
		{
			$has_cdata = true;
			
			$start = strpos($xml, '<![CDATA[');
			$end = strpos($xml, ']]>', $start);
			
			if (false !== $start and false !== $end)
			{
				$xml = substr($xml, 0, $start) . substr($xml, $end + 3);
			}
			else
			{
				break;
			}
		}	
		
		// Check well-formedness
		while (false !== strpos($xml, '<'))
		{
			$opentag_start = strpos($xml, '<');
			$opentag_end = strpos($xml, '>');
			
			$tag_w_attrs = trim(substr($xml, $opentag_start + 1, $opentag_end - $opentag_start - 1));
			
			$tag = '';
			$attributes = array();
			$this->_extractAttributes($tag_w_attrs, $tag, $attributes);
			
			if (substr($tag_w_attrs, 0, 1) == '?')			// <?xml 
			{
				// ignore
			}
			else if (substr($tag_w_attrs, 0, 1) == '!')		// <!DOCTYPE 
			{
				// ignore
			}
			//else if (substr($tag_w_attrs, 0, 3) == '!--')	// <!-- comment
			//{
			//	// ignore
			//}
			else if (substr($tag_w_attrs, -1, 1) == '/')
			{
				// completely ignore, auto-closed because it has no children
			} 
			else if (substr($tag_w_attrs, 0, 1) == '/')		// close tag
			{
				$tag = substr($tag, 1);
				
				$pop = array_shift($stack);
				
				if ($pop != $tag)
				{
					$errnum = QUICKBOOKS_XML_ERROR_MISMATCH;
					$errmsg = 'Mismatched tags, found: ' . $tag . ', expected: ' . $pop;
					
					return false;
				}
			}
			else	// open tag
			{
				array_unshift($stack, $tag);
			}
			
			$xml = trim(substr($xml, $opentag_end + 1));
		}
		
		if (strlen($xml))
		{
			$errnum = QuickBooks_XML::ERROR_GARBAGE;
			$errmsg = 'Found this garbage data at end of stream: ' . $xml;
			return false;
		}
		
		if (count($stack))
		{
			$errnum = QuickBooks_XML::ERROR_DANGLING;
			$errmsg = 'XML stack still contains this after parsing: ' . var_export($stack, true);
			return false;
		}
		
		return true;
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
			return false;
		}
		
		// first, let's remove all of the comments
		if ($this->validate($errnum, $errmsg))
		{
			$base = new QuickBooks_XML_Node('root');
			$this->_parseHelper($this->_xml, $base, $errnum, $errmsg);
			
			if ($errnum != QuickBooks_XML::ERROR_OK)
			{
				return false;
			}
			
			$tmp = $base->children();
			
			return new QuickBooks_XML_Document(current($tmp));
		}
		
		return false;
	}
	
	/**
	 * XML parsing recursive helper function
	 * 
	 * @param string $xml
	 * @param QuickBooks_XML_Node $root
	 * @return void
	 */
	protected function _parseHelper($xml, &$Root, &$errnum, &$errmsg, $indent = 0)
	{
		$errnum = QuickBooks_XML::ERROR_OK;
		$errmsg = '';
		
		$arr = array();
		$xml = trim($xml);

		if (!strlen($xml))
		{
			return false;
		}

		$data = '';

		$vstack = array();
		$dstack = array();

		// Remove comments
		while (false !== strpos($xml, '<!--'))
		{
			$start = strpos($xml, '<!--');
			$end = strpos($xml, '-->', $start);

			if (false !== $start and false !== $end)
			{
				$xml = substr($xml, 0, $start) . substr($xml, $end + 3);
			}
			else
			{
				break;
			}
		}

		$raw = $xml;
		$current = 0;
		$last = '';

		$i = 0;

		// Parse
		while (false !== strpos($xml, '<'))
		{
			/*
			print('now examinging:');
			print('--------------');
			print($xml);
			print('-----------');
			print("\n\n\n");
			*/
			
			$opentag_start = strpos($xml, '<');
			$opentag_end = strpos($xml, '>');
			
			// CDATA check
			if (substr($xml, $opentag_start, 3) == '<![')
			{
				// Find the end of the CDATA section
				$cdata_end = strpos($xml, ']]>');
				
				$opentag_start = strpos($xml, '<', $cdata_end + 3);
				$opentag_end = strpos($xml, '>', $cdata_end + 3);
			}
			
			//print('opentag start/end (' . $opentag_start . ', ' . $opentag_end . ') puts us at: {{' . substr($xml, $opentag_start, $opentag_end - $opentag_start) . '}}' . "\n\n");
			
			$tag_w_attrs = trim(substr($xml, $opentag_start + 1, $opentag_end - $opentag_start - 1));
			
			$tag = '';
			$attributes = array();
			$this->_extractAttributes($tag_w_attrs, $tag, $attributes);
			
			if (substr($tag_w_attrs, 0, 1) == '?')		// xml declration
			{
				// ignore
			}
			else if (substr($tag_w_attrs, 0, 1) == '!')
			{
				// ignore
			}
			//else if (substr($tag_w_attrs, 0, 3) == '!--')		// comment
			//{
			//	// ignore
			//}
			else if (substr($tag_w_attrs, -1, 1) == '/')
			{
				// ***DO NOT*** completely ignore, auto-closed because it has no children
				// Completely ignoring causes some SOAP errors for requests like <serverVersion xmlns="http://developer.intuit.com/" />
				
				// Shove the item on to the stack
				array_unshift($vstack, array( $tag, $tag_w_attrs, $current + $opentag_end ) );
				array_unshift($dstack, array( $tag, $tag_w_attrs, $current + $opentag_end ) );
				
				$key = key($vstack);
				$tmp = array_shift($vstack);
				
				$pop = $tag;
				$gnk = $tag_w_attrs;
				$pos = $current + $opentag_end;
				
				// there is no data, so empty data and the length is 0
				$length = 0;
				$data = null;
				
				if (count($vstack))
				{
					array_shift($dstack);
				}
				else
				{
					$dstack[$key] = array( $pop, $gnk, $pos, $length, $data );
				}
			}
			else if (substr($tag_w_attrs, 0, 1) == '/')		// close tag
			{
				// NOTE: If you change the code here, you'll likely have to 
				//	change it in the above else () section as well, as that 
				//	section handles data-less tags like <serverVersion />
				
				$tag = substr($tag, 1);
				
				$key = key($vstack);
				$tmp = array_shift($vstack);
				
				$pop = $tmp[0];
				$gnk = $tmp[1];
				$pos = $tmp[2];
				
				if ($pop != $tag)
				{
					$errnum = QuickBooks_XML::ERROR_MISMATCH;
					$errmsg = 'Mismatched tags, found: ' . $tag . ', expected: ' . $pop;
					
					return false;
				}
				
				$data = substr($raw, $pos, $current + $opentag_start - $pos);
				
				// Handle <![CDATA[ ... ]]> sections
				if (substr($data, 0, 9) == '<![CDATA[')
				{
					$cdata_end = strpos($data, ']]>');
					
					// Set the data to the CDATA section...
					$data = QuickBooks_XML::encode(substr($data, 9, $cdata_end - 9));
					
					// ... and remove the CDATA from the remaining XML string
					//$current = $current + strlen($data) + 12; 
				}
				
				if (count($vstack))
				{
					array_shift($dstack);
				}
				else
				{
					$dstack[$key] = array( $pop, $gnk, $pos, $current + $opentag_start - $pos, $data );
				}
			}
			else	// open tag
			{
				array_unshift($vstack, array( $tag, $tag_w_attrs, $current + $opentag_end + 1 ) );
				array_unshift($dstack, array( $tag, $tag_w_attrs, $current + $opentag_end + 1 ) );
			}
			
			//print('stacks' . "\n");
			//print_r($vstack);
			//print_r($dstack);
			
			$xml = substr($xml, $opentag_end + 1);
			
			$current = $current + $opentag_end + 1;
		}

		if (strlen($xml))
		{
			$errnum = QuickBooks_XML::ERROR_GARBAGE;
			$errmsg = 'Found this garbage data at end of stream: ' . $xml;
			return false;
		}

		if (count($vstack))
		{
			$errnum = QuickBooks_XML::ERROR_DANGLING;
			$errmsg = 'XML stack still contains this after parsing: ' . var_export($vstack, true);
			return false;
		}

		//print_r($dstack);
		//exit;
		
		$dstack = array_reverse($dstack);

		$last = '';
		foreach ($dstack as $node)
		{
			$tag = $node[0];
			$tag_w_attrs = $node[1];
			$start = $node[2];

			if (count($node) < 5)
			{
				continue;
			}

			$length = $node[3];
			$payload = $node[4];

			$tmp = '';
			$attributes = array();
			$this->_extractAttributes($tag_w_attrs, $tmp, $attributes);
			
			$Node = new QuickBooks_XML_Node($tag);
			foreach ($attributes as $key => $value)
			{
				$value = QuickBooks_XML::decode($value, true);
				
				$Node->addAttribute($key, $value);
			}
			
			if (false !== strpos($payload, '<'))
			{
				// The tag contains child tags 
				
				$tmp = $this->_parseHelper($payload, $Node, $errnum, $errmsg, $indent + 1);
				if (!$tmp)
				{
					return false;
				}
			}
			else
			{
				// This tag has no child tags contained inside it
				
				// Make sure we decode any entities
				$payload = QuickBooks_XML::decode($payload, true);
				
				$Node->setData($payload);
			}

			$Root->addChild($Node);

			$last = $tag;
		}

		return $Root;
	}
	
	protected function _extractAttributes($tag_w_attrs, &$tag, &$attributes)
	{
		$tag = '';
		$attributes = array();
		
		$tmp = QuickBooks_XML::extractTagAttributes($tag_w_attrs, true);
		
		$tag = array_shift($tmp);
		$attributes = $tmp;
		
		/*
		print('extracting attributes from: {{' . $tag_w_attrs . '}}' . "\n");
		print('	tag: [[' . $tag . ']]' . "\n");
		print('	attrs: ' . print_r($attributes, true) . "\n");
		print("\n");
		*/
		
		return true;
	}
}
