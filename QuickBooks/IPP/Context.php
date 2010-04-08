<?php

class QuickBooks_IPP_Context
{
	protected $_IPP;
	
	public function __construct($IPP)
	{
		$this->_IPP = $IPP;
	}
	
	public function IPP()
	{
		return $this->_IPP;
	}
}