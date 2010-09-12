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
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 */

/**
 * 
 */
class QuickBooks_Iterator
{
	protected $_list;
	protected $_type;
	
	public function __construct($list, $type = null)
	{
		$this->_list = $list;
		array_unshift($this->_list, null);
	}
	
	public function reset()
	{
		return reset($this->_list);
	}
	
	public function next()
	{
		return next($this->_list);
	}
	
	public function count()
	{
		return count($this->_list) - 1;
	}
	
	public function type()
	{
		return $this->_type;
	}
}
