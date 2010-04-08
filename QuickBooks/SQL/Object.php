<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage SQL
 */

/**
 * 
 */
class QuickBooks_SQL_Object
{
	/**
	 * @var string
	 */
	protected $_table;
		
	/**
	 * @var string
	 */
	protected $_path;
		
	/**
	 * @var array
	 */
	protected $_arr;
		
	/**
	 * 
	 * 
	 * @param string $type
	 * @param array $arr
	 */
	public function __construct($table, $path, $arr = array())
	{
		$this->_table = $table;
		$this->_path = $path;
		$this->_arr = $arr;
	}
		
	/**
	 * Return the type of SQL object this is
	 * 
	 * @deprecated
	 * @return string
	 */
	public function type()
	{
		return $this->_table;
	}
		
	public function table()
	{
		return $this->_table;
	}
		
	public function path()
	{
		return $this->_path;
	}
		
	/**
	 * Set an attribute of the SQL object
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function set($key, $value)
	{
		$this->_arr[$key] = $value;
	}
		
	/**
	 * Set an attribute of the SQL object
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function remove($key)
	{
		if ($this->exists($key))
		{
			unset($this->_arr[$key]);
		}
	}
		
	/**
	 * Change the path (i.e. "InvoiceRet InvoiceLineRet" of this SQL object to something else
	 * 
	 * @param string $path
	 * @return void
	 */
	public function change($path)
	{
		$this->_path = $path;
	}
		
	public function get($key, $default = null)
	{
		if ($this->exists($key))
		{
			return $this->_arr[$key];
		}
		
		return $default;
	}
		
	public function exists($key)
	{
		return isset($this->_arr[$key]);
	}
		
	public function asArray()
	{
		return $this->_arr;
	}
		
	public function asXML()
	{
		
	}
}
