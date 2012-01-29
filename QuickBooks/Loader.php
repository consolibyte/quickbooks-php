<?php

/**
 * File/class loader for QuickBooks packages 
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @package QuickBooks
 * @subpackage Loader
 */

//  
if (!defined('QUICKBOOKS_LOADER_REQUIREONCE'))
{
	define('QUICKBOOKS_LOADER_REQUIREONCE', true);
}

if (!defined('QUICKBOOKS_LOADER_AUTOLOADER'))
{
	define('QUICKBOOKS_LOADER_AUTOLOADER', true);
}

/**
 * 
 */
class QuickBooks_Loader
{
	/**
	 * 
	 */
	static public function load($file, $autoload = true)
	{
		//print('loading file [' . $file . ']' . "\n");
		
		if ($autoload and 
			QuickBooks_Loader::_autoload())
		{
			return true;
		}
		
		static $loaded = array();
		
		if (isset($loaded[$file]))
		{
			return true;
		}
		
		$loaded[$file] = true;
		
		if (QUICKBOOKS_LOADER_REQUIREONCE)
		{
			require_once QUICKBOOKS_BASEDIR . $file;
		}
		else
		{
			require QUICKBOOKS_BASEDIR . $file;
		}
		
		return true;
	}
	
	/**
	 * 
	 */
	static protected function _autoload()
	{
		if (!QUICKBOOKS_LOADER_AUTOLOADER)
		{
			return false;
		}
		
		static $done = false;
		static $auto = false;
		
		if (!$done)
		{
			$done = true;
			
			if (function_exists('spl_autoload_register'))
			{
				// Register the autoloader, and return TRUE
				spl_autoload_register(array( 'QuickBooks_Loader', '__autoload' ));
				
				$auto = true;
				return true;
			}
		}
		
		return $auto;
	}
	
	/**
	 * 
	 */
	static public function __autoload($name)
	{
		if (substr($name, 0, 10) == 'QuickBooks')
		{
			$file = '/' . str_replace('_', DIRECTORY_SEPARATOR, $name) . '.php';
			QuickBooks_Loader::load($file, false);
		}
	}
	
	/** 
	 * Import (require_once) a bunch of PHP files from a particular PHP directory
	 * 
	 * @param string $dir
	 * @return boolean
	 */
	static public function import($dir, $autoload = true)
	{
		$dh = opendir(QUICKBOOKS_BASEDIR . $dir);
		if ($dh)
		{
			while (false !== ($file = readdir($dh)))
			{
				$tmp = explode('.', $file);
				if (end($tmp) == 'php' and 
					!is_dir(QUICKBOOKS_BASEDIR . $dir . DIRECTORY_SEPARATOR . $file))
				{
					QuickBooks_Loader::load($dir . DIRECTORY_SEPARATOR . $file, $autoload);
					//require_once $dir . '/' . $file;
				}
			}
			
			return closedir($dh); 
		}
		
		return false;
	}	
}
