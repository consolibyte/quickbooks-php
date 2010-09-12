<?php

/**
 * QuickBooks encryption library factory method
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
 * @subpackage Encryption
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Encryption.php');

/**
 * 
 * 
 * 
 */
class QuickBooks_Encryption_Factory
{
	// , $iv = null, $mode = null
	static public function create($encrypt)
	{
		$class = 'QuickBooks_Encryption_' . ucfirst(strtolower($encrypt));
		$file = '/QuickBooks/Encryption/' . ucfirst(strtolower($encrypt)) . '.php';
		
		QuickBooks_Loader::load($file);
		
		return new $class();
	}
	
	/**
	 * 
	 * 
	 * @param string $encrypted
	 * @return string
	 */
	static public function determine(&$encrypted)
	{
		if ($encrypted[0] == '{' and 
			false !== ($end = strpos($encrypted, ':')))
		{
			$number = substr($encrypted, 1, $end);
			
			$method = substr($encrypted, 1 + strlen($number), $number);
			$encrypted = substr($encrypted, $number + 4);
			return $method;
		}
		
		return null;
	}
}
