<?php

/**
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
