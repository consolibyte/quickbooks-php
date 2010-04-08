<?php

abstract class QuickBooks_Hook
{
	protected $_argc;
	protected $_argv;
	
	public function __construct()
	{
		$argv = func_get_args();
		$this->_argv = $argv;
		$this->_argc = count($argv);
	}
	
	abstract public function hook($requestID, $user, $hook, &$err, $hook_data, $callback_config);
}