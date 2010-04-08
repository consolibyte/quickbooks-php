<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Frontend
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Frontend/Menu.php');

/**
 * 
 */
class QuickBooks_Frontend
{
	/**
	 * The type of skin the front-end is using
	 * 
	 * @var string
	 */
	protected $_skin;
	
	/**
	 * A DSN-style connection string for the connection to the driver
	 * 
	 * @var string
	 */
	protected $_dsn;
	
	/**
	 * Create a new QuickBooks front-end instance 
	 * 
	 * @param string $dsn
	 * @param array $frontend_options
	 */
	public function __construct($dsn, $frontend_options = array())
	{
		$this->_dsn = $dsn;
		
		$frontend_options = $this->_defaults($frontend_options);
		$this->_skin = $frontend_options['skin'];
	}
	
	/**
	 * Default configuration variables
	 * 
	 * @param array $arr
	 * @return array
	 */
	protected function _defaults($arr)
	{
		$defaults = array(
			'skin' => 'default', 
			);
			
		return array_merge($defaults, $arr);
	}
	
	/**
	 * Import/load all available modules into the QuickBooks Front-end
	 * 
	 * @param Frontend_Menu $menu
	 * @return void
	 */
	protected function _importModules(&$menu)
	{
		$dir = dirname(__FILE__) . '/Frontend/Module';
		
		$menu = new QuickBooks_Frontend_Menu();
		
		$dh = opendir($dir);
		while (false !== ($file = readdir($dh)))
		{
			if (substr($file, -4) == '.php')
			{
				include_once $dir . '/' . $file;
				
				$class = 'QuickBooks_Frontend_Module_' . substr($file, 0, -4);
				if (class_exists($class) and is_subclass_of($class, 'QuickBooks_Frontend_Module'))
				{
					$name = call_user_func( array( $class, 'name' ) );
					$methods = call_user_func( array( $class, 'menu' ) );
					$order = call_user_func( array( $class, 'order' ) );
					
					$menu->addModule($name, $order);
					foreach ($methods as $url => $text)
					{
						$menu->addMethod($name, $url, $text);
					}
				}
			}
		}
	}
	
	/**
	 * Create a skin object instance
	 * 
	 * @param string $skin
	 * @param Frontend_Menu $menu
	 * @param array $opts
	 * @return Frontend_Skin
	 */
	protected function _skinFactory($skin, $menu, $opts = array())
	{
		$class = 'QuickBooks_Frontend_Skin_' . ucfirst(strtolower($skin));
		$file = '/QuickBooks/Frontend/Skin/' . ucfirst(strtolower($skin)) . '.php';
		
		QuickBooks_Loader::load($file);
		
		if (class_exists($class))
		{
			return new $class($menu, $opts);
		}
	}
	
	/**
	 * Start the front-end and handle any requests
	 * 
	 * @return boolean
	 */
	public function handle()
	{
		header('Content-type: text/html');
		
		$menu = null;
		$this->_importModules($menu);
		
		$driver = QuickBooks_Utilities::driverFactory($this->_dsn);
		$skin = $this->_skinFactory($this->_skin, $menu);
		
		$MOD = 'Home';
		if (isset($_REQUEST['MOD']))
		{
			$MOD = strtolower(trim(strip_tags($_REQUEST['MOD'])));
		}
		
		$DO = 'home';
		if (isset($_REQUEST['DO']))
		{
			$DO = strtolower(trim(strip_tags($_REQUEST['DO'])));
		}
		
		$module = ucfirst(strtolower($MOD));
		$class = 'QuickBooks_Frontend_Module_' . $module;
				
		if (class_exists($class))
		{
			$Object = new $class($driver, $skin, $menu);
			
			if (method_exists($Object, $DO) and 
				$Object instanceof QuickBooks_Frontend_Module)
			{
				return $Object->$DO($MOD, $DO);
			}
			else
			{
				return $Object->error($MOD, $DO);
			}
		}
		else
		{
			/*
			 * @todo Better error handling... 
			 */
			die('Error!');
			
			return false;
		}
	}
}
