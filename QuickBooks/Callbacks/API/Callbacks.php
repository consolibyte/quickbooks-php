<?php

/**
 * Static callback methods for the API server
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Callbacks
 */

// Only for testing
//require_once '../../../QuickBooks.php';

/**
 * QuickBooks utility methods
 */
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

/**
 * QuickBooks XML parser class 
 */
QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

/**
 * QuickBooks object instance classes
 */
QuickBooks_Loader::load('/QuickBooks/Object.php');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Callbacks.php');

/**
 * Static callback methods for the API classes
 */
class QuickBooks_Callbacks_API_Callbacks
{
	/**
	 * 
	 * 
	 * @param string $xml
	 * @param string $version
	 * @param string $locale
	 * @param string $onerror
	 * @return string
	 */
	protected static function _replacements($xml, $version, $locale, $requestID, $onerror = 'stopOnError')
	{
		if ($locale and $locale != QUICKBOOKS_LOCALE_US)
		{
			$version = $locale . $version;
		}
		
		$xml = str_replace('{$version}', $version, $xml);
		$xml = str_replace('{$locale}', $locale, $xml);
		$xml = str_replace('{$requestID}', $requestID, $xml);
		$xml = str_replace('{$onerror}', $onerror, $xml);
		
		return $xml;
	}
	
	
	/**
	 * Create a mapping between an application's primary key and a QuickBooks object
	 * 
	 * @param string $type				The type of QuickBooks object (i.e.: QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_OBJECT_INVOICE, etc.)
	 * @param mixed $ID					The primary key of the application record
	 * @param string $ListID_or_TxnID	The ListID or TxnID of the object within QuickBooks
	 * @param string $editsequence		The EditSequence of the object within QuickBooks
	 * @return boolean					
	 */
	protected static function _mapCreate($func, $user, $type, $ID, $ListID_or_TxnID, $editsequence = '', $extra = null)
	{
		if (strlen($func))
		{
			if (false === strpos($func, '::'))
			{
				return $func($type, $ID, $ListID_or_TxnID, $editsequence, $extra); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ID, $ListID_or_TxnID, $editsequence, $extra);
			}
		}
		else
		{ 
			$Driver = QuickBooks_Driver_Singleton::getInstance();
			return $Driver->identMap($user, $type, $ID, $ListID_or_TxnID, $editsequence, $extra);
		}
	}
	
	/**
	 * Map an application primary key to a QuickBooks ListID or TxnID
	 * 
	 * @param string $type		The type of object (i.e.: QUICKBOOKS_OBJECT_CUSTOMER, QUICKBOOKS_OBJECT_INVOICE, etc.)
	 * @param mixed $ID			The primary key of the record
	 * @return string			The ListID or TxnID (or NULL if it couldn't be mapped)			
	 */
	protected static function _mapToQuickBooksID($func, $user, $type, $ID)
	{
		if (strlen($func))
		{
			if (false === strpos($func, '::'))
			{
				return $func($type, $ID); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ID);
			}
		}
		else
		{
			$editsequence = '';
			$extra = null;
			
			//print('mapping: ' . $user . ', ' . $type . ', ' . $ID . "\n");
			
			$Driver = QuickBooks_Driver_Singleton::getInstance();
			$ListID_or_TxnID = $Driver->identToQuickBooks($user, $type, $ID, $editsequence, $extra);
			
			//print('got back: ' . $ListID_or_TxnID . "\n");
			
			return $ListID_or_TxnID;
		}
	}
	
	/**
	 * Map a QuickBooks ListID or TxnID to an application primary key
	 * 
	 * @param string $type					The type of object
	 * @param string $ListID_or_TxnID		The ListID or TxnID of the object within QuickBooks
	 * @return string						The application record primary key
	 */
	static protected function _mapToApplicationID($func, $user, $type, $ListID_or_TxnID)
	{
		if (strlen($func))
		{
			if (false === strpos($func, '::'))
			{
				return $func($type, $ListID_or_TxnID); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ListID_or_TxnID);
			}
		}
		else
		{
			$extra = null;
			
			$Driver = QuickBooks_Driver_Singleton::getInstance();
			return $Driver->identToApplication($user, $type, $ListID_or_TxnID, $extra);
		}
	}
	
	/**
	 * Map a type and application primary key to a QuickBooks EditSequence string
	 * 
	 * @param string $type		The type of object
	 * @param mixed $ID			The application primary key
	 * @return string			The QuickBooks EditSequence string
	 */
	static protected function _mapToEditSequence($func, $user, $type, $ID)
	{
		if (strlen($func))
		{
			if (false === strpos($func, '::'))
			{
				return $func($type, $ID); 
			}
			else
			{
				$tmp = explode('::', $func);
				
				return call_user_func(array( $tmp[0], $tmp[1] ), $type, $ID);
			}
		}
		else
		{
			$editsequence = '';
			$extra = null;
			
			$Driver = QuickBooks_Driver_Singleton::getInstance();
			$Driver->identToQuickBooks($user, $type, $ID, $editsequence, $extra);
			
			return $editsequence;
		}
	}
	
	/**
	 * 	 * @TODO THIS NEEDS SOME SERIOUS CLEANUP
	 */	
	public static function mappings($xml, $user, $config = array())
	{
		return QuickBooks_Callbacks_API_Callbacks::_mappings($xml, $user, $config);
	}
	
	/**
	 * 
	 * @TODO THIS NEEDS SOME SERIOUS CLEANUP
	 * 
	 * @param string $xml
	 * @return string
	 */
	protected static function _mappings($xml, $user, $config)
	{
		if (empty($config['map_to_quickbooks_handler']))
		{
			$config['map_to_quickbooks_handler'] = null;
		}
		
		//$EditSequence = '';
		//$first = true;
		
		while (false !== ($start = strpos($xml, '<' . QUICKBOOKS_API_APPLICATIONID . '>')))
		{
			$end = strpos($xml, '</' . QUICKBOOKS_API_APPLICATIONID . '>');
			
			$encode = substr($xml, $start + strlen(QUICKBOOKS_API_APPLICATIONID) + 2, $end - $start - strlen(QUICKBOOKS_API_APPLICATIONID) - 2);
			
			//print('encoded: ' . $encode . "\n");
			
			$type = '';
			$tag = '';
			$ID = '';
			QuickBooks_Callbacks_API_Callbacks::_decodeApplicationID($encode, $type, $tag, $ID);
			
			//print('decode: ' . $type . ', ' . $tag . ', ' . $ID . "\n");
			
			$ListID_or_TxnID = QuickBooks_Callbacks_API_Callbacks::_mapToQuickBooksID($config['map_to_quickbooks_handler'], $user, $type, $ID);
			
			//print('ListID or TxnID: ' . $ListID_or_TxnID . "\n");
			
			//exit;
			
			/*
			if ($first)
			{
				$EditSequence = QuickBooks_Callbacks_API_Callbacks::_mapToEditSequence($config['map_to_quickbooks_handler'], $user, $type, $ID);
				$first = false;
			}
			*/
			
			$xml = substr($xml, 0, $start) . '<' . $tag . '>' . $ListID_or_TxnID . '</' . $tag . '>' . substr($xml, $end + strlen(QUICKBOOKS_API_APPLICATIONID) + 3);
		}
		
		//exit;
		
		$start = strpos($xml, '<' . QUICKBOOKS_API_APPLICATIONEDITSEQUENCE . '>');
		$end = strpos($xml, '</' . QUICKBOOKS_API_APPLICATIONEDITSEQUENCE . '>');
		
		if ($start and $end)
		{
			$encode = substr($xml, $start + strlen(QUICKBOOKS_API_APPLICATIONEDITSEQUENCE) + 2, $end - $start - strlen(QUICKBOOKS_API_APPLICATIONEDITSEQUENCE) - 2);
			
			$type = '';
			$tag = '';
			$ID = '';
			QuickBooks_Callbacks_API_Callbacks::_decodeApplicationEditSequence($encode, $type, $tag, $ID);
			
			$EditSequence = QuickBooks_Callbacks_API_Callbacks::_mapToEditSequence($config['map_to_quickbooks_handler'], $user, $type, $ID);
			
			$xml = substr($xml, 0, $start) . '<EditSequence>' . $EditSequence . '</EditSequence>' . substr($xml, $end + strlen(QUICKBOOKS_API_APPLICATIONEDITSEQUENCE) + 3);
		}
		
		/*
		while (false !== ($start = strpos($xml, '<EditSequence>')))
		{
			$end = strpos($xml, '</' . QUICKBOOKS_API_APPLICATIONID . '>');
			
			$encode = substr($xml, $start + strlen(QUICKBOOKS_API_APPLICATIONID) + 2, $end - $start - strlen(QUICKBOOKS_API_APPLICATIONID) - 2);
			
			$type = '';
			$tag = '';
			$ID = '';
			QuickBooks_Callbacks_API_Callbacks::_decodeApplicationID($encode, $type, $tag, $ID);
			
			$ListID_or_TxnID = QuickBooks_Callbacks_API_Callbacks::_mapToQuickBooksID($config['map_to_quickbooks_handler'], $user, $type, $ID);
			
			$xml = substr($xml, 0, $start) . '<' . $tag . '>' . $ListID_or_TxnID . '</' . $tag . '>' . substr($xml, $end + strlen(QUICKBOOKS_API_APPLICATIONID) + 3);
		}
		*/
		
		return $xml;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected static function _decodeApplicationID($encode, &$type, &$tag, &$ID)
	{
		return QuickBooks_API::decodeApplicationID($encode, $type, $tag, $ID);
	}
	
	protected static function _decodeApplicationEditSequence($encode, &$type, &$tag, &$ID)
	{
		return QuickBooks_API::decodeApplicationEditSequence($encode, $type, $tag, $ID);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	protected static function _defaults($options)
	{
		$defaults = array(
			'always_use_iterators' => false, 
			'map_create_handler' => null, 
			'map_to_quickbooks_handler' => null,
			'map_to_application_handler' => null,
			'map_to_editsequence_handler' => null,  
			);
		
		return array_merge($defaults, $options);
	}
	
	/**
	 * 
	 * @TODO This callback code should be ported to QuickBooks_Callbacks style calls
	 * 
	 * @param string $func_or_method
	 * @param string $method
	 * @param string $action
	 * @param mixed $ID
	 * @param string $err
	 * @param string $qbxml
	 * @param object $qbobject
	 * @param resource $qbres
	 * @return boolean
	 */
	protected static function _callCallbacks($funcs_or_methods, $method, $action, $ID, &$err, $qbxml, $qbobject, $qbres)
	{
		foreach ($funcs_or_methods as $callback)
		{
			if (!$callback)
			{
				continue;
			}
			
			$return = QuickBooks_Callbacks::callAPICallback(null, null, $callback, 
				$method, 
				$action, 
				$ID, 
				$err, 
				$qbxml, 
				$qbobject, 
				$qbres);
			
			/*
			else if (false !== strpos($func, '::') and 
				true) // method_exists()) 	// is this safe to do?
			{
				// Callback *static method*
				
				$tmp = explode('::', $func);
				
				$return = call_user_func(array( $tmp[0], $tmp[1] ), $method, $action, $ID, $err, $qbxml, $qbobject, $qbres);
			}
			else if (function_exists($func))
			{
				// Callback *function* 
				
				$return = call_user_func($func, $method, $action, $ID, $err, $qbxml, $qbobject, $qbres);
			}
			else
			{
				$err = 'Could not call function or method: ' . $func;
				return false;
			}
			*/
			
			if (!$return)
			{
				break;
			}
		}
		
		if ($err)
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * 
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param float $version
	 * @param string $locale
	 * @param array $config
	 * @return string
	 */
	protected static function _doQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		if (isset($extra['api']))
		{
			if ($qbxml)
			{
				//$qbxml = $extra['qbxml'];
				$qbxml = QuickBooks_Callbacks_API_Callbacks::_replacements($qbxml, $version, $locale, $requestID);
				
				return $qbxml;
			}
		}
		else
		{
			$err = 'Request ID ' . $requestID . ', ' . $action . ', ' . $ID . ' is not an API request...';
			return false;
		}
	}
	
	/**
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $xml
	 * @param array $idents
	 * @return boolean
	 */
	protected static function _doQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents, $callback_options = array())
	{
		// This is stuff we'll be passing to the callback handler functions/methods
		// $action
		// $ID
		$err = '';
		$qbxml =& $xml;
		$qbiterator = null;
		$qbres = null;
		
		$method = null;
		if (isset($extra['method']))
		{
			$method = $extra['method'];
		}
		
		$xml_errnum = 0;
		$xml_errmsg = '';
		
		$Parser = new QuickBooks_XML_Parser($xml);
		if ($Parser->validate($xml_errnum, $xml_errmsg) and 
			$Doc = $Parser->parse($xml_errnum, $xml_errmsg))
		{
			$list = array();
			
			$Root = $Doc->getRoot();
			
			// Get rid of some gunk... 
			$Response = $Root->getChildAt('QBXML QBXMLMsgsRs ' . $action . 'Rs');
			
			if ($Response)
			{
				foreach ($Response->children() as $Child)
				{
					if ($Object = QuickBooks_Callbacks_API_Callbacks::_objectFromXML($action, $Child))
					{
						$list[] = $Object;
					}
				}
			}
			
			$Iterator = new QuickBooks_Iterator($list);
		}
		else
		{
			$err = 'XML parser error: ' . $xml_errnum . ': ' . $xml_errmsg;
		}
		
		if ($err)
		{
			return false;
		}
		
		//print_r($extra);
		//print_r($Iterator);
		
		if (isset($extra['callbacks']) and is_array($extra['callbacks']))
		{
			QuickBooks_Callbacks_API_Callbacks::_callCallbacks($extra['callbacks'], $method, $action, $ID, $err, $qbxml, $Iterator, $qbres, $callback_options);
		}
		
		return true;
	}
	
	protected static function _doModRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	protected static function _doModResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	protected static function _doAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		if (isset($extra['api']))
		{
			if ($qbxml)
			{
				$config = QuickBooks_Callbacks_API_Callbacks::_defaults($config);
				
				$qbxml = QuickBooks_Callbacks_API_Callbacks::_replacements($qbxml, $version, $locale, $requestID);
				$qbxml = QuickBooks_Callbacks_API_Callbacks::_mappings($qbxml, $user, $config);
				
				return $qbxml;
			}
			
			$err = 'API Server could not find any qbXML requests to send...';
			return false;
		}
		else
		{
			// this is *not* a request that was supposed to come from the API, 
			//	so, we'll re-queue it, and *not* process it 
			
			$err = 'Request ID ' . $requestID . ', ' . $action . ', ' . $ID . ' is not an API request...';
			return false;
		}
	}
	
	public static function RawQBXMLResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		// Determine the $action parameter (_doAddResponse needs this)
		// @TODO Move this to the _doAddRseponse method
		
		//$action = 'CustomerQuery';
		
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	protected static function _doAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		//print('THIS GOT CALLED!');
		//print_r($extra);
		
		// This is stuff we'll be passing to the callback handler functions/methods
		$method = null;
		// $action
		// $ID
		$err = '';
		$qbxml =& $xml;
		$qbobject = null;
		$qbres = null;
		
		if (isset($extra['method']))
		{
			$method = $extra['method'];
		}
		
		$xml_errnum = 0;
		$xml_errmsg = '';
		
		//print($xml);
		
		$Object = null;
		
		if ($action)
		{
			$Parser = new QuickBooks_XML_Parser($xml);
			if ($Parser->validate($xml_errnum, $xml_errmsg) and 
				$Doc = $Parser->parse($xml_errnum, $xml_errmsg))
			{
				$Root = $Doc->getRoot();
				
				// There is some nested garbage we don't really need here... let's get rid of it
				$Response = $Root->getChildAt('QBXML QBXMLMsgsRs ' . $action . 'Rs');
				
				$Child = null;
				if ($Response)
				{
					$Child = $Response->getChild(0);
					
					// Try to build an object from the returned XML
					//if ($qbobject = QuickBooks_Callbacks_API_Callbacks::_objectFromAction($action, $paths))
					if ($Object = QuickBooks_Callbacks_API_Callbacks::_objectFromXML($action, $Child))
					{
						; 
					}
					else
					{
						$Object = null;
					}
				}
			}
			else
			{
				$err = 'XML parser error: ' . $xml_errnum . ': ' . $xml_errmsg;
			}
		}
		
		if ($err)
		{
			return false;
		}
		
		if (isset($extra['callbacks']) and is_array($extra['callbacks']))
		{
			QuickBooks_Callbacks_API_Callbacks::_callCallbacks($extra['callbacks'], $method, $action, $ID, $err, $qbxml, $Object, $qbres);
		}
				
		return true;
	}
	
	/**
	 * 
	 * 
	 * 
	 */	
	protected static function _objectFromXML($action, $XML)
	{
		return QuickBooks_Object::fromXML($XML, $action);
	}
	
	/*
	protected static function _objectFromAction($action, $arr = array())
	{
		if (strtolower(substr($action, -3)) == 'add')
		{
			$type = substr($action, 0, -3);
			$class = 'QuickBooks_Object_' . ucfirst(strtolower($type));
			
			if (class_exists($class))
			{
				return new $class($arr);
			}
		}
		else if (strtolower(substr($action, -3)) == 'mod')
		{
			$type = substr($action, 0, -3);
			$class = 'QuickBooks_Object_' . ucfirst(strtolower($type));
			
			if (class_exists($class))
			{
				return new $class($arr);
			}
		}
		
		
		//switch ($action)
		//{
		//	case QUICKBOOKS_ADD_CUSTOMER:
		//	case QUICKBOOKS_MOD_CUSTOMER:
		//		return new QuickBooks_Object_Customer($arr);
		//	case QUICKBOOKS_ADD_INVOICE:
		//	case QUICKBOOKS_MOD_INVOICE:
		//		return new QuickBooks_Object_Invoice($arr);
		//	case QUICKBOOKS_
		//}
		
		return null;
	}
	*/
	
	/**
	 * @todo Fix this... use the Utilities class? Use constants? Something...?
	 */
	/*
	protected static function _objectFromReturned($returned, $arr = array())
	{
		$type = substr(strtolower($returned), 0, -3);
		
		if (substr(strtolower($type), 0, 4) == 'item')
		{
			$type = substr($type, 4) . 'Item';
		}
		
		$class = 'QuickBooks_Object_' . ucfirst(strtolower($type));
		
		if (class_exists($class))
		{
			$Object = new $class($arr);
			
			//print('class: ' . $class . "\n");
			//print_r($arr);
			exit;
			
			return $Object;
		}
		
		return null;
	}
	*/
	
	public static function AccountAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function AccountAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ClassAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ClassAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function EmployeeAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function EmployeeAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function EstimateAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function EstimateAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function BillAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function BillAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function BillPaymentCheckAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function BillPaymentCheckAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function CheckAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function CheckAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function DepositAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function DepositAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function JournalEntryAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function JournalEntryAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	

	public static function InventoryAdjustmentAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}

	public static function InventoryAdjustmentAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function InvoiceAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function InvoiceAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function ItemReceiptAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}

	public static function ItemReceiptAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function SalesReceiptAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function SalesReceiptAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function VendorAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function VendorAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ItemServiceAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemServiceAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function ItemSalesTaxAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemSalesTaxAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ItemInventoryAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemInventoryAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ItemNonInventoryAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemNonInventoryAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ReceivePaymentAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ReceivePaymentAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	
	public static function CustomerAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function CustomerAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		// 															$requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function CustomerModRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doModRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function CustomerModResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doModResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}


	public static function DataExtAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function DataExtAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function DataExtModRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doModRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function DataExtModResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doModResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function BillPaymentCheckQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public static function BillPaymentCheckQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function BillQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function BillQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function BillingRateQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function BillingRateQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function CheckQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function CheckQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	/**
	 * 
	 * 
	 */
	public static function JournalEntryQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function JournalEntryQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	/**
	 * Pass a request to QuickBooks
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $version
	 * @param array $locale
	 * @return boolean
	 */
	public static function PaymentMethodQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * Handle a response from QuickBooks
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $xml
	 * @param array $idents
	 * @return boolean
	 */
	public static function PaymentMethodQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ChargeQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function ChargeQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ClassQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function ClassQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	
	public static function CustomerQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public static function CustomerQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function CustomerTypeQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function CustomerTypeQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public static function EmployeeQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function EmployeeQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public static function EstimateQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * 
	 * 
	 */
	public static function EstimateQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function InvoiceQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function InvoiceQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	
	/**
	 * Pass a request to QuickBooks
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $version
	 * @param array $locale
	 * @return boolean
	 */
	public static function ItemQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * Handle a response from QuickBooks
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $xml
	 * @param array $idents
	 * @return boolean
	 */
	public static function ItemQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ItemServiceQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemServiceQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ItemSalesTaxQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemSalesTaxQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ItemSalesTaxGroupQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemSalesTaxGroupQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function SalesTaxCodeQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function SalesTaxCodeQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}

	public static function ItemInventoryQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemInventoryQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ItemNonInventoryQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemNonInventoryQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	/*
	public static function ItemQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ItemQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	*/
	
	public static function SalesOrderQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function SalesOrderQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function SalesReceiptQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function SalesReceiptQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	/**
	 * Pass a request to QuickBooks
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $version
	 * @param array $locale
	 * @return boolean
	 */
	public static function ShipMethodAddRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	/**
	 * Handle a response from QuickBooks
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ID
	 * @param mixed $extra
	 * @param string $err
	 * @param integer $last_action_time
	 * @param integer $last_actionident_time
	 * @param string $xml
	 * @param array $idents
	 * @return boolean
	 */
	public static function ShipMethodAddResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doAddResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	public static function ShipMethodQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function ShipMethodQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	

	public static function UnitOfMeasureSetQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function UnitOfMeasureSetQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}	
	
	public static function AccountQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryRequest($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $config, $qbxml);
	}
	
	public static function AccountQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		return QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	public static function TermsQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		
	}
	
	/**
	 * 
	 * 
	 */
	public static function TermsQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		
	}
	
	public static function VendorQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		
	}
	
	/**
	 * 
	 * 
	 */
	public static function VendorQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		
	}
	
	public static function TermsTypeQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		
	}
	
	/**
	 * 
	 * 
	 */
	public static function VendorTypeQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		
	}
	
	public static function VendorCreditQueryQueryRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		
	}
	
	/**
	 * 
	 * 
	 */
	public static function VendorCreditQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
	{
		
	}
}

