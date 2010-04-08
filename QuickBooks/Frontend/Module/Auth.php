<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

QuickBooks_Loader::load('/QuickBooks/Utilities.php');

define('QUICKBOOKS_FRONTEND_MODULE_AUTH_ERROR_SUCCESS', 's');
define('QUICKBOOKS_FRONTEND_MODULE_AUTH_ERROR_FAILURE', 'f');

class QuickBooks_Frontend_Module_Auth extends QuickBooks_Frontend_Module
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
			'username' => '', 
			'password' => '', 
			'company' => '', 
			);
		
		if (empty($_POST['user']['password']) or 
			empty($_POST['confirm_password']) or 
			(isset($_POST['user']['password']) and isset($_POST['confirm_password']) and $_POST['user']['password'] != $_POST['confirm_password']))
		{
			$msg = 'You must enter a QuickBooks Framework password twice!';	
		}
		else
		{
			$arr['password'] = trim($_POST['user']['password']);
		}
		
		if (empty($_POST['user']['username']))
		{
			$msg = 'You must enter a valid QuickBooks Framework username.';	
		}
		else
		{
			$arr['username'] = trim($_POST['user']['username']);
		}
		
		if (!empty($_POST['user']['company']))
		{
			$arr['company'] = trim($_POST['user']['company']);
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
		$this->_skin->display('Auth/home.tpl');
	}
	
	public function searchForm($MOD, $DO)
	{
		
		$this->_skin->display('Auth/searchForm.tpl');
	}
	
	public function searchResult($MOD, $DO)
	{
		$Iterator = $this->_driver->authView($this->_offset(), $this->_limit());
		$total = $this->_driver->authSize();
		
		$this->_skin->assignRef('Iterator', $Iterator);
		$this->_skin->assign('total', $total);
		
		$this->_skin->assign('offset', $this->_offset());
		$this->_skin->assign('limit', $this->_limit());
		$this->_skin->assign('perpage', $this->_limit());
		
		$this->_skin->display('Auth/searchResult.tpl');
	}
	
	public function addForm($MOD, $DO)
	{
		$this->_skin->assign('error', $this->_stat() == QUICKBOOKS_FRONTEND_MODULE_AUTH_ERROR_FAILURE);
		
		switch ($this->_stat())
		{
			case QUICKBOOKS_FRONTEND_MODULE_AUTH_ERROR_SUCCESS:
				$this->_skin->assign('msg', 'Successfully added the user!');
				break;
			case QUICKBOOKS_FRONTEND_MODULE_AUTH_ERROR_FAILURE:
				$this->_skin->assign('msg', 'Failed to add the user: ' . $this->_msg());
				break;
			default:
				$this->_skin->assign('msg', '');
				break;
		}
		
		$this->_skin->display('Auth/addForm.tpl');
	}
	
	public function addResult($MOD, $DO)
	{
		$add = array();
		$msg = '';
		
		if ($this->_add($add, $msg))
		{
			if ($this->_driver->authCreate($add['username'], $add['password'], $add['company']))
			{
				
				header('Location: ?MOD=auth&DO=addForm&stat=' . QUICKBOOKS_FRONTEND_MODULE_AUTH_ERROR_SUCCESS);
				exit;
			}
		}
		
		header('Location: ?MOD=auth&DO=addForm&stat=' . QUICKBOOKS_FRONTEND_MODULE_AUTH_ERROR_FAILURE . '&msg=' . $msg);
		exit;
	}
	
	public function disableResult($MOD, $DO)
	{
		
	}
	
	public function editForm($MOD, $DO)
	{
		
	}
	
	public function editResult($MOD, $DO)
	{
		
	}
	
	/**
	 * Show the form used to test custom authorization/local authorization of users
	 * 
	 * @param string $MOD
	 * @param string $DO
	 * @return void
	 */
	public function testForm($MOD, $DO)
	{
		
	}
	
	public function testResult($MOD, $DO)
	{
		
	}
	
	static public function menu()
	{
		return array(
			'?MOD=auth&DO=searchForm' => 'View Users',
			'?MOD=auth&DO=addForm' => 'Add a User', 
			//'?MOD=auth&DO=testForm' => 'Test Authorization', 
			); 
	}
	
	static public function name()
	{
		return 'Authorization';
	}
	
	static public function order()
	{
		return 10;
	}
}

?>