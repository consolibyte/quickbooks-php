<?php

/**
 * 
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
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
	
	public function parseIPP($xml, $method, &$xml_errnum, &$xml_errmsg, &$err_code, &$err_desc, &$err_db)
	{
		// Massage it... *sigh*
		$xml = $this->_massageQBOXML($xml);
	
		//print($xml);
	
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
			
			//print_r($Root);
			
			switch ($method)
			{
				case QuickBooks_IPP::API_GETUSERINFO:
					return $this->_parseIPPGetUserInfo($Root);
				case QuickBooks_IPP::API_GETUSERROLE:
					return $this->_parseIPPGetUserRole($Root);
				case QuickBooks_IPP::API_GETENTITLEMENTVALUES:
					return $this->_parseIPPGetEntitlementValues($Root);
				case QuickBooks_IPP::API_GETENTITLEMENTVALUESANDUSERROLE:
					return $this->_parseIPPGetEntitlementValuesAndUserRole($Root);
				case QuickBooks_IPP::API_GETDBINFO:
					return $this->_parseIPP_HashMap($Root);
				case QuickBooks_IPP::API_GETDBVAR:
					return $this->_parseIPP_NodeValue($Root, 'qdbapi/value');
				case QuickBooks_IPP::API_GETIDSREALM:
					return $this->_parseIPP_NodeValue($Root, 'qdbapi/realm');
				case QuickBooks_IPP::API_GETISREALMQBO:
					return $this->_parseIPP_NodeValue($Root, 'qdbapi/IsQBO') == 'true';
				case QuickBooks_IPP::API_GETBASEURL:
					return $this->_parseIPP_NodeValue($Root, 'qboQboUser/qboCurrentCompany/qboBaseURI') . '/resource';		// Oooh, that's probably bad...
			}
		}
		
		return false;
	}
	
	protected function _parseIPP_NodeValue($Root, $key)
	{
		return $Root->getChildDataAt($key);
	}
	
	protected function _parseIPP_HashMap($Root)
	{
		$info = array();
		
		foreach ($Root->children() as $Node)
		{
			$name = $Node->name();
			$data = $Node->data();
			
			if ($name == 'action' or
				$name == 'errcode' or 
				$name == 'errtext')
			{
				continue;
			}
			
			$info[$name] = $data;
		}
		
		return $info;
	}
	
	protected function _parseIPPGetEntitlementValuesAndUserRole($Root)
	{
		// Parse out the metadata and entitlements
		$retr = $this->_parseIPPGetEntitlementValues($Root);
		
		$User = $Root->getChildAt('qdbapi/user');
		
		$retr[0]['userId'] = $User->getAttribute('id');
		$retr[0]['userName'] = $User->getChildDataAt('user/name');
		
		// Now append to that the user roles
		$Roles = $Root->getChildAt('qdbapi/user/roles');
		
		$list = array();
		foreach ($Roles->children() as $Node)
		{
			$Node2 = $Node->getChildAt('role/access');
			
			$list[] = new QuickBooks_IPP_Role(
				$Node->getAttribute('id'), 
				$Node->getChildDataAt('role/name'), 
				$Node2->getAttribute('id'), 
				$Node2->data()
				);
		}
		
		$retr[] = $list;
		
		return $retr;
	}
	
	/**
	 * 
	 * 
	 * IMPORTANT NOTE:
	 * 	This code is re-used by GetEntitlementValuesAndUserRole(), so make sure 
	 * 	that if you change this code, you don't break anything in that method.
	 * 
	 * @param object $Root
	 * @return array
	 */
	protected function _parseIPPGetEntitlementValues($Root)
	{
		$metadata = array();
		foreach ($Root->children() as $Node)
		{
			if (!$Node->hasChildren())
			{
				$metadata[$Node->name()] = $Node->data();
			}
		}
		
		$list = array();
		$Entitlements = $Root->getChildAt('qdbapi/entitlements');
		foreach ($Entitlements->children() as $Node)
		{
			$Node2 = $Node->getChildAt('entitlement/term');
			
			$list[] = new QuickBooks_IPP_Entitlement(
				$Node->getAttribute('id'), 
				$Node->getChildDataAt('entitlement/name'), 
				$Node2->getAttribute('id'), 
				$Node2->data()
				);
		}
		
		return array(
			0 => $metadata, 
			1 => $list, 
			);
	}
	
	protected function _parseIPPGetUserInfo($Root)
	{
		$Node = $Root->getChildAt('qdbapi/user');
		
		return new QuickBooks_IPP_User(
			$Node->getAttribute('id'), 
			$Node->getChildDataAt('user/email'),
			$Node->getChildDataAt('user/firstName'), 
			$Node->getChildDataAt('user/lastName'), 
			$Node->getChildDataAt('user/login'), 
			$Node->getChildDataAt('user/screenName'), 
			$Node->getChildDataAt('user/isVerified'), 
			$Node->getChildDataAt('user/externalAuth'), 
			$Node->getChildDataAt('user/authid'));
	}
	
	protected function _parseIPPGetUserRole($Root)
	{
		$Roles = $Root->getChildAt('qdbapi/user/roles');
		$list = array();
		
		foreach ($Roles->children() as $Node)
		{
			$Node2 = $Node->getChildAt('role/access');
			
			$list[] = new QuickBooks_IPP_Role(
				$Node->getAttribute('id'), 
				$Node->getChildDataAt('role/name'), 
				$Node2->getAttribute('id'), 
				$Node2->data());
		}
		
		return $list;
	}
	
	protected function _massageQBOXML($xml)
	{
		if (false !== strpos($xml, '<qbo:'))
		{
			// BAD HACK: It's a QBO data set, we need to adjust some things
			$xml = str_replace(
				array( 
					'<qbo:', 
					'</qbo:'
				 ), 
				 array( 
				 	'<qbo', 
				 	'</qbo'
				 ), $xml);
		}
		
		/*
		if ($optype == QuickBooks_IPP_IDS::OPTYPE_ADD or $optype == QuickBooks_IPP_IDS::OPTYPE_MOD)
		{
			//$xml = '<RestResponse>' . $xml . '</RestResponse>';
		}
		*/
		
		return $xml;
	}
	
	public function parseIDS($xml, $optype, $flavor, $version, &$xml_errnum, &$xml_errmsg, &$err_code, &$err_desc, &$err_db)
	{
		switch ($version)
		{
			case QuickBooks_IPP_IDS::VERSION_2:
				return $this->_parseIDS_v2($xml, $optype, $flavor, $version, $xml_errnum, $xml_errmsg, $err_code, $err_desc, $err_db);
			case QuickBooks_IPP_IDS::VERSION_3:
				return $this->_parseIDS_v3($xml, $optype, $flavor, $version, $xml_errnum, $xml_errmsg, $err_code, $err_desc, $err_db);
		}

		return false;
	}

	protected function _parseIDS_v3($xml, $optype, $flavor, $version, &$xml_errnum, &$xml_errmsg, &$err_code, &$err_desc, &$err_db)
	{
		// Parse it 
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

			switch ($optype)
			{
				case QuickBooks_IPP_IDS::OPTYPE_CDC:

					$types = array();

					$List = $Root->getChildAt('IntuitResponse CDCResponse');
					foreach ($List->children() as $ObjList)
					{
						foreach ($ObjList->children() as $Child)
						{
							$type = $Child->name();
							if (empty($types[$type]))
							{
								$types[$type] = array();
							}

							$class = 'QuickBooks_IPP_Object_' . $Child->name();
							$Object = new $class();
							
							foreach ($Child->children() as $Data)
							{
								$this->_push($Data, $Object);
							}
							
							$types[$type][] = $Object;
						}
					}

					return $types;

					break;
				case QuickBooks_IPP_IDS::OPTYPE_ADD:	// Parse an ADD type response
					return QuickBooks_IPP_IDS::buildIDType('', QuickBooks_XML::extractTagContents('Id', $xml));
				case QuickBooks_IPP_IDS::OPTYPE_MOD:
					return true;		// If we got this far, it was a success
				case QuickBooks_IPP_IDS::OPTYPE_QUERY: 

					$list = array();

					$List = $Root->getChildAt('IntuitResponse QueryResponse');

					$attrs = $List->attributes();

					if (!array_key_exists('startPosition', $attrs) and 
						array_key_exists('totalCount', $attrs))
					{
						return $attrs['totalCount'];
					}
					else
					{

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
					}
			}
		}
		else
		{
			$xml_errnum = $errnum;
			$xml_errmsg = $errmsg;
			
			return false;
		}
	}	

	protected function _parseIDS_v2($xml, $optype, $flavor, $version, &$xml_errnum, &$xml_errmsg, &$err_code, &$err_desc, &$err_db)
	{
		// Massage it... *sigh*
		$xml = $this->_massageQBOXML($xml, $optype);

		// Parse it 
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
				case QuickBooks_IPP_IDS::OPTYPE_REPORT:		// Parse a REPORT type response
					
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
				case QuickBooks_IPP_IDS::OPTYPE_QUERY:		// Parse a QUERY type response
				case QuickBooks_IPP_IDS::OPTYPE_FINDBYID:
				
					//print_r($List);
					//exit;
					
					//print_r($Root);
					//exit;
					
					// Stupid QuickBooks Online... *sigh*
					if ($optype == QuickBooks_IPP_IDS::OPTYPE_FINDBYID and 
						$flavor == QuickBooks_IPP_IDS::FLAVOR_ONLINE) //$Root->name() == 'CompanyMetaData')
					{
						$List = new QuickBooks_XML_Node(__CLASS__ . '__line_' . __LINE__);
						$List->addChild($Root);
					}
					
					//print_r($List);
					//exit;
					
					//  Normal parsing of query results
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
				case QuickBooks_IPP_IDS::OPTYPE_ADD:	// Parse an ADD type response
				case QuickBooks_IPP_IDS::OPTYPE_MOD:
					
					//print("\n\n\n" . 'response was: ' . $List->name() . "\n\n\n");
					
					//print_r('list name [' . $List->name() . ']');
					
					switch ($List->name())
					{
						case 'Id':		// This is what QuickBooks Online, IDS v2 does
							
							return QuickBooks_IPP_IDS::buildIDType($List->getAttribute('idDomain'), $List->data());
						case 'Error':
							
							$err_code = $List->getChildDataAt('Error ErrorCode');
							$err_desc = $List->getChildDataAt('Error ErrorDesc');
							$err_db = $List->getChildDataAt('Error DBErrorCode');
							
							return false;
						case 'Success':
							
							$checks = array(
								'Success PartyRoleRef Id', 	// QuickBooks desktop, IDS v2
								'Success PartyRoleRef PartyReferenceId', 	// QuickBooks desktop, IDS v2
								'Success ObjectRef Id',   	// QuickBooks desktop, IDS v2
								);
								
							foreach ($checks as $xpath)
							{	
								$IDNode = $List->getChildAt($xpath);
								
								if ($IDNode)
								{
									return QuickBooks_IPP_IDS::buildIDType($IDNode->getAttribute('idDomain'), $IDNode->data());
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
		
		if (substr($name, -2, 2) == 'Id' or 
			$name == 'ExternalKey' or 
			substr($name, -3, 3) == 'Ref')
		{
			$data = QuickBooks_IPP_IDS::buildIDType($Node->getAttribute('idDomain'), $data);
		}
		
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