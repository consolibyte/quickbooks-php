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
QuickBooks_Loader::load('/QuickBooks/Utilities.php');

define('QUICKBOOKS_SKIN_HOOK_SETHEADER', 'setheader');
define('QUICKBOOKS_SKIN_HOOK_SETFOOTER', 'setfooter');
define('QUICKBOOKS_SKIN_HOOK_ASSIGN', 'assign');
define('QUICKBOOKS_SKIN_HOOK_ASSIGNREF', 'assignref');
define('QUICKBOOKS_SKIN_HOOK_ASSIGNARRAY', 'assignarray');
define('QUICKBOOKS_SKIN_HOOK_CLEAR', 'clear');
define('QUICKBOOKS_SKIN_HOOK_SETGLOBAL', 'setglobal');
define('QUICKBOOKS_SKIN_HOOK_DISPLAY', 'display');

/**
 * 
 */
class QuickBooks_Frontend_Skin
{
	/**
	 * 
	 */
	protected $_vars;
	
	/**
	 * 
	 */
	protected $_config;
	
	/**
	 * 
	 */
	protected $_globals;
	
	/**
	 * 
	 */
	protected $_hooks;
	
	/**
	 * 
	 */
	public function __construct($config = array())
	{
		$this->_config = $this->_options($config);
		
		$this->_vars = array();
		$this->_globals = array();
	}
	
	protected function _options($config)
	{
		$defaults = array(
			'template_path' => dirname(__FILE__), 
			'header' => null, 
			'footer' => null, 
			'hooks' => array(), 
			'filters' => array(), 
			);
		
		return array_merge($defaults, $config);
	}
	
	protected function _doHooks($which)
	{
		
	}
	
	public function setTemplatePath($path)
	{
		$this->_config['template_path'] = $path;
	}
	
	public function getTemplatePath()
	{
		return $this->_config['template_path'];
	}
	
	/**
	 * Set a file to use as a header template
	 * 
	 * If you set a header template, then whenever you call the ->display() 
	 * method, the header template will be output immediately before the 
	 * display template. 
	 * 
	 * @param string $header
	 * @return void
	 */
	public function setHeader($header)
	{
		$this->_config['header'] = $header;
	}
	
	public function setFooter($footer)
	{
		$this->_config['footer'] = $footer;
	}
	
	/**
	 * Make a variable available to the template
	 * 
	 * @param string $key 	The variable name
	 * @param mixed $value	The variable value
	 * @return void
	 */
	public function assign($key, $value)
	{
		/*if (is_array($value))
		{
			foreach ($value as $arr_key => $arr_value)
			{
				$this->_vars[$key . '[' . $arr_key . ']'] = $arr_value;
			}
		}*/
		
		$this->_vars[$key] = $value;
	}
	
	/**
	 * Make a variable available to the template (pass by reference)
	 * 
	 * @param string $key		The variable name
	 * @param string $value		The variable value (reference)
	 * @return void
	 */
	public function assignRef($key, &$value)
	{
		/*if (is_array($value))
		{
			
		}
		*/
		
		$this->_vars[$key] = $value;
	}
	
	public function assignArray($arr)
	{
		foreach ($arr as $key => $value)
		{
			$this->assign($key, $value);
		}
	}
	
	public function clear()
	{
		$this->_vars = array();
	}
	
	/**
	 * 
	 */
	public function setGlobal($key)
	{
		$this->_globals[] = $key;
	}
	
	/**
	 * 
	 */
	public function display($template, $header_and_footer = true)
	{
		foreach ($this->_globals as $global)
		{
			global $$global;
		}
		
		if ($header_and_footer and $this->_config['header'])
		{
			$this->display($this->_config['header'], false);
		}
		
		if (is_file($this->_config['template_path'] . '/' . $template))
		{
			include $this->_config['template_path'] . '/' . $template;
		}
		
		if ($header_and_footer and $this->_config['footer'])
		{
			$this->display($this->_config['footer'], false);
		}
	}
	
	public function fetch($template, $header_and_footer = true)
	{
		
	}
	
	protected function __helper($key, &$from)
	{
		/*
		print('key is: ' . $key . '<br />');
		print('from: ');
		print('<pre>');
		print_r($from);
		print('</pre>');
		*/
		
		if (isset($from[$key]))
		{
			return $from[$key];
		}
		else if (false !== ($start = strpos($key, '[')) and 
			false !== ($end = strpos($key, ']')) and 
			$array = substr($key, 0, $start) and 
			$index = substr($key, $start + 1, $end - $start - 1) and 
			isset($from[$array]))
		{
			return $this->__helper($index . substr($key, $end + 1), $from[$array]);
			//return $this->__helper($index, $from[$array]);
		}
		
		return null;
	}
	
	public function _($key, $modifiers = null)
	{
		$tmp = $this->__helper($key, $this->_vars);
		
		if (is_null($modifiers))
		{
			return $tmp;
		}
		else
		{
			// 
		}
	}
	
	public function readfile($file)
	{
		return readfile($this->_config['template_path'] . '/' . $file);
	}
	
	public function loadHook($when, $hook)
	{
		
	}
	
	public function clearHooks()
	{
		
	}
	
	public function loadFilter($filter)
	{
		
	}
	
	public function clearFilters()
	{
		
	}
	
	public function loadPlugin($plugin)
	{
		
	}
	
	public function plugin($which)
	{
		
	}
}
