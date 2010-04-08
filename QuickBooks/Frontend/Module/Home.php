<?php

/**
 * 
 * 
 * @package QuickBooks
 * @subpackage Frontend
 */

/**
 * 
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

/**
 * 
 */
class QuickBooks_Frontend_Module_Home extends QuickBooks_Frontend_Module
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
		$this->_skin->assign('initialized', $this->_driver->initialized());
		
		$this->_skin->display('Home/home.tpl');
	}
	
	public static function menu()
	{
		return array();
	}
	
	public static function name()
	{
		return 'Home';
	}
}

?>