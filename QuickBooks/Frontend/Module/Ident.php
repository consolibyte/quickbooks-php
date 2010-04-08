<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

QuickBooks_Loader::load('/QuickBooks/Utilities.php');

class QuickBooks_Frontend_Module_Ident extends QuickBooks_Frontend_Module
{
	protected $_driver;
	protected $_skin;
	
	final public function __construct($driver, $skin)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
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
		header('Location: ?MOD=queue&DO=searchForm');
		exit;
	}
	
	public function searchForm($MOD, $DO)
	{
		
		$this->_skin->display('Ident/searchForm.tpl');
	}
	
	public function searchResult($MOD, $DO)
	{
		$Iterator = $this->_driver->identView($this->_offset(), $this->_limit());
		$total = $this->_driver->identSize(null, false);
		
		$this->_skin->assignRef('Iterator', $Iterator);
		$this->_skin->assign('total', $total);
		
		$this->_skin->assign('offset', $this->_offset());
		$this->_skin->assign('limit', $this->_limit());
		$this->_skin->assign('perpage', $this->_limit());
		
		$this->_skin->display('Ident/searchResult.tpl');
	}
	
	public function addForm($MOD, $DO)
	{
		
		$this->_skin->display('Ident/addForm.tpl');
	}
	
	public function addResult($MOD, $DO)
	{
		
		
		header('Location: ?MOD=queue&DO=addForm&stat=' . QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_FAILURE . '&msg=' . $msg);
		exit;
	}
	
	static public function menu()
	{
		return array(
			'?MOD=ident&DO=searchForm' => 'View Associations',
			'?MOD=ident&DO=addForm' => 'Add an Association', 
			); 
	}
	
	static public function name()
	{
		return 'Associations';
	}
	
	static public function order()
	{
		return 30;
	}
}

?>