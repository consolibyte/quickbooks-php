<?php

QuickBooks_Loader::load('/QuickBooks/IPP/Object.php');

class QuickBooks_IPP_Object_Report extends QuickBooks_IPP_Object
{
	protected $_report_name;
	
	public function __construct($name)
	{
		$this->_report_name = $name;
		parent::__construct();
	}
	
	public function getRowCount()
	{
		$Data = $this->_data['Data'][0];
		return $Data->getRowCount();
	}
	
	public function getColumnCount()
	{
		return count($this->_data['ColDesc']);
	}
}
