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