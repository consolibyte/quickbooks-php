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

class QuickBooks_IPP_Role
{
	protected $_roleid;
	
	protected $_name;
	
	protected $_access_id;
	
	protected $_access_name;
	
	public function __construct($roleid, $name, $access_id, $access_name)
	{
		$this->_roleid = $roleid;
		$this->_name = $name;
		$this->_access_id = $access_id;
		$this->_access_name = $access_name;
	}
	
	public function getRoleId()
	{
		return $this->_roleid;
	}
	
	public function getName()
	{
		return $this->_name;
	}
}