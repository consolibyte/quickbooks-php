<?php

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