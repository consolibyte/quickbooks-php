<?php

/**
 * QuickBooks XML node - individual tags within an XML document
 * 
 * @todo YAML exporting *does not* work correctly
 * @todo Array exporting *does not* work correctly
 * @todo JSON exporting *does not* work correctly
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage XML
 */

/**
 * QuickBooks XML node
 */
class QuickBooks_XML_Node
{
	/**
	 * Tag name
	 * @var string
	 */
	protected $_name;
	
	/**
	 * Tag data
	 * @var string
	 */
	protected $_data;

	/**
	 * An associative array of attributes for this tag
	 * @var array
	 */
	protected $_attributes;
	
	/**
	 * A string containing comments that were found immediately after this tag
	 * @var string
	 */
	protected $_comment;
	
	/**
	 * An array of child tags within this tag
	 * @var array
	 */
	protected $_children;
	
	/**
	 * Create a new XML node
	 * 
	 * @param string $name
	 * @param string $data
	 */
	public function __construct($name = null, $data = null)
	{
		$this->_name = $name;
		
		$this->_data = $data;
		$this->_children = array();
		$this->_attributes = array();
	}
	
	/**
	 * Add a child tag (another node) to this tag
	 * 
	 * @param QuickBooks_XML_Node $node
	 * @param boolean $prepend
	 * @return boolean
	 */
	public function addChild($node, $prepend = false)
	{
		if ($prepend)
		{
			array_unshift($this->_children, $node);
		}
		else
		{
			$this->_children[] = $node;
		}
		
		return true;
	}
	
	/**
	 * Add an attribute to this XML tag/node
	 * 
	 * @param string $attr		The attribute name
	 * @param mixed $value		The attribute value
	 * @return boolean
	 */
	public function addAttribute($attr, $value)
	{
		$this->_attributes[$attr] = $value;
		return true;
	}
	
	/**
	 * Set an attribute in this XML tag/node
	 * 
	 * @param string $attr
	 * @param mixed $value
	 * @return boolean 
	 */
	public function setAttribute($attr, $value)
	{
		return $this->addAttribute($attr, $value);
	}
	
	/**
	 * Get an attribute from this XML tag/node
	 * 
	 * @param string $attr
	 * @return mixed
	 */
	public function getAttribute($attr)
	{
		if ($this->attributeExists($attr))
		{
			return $this->_attributes[$attr];
		}
		
		return false;
	}
	
	/**
	 * Tell whether or not an attribute exists
	 * 
	 * @param string $attr
	 * @return boolean
	 */
	public function attributeExists($attr)
	{
		return isset($this->_attributes[$attr]);
	}
	
	/**
	 * Set the name of this tag/node
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function setName($name)
	{
		$this->_name = $name;
		return true;
	}
	
	/**
	 * Set the data contained by the XML node
	 * 
	 * @param string
	 * @return boolean
	 */
	public function setData($data)
	{
		$this->_data = $data;
		return true;
	}

	/**
	 *
	 * @param <type> $path
	 * @param <type> $attr
	 * @param <type> $value 
	 */
	public function setChildAttributeAt($path, $attr, $value, $create = false)
	{
		if ($child = $this->getChildAt($path))
		{
			if ($child->attributeExists($attr))
			{
				$child->setAttribute($attr, $value);
			}
			else
			{
				$child->addAttribute($attr, $value);
			}
		}
		else if ($create)
		{
			$this->setChildDataAt($path, null, true);
			return $this->setChildAttributeAt($path, $attr, $value, false);
		}
		
		return false;
	}
	
