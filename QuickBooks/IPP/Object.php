<?php

/**
 * Base QuickBooks IPP/IDS class
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

/**
 * This class is the base IPP object class for IPP/IDS objects
 */
class QuickBooks_IPP_Object
{
	/**
	 * Array containing all object data
	 * @var array
	 */
	protected $_data;
	
	/**
	 * Create a new object
	 * 
	 *
	 */
	public function __construct($data = array())
	{
		$this->_data = $data;
	}
	
	/**
	 *
	 * 
	 * NOTE: This only works for SimpleXML... should probably be changed so 
	 * that this calls the QuickBooks_XML_Node class and then calls an XPath
	 * method within that... *sigh* 
	 *
	 */ 
	public function getXPath($xpath)
	{
		$str = $this->asIDSXML();
		
		//print('[[' . $str . ']]');
		
		$XML = new SimpleXMLElement($str);
		
		$retr = $XML->xpath($xpath);
		
		// This is our node value
		$cur = current($retr);
		
		if (is_object($cur))
		{
			// Check if it's an id type, in which case we need to build an IdType return string
			$attrs = $cur->attributes();
			
			if (isset($attrs['idDomain']))
			{
				return QuickBooks_IPP_IDS::buildIdType($attrs['idDomain'], $cur . '');
			}
			
			return $cur . '';
		}
		
		return null;
	}
	
	public function get($field)
	{
		/*
		if (isset($this->_data[$field]))
		{
			return $this->_data[$field];
		}
		*/
		
		$args = func_get_args();
		array_shift($args);
		
		return $this->__call('get' . $field, $args);
	}
	
	public function set($field, $value)
	{
		//$this->_data[$field] = $value;
		
		return $this->__call('set' . $field, array( $value ));
	}
	
	public function setDateType($field, $value)
	{
		if ((string) ((float) $value) == $value)
		{
			return $this->set($field, date('Y-m-d', $value));
		}
		else
		{
			return $this->set($field, date('Y-m-d', strtotime($value)));
		}
	}
	
	public function getDateType($field, $format = 'Y-m-d')
	{
		// This fixes a problem with PHP interpreting dates in the format "2012-01-02T00:00:00Z" as being from the day previous
		$value = str_replace('T00:00:00Z', '', $this->get($field));
		
		return date($format, strtotime($value));
	}
	
	public function setAmountType($field, $value)
	{
		return $this->set($field, sprintf('%01.2f', $value));
	}
	
	public function remove($field)
	{
		if (isset($this->_data[$field]))
		{
			unset($this->_data[$field]);
		}
	}
	
