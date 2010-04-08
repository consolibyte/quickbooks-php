<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

QuickBooks_Loader::load('/QuickBooks/Utilities.php');

define('QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_SUCCESS', 's');
define('QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_FAILURE', 'f');

define('QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_ARRAY', 'a');
define('QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_STRING', 's');
define('QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_INTEGER', 'i');
define('QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_FLOAT', 'f');
define('QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_BOOLEAN', 'b');

class QuickBooks_Frontend_Module_Queue extends QuickBooks_Frontend_Module
{
	protected $_driver;
	protected $_skin;
	
	final public function __construct($driver, $skin)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
	}
	
	protected function _add(&$arr, &$msg)
	{
		$msg = '';
		
		$arr = array(
			'user' => '', 
			'action' => '', 
			'ident' => '', 
			'extra' => null, 
			'priority' => 0,
			'replace' => true,  
			);
		
		if (empty($_POST['qb_username']))
		{
			$msg = 'You must enter a valid QuickBooks Framework username.';	
		}
		else
		{
			$arr['qb_username'] = trim($_POST['qb_username']);
		}
		
		if (empty($_POST['qb_action']))
		{
			$msg = 'You must choose or enter a QuickBooks action.';
		}
		else
		{
			$arr['qb_action'] = trim($_POST['qb_action']);
		}
		
		if (empty($_POST['ident']))
		{
			$msg = 'You must enter an ID/ident string for the request.';
		}
		else
		{
			$arr['ident'] = trim($_POST['ident']);
		}
		
		if (isset($_POST['extra']) and isset($_POST['extra_type']))
		{
			switch ($_POST['extra_type'])
			{
				case QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_ARRAY:
					$arr['extra'] = (array) $_POST['extra'];
					break;
				case QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_STRING:
					$arr['extra'] = '' . $_POST['extra'];
					break;
				case QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_INTEGER:
					$arr['extra'] = (int) $_POST['extra'];
					break;
				case QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_FLOAT:
					$arr['extra'] = (float) $_POST['extra'];
					break;
				case QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_BOOLEAN:
					$arr['extra'] = (boolean) $_POST['extra'];
					break;
				default:
					$msg = 'You must choose a valid data type.';
					break;
			}
		}
		
		if (isset($_POST['priority']) and is_numeric($_POST['priority']))
		{
			$arr['priority'] = (int) $_POST['priority'];
		}
		else
		{
			$msg = 'You must choose a valid request priority.';
		}
		
		return strlen($msg) == 0;
	}
	
	protected function _msg()
	{
		if (isset($_GET['msg']))
		{
			return $_GET['msg'];
		}
		
		return null;
	}
	
	protected function _stat()
	{
		if (isset($_GET['stat']))
		{
			return $_GET['stat'];
		}
		
		return null;
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
		
		$this->_skin->display('Queue/searchForm.tpl');
	}
	
	public function searchResult($MOD, $DO)
	{
		$Iterator = $this->_driver->queueView($this->_offset(), $this->_limit());
		$total = $this->_driver->queueSize(null);
		
		$this->_skin->assignRef('Iterator', $Iterator);
		$this->_skin->assign('total', $total);
		
		$this->_skin->assign('offset', $this->_offset());
		$this->_skin->assign('limit', $this->_limit());
		$this->_skin->assign('perpage', $this->_limit());
		
		$this->_skin->display('Queue/searchResult.tpl');
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
		
		$this->_skin->assign('error', $this->_stat() == QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_FAILURE);
		
		switch ($this->_stat())
		{
			case QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_SUCCESS:
				$this->_skin->assign('msg', 'Successfully queued the request!');
				break;
			case QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_FAILURE:
				$this->_skin->assign('msg', 'Failed to queue the request: ' . $this->_msg());
				break;
			default:
				$this->_skin->assign('msg', '');
				break;
		}
		
		$this->_skin->display('Queue/addForm.tpl');
	}
	
	public function addResult($MOD, $DO)
	{
		$add = array();
		$msg = '';
		
		if ($this->_add($add, $msg))
		{
			if ($this->_driver->queueEnqueue($add['user'], $add['action'], $add['ident'], $add['replace'], $add['priority'], $add['extra']))
			{
				
				header('Location: ?MOD=queue&DO=addForm&stat=' . QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_SUCCESS);
				exit;
			}
		}
		
		header('Location: ?MOD=queue&DO=addForm&stat=' . QUICKBOOKS_FRONTEND_MODULE_QUEUE_ERROR_FAILURE . '&msg=' . $msg);
		exit;
	}
	
	static public function menu()
	{
		return array(
			'?MOD=queue&DO=searchForm' => 'View the Queue',
			'?MOD=queue&DO=addForm' => 'Add to the Queue', 
			); 
	}
	
	static public function name()
	{
		return 'Queue';
	}
	
	static public function order()
	{
		return 20;
	}
}

?>