	/**
	 * Recursive helper function - get child at location
	 * 
	 * @param QuickBooks_XML_Node $root
	 * @param string $path
	 * @return QuickBooks_XML_Node
	 */
	protected function _getChildAtHelper($root, $path)
	{
		if (false !== strpos($path, ' ') and false === strpos($path, '/'))
		{
			$path = str_replace(' ', '/', $path);
		}
		
		$explode = explode('/', $path);
		//$explode = explode(' ', $path);
		$current = array_shift($explode);
		$next = current($explode);
		
		if ($path == $root->name())
		{
			return $root;
		}
		else if ($current == $root->name())
		{
			$path = implode('/', $explode);
			
			foreach ($root->children() as $child)
			{
				if ($child->name() == $next)
				{
					return $this->_getChildAtHelper($child, $path);
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Get the data segment of an XML child node at a particular path
	 * 
	 * @param string $path
	 * @return mixed
	 */
	public function getChildDataAt($path)
	{
		if ($child = $this->getChildAt($path))
		{
			return $child->data();
		}
		
		return false;
	}
	
	/**
	 * Get a child XML node at a particular path
	 * 
	 * @param string $path
	 * @return QuickBooks_XML_Node
	 */
	public function getChildAt($path)
	{
		return $this->_getChildAtHelper($this, $path);
	}
	
	/**
	 * 
	 * 
	 * @param <type> $path
	 * @return <type> 
	 */
	public function childExistsAt($path)
	{
		$child = $this->getChildAt($path);
		return is_object($child);
	}
	
	/**
	 * Add a child XML node at a particular path
	 * 
	 * @param string $path
	 * @param QuickBooks_XML_Node $child
	 * @param boolean $create
	 * @return boolean
	 */
	public function addChildAt($path, $node, $create = false)
	{
		return $this->_addChildAtHelper($this, $path, $node, $create);
	}
	
	/**
	 * 
	 * 
	 * @param QuickBooks_XML_Node $root
	 * @param string $path
	 * @param QuickBooks_XML_Node $child
	 * @param boolean $create
	 * @return boolean
	 */
	protected function _addChildAtHelper(&$root, $path, $node, $create = false)
	{
		if (false !== strpos($path, ' ') and false === strpos($path, '/'))
		{
			$path = str_replace(' ', '/', $path);
		}
		
		$explode = explode('/', $path);
		/*$explode = explode(' ', $path);*/
		$current = array_shift($explode);
		$next = current($explode);
		
		if ($path == $root->name())
		{
			return $root->addChild($node);
		}
		else
		{
			$path = implode('/', $explode);
			
			foreach ($root->children() as $child)
			{
				if ($child->name() == $next)
				{
					return $this->_addChildAtHelper($child, $path, $node, $create);
				}
			}
		}
		
		if ($create)
		{
			$root->addChild(new QuickBooks_XML_Node($next));
			foreach ($root->children() as $child)
			{
				if ($child->name() == $next)
				{
					return $this->_addChildAtHelper($child, $path, $node, $create);
				}
			}
		}
		
		return false;
	}
	
	public function setChildDataAt($path, $data, $create = false)
	{
		if (false !== strpos($path, ' ') and false === strpos($path, '/'))
		{
			$path = str_replace(' ', '/', $path);
		}
		
		$explode = explode('/', $path);
		$allbutend = implode('/', array_slice($explode, 0, -1));
		
		/*
		$explode = explode(' ', $path);
		$allbutend = implode(' ', array_slice($explode, 0, -1));
		*/
		
		$end = end($explode);
		
		$child = $this->getChildAt($path);
		
		if (!$child and $create)
		{
			$this->addChildAt($allbutend, new QuickBooks_XML_Node($end), true);
			$child = $this->getChildAt($path);
		}
		
		if ($child)
		{
			$child->setData($data);
		}
		
		return false;
	}
	
	/**
	 * Get a child XML node's attributes (associative array)
	 * 
	 * @param string $path
	 * @return array 
	 */
	public function getChildAttributesAt($path)
	{
		if ($child = $this->getChildAt($path))
		{
			return $child->attributes();
		}
		
		return false;
	}
	
	/**
	 * 
	 */
	protected function _pathHelper()
	{
		
	}
	
	/**
	 * 
	 */
	public function path($path)
	{
		
	}
	
	/**
	 * 
	 */
	protected function _getChildByTagHelper()
	{
		
	}
	
	/**
	 * 
	 */
	public function getChildByTag($name)
	{
		
	}
	
	/**
	 * 
	 * 
	 * @param string $pattern
	 * @param string $str
	 * @return boolean
	 */
	static protected function _fnmatch($pattern, $str)
	{
		$arr = array(
			'\*' => '.*', 
			'\?' => '.'
			);
		return preg_match('#^' . strtr(preg_quote($pattern, '#'), $arr) . '$#i', $str);
	}
	
	/**
	 * Get an array of child nodes for this XML node
	 * 
	 * @param string $pattern
	 * @return array
	 */
	public function children($pattern = null)
	{
		if (!is_null($pattern))
		{
			$list = array();
			
			foreach ($this->_children as $Child)
			{
				if ($this->_fnmatch($pattern, $Child->name()))
				{
					$list[] = $Child;
				}
			}
			
			return $list;
		}
		
		return $this->_children;
	}
	
	/**
	 * Get the data contained by this XML node
	 * 
	 * @return mixed 
	 */
	public function data()
	{
		return $this->_data;
	}
	
	/**
	 * Tell whether or not this XML node contains data
	 * 
	 * @return boolean
	 */
	public function hasData()
	{
		return strlen($this->_data) > 0;
	}
	
	/**
	 * Set a comment for this node
	 * 
	 * @param string $comment
	 * @return boolean
	 */
	public function setComment($comment)
	{
		$this->_comment = $comment;
		return true;
	}
	
	/**
	 * Retrieve any comment set for this XML node
	 * 
	 * @return string
	 */
	public function comment()
	{
		return $this->_comment;
	}
	
	/**
	 * Tell whether or not this XML node contains a comment
	 * 
	 * @return boolean
	 */
	public function hasComment()
	{
		return strlen($this->_comment) > 0;
	}
	
	/**
	 * Tell the name of this XML node/tag
	 * 
	 * @return string
	 */
	public function name()
	{
		return $this->_name;
	}
	
	/**
	 * Get an associative array of attributes the XML node contains
	 * 
	 * @return array
	 */
	public function attributes()
	{
		return $this->_attributes;
	}
	
	/**
	 * Tell how many child elements this particular XML node has
	 * 
	 * @return integer
	 */
	public function childCount()
	{
		return count($this->_children);
	}
	
	/**
	 * Tell whether or not this XML node has any children
	 * 
	 * @return boolean
	 */
	public function hasChildNodes()
	{
		return $this->childCount() > 0;
	}
	
	/**
	 * Alias of {@link QuickBooks_XML_Node::hasChildNodes()}
	 */
	public function hasChildren()
	{
		return $this->hasChildNodes();
	}
	
	/**
	 * Tell how many attributes this particular XML node has
	 * 
	 * @return integer
	 */
	public function attributeCount()
	{
		return count($this->_attributes);
	}
	
	public function removeChild($which)
	{
		if (isset($this->_children[$which]))
		{
			unset($this->_children[$which]);
			$this->_children = array_merge($this->_children);
			
			return true;
		}
		
		return false;
	}
	
	public function replaceChild($which, $node)
	{
		
	}
	
	public function getChild($which)
	{
		if (isset($this->_children[$which]))
		{
			return $this->_children[$which];
		}
		
		return null;
	}
	
	public function normalize()
	{
		
	}
	
	public function equals($node, $recurse = true)
	{
		
	}
	
	public function getElementById()
	{
		
	}
	
	public function getElementByTagName()
	{
		
	}
	
	public function hasAttributes()
	{
		return $this->attributeCount() > 0;
	}
	
	/**
	 * Remove an attribute from the XML node
	 * 
	 * @param string $attr
	 * @return boolean
	 */
	public function removeAttribute($attr)
	{
		if ($this->attributeExists($attr))
		{
			unset($this->_attributes[$attr]);
			return true;
		}
		
		return false;
	}
	
	/**
	 * Resursive helper function for converting to XML
	 * 
	 * @param QuickBooks_XML_Node $node
	 * @param integer $tabs
	 * @param boolean $empty				A constant, one of: QUICKBOOKS_XML_XML_PRESERVE, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_COMPRESS
	 * @param string $indent
	 * @return string
	 */
	public function _asXMLHelper($node, $tabs, $empty, $indent)
	{
		$xml = '';
		
		if ($node->childCount())
		{
			$xml .= str_repeat($indent, $tabs) . '<' . $node->name();
			
			foreach ($node->attributes() as $key => $value)
			{
				// Make sure double-encode is *off* 
				//$xml .= ' ' . $key . '="' . QuickBooks_XML::encode($value, true, false) . '"';
				$xml .= ' ' . $key . '="' . QuickBooks_XML::encode($value) . '"';
			}
			
			$xml .= '>' . "\n";
			foreach ($node->children() as $child)
			{
				$xml .= $this->_asXMLHelper($child, $tabs + 1, $empty, $indent);
			}
			$xml .= str_repeat($indent, $tabs) . '</' . $node->name() . '>' . "\n";
		}
		else
		{
			if ($node->hasAttributes())		// if the node has attributes, we'll build the whole thing no matter what
			{
				$xml .= str_repeat($indent, $tabs) . '<' . $node->name();
				
				foreach ($node->attributes() as $key => $value)
				{
					// Double-encode is *off*
					//$xml .= ' ' . $key . '="' . QuickBooks_XML::encode($value, true, false) . '"';
					$xml .= ' ' . $key . '="' . QuickBooks_XML::encode($value) . '"';
				}
				
				// Double-encode is *off*
				//$xml .= '>' . QuickBooks_XML::encode($node->data(), true, false) . '</' . $node->name() . '>' . "\n";
				$xml .= '>' . QuickBooks_XML::encode($node->data()) . '</' . $node->name() . '>' . "\n";
			}
			else
			{
				if ($node->hasData() or $empty == QUICKBOOKS_XML_XML_PRESERVE)
				{
					// Double-encode is *off*
					//$xml .= str_repeat($indent, $tabs) . '<' . $node->name() . '>' . QuickBooks_XML::encode($node->data(), true, false) . '</' . $node->name() . '>' . "\n";
					$xml .= str_repeat($indent, $tabs) . '<' . $node->name() . '>' . QuickBooks_XML::encode($node->data()) . '</' . $node->name() . '>' . "\n";
				}
				else if ($empty == QUICKBOOKS_XML_XML_COMPRESS)
				{
					$xml .= str_repeat($indent, $tabs) . '<' . $node->name() . ' />' . "\n";
				}
				else if ($empty == QUICKBOOKS_XML_XML_DROP)
				{
					; // do nothing, drop the empty element
				}
			}
			
			/*
			$xml .= str_repeat($indent, $tabs) . '<' . $node->name();
			
			foreach ($node->attributes() as $key => $value)
			{
				$xml .= ' ' . $key . '="' . htmlentities($value, ENT_QUOTES) . '"';
			}
			
			if ($node->data())
			{
				$xml .= '>' . htmlentities($node->data()) . '</' . $node->name() . '>' . "\n";
			}
			else if ($compress)
			{
				$xml .= ' />' . "\n";
			}
			else
			{
				$xml .= '></' . $node->name() . '>' . "\n";
			}
			*/
		}
		
		return $xml;
	}
	
	/**
	 * Get an XML representation of this XML node and it's child XML nodes
	 * 
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE
	 * @param string $indent					The character to use to indent the XML with
	 * @return string
	 */
	public function asXML($todo_for_empty_elements = true, $indent = "\t")
	{
		return $this->_asXMLHelper($this, 0, $todo_for_empty_elements, $indent);
	}
	
	/**
	 * 
	 */
	protected function _asJSONHelper($node, $tabs, $indent)
	{
		$json = '';
		
		if ($node->childCount() or $node->attributeCount())	// container elements surrounded with { ... }
		{
			$json .= str_repeat($indent, $tabs) . $node->name() . ':{' . "\n";
			
			$list = array();
			foreach ($node->children() as $child)
			{
				$json .= $this->_asJSONHelper($child, $tabs + 1, $indent);
			}
		
			foreach ($node->attributes() as $key => $value)
			{
				$json .= str_repeat($indent, $tabs) . '"' . $key . '": "' . $value . '", ' . "\n";
			}
			
			$json .= "\n" . str_repeat($indent, $tabs) . '}';
		}
		else
		{
			$json .= str_repeat($indent, $tabs) . '"' . $node->name() . '": "' . $node->data() . '", ' . "\n";
		}
		
		return $json;
	}
	
	/**
	 * Get a JSON representation of this XML node
	 * 
	 * @return string
	 */
	public function asJSON($indent = "\t")
	{
		return '{' . "\n" . $this->_asJSONHelper($this, 1, $indent) . '}'; 
	}
	
	/**
	 * Get an array represtation of this XML node
	 * 
	 * @param string $mode
	 * @return array 
	 */
	public function asArray($mode = QUICKBOOKS_XML_ARRAY_NOATTRIBUTES)
	{
		switch ($mode)
		{
			case QUICKBOOKS_XML_ARRAY_EXPANDATTRIBUTES:
				return $this->_asArrayExpandAttributesHelper($this);
			case QUICKBOOKS_XML_ARRAY_BRANCHED:
				return $this->_asArrayBranchedHelper($this);
			case QUICKBOOKS_XML_ARRAY_PATHS:
				
				$current = '';
				$paths = array();
				$this->_asArrayPathsHelper($this, $current, $paths);
				
				return $paths;
			case QUICKBOOKS_XML_ARRAY_NOATTRIBUTES:
			default:
				return $this->_asArrayNoAttributesHelper($this);
		}
	}
	
	/**
	 * Helper function for converting to an array mapping paths to tag values
	 * 
	 * @param QuickBooks_XML_Node $node
	 * @param string $current
	 * @param array $paths
	 * @return void
	 */
	protected function _asArrayPathsHelper($node, $current, &$paths)
	{
		if ($node->hasChildNodes())
		{
			foreach ($node->children() as $child)
			{
				$this->_asArrayPathsHelper($child, $current . ' ' . $node->name(), $paths);
			}
		}
		else if ($node->hasData())
		{
			$paths[trim($current . ' ' . $node->name())] = $node->data();
		}
	}
	
	/**
	 * Save this XML node structure as an XML file
	 * 
	 * @param mixed $path_or_resource			The filepath of the file you want write to *or* an opened file resource
	 * @param string $mode						The mode to open the file in
	 * @param boolean $todo_for_empty_elements	A constant, one of: QUICKBOOKS_XML_XML_COMPRESS, QUICKBOOKS_XML_XML_DROP, QUICKBOOKS_XML_XML_PRESERVE 
	 * @return integer							The number of bytes written to the file
	 */
	public function saveXML($path_or_resource, $mode = 'wb', $todo_for_empty_elements = QUICKBOOKS_XML_XML_COMPRESS)
	{
		$xml = $this->asXML($todo_for_empty_elements);
		
		if (is_resource($path_or_resource))
		{
			return fwrite($path_or_resource, $xml);
		}
		
		$fp = fopen($path_or_resource, $mode);
		$bytes = fwrite($fp, $xml);
		fclose($fp);
		
		return $bytes;
	}
	
	/**
	 * Save the XML node structure as a JSON document
	 * 
	 * @param mixed $path_or_resource
	 * @param string $mode
	 * @return integer 
	 */
	public function saveJSON($path_or_resource, $mode = 'wb')
	{
		$json = $this->_root->asJSON();
		
		if (is_resource($path_or_resource))
		{
			return fwrite($path_or_resource, $json);
		}
		
		$fp = fopen($path_or_resource, $mode);
		$bytes = fwrite($fp, $json);
		fclose($fp);
		
		return $bytes;
	}
	
	/**
	 * Get a YAML representation of this XML node
	 * 
	 * @return string
	 */
	public function asYAML()
	{
		
	}
	
	/**
	 * Save a YAML representation of this XML node structure to disk 
	 * 
	 * @param mixed $path_or_resource
	 * @param string $mode
	 * @return integer
	 */
	public function saveYAML($path_or_resource, $mode = 'wb')
	{
		
	}
}

?>