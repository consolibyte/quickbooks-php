<?php

/**
 * SOAP response container for ->getInteractiveURL() call
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * Result interface
 */
QuickBooks_Loader::load('/QuickBooks/Result.php');

/**
 * 
 */
class QuickBooks_Result_GetInteractiveURL extends QuickBooks_Result
{
	
	public function __construct($url)
	{
		
	}
}
