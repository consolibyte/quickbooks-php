<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage UnitTest
 */

class QuickBooks_UnitTest_Result
{
	protected $_name;
	protected $_result;
	protected $_msg;
	protected $_actual;
	protected $_expected;
	
	public function __construct($name, $result, $expected, $actual, $msg = null)
	{
		$this->_name = $name;
		$this->_result = $result;
		$this->_msg = $msg;
		
		$this->_expected = $expected;
		$this->_actual = $actual;
	}
	
	public function name()
	{
		return $this->_name;
	}
	
	public function result()
	{
		return $this->_result;
	}
	
	public function message()
	{
		return $this->_msg;
	}
	
	public function expected()
	{
		return $this->_expected;
	}
	
	public function actual()
	{
		return $this->_actual;
	}
}

?>