/*
$requestID = 'SXRlbVF1ZXJ5fDMyNQ==';
$user = 'quickbooks';
$action = QUICKBOOKS_QUERY_ITEM;
$ID = 324;
$extra = array();
$err = null;
$last_action_time = null;
$last_actionident_time = null;
$xml = '<?xml version="1.0" ?>
<QBXML>
<QBXMLMsgsRs>
<ItemQueryRs requestID="SXRlbVF1ZXJ5fDMyNQ==" statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<ItemInventoryAssemblyRet>
<ListID>80000317-1228629275</ListID>
<TimeCreated>2008-12-06T21:54:35-08:00</TimeCreated>
<TimeModified>2010-01-15T09:43:05-08:00</TimeModified>
<EditSequence>1263577385</EditSequence>
<Name>esp-boss-12</Name>
<FullName>Retail 12oz bags-BOM:esp-boss-12</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>80000306-1228267908</ListID>
<FullName>Retail 12oz bags-BOM</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<UnitOfMeasureSetRef>
<ListID>8000000D-1197576561</ListID>
<FullName>By the 12oz</FullName>
</UnitOfMeasureSetRef>
<SalesTaxCodeRef>
<ListID>20000-1157059695</ListID>
<FullName>Non</FullName>
</SalesTaxCodeRef>
<SalesDesc>The Boss Espresso Fall 2009, thick and sticky mix, 12oz bag</SalesDesc>
<SalesPrice>13.00</SalesPrice>
<IncomeAccountRef>
<ListID>800000B9-1174689297</ListID>
<FullName>Sales Wholesale:Coffee</FullName>
</IncomeAccountRef>
<PurchaseDesc>The Boss Espresso Fall 2009, thick and sticky mix, 12oz bag</PurchaseDesc>
<PurchaseCost>2.69</PurchaseCost>
<COGSAccountRef>
<ListID>310000-1157059733</ListID>
<FullName>Cost of Goods Sold</FullName>
</COGSAccountRef>
<AssetAccountRef>
<ListID>80000222-1239318881</ListID>
<FullName>Inventory-Green Beans</FullName>
</AssetAccountRef>
<QuantityOnHand>-281</QuantityOnHand>
<AverageCost>2.695</AverageCost>
<QuantityOnOrder>0</QuantityOnOrder>
<QuantityOnSalesOrder>0</QuantityOnSalesOrder>
<ItemInventoryAssemblyLine>
<ItemInventoryRef>
<ListID>800002BF-1217618998</ListID>
<FullName>Green Coffee:Braz-montecristo-GREEN</FullName>
</ItemInventoryRef>
<Quantity>0.5</Quantity>
</ItemInventoryAssemblyLine>
<ItemInventoryAssemblyLine>
<ItemInventoryRef>
<ListID>8000038D-1249427343</ListID>
<FullName>Green Coffee:eth-amaro-sid-GRN-09</FullName>
</ItemInventoryRef>
<Quantity>0.25</Quantity>
</ItemInventoryAssemblyLine>
<ItemInventoryAssemblyLine>
<ItemInventoryRef>
<ListID>800002F5-1226015694</ListID>
<FullName>Green Coffee:eth-yirg-Dom-GRN</FullName>
</ItemInventoryRef>
<Quantity>0.25</Quantity>
</ItemInventoryAssemblyLine>
<ItemInventoryAssemblyLine>
<ItemInventoryRef>
<ListID>8000037D-1247094112</ListID>
<FullName>Coffee Packaging-group:1lb. Custom kraft bag</FullName>
</ItemInventoryRef>
<Quantity>1</Quantity>
</ItemInventoryAssemblyLine>
</ItemInventoryAssemblyRet>
</ItemQueryRs>
</QBXMLMsgsRs>
</QBXML>';
$idents = array();
$callback_options = array();

QuickBooks_Callbacks_API_Callbacks::_doQueryResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents, $callback_options = array());
*/
