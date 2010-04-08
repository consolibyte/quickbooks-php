<?php

//ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/home/library_php');


QuickBooks_Loader::load('/QuickBooks/UnitTest.php');

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
		$this->assertTrue(false);
	}
	
	public function testQueueDequeue()
	{
		
	}
	
	public function testQueueFetch()
	{
		
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