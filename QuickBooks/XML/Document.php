<?php

/**
 * QuickBooks XML document class
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

?>
