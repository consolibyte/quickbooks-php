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
					$name = $Data->name();
					$data = $Data->data();
					
					$Object->{'set' . $name}($data);
				}
				
				$list[] = $Object;
			}
		}
		
		return $list;
	}
}