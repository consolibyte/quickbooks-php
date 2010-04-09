<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 * @subpackage IPP
 */

// 
QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

// 
QuickBooks_Loader::load('/QuickBooks/XML.php');

// 
QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

/**
 * 
 * 
 */
class QuickBooks_IPP_Parser
{
	public function __construct()
	{
		
	}
	
	public function parseIDS($xml)
	{
		$Parser = new QuickBooks_XML_Parser($xml);
		
		$list = array();
		
		$errnum = QuickBooks_XML::ERROR_OK;
		$errmsg = null;
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$Root = $Doc->getRoot();
			$List = current($Root->children());
			
			foreach ($List->children() as $Child)
			{
				$class = 'QuickBooks_IPP_Object_' . $Child->name();
				$Object = new $class();
				
				foreach ($Child->children() as $Data)
				{
					$this->_push($Data, $Object);
				}
				
				$list[] = $Object;
			}
		}
		
		return $list;
	}
	
	protected function _push($Node, $Object)
	{
		$name = $Node->name();
		$data = $Node->data();
		
		$adds = array();
		
		if ($Node->hasChildren())
		{
			$class = 'QuickBooks_IPP_Object_' . $name;
			$Subobject = new $class();
			
			foreach ($Node->children() as $Subnode)
			{
				$this->_push($Subnode, $Subobject);
			}
			
			$Object->{'add' . $name}($Subobject);
		}
		else
		{
			if (isset($adds[$name]))
			{
				$Object->{'add' . $name}($data);
			}
			else
			{
				if ($data == 'false')
				{
					$Object->{'set' . $name}(false);
				}
				else if ($data == 'true')
				{
					$Object->{'set' . $name}(true);
				}
				else
				{
					$Object->{'set' . $name}($data);
				}
			}		
		}
	}
}