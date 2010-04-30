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
	
	public function parseIDS($xml, $optype, &$xml_errnum, &$xml_errmsg, &$err_code, &$err_desc, &$err_db)
	{
		$Parser = new QuickBooks_XML_Parser($xml);
		
		// Initial to success
		$xml_errnum = QuickBooks_XML::ERROR_OK;
		$err_code = QuickBooks_IPP::ERROR_OK;
		
		// Try to parse the XML IDS response
		$errnum = QuickBooks_XML::ERROR_OK;
		$errmsg = null;
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$Root = $Doc->getRoot();
			$List = current($Root->children());
			
			switch ($optype)
			{
				case QuickBooks_IPP::IDS_REPORT:
					
					$Report = new QuickBooks_IPP_Object_Report('@todo Make sure we show the title of the report!');
					
					foreach ($List->children() as $Child)
					{
						$class = 'QuickBooks_IPP_Object_' . $Child->name();
						$Object = new $class();
						
						foreach ($Child->children() as $Data)
						{
							$this->_push($Data, $Object);
						}
						
						$method = 'add' . $Child->name();
						$Report->$method($Object);
					}
					
					return $Report;
					
					break;
				case QuickBooks_IPP::IDS_QUERY:			// Parse a QUERY type response
				
					$list = array();
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
					return $list;
					
					break;
				case QuickBooks_IPP::IDS_ADD:			// Parse an ADD type response
					
					//print("\n\n\n" . 'response was: ' . $List->name() . "\n\n\n");
					
					switch ($List->name())
					{
						case 'Error':
							
							$err_code = $List->getChildDataAt('Error ErrorCode');
							$err_desc = $List->getChildDataAt('Error ErrorDesc');
							$err_db = $List->getChildDataAt('Error DBErrorCode');
							
							return false;
						case 'Success':
							
							$checks = array(
								'Success PartyRoleRef PartyReferenceId',
								'Success ObjectRef Id',  
								);
								
							foreach ($checks as $xpath)
							{	
								$id = $List->getChildDataAt($xpath);
								
								if ($id)
								{
									return $id;
								}
							}
							
							$err_code = QuickBooks_IPP::ERROR_INTERNAL;
							$err_desc = 'Could not locate unique ID in response: ' . $xml;
							$err_db = '';
							
							return false;
						default:
							
							// This should never happen unless Keith neglected 
							//	to implement some part of the IPP/IDS spec
							$err_code = QuickBooks_IPP::ERROR_INTERNAL;
							$err_desc = 'The parseIDS() method could not understand node [' . $List->name() . '] in response: ' . $xml;
							$err_db = null;
							
							return false;
					}
					
					break;
				default:
					
					$err_code = QuickBooks_IPP::ERROR_INTERNAL;
					$err_desc = 'The parseIDS() method could not understand the specified optype: [' . $optype . ']';
					$err_db = null;
					
					return false;
			}
		}
		else
		{
			$xml_errnum = $errnum;
			$xml_errmsg = $errmsg;
			
			return false;
		}
	}
	
	protected function _push($Node, $Object)
	{
		$name = $Node->name();
		$data = $Node->data();
		
		$adds = array(
			);
		
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
			if (true or isset($adds[$name]))
			{
				$Object->{'add' . $name}($data);
			}
			
			/*else
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
			}*/		
		}
	}
}