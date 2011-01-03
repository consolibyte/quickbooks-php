<?php

/**
 * QuickBooks Unit-test framework
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 */

QuickBooks_Loader::load('/QuickBooks/UnitTest/Result.php');

class QuickBooks_UnitTest
{
	protected $__result;
	
	protected $__lastStatus;
	protected $__lastMessage;
	protected $__lastActual;
	protected $__lastExpected;
	
	public function __construct()
	{
		
	}
	
	final public function markTestSkipped()
	{
		
	}
	
	final public function markTestIncomplete()
	{
		
	}
	
	final public function run($print = true)
	{
		$all = true;
		$result = array();
		
		// Call the custom setup method (connect to database, whatever else the test needs to do, etc.)
		$this->setUp();
		
		$methods = get_class_methods($this);
		
		foreach ($methods as $method)
		{
			if (strtolower(substr($method, 0, 4)) == 'test')
			{
				$this->__clearLastStatus();
				
				$this->$method();
				
				if ($this->__getLastStatus())
				{
					$result[] = new QuickBooks_UnitTest_Result($method, true, $this->__getLastExpected(), $this->__getLastActual());
				}
				else
				{
					$result[] = new QuickBooks_UnitTest_Result($method, false, $this->__getLastExpected(), $this->__getLastActual(), $this->__getLastMessage());
					
					$all = false;
				}
			}
		}
		
		// Call the custom teardown method (disconnect, etc.)
		$this->tearDown();
		
		// Store results
		$this->__result = $result;
		
		if ($print)
		{
			$this->__print();
		}
		
		return $all;
	}
	
	final protected function __print()
	{
		$class = get_class($this);
		
		foreach ($this->__result as $Result)
		{
			if ($Result->result())
			{
				print($class . '->' . $Result->name() . ' PASSED!' . "\n");
			}
			else
			{
				print($class . '->' . $Result->name() . ' FAILED! ' . "\n");
				print("\t\t" . 'Expected: ' . $Result->expected() . ', Actual: ' . $Result->actual() . "\n");
				print("\t\t" . $Result->message() . "\n");
			}
		}
	}
	
	/**
	 * 
	 * 
	 */
	final public function result($format = null)
	{
		
	}
	
	final protected function __clearLastStatus()
	{
		$this->__lastStatus = null;
	}
	
	final protected function __setLastStatus($status)
	{
		$this->__lastStatus = $status;
	}
	
	final protected function __getLastStatus()
	{
		return $this->__lastStatus;
	}
	
	final protected function __setLastMessage($msg)
	{
		$this->__lastMessage = $msg;
	}
	
	final protected function __getLastMessage()
	{
		return $this->__lastMessage;
	}
	
	final protected function __setLastError($errno)
	{
		$this->__lastError = $errno;
	}
	
	final protected function __getLastError()
	{
		return $this->__lastError;
	}
	
	final protected function __getLastActual()
	{
		return $this->__lastActual;
	}
	
	final protected function __getLastExpected()
	{
		return $this->__lastExpected;
	}
	
	final protected function __setLastActual($actual)
	{
		$this->__lastActual = $actual;
	}
	
	final protected function __setLastExpected($expected)
	{
		$this->__lastExpected = $expected;
	}
	
	final public function assertEquals($expected, $actual, $strict_types = false)
	{
		if (is_array($expected))
		{
			
		}
		else if (is_object($expected))
		{
			
		}
		else if ($strict_types)
		{
			$this->__setLastStatus($expected === $actual);
		}
		
		$this->__setLastStatus($expected == $actual);
	}
	
	final public function assertGreaterThan($expected, $actual)
	{
		$this->__setLastStatus($actual > $expected);
	}
	
	final public function assertLessThan($expected, $actual)
	{
		$this->__setLastStatus($actual < $expected);
	}
	
	final public function assertArrayIsEmpty($actual)
	{
		$this->__setLastExpected(array());
		$this->__setLastActual($actual);
		
		$this->__setLastStatus(count($actual) == 0);
	}
	
	final public function assertIsNull($actual, $or_blank = false)
	{
		$this->__setLastExpected(null);
		$this->__setLastActual($actual);
		
		$this->__setLastStatus(
			is_null($actual) or 
			($or_blank and strlen($actual) == 0));
	}
	
	final public function assertTrue($actual, $strict = false)
	{
		$this->__setLastExpected(true);
		$this->__setLastActual($actual);
		
		if ($strict)
		{
			$this->__setLastStatus($actual === true);
		}
		else
		{
			$this->__setLastStatus($actual == true);
		}
	}
	
	public function setUp()
	{
		return;
	}
	
	public function tearDown()
	{
		return;
	}
}

?>