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

class QuickBooks_IPP_Cache
{
	const MAP_QBXML = 'qbxml';
	
	const MAP_IPP = 'ipp';
	
	protected $_context;
	
	public function __construct($Context, $dsn, $map = QuickBooks_IPP_Cache::MAP_IPP, $map_dsn)
	{
		$this->_context = $Context;
	}
	
	protected function _mapFactory($map)
	{
		$class = 'QuickBooks_IPP_Cache_Mapper_' . ucfirst(strtolower($map));
		$file = 'QuickBooks/IPP/Cache/Mapper/' . ucfirst(strtolower($map));
		
		QuickBooks_Loader::load($file);
		
		return new $class($map_dsn);
	}
	
	public function refresh($resources = array(), $IDs = null)
	{
		
	}
	
	public function add($resources = array(), $IDs = null)
	{
		
	}
	
	public function mod($resources = array(), $IDs = null)
	{
		
	}
	
	public function query($resources = array(), $IDs = null)
	{
		
	}
	
	public function delete($resources = array(), $IDs = null)
	{
		
	}
	
	public function todo($resources = array(), $actions = array())
	{
		foreach ($resources as $resource)
		{
			foreach ($actions as $action)
			{
				$todos = 
				
				
			}
		}
	}
	
	public function initialized()
	{
		
	}
	
	public function initialize()
	{
		
	}
}