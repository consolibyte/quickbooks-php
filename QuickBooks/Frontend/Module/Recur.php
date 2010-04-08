<?php

/**
 * 
 * 
 * @package QuickBooks
 * @subpackage Frontend
 */

QuickBooks_Loader::load('/QuickBooks/Utilities.php');

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

define('QUICKBOOKS_FRONTEND_MODULE_RECUR_ERROR_SUCCESS', 's');
define('QUICKBOOKS_FRONTEND_MODULE_RECUR_ERROR_FAILURE', 'f');

define('QUICKBOOKS_FRONTEND_MODULE_RECUR_TYPE_ARRAY', 'a');
define('QUICKBOOKS_FRONTEND_MODULE_RECUR_TYPE_STRING', 's');
define('QUICKBOOKS_FRONTEND_MODULE_RECUR_TYPE_INTEGER', 'i');
define('QUICKBOOKS_FRONTEND_MODULE_RECUR_TYPE_FLOAT', 'f');
define('QUICKBOOKS_FRONTEND_MODULE_RECUR_TYPE_BOOLEAN', 'b');

class QuickBooks_Frontend_Module_Recur extends QuickBooks_Frontend_Module
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
		header('Location: ?MOD=recur&DO=searchForm');
		exit;
	}
	
	public function searchForm($MOD, $DO)
	{
		
		$this->_skin->display('Recur/searchForm.tpl');
	}
	
	public function searchResult($MOD, $DO)
	{
		$Iterator = $this->_driver->recurView($this->_offset(), $this->_limit());
		$total = $this->_driver->recurSize(null);
		
		$this->_skin->assignRef('Iterator', $Iterator);
		$this->_skin->assign('total', $total);
		
		$this->_skin->assign('offset', $this->_offset());
		$this->_skin->assign('limit', $this->_limit());
		$this->_skin->assign('perpage', $this->_limit());
		
		$this->_skin->display('Recur/searchResult.tpl');
	}
	
	public function addForm($MOD, $DO)
	{
		$this->_skin->assign('actions', QuickBooks_Utilities::listActions());
		
		$users = array();
		$iterator = $this->_driver->authView(0, 999);
		while ($arr = $iterator->next())
		{
			$users[] = $arr['qb_username'];
		}
		
		$this->_skin->assign('users', $users);
		
		$this->_skin->assign('error', $this->_stat() == QUICKBOOKS_FRONTEND_MODULE_RECUR_ERROR_FAILURE);
		
		switch ($this->_stat())
		{
			case QUICKBOOKS_FRONTEND_MODULE_RECUR_ERROR_SUCCESS:
				$this->_skin->assign('msg', 'Successfully added the event!');
				break;
			case QUICKBOOKS_FRONTEND_MODULE_RECUR_ERROR_FAILURE:
				$this->_skin->assign('msg', 'Failed to add the event: ' . $this->_msg());
				break;
			default:
				$this->_skin->assign('msg', '');
				break;
		}
		
		$this->_skin->display('Recur/addForm.tpl');
	}
	
	public function addResult($MOD, $DO)
	{
		$add = array();
		$msg = '';
		
		
	}		
	
	static public function menu()
	{
		return array(
			//'?MOD=recur&DO=searchForm' => 'View Recurring Events',
			//'?MOD=recur&DO=addForm' => 'Add a Recurring Event', 
			); 
	}
	
	static public function name()
	{
		return 'Recurring Events';
	}
	
	static public function order()
	{
		return 21;
	}
}

?>