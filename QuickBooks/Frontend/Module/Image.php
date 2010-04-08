<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

QuickBooks_Loader::load('/QuickBooks/Utilities.php');

class QuickBooks_Frontend_Module_Image extends QuickBooks_Frontend_Module
{
	protected $_driver;
	protected $_skin;
	
	final public function __construct($driver, $skin)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
	}
	
	public function home($MOD, $DO)
	{
		
	}
	
	public function display($MOD, $DO)
	{
		
	}
	
	static public function menu()
	{
		return array( ); 
	}
	
	static public function name()
	{
		return null;
	}
	
	static public function order()
	{
		return -1;
	}
}

?>
