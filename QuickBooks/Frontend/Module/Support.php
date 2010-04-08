<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Module.php');

class QuickBooks_Frontend_Module_Support extends QuickBooks_Frontend_Module
{
	protected $_driver;
	protected $_skin;
	
	final public function __construct($driver, $skin, $menu)
	{
		$this->_driver = $driver;
		$this->_skin = $skin;
	}
	
	public function home($MOD, $DO)
	{
		$this->_skin->display('Support/home.tpl');
	}
	
	public function getForm($MOD, $DO)
	{
		$this->_skin->display('Support/get.tpl');
	}
	
	public function getSend($MOD, $DO)
	{
		
	}
	
	public function paidForm($MOD, $DO)
	{
		$this->_skin->display('Support/paid.tpl');
	}
	
	public function paidSend($MOD, $DO)
	{
		
	}
	
	public function forums($MOD, $DO)
	{
		
	}
	
	static public function menu()
	{
		return array(
			//'http://www.consolibyte.com/quickbooks_integration/support' => 'Get Free Support', 
			//'http://www.consolibyte.com/quickbooks_integration/paid_support_and_consulting' => 'Paid Support &amp; Consulting', 
			//'http://www.consolibyte.com/forums/' => 'Support Forums', 
			//'http://www.consolibyte.com/wiki/' => 'Support Wiki',
			'http://idnforums.intuit.com/messageview.aspx?catid=56&threadid=9164&enterthread=y' => 'Intuit Support Forums',  
			);
	}
	
	static public function name()
	{
		return 'Support';
	}
	
	static public function order()
	{
		return 60;
	}
}
	
?>