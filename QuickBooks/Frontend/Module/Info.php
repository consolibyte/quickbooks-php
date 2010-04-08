<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

class QuickBooks_Frontend_Module_Info extends QuickBooks_Frontend_Module
{
	final public function __construct($driver, $skin, $menu)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
		$this->_menu = $menu;
	}
	
	public function home($MOD, $DO)
	{
		
	}
	
	public function serverinfo($MOD, $DO)
	{
		// allow user to query a SOAP server for info (the text output in debug mode)
		
	}
	
	public function platforminfo($MOD, $DO)
	{
		$this->_skin->assign('php_uname', php_uname());
		$this->_skin->assign('php_version', phpversion());
		
		$this->_skin->assign('soap_phpext', extension_loaded('soap'));
		$this->_skin->assign('soap_builtin', true);
		$this->_skin->assign('soap_pear', false);
		$this->_skin->assign('soap_nusoap', false);
		
		$this->_skin->display('Info/platforminfo.tpl');
	}
	
	public function packageinfo($MOD, $DO)
	{
		$this->_skin->assign('initialized', $this->_driver->initialized());
		
		$this->_skin->assign('driver_class', get_class($this->_driver));
		$this->_skin->assign('driver_version', 'undef');
		
		$this->_skin->assign('modules', $this->_menu->modules());
		
		$this->_skin->display('Info/packageinfo.tpl');
	}
	
	public function phpinfo($MOD, $DO)
	{
		phpinfo();
	}
	
	static public function menu()
	{
		return array(
			'?MOD=info&DO=packageinfo' => 'Package Information',
			'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?MOD=info&DO=phpinfo' => 'PHP Information', 
			'?MOD=info&DO=platforminfo' => 'Platform Information', 
			//'?MOD=info&DO=serverinfo' => 'SOAP Server Information',
			//'?MOD=info&DO=debugForm' => 'Debugging Report', 			// dump all mysql tables, files, etc. and e-mail to me?
			);
	}
	
	static public function name()
	{
		return 'Information';
	}
	
	static public function order()
	{
		return 100;
	}
}

?>