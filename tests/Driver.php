<?php

//ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/home/library_php');


require_once '../QuickBooks.php';

class QuickBooks_Test_Driver extends QuickBooks_UnitTest
{
	public function setUp()
	{
		
	}
	
	public function tearDown()
	{
		
	}
	
	public function testQueueEnqueue()
	{
		$this->assertTrue(true);
	}
	
	public function testQueueDequeue()
	{
		return $this->assertGreaterThan(2, 1);
	}
	
	public function testQueueFetch()
	{
		return $this->assertGreaterThan(1, 2);
	}
	
	public function testQueueSize()
	{
		
	}
	
	public function testQueueStatus()
	{
		
	}
	
	public function testAuthCreate()
	{
		
	}
	
	public function testAuthCheck()
	{
		
	}
	
	public function testAuthLoginSuccess()
	{
		
	}
	
	public function testAuthLoginFailure()
	{
		
	}
	
	public function testAuthDisable()
	{
		
	}
}

if (!empty($argv[0]) and $argv[0] == 'Driver.php')
{
	$test = new QuickBooks_Test_Driver();
	$test->run();
}

?>