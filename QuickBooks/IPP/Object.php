<?php

class QuickBooks_IPP_Object
{
	protected $_data;
	
	public function __construct()
	{
		$this->_data = array();
	}
	
	public function __call($name, $args)
	{
		if (substr($name, 0, 3) == 'set')
		{
			//print('called: ' . $name . ' with args: ' . print_r($args, true) . "\n");
			
			$field = substr($name, 3);
			
			if (count($args) == 1)
			{
				$this->_data[$field] = current($args);
			}
			else
			{
				
			}
		}
		else if (substr($name, 0, 3) == 'get')
		{
			$field = substr($name, 3);
			
			//print('getting field: [' . $field . ']' . "\n");
			//print_r($this->_data);
			
			
			if (isset($this->_data[$field]))
			{
				return $this->_data[$field];
			}
			
			return null;
		}
	}
}