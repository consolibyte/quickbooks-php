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
class QuickBooks_SQL
{
	/**
	 * Hook which occurs every time a new record is INSERTed into the SQL mirror
	 */
	const HOOK_SQL_INSERT = 'QuickBooks_SQL sql-insert';
	
	/**
	 * Hook which occurs every time a record is UPDATEd in the SQL mirror 
	 */
	const HOOK_SQL_UPDATE = 'QuickBooks_SQL sql-update';
	
	/**
	 *
	 */
	const HOOK_SQL_DELETE = 'QuickBooks_SQL sql-delete';
	
	/**
	 * 
	 */
	const HOOK_SQL_INVENTORY = 'QuickBooks_SQL sql-inventory';
	
	const HOOK_SQL_INVENTORYASSEMBLY = 'QuickBooks_SQL sql-inventoryassembly';
	
	/**
	 *
	 */
	const HOOK_QUICKBOOKS_INSERT = 'QuickBooks_SQL quickbooks-insert';
	
	/**
	 *
	 */
	const HOOK_QUICKBOOKS_UPDATE = 'QuickBooks_SQL quickbooks-update';
	
	/**
	 *
	 */
	const HOOK_QUICKBOOKS_DELETE = 'QuickBooks_SQL quickbooks-delete';
	
	/**
	 * 
	 */
	protected $_config;
	
	/**
	 * 
	 * 
	 * @param string $dsn
	 * @param array $sql_options
	 * @param array $driver_options
	 */
	public function __construct($dsn, $sql_options = array(), $driver_options = array())
	{
		$this->_config = $this->_defaults($sql_options);
	}
	
	protected function _defaults($options)
	{
		$defaults = array(
			
			);
			
		return array_merge($defaults, $options);
	}
	
	/**
	 * Tell whether or not a string starts with another string
	 * 
	 * @param string $str
	 * @param string $startswith
	 * @return boolean 
	 */
	protected function _startsWith($str, $startswith)
	{
		$length = strlen($startswith);
		
		return (substr($str, 0, $length)) == $startswith;
	}
	
	/**
	 * Execute an SQL query and return the result resource
	 * 
	 * @param string $sql		The SQL query to execute
	 * @param boolean $look		Whether or not to examine the query and see if it's an INSERT/UPDATE/DELETE query
	 * @return resource
	 */
	public function query($sql, $look = true)
	{
		if ($this->_driver)
		{
			if ($look)
			{
				$tmp = trim(strtoupper($sql));
				
				if ($this->_startsWith($sql, 'UPDATE '))
				{
					
				}
				else if ($this->_startsWith($sql, 'INSERT INTO '))
				{
					
				}
				else if ($this->_startsWith($sql, 'DELETE FROM '))
				{
					
				}
			}
			
			return $this->_driver->query($sql);
		}
		
		return false;
	}
	
	/**
	 * Fetch a record from a result resource
	 * 
	 * @param resource $res			The result resource to fetch the next record from
	 * @param boolean $as_object
	 * @param integer $index
	 * @return object
	 */
	public function fetch($res, $as_object = true, $index = null)
	{
		
	}
	
	/**
	 * 
	 * 
	 * @param string $str
	 * @return string
	 */
	public function escape($str)
	{
		
	}
	
	public function last()
	{
		
	}
	
	public function getCustomer($listID)
	{
		
	}
	
	public function addCustomer($customer)
	{
		
	}
	
	public function modifyCustomer($listID, $customer)
	{
		
	}
	
	public function deleteCustomer($listID)
	{
		
	}
}
