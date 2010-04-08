<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Frontend
 */

class QuickBooks_Frontend_Menu
{
	protected $_arr;
	
	public function __construct()
	{
		$this->_arr = array();
	}
	
	protected function _locate($module)
	{
		$count = count($this->_arr);
		for ($i = 0; $i < $count; $i++)
		{
			if ($this->_arr[$i][0] == $module)
			{
				return $i;
			}
		}
		
		return -1;	
	}
	
	/**
	 * 
	 * 
	 * @param string $module
	 * @param integer $order
	 * @return boolean
	 */
	public function addModule($module, $order = 99)
	{
		$this->_arr[] = array( $module, array(), $order );
		
		return true;
	}
	
	/**
	 * 
	 * 
	 * @param string $module
	 * @param string $url
	 * @param string $text
	 * @return boolean
	 */
	public function addMethod($module, $url, $text)
	{
		$index = $this->_locate($module);
		if ($index >= 0)
		{
			$this->_arr[$index][1][$url] = $text;
			
			return true;
		}
		
		return false;
	}
	
	public function modules()
	{
		$list = array();
		
		$sorter = create_function('$a, $b', ' if ($a[2] == $b[2]) { return 0; } else if ($a[2] > $b[2]) { return 1; } return -1; ');
		
		usort($this->_arr, $sorter);
		
		$count = count($this->_arr);
		for ($i = 0; $i < $count; $i++)
		{
			$list[] = $this->_arr[$i][0];
		}
		
		return $list;
	}
	
	public function methods($module)
	{
		$index = $this->_locate($module);
		if ($index >= 0)
		{
			return $this->_arr[$index][1];
		}
		
		return array();
	}
	
	public function exists($module, $method = null)
	{
		if (is_null($method))
		{
			return $this->_locate($module) >= 0;
		}
		
		$index = $this->_locate($module);
		if ($index >= 0)
		{
			return isset($this->_arr[$index][1][$method]);
		}
	}
}

