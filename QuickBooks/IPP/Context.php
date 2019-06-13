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
 * 
 *
 */
 
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
	
	public function lastError()
	{
		return $this->_IPP->lastError();
	}
	
	public function ticket()
	{
		return $this->_ticket;
	}
	
	public function token()
	{
		return $this->_token;
	}

	public function authcreds()
	{
		return $this->_IPP->authcreds();
	}
}