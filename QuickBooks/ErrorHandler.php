<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 */

/**
 * 
 * 
 * 
 */
class QuickBooks_ErrorHandler
{
	/**
	 * 
	 */
	static public function handle($errno, $errstr, $errfile, $errline)
	{
		print('
			ERROR: [' . $errno . '] ' . $errstr . '
        	Fatal error on line ' . $errline . ' in file ' . $errfile . ', PHP v' . PHP_VERSION . ' (' . PHP_OS . ')
		');
		
		exit(1);
	}
}

