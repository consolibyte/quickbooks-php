<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

QuickBooks_Loader::load('/QuickBooks/XML.php');

class QuickBooks_IPP_Parser
{
	public function __construct()
	{
		
	}
	
	public function parse($xml)
	{
		$Parser = new QuickBooks_XML_Parser($xml);
		
		$adds = array(
			'Address', 
			'Phone', 
			//'Fax', 
			//'Email', 
			);
		
		$list = array();
		
		
		$errnum = QuickBooks_XML::ERROR_OK;
		$errmsg = null;
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$Root = $Doc->getRoot();
			$List = current($Root->children());
			
			foreach ($List->children() as $Child)
			{
				$Object = new QuickBooks_IPP_Object_Customer();
				
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
				$Object->{'set' . $name}($data);
			}		
		}
	}
}