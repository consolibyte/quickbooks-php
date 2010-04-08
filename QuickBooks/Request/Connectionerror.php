<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage Client
 */

/**
 * 
 * 
 * 
 */
class QuickBooks_Request_ConnectionError extends QuickBooks_Request
{
	public $ticket;
	public $hresult;
	public $message;
	
	public function __construct($ticket = null, $hresult = null, $message = null)
	{
		$this->ticket = $ticket;
		$this->hresult = $hresult;
		$this->message = $message;
	}
}
