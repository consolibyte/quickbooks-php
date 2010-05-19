<?php

class QuickBooks_IPP_Context
{
	protected $_IPP;
	
	protected $_ticket;
	
	protected $_token;
	
	public function __construct($IPP, $ticket, $token)
	{
		$this->_IPP = $IPP;
		
		$this->_ticket = $ticket;
		$this->_token = $token;
	}
	
	public function IPP()
	{
		return $this->_IPP;
	}
	
	public function lastRequest()
	{
		return $this->_IPP->lastRequest();
	}
	
	public function lastResponse()
	{
		return $this->_IPP->lastResponse();
	}
	
	public function lastDebug()
	{
		return $this->_IPP->lastDebug();
	}
	
	public function ticket()
	{
		return $this->_ticket;
	}
	
	public function token()
	{
		return $this->_token;
	}
}