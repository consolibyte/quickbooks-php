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
abstract class QuickBooks_Frontend_Module
{
	abstract public function __construct($driver, $skin, $menu);
	
	abstract public function home($MOD, $DO);
	
	public function error($MOD, $DO)
	{
		print('Oops, an error occured!');
	}
	
	static public function menu()
	{
		return array();
	}
	
	static public function name()
	{
		return 'Undefined';
	}
	
	static public function order()
	{
		return 99;
	}
	
	static public function skin()
	{
		return null;
	}
}

