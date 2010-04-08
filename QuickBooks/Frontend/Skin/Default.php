<?php

QuickBooks_Loader::load('/QuickBooks/Frontend/Skin.php');

define('QUICKBOOKS_FRONTEND_SKIN_DEFAULT_NAME', 'Default Skin');

class QuickBooks_Frontend_Skin_Default extends QuickBooks_Frontend_Skin
{
	protected $_menu;
	
	public function __construct($menu, $config = array())
	{
		parent::__construct($config);
		
		$this->_menu = $menu;
		
		$this->assign('skin_name', QUICKBOOKS_FRONTEND_SKIN_DEFAULT_NAME);
		$this->assign('skin_menu', $menu);
		
		$this->assign('quickbooks_package_author', QUICKBOOKS_PACKAGE_AUTHOR);
		$this->assign('quickbooks_package_name', QUICKBOOKS_PACKAGE_NAME);
		$this->assign('quickbooks_package_version', QUICKBOOKS_PACKAGE_VERSION);
		$this->assign('quickbooks_package_frontend', QUICKBOOKS_FRONTEND_SKIN_DEFAULT_NAME);
		$this->assign('quickbooks_package_website', QUICKBOOKS_PACKAGE_WEBSITE);
	}
	
	public function display($template, $header_and_footer = true)
	{
		$modpath = dirname(__FILE__) . '/../Module/';
		$skinpath = dirname(__FILE__) . '/Default';
		
		if ($header_and_footer)
		{
			parent::setTemplatePath($skinpath);
				parent::display('header.tpl', false);
		}
		
		parent::setTemplatePath($modpath);
			parent::display($template, false);
		
		if ($header_and_footer)
		{
			parent::setTemplatePath($skinpath);
				parent::display('footer.tpl', false);
		}
			
		parent::setTemplatePath($modpath);
	}
}

?>