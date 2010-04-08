<?php

/**
 * QuickBooks response object for responses to the ->interactiveDone() SOAP method call
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * QuickBooks result base class
 */
QuickBooks_Loader::load('/QuickBooks/Result.php');

/**
 * QuickBooks response object for responses to the ->interactiveDone() SOAP method call
 */
class QuickBooks_Result_InteractiveDone extends QuickBooks_Result
{
	/**
	 * A string indicating the interactive session is done
	 * 
	 * @var string
	 */
	public $interactiveDoneResult;
	
	/**
	 * Create a new result object
	 * 
	 * @param string $version
	 */
	public function __construct($str)
	{
		$this->interactiveDoneResult = $str;
	}
}
