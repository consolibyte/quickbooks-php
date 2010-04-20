<?php

class QuickBooks_IPP_Context
{
	protected $_IPP;
	
	public function __construct($IPP, $ticket, $token)
	{
		$this->_IPP = $IPP;
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
}