<?php

QuickBooks_Loader::load('/QuickBooks/Utilities.php');

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

class QuickBooks_Frontend_Module_Setup extends QuickBooks_Frontend_Module
{
	final public function __construct($driver, $skin, $menu)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
		$this->_menu = $menu;
	}
	
	protected function _HTTPPostDefaults()
	{
		$defaults = array(
			'name' => '', 
			'descrip' => '', 
			'appurl' => '', 
			'appsupport' => '', 
			'fileid' => '', 
			'ownerid' => '', 
			'username' => '', 
			'qbtype' => QUICKBOOKS_TYPE_QBFS,
			'readonly' => false, 
			'run_every_n_seconds' => 0,
			'personaldata' => QUICKBOOKS_PERSONALDATA_DEFAULT, 
			'unattendedmode' => QUICKBOOKS_UNATTENDEDMODE_DEFAULT, 
			'authflags' => QUICKBOOKS_SUPPORTED_DEFAULT, 
			'notify' => false, 
			'appdisplayname' => '', 
			'appuniquename' => '',
			'appid' => '',  			
			);
		
		if (isset($_POST['qwc']) and is_array($_POST['qwc']))
		{
			return array_merge($defaults, $_POST['qwc']);
		}
		
		return $defaults;
	}
	
	public function home($MOD, $DO)
	{
		$this->_skin->display('Setup/home.tpl');
	}
	
	public function qwcForm($MOD, $DO, $err = null)
	{
		$qwc = $this->_HTTPPostDefaults();
		
		//print_r($qwc);
		
		$this->_skin->assign('error', $err);
		
		$this->_skin->assignArray($qwc);
		$this->_skin->display('Setup/qwcForm.tpl');
	}
	
	public function qwcGenerate($MOD, $DO)
	{
		$qwc = $this->_HTTPPostDefaults();
		extract($qwc);
		
		if (empty($name))
		{
			return $this->qwcForm($MOD, $DO, 'You must enter an application name!');
		}
		else if (empty($username))
		{
			return $this->qwcForm($MOD, $DO, 'You must enter a Web Connector username!');
		}
		
		if (empty($fileid))
		{
			$fileid = QuickBooks_Utilities::generateFileID();
		}
		
		if (empty($ownerid))
		{
			$ownerid = QuickBooks_Utilities::generateOwnerID();
		}
		
		$xml = QuickBooks_Utilities::generateQWC(
			$name, 
			$descrip, 
			$appurl, 
			$appsupport, 
			$username, 
			$fileid, 
			$ownerid, 
			$qbtype, 
			$readonly, 
			$run_every_n_seconds, 
			$personaldata, 
			$unattendedmode, 
			$authflags, 
			$notify, 
			$appdisplayname, 
			$appuniquename, 
			$appid);
			
		header('Content-type: text/plain');
		print($xml);
		exit;
	}
	
	static public function menu()
	{
		return array(
			//'?MOD=setup&DO=initForm' => 'Initialize the Framework',
			'?MOD=setup&DO=qwcForm' => 'Generate a .QWC File',
			);
	}
	
	static public function name()
	{
		return 'Setup';
	}
	
	static public function order()
	{
		return 1;
	}
}

?>