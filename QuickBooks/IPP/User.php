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

class QuickBooks_IPP_User
{
	const ANONYMOUS = 'anonymous';
	
	protected $_userid;
	
	protected $_email;
	
	protected $_firstname;
	
	protected $_lastname;
	
	protected $_login;
	
	protected $_screenname;
	
	protected $_is_verified;
	
	protected $_external_auth;
	
	protected $_authid;
	
	public function __construct($userid, $email, $firstname, $lastname, $login, $screenname, $is_verified, $external_auth, $authid)
	{
		$this->_userid = $userid;
		$this->_email = $email;
		$this->_firstname = $firstname;
		$this->_lastname = $lastname;
		$this->_login = $login;
		$this->_screenname = $screenname;
		$this->_is_verified = $is_verified;
		$this->_external_auth = $external_auth;
		$this->_authid = $authid;
	}
	
	public function getUserId()
	{
		return $this->_userid;
	}
	
	public function getEmail()
	{
		return $this->_email;
	}
	
	public function getScreenName()
	{
		return $this->_screenname;
	}
	
	public function getFirstName()
	{
		return $this->_firstname;
	}
	
	public function getLastName()
	{
		return $this->_lastname;
	}
	
	public function getLogin()
	{
		return $this->_login;
	}
	
	public function isVerified()
	{
		return (boolean) $this->_is_verified;
	}
	
	public function isAnonymous()
	{
		return $this->_login == QuickBooks_IPP_User::ANONYMOUS;
	}
	
	public function getExternalAuth()
	{
		return $this->_external_auth;
	}
	
	public function getAuthId()
	{
		return $this->_authid;
	}
}