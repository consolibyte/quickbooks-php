<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

class QuickBooks_Frontend_Module_Log extends QuickBooks_Frontend_Module
{
	protected $_driver;
	protected $_skin;
	protected $_menu;
	
	final public function __construct($driver, $skin, $menu)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
		$this->_menu = $menu;
	}
	
	protected function _limit()
	{
		if (isset($_GET['limit']) and (int) $_GET['limit'])
		{
			return max(1, (int) $_GET['limit']);
		}
		
		return 15;
	}
	
	protected function _offset()
	{
		if (isset($_GET['offset']) and (int) $_GET['offset'])
		{
			return max(0, (int) $_GET['offset']);
		}
		
		return 0;
	}
	
	public function home($MOD, $DO)
	{
		
		
		$this->_skin->display('Log/home.tpl');
	}
	
	public function view($MOD, $DO)
	{
		$Iterator = $this->_driver->logView($this->_offset(), $this->_limit());
		$total = $this->_driver->logSize();
		
		$this->_skin->assignRef('Iterator', $Iterator);
		$this->_skin->assign('total', $total);
		
		$this->_skin->assign('offset', $this->_offset());
		$this->_skin->assign('limit', $this->_limit());
		$this->_skin->assign('perpage', $this->_limit());
		
		$this->_skin->display('Log/view.tpl');
	}
	
	static public function menu()
	{
		return array(
			'?MOD=log&DO=home' => 'View Server Log', 
			); 
	}
	
	static public function name()
	{
		return 'Server Log';
	}
	
	static public function order()
	{
		return 40;
	}
}

?>