	public function __call($name, $args)
	{
		if (substr($name, 0, 3) == 'set')
		{
			//print('called: ' . $name . ' with args: ' . print_r($args, true) . "\n");
			
			$field = substr($name, 3);
			
			$tmp = null;
			if (count($args) == 1)
			{
				$tmp = current($args);
				$this->_data[$field] = $tmp;
			}
			else
			{
				
			}
			
			return $tmp;
		}
		else if (substr($name, 0, 3) == 'get')
		{
			$field = substr($name, 3);
			
			//print('getting field: [' . $field . ']' . "\n");
			//print_r($this->_data);
			
			
			if (isset($this->_data[$field]))
			{
				if (isset($args[0]) and 
					is_numeric($args[0]))
				{
					// Trying to fetch a repeating element
					if (isset($this->_data[$field][$args[0]]))
					{
						return $this->_data[$field][$args[0]];
					}
					
					return null;
				}
				else if (!count($args) and 
					isset($this->_data[$field]) and 
					is_array($this->_data[$field]))
				{
					return $this->_data[$field][0]; 
				}
				else
				{
					// Normal data
					return $this->_data[$field];
				}
			}
			
			return null;
		}
		else if (substr($name, 0, 5) == 'count')
		{
			$field = substr($name, 5);
			
			if (isset($this->_data[$field]) and 
				is_array($this->_data[$field]))
			{
				return count($this->_data[$field]);
			}
			else if (isset($this->_data[$field]))
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else if (substr($name, 0, 3) == 'add')
		{
			$field = substr($name, 3);
			
			if (!isset($this->_data[$field]))
			{
				$this->_data[$field] = array();
			}
			
			$tmp = current($args);
			$this->_data[$field][] = $tmp;
			
			return $tmp;
		}
		else if (substr($name, 0, 5) == 'unset')
		{
			$field = substr($name, 5);
			
			if (isset($this->_data[$field]))
			{
				if (isset($args[0]) and 
					is_numeric($args[0]))
				{
					// Trying to fetch a repeating element
					if (isset($this->_data[$field][$args[0]]))
					{
						unset($this->_data[$field][$args[0]]);
					}
					
					return true;
				}
				else
				{
					unset($this->_data[$field]);
				}
			}
		}
		else
		{
			trigger_error('Call to undefined method $' . get_class($this) . '->' . $name . '(...)', E_USER_ERROR);
			return false;
		}
	}
	
	public function resource()
	{
		$split = explode('_', get_class($this));
		return end($split);
	}
	
	/**
	 * 
	 * 
	 */
	protected function _defaults()
	{
		return array();
	}
	
	/**
	 * 
	 * 
	 */
	protected function _order()
	{
		return array();
	}
	
	protected function _reorder($data, $base = '')
	{
		$order = $this->_order();
		
		$retr = array();
		
		foreach ($order as $path => $null)
		{
			if (array_key_exists($path, $data))
			{
				$retr[$path] = $data[$path];
			}
		}
		
		$diff = array_diff_key($data, $order);
		
		if (count($diff))
		{
			// Some keys got left behind!
			$retr = array_merge($retr, $diff);
		}
		
		return $retr;
	}
	
	
	/**
	 * Apply a user-defined function to every single data field in the object
	 *
	 * @param string $callback		The callback function 
	 */
	public function walk($callback)
	{
		//print_r($this->_data);
		//exit;
		
		foreach ($this->_data as $key => $value)
		{
			if (is_object($value))
			{
				$value->walk($callback);
			}
			else if (is_array($value))
			{
				foreach ($value as $skey => $svalue)
				{
					if (is_object($svalue))
					{
						$svalue->walk($callback);
					}
					else
					{
						$this->_data[$key][$skey] = call_user_func($callback, $this->resource(), $key, $svalue);
					}
				}
			}
			else
			{
				$this->_data[$key] = call_user_func($callback, $this->resource(), $key, $value);
			}
		}
	}
	
	public function asXML($indent = 0, $parent = null, $optype = null, $flavor = null, $version = QuickBooks_IPP_IDS::VERSION_3)
	{
		if ($version == QuickBooks_IPP_IDS::VERSION_3)
		{
			return $this->_asXML_v3($indent, $parent, $optype, $flavor);
		}
		else
		{
			return $this->asIDSXML($indent, $parent, $optype, $flavor);
		}
	}

	protected function _asXML_v3($indent, $parent, $optype, $flavor)
	{
		$data = $this->_data;
		$data = $this->_reorder($data);

		$xml = str_repeat("\t", $indent) . '<' . $this->resource() . ' xmlns="http://schema.intuit.com/finance/v3">' . QUICKBOOKS_CRLF;
		
		// Go through the data, creating XML out of it
		foreach ($data as $key => $value)
		{
			if (is_object($value))
			{
				// If this causes problems, it can be commented out. It handles only situations where you are ->set(...)ing full objects, which can also be done by ->add(...)ing full objects instead
				$xml .= $value->_asXML_v3($indent + 1, null, null, $flavor);
			}
			else if (is_array($value))
			{
				foreach ($value as $skey => $svalue)
				{
					//print('converting array: [' . $key . ' >> ' . $skey . ']');
					
					if (is_object($svalue))
					{
						$xml .= $svalue->_asXML_v3($indent + 1, $key, null, $flavor);
					}
					/*else if (substr($key, -2, 2) == 'Id')
					{
						$for_qbxml = false;
						
						$tmp = QuickBooks_IPP_IDS::parseIdType($svalue);
						
						if ($tmp[0])
						{
							$xml .= str_repeat("\t", $indent + 1) . '<' . $key . ' idDomain="' . $tmp[0] . '">';
						}
						else
						{
							$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
						}
						
						$xml .= QuickBooks_XML::encode($tmp[1], $for_qbxml);
						$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;						
					}*/
					else
					{
						//$for_qbxml = false;
						//
						//$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
						//$xml .= QuickBooks_XML::encode($value, $for_qbxml);
						//$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;
						
						if (substr($key, -3, 3) == 'Ref' and $svalue{0} == '{')
						{
							$svalue = trim($svalue, '{}-');
						}
						else if ($key == 'Id' and $svalue{0} == '{')
						{
							$svalue = trim($svalue, '{}-');	
						}
						else if ($key == 'DefinitionId' and $svalue{0} == '{')
						{
							$svalue = trim($svalue, '{}-');
						}
						else if ($key == 'TxnId' and $svalue{0} == '{')
						{
							$svalue = trim($svalue, '{}-');
						}

						$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>' . QuickBooks_XML::encode($svalue, false) . '</' . $key . '>' . QUICKBOOKS_CRLF;
					}
				}
			}
			/*else if (substr($key, -2, 2) == 'Id')
			{
				$for_qbxml = false;
				
				$tmp = QuickBooks_IPP_IDS::parseIdType($value);
				
				if ($tmp[0])
				{
					$xml .= str_repeat("\t", $indent + 1) . '<' . $key . ' idDomain="' . $tmp[0] . '">';
				}
				else
				{
					$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
				}
				
				$xml .= QuickBooks_XML::encode($tmp[1], $for_qbxml);
				$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;
			}*/
			else
			{
				$for_qbxml = false;
				
				if (substr($key, -3, 3) == 'Ref' and $value{0} == '{')
				{
					$value = trim($value, '{}-');
				}
				else if ($key == 'Id' and $value{0} == '{')
				{
					$value = trim($value, '{}-');	
				}
				else if ($key == 'DefinitionId' and $value{0} == '{')
				{
					$value = trim($value, '{}-');
				}
				else if ($key == 'TxnId' and $value{0} == '{')
				{
					$value = trim($value, '{}-');
				}
				
				$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
				$xml .= QuickBooks_XML::encode($value, $for_qbxml);
				$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;
			}
		}
		
		$xml .= str_repeat("\t", $indent) . '</' . $this->resource() . '>' . QUICKBOOKS_CRLF;
		
		return $xml;
	}
	
	public function asIDSXML($indent = 0, $parent = null, $optype = null, $flavor = null)
	{
		// We're not going to actually change the data, just change a copy of it
		$data = $this->_data;
		
		if (!$parent)
		{
			$parent = $this->resource();
		}
		
		if ($optype == QuickBooks_IPP_IDS::OPTYPE_ADD or $optype == QuickBooks_IPP_IDS::OPTYPE_MOD)
		{
			if ($flavor == QuickBooks_IPP_IDS::FLAVOR_ONLINE)
			{
				$xml = str_repeat("\t", $indent) . '<' . $this->resource() . ' xmlns="http://www.intuit.com/sb/cdm/v2" xmlns:ns2="http://www.intuit.com/sb/cdm/qbopayroll/v1" xmlns:ns3="http://www.intuit.com/sb/cdm/qbo">' . QUICKBOOKS_CRLF;
			}
			else
			{
				$xml = str_repeat("\t", $indent) . '<Object xsi:type="' . $this->resource() . '">' . QUICKBOOKS_CRLF;
			}
			
			// Merge in the defaults for this object type
			$data = array_merge($this->_defaults(), $data);
		}
		else if ($parent == 'CustomField')
		{
			$xml = str_repeat("\t", $indent) . '<' . $parent . ' xsi:type="StringTypeCustomField">' . QUICKBOOKS_CRLF;
		}
		else
		{
			$xml = str_repeat("\t", $indent) . '<' . $parent . '>' . QUICKBOOKS_CRLF;
		}
		
		// Re-order is correctly
		$data = $this->_reorder($data);
		
		// Go through the data, creating XML out of it
		foreach ($data as $key => $value)
		{
			if (is_object($value))
			{
				// If this causes problems, it can be commented out. It handles only situations where you are ->set(...)ing full objects, which can also be done by ->add(...)ing full objects instead
				$xml .= $value->asIDSXML($indent + 1, null, null, $flavor);
			}
			else if (is_array($value))
			{
				foreach ($value as $skey => $svalue)
				{
					//print('converting array: [' . $key . ' >> ' . $skey . ']');
					
					if (is_object($svalue))
					{
						$xml .= $svalue->asIDSXML($indent + 1, $key, null, $flavor);
					}
					else if (substr($key, -2, 2) == 'Id')
					{
						$for_qbxml = false;
						
						$tmp = QuickBooks_IPP_IDS::parseIdType($svalue);
						
						if ($tmp[0])
						{
							$xml .= str_repeat("\t", $indent + 1) . '<' . $key . ' idDomain="' . $tmp[0] . '">';
						}
						else
						{
							$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
						}
						
						$xml .= QuickBooks_XML::encode($tmp[1], $for_qbxml);
						$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;						
					}
					else
					{
						//$for_qbxml = false;
						//
						//$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
						//$xml .= QuickBooks_XML::encode($value, $for_qbxml);
						//$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;
						
						$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>' . QuickBooks_XML::encode($svalue, false) . '</' . $key . '>' . QUICKBOOKS_CRLF;
					}
				}
			}
			else if (substr($key, -2, 2) == 'Id')
			{
				$for_qbxml = false;
				
				$tmp = QuickBooks_IPP_IDS::parseIdType($value);
				
				if ($tmp[0])
				{
					$xml .= str_repeat("\t", $indent + 1) . '<' . $key . ' idDomain="' . $tmp[0] . '">';
				}
				else
				{
					$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
				}
				
				$xml .= QuickBooks_XML::encode($tmp[1], $for_qbxml);
				$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;
			}
			else
			{
				$for_qbxml = false;
				
				$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
				$xml .= QuickBooks_XML::encode($value, $for_qbxml);
				$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;
			}
		}
		
		if ($optype == QuickBooks_IPP_IDS::OPTYPE_ADD or $optype == QuickBooks_IPP_IDS::OPTYPE_MOD)
		{
			if ($flavor == QuickBooks_IPP_IDS::FLAVOR_ONLINE)
			{
				$xml .= str_repeat("\t", $indent) . '</' . $this->resource() . '>' . QUICKBOOKS_CRLF;
			}
			else
			{
				$xml .= str_repeat("\t", $indent) . '</Object>' . QUICKBOOKS_CRLF;
			}
		}
		else
		{
			$xml .= str_repeat("\t", $indent) . '</' . $parent . '>' . QUICKBOOKS_CRLF;
		}
		
		return $xml;
	}
}