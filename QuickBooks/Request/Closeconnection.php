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
class QuickBooks_Request_CloseConnection extends QuickBooks_Request
{
	public $ticket;
	
	public function __construct($ticket = null)
	{
		$this->ticket = $ticket;
	}
}

