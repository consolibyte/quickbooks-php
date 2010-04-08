<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

class QuickBooks_Frontend_Module_Zencart extends QuickBooks_Frontend_Module
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
	
	public function packageinfo($MOD, $DO)
	{
		$this->_skin->assign('initialized', $this->_driver->initialized());
		
		$this->_skin->assign('driver_class', get_class($this->_driver));
		
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
			'?MOD=zencart&DO=tmp' => 'Temp',
			);
	}
	
	static public function name()
	{
		return 'Zen Cart';
	}
	
	static public function order()
	{
		return 95;
	}
}

?>