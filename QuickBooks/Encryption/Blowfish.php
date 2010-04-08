<?php

/**
 * QuickBooks encryption library: Blowfish
 * 
 * 
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

define('CRYPT_ENGINE_BUILTIN', 'builtin');
define('CRYPT_ENGINE_MCRYPT', 'mcrypt');
define('CRYPT_ENGINE_GUESS', 'guess');
define('CRYPT_ENGINE__', CRYPT_ENGINE_GUESS);

class QuickBooks_Encryption_Blowfish extends QuickBooks_Encryption
{
	public function __construct()
	{
		
	}
	
	public function setIV()
	{
		
	}
	
	public function getIV()
	{
		
	}
	
	public function setMode()
	{
		
	}
	
	public function getMode()
	{
		
	}
	
	public function encrypt()
	{
		
	}
	
	public function decrypt()
	{
		
	}
}
