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
	public function __construct()
	{
		$this->_data = array();
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
				unset($this->_data[$field]);
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
	
	public function asIDSXML($indent = 0, $parent = null, $optype = null)
	{
		// We're not going to actually change the data, just change a copy of it
		$data = $this->_data;
		
		if (!$parent)
		{
			$parent = $this->resource();
		}
		
		if ($optype == QuickBooks_IPP::IDS_ADD)
		{
			$xml = str_repeat("\t", $indent) . '<Object xsi:type="' . $this->resource() . '">' . QUICKBOOKS_CRLF;
			
			// Merge in the defaults for this object type
			$data = array_merge($this->_defaults(), $data);
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
				$xml .= $value->asIDSXML($indent + 1);
			}
			else if (is_array($value))
			{
				foreach ($value as $skey => $svalue)
				{
					$xml .= $svalue->asIDSXML($indent + 1, $key);
				}
			}
			else
			{
				$for_qbxml = false;
				
				$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
				$xml .= QuickBooks_XML::encode($value, $for_qbxml);
				$xml .= '</' . $key . '>' . QUICKBOOKS_CRLF;
			}
		}
		
		if ($optype == QuickBooks_IPP::IDS_ADD)
		{
			$xml .= str_repeat("\t", $indent) . '</Object>' . QUICKBOOKS_CRLF;
		}
		else
		{
			$xml .= str_repeat("\t", $indent) . '</' . $parent . '>' . QUICKBOOKS_CRLF;
		}
		
		return $xml;
	}
}