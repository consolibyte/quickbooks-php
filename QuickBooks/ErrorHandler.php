<?php

/**
 * 
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
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

