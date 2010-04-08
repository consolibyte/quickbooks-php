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
class QuickBooks_Request_ReceiveResponseXML extends QuickBooks_Request
{
	public $ticket;
	
	public $hresult;
	
	public $message;
	
	public $response;
	
	public function __construct($ticket = null, $response = null, $hresult = null, $message = null)
	{
		$this->ticket = $ticket;
		$this->response = $response;
		$this->hresult = $hresult;
		$this->message = $message;
	}
}