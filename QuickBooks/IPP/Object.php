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
 * 
 * 
 */

class QuickBooks_IPP_Object
{
	protected $_data;
	
	public function __construct()
	{
		$this->_data = array();
	}
	
	/*
	public function getID()
	{
		return $this->__call('getId', array());
	}
	
	public function setID($ID)
	{
		return $this->__call('setId', $ID);
	}
	*/
	
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
			
			if (count($args) == 1)
			{
				$this->_data[$field] = current($args);
			}
			else
			{
				
			}
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
			
			$this->_data[$field][] = current($args);
		}
		else if (substr($name, 0, 5) == 'unset')
		{
			$field = substr($name, 5);
			
			if (isset($this->_data[$field]))
			{
				unset($this->_data[$field]);
			}
		}
	}
	
	public function resource()
	{
		$split = explode('_', get_class($this));
		return end($split);
	}
	
	protected function _defaults()
	{
		return array();
	}
	
	public function asIDSXML($indent = 0, $parent = null, $optype = null)
	{
		if (!$parent)
		{
			$parent = $this->resource();
		}
		
		if ($optype == QuickBooks_IPP::IDS_ADD)
		{
			$xml = str_repeat("\t", $indent) . '<Object xsi:type="' . $this->resource() . '">' . QUICKBOOKS_CRLF;
			
			// Merge in the defaults for this object type
			$this->_data = array_merge($this->_defaults(), $this->_data);
		}
		else
		{
			$xml = str_repeat("\t", $indent) . '<' . $parent . '>' . QUICKBOOKS_CRLF;
		}
		
		foreach ($this->_data as $key => $value)
		{
			if (is_object($value))
			{
				//$xml .= $value->asIDSXML($ident + 1);
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
				$xml .= str_repeat("\t", $indent + 1) . '<' . $key . '>';
				$xml .= $value;
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