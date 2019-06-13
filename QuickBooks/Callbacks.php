<?php

/**
 * Centralized static QuickBooks callback methods
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 *
 * As or release v1.5.3 all callback calling is being re-factored and
 * re-located to this file to ease maintainance of callbacks. Callbacks are now
 * supported as:
 * 	- functions
 * 	- static class methods
 * 	- object instance methods
 *
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 *
 * @package QuickBooks
 * @subpackage Callbacks
 */

/**
 *
 */
define('QUICKBOOKS_CALLBACKS_TYPE_NONE', 'none');

/**
 *
 */
define('QUICKBOOKS_CALLBACKS_TYPE_FUNCTION', 'function');

/**
 *
 */
define('QUICKBOOKS_CALLBACKS_TYPE_STATIC_METHOD', 'static-method');

/**
 *
 */
define('QUICKBOOKS_CALLBACKS_TYPE_OBJECT_METHOD', 'object-method');

/**
 *
 */
define('QUICKBOOKS_CALLBACKS_TYPE_HOOK_INSTANCE', 'instanceof-hook');

/**
 * QuickBooks class for calling callback functions/object instance methods/static class methods
 */
class QuickBooks_Callbacks
{
	const TYPE_NONE = 'none';

	const TYPE_FUNCTION = 'function';

	const TYPE_STATIC_METHOD = 'static-method';

	const TYPE_OBJECT_METHOD = 'object-method';

	/**
	 *
	 *
	 */
	static public function callAuthenticate($Driver, $callback, $username, $password, &$customauth_company_file, &$customauth_wait_before_next_update, &$customauth_min_run_every_n_seconds)
	{
		$type = QuickBooks_Callbacks::_type($callback, $Driver);

		if ($Driver)
		{
			// Log the callback for debugging
			$Driver->log('Calling auth callback [type=' . $type . ']', null, QUICKBOOKS_LOG_DEVELOP);
		}

		// Backward compat
		if (is_string($callback))
		{
			$callback = str_replace('function://', '', $callback);
		}

		// Make sure we can pass back an error
		$which = 5;

		$err = null;
		$ret = null;

		$vars = array( $username, $password, &$customauth_company_file, &$customauth_wait_before_next_update, &$customauth_min_run_every_n_seconds, &$err );
		if ($type == QuickBooks_Callbacks::TYPE_OBJECT_METHOD)			// Object instance method hook
		{
			$object = $callback[0];
			$method = $callback[1];

			if ($Driver)
			{
				$Driver->log('Calling auth instance method: ' . get_class($callback[0]) . '->' . $callback[1], null, QUICKBOOKS_LOG_VERBOSE);
			}

			$ret = QuickBooks_Callbacks::_callObjectMethod( array( $object, $method ), $vars, $err, $which);
		}
		else if ($type == QuickBooks_Callbacks::TYPE_FUNCTION)		// Function hook
		{
			$err = '';

			if ($Driver)
			{
				$Driver->log('Calling auth function: ' . $callback, null, QUICKBOOKS_LOG_VERBOSE);
			}

			$ret = QuickBooks_Callbacks::_callFunction($callback, $vars, $err, $which);
		}
		else if ($type == QuickBooks_Callbacks::TYPE_STATIC_METHOD)		// Static method hook
		{
			if ($Driver)
			{
				$Driver->log('Calling auth static method: ' . $callback, null, QUICKBOOKS_LOG_VERBOSE);
			}

			//$tmp = explode('::', $callback);
			//$class = trim(current($tmp));
			//$method = trim(end($tmp));

			$ret = QuickBooks_Callbacks::_callStaticMethod($callback, $vars, $err, $which);
		}
		else
		{
			if ($Driver)
			{
				$Driver->log('Unsupported auth callback type: [gettype=' . gettype($callback) . ']', null, QUICKBOOKS_LOG_VERBOSE);
			}
		}

		if ($err and
			$Driver)
		{
			$Driver->log('Auth callback error: ' . $err, null, QUICKBOOKS_LOG_VERBOSE);
		}

		return $ret;
	}

	/**
	 * Call a callback function
	 *
	 * @param string $function		A valid function name
	 * @param array $vars			An array of arguments to the function
	 * @param string $err			An error message will be passed back to this if an error occurs
	 * @param integer $which		If you want a particular $var to be passed the error message, specify which $var as an integer here (i.e. 0 to fill $var[0], 1 to fill $var[1], etc.)
	 * @return mixed
	 */
	static protected function _callFunction($function, &$vars, &$err, $which = null)
	{
		if (!function_exists($function))
		{
			$err = 'Callback does not exist: [function] ' . $function . '(...)';
			return false;
		}

		$ret = call_user_func_array($function, $vars);

		if (!is_null($which))
		{
			$err = $vars[$which];
		}

		return $ret;
	}

	/**
	 * Call an object method callback (object instance method)
	 *
	 * @param array $object_and_method		An array with two indexes: array( 0 => $object_instance, 1 => 'method_to_call' )
	 * @param array $vars
	 * @param string $err
	 * @param integer $which
	 * @return mixed
	 */
	static protected function _callObjectMethod($object_and_method, &$vars, &$err, $which = null)
	{
		$object = current($object_and_method);
		$method = next($object_and_method);

		if (is_callable(array( $object, $method)))
		{
			$ret = call_user_func_array( array( $object, $method ), $vars);

			if (!is_null($which))
			{
				$err = $vars[$which];
			}

			return $ret;
		}

		$err = 'Object method does not exist: instance of ' . get_class($object) . '->' . $method . '(...)';
		return false;
	}

	/**
	 * Call a static method of a class and return the result
	 *
	 * @param string $class_and_method
	 * @param array $vars
	 * @param string $err
	 * @param integer $which
	 * @return mixed
	 */
	static protected function _callStaticMethod($class_and_method, &$vars, &$err, $which = null)
	{
		$tmp = explode('::', $class_and_method);
		$class = current($tmp);
		$method = next($tmp);

		if (is_callable(array( $class, $method)))
		{
			$ret = call_user_func_array(array( $class, $method ), $vars);

			if (!is_null($which))
			{
				// *** WARNING *** This is a hack for just this _callStaticMethod routine, because the offset doesn't seem to be working correctly for static methods...
				//$which = $which - 1;

				$err = $vars[$which];
			}

			return $ret;
		}

		$err = 'Static method does not exist: ' . $class . '::' . $method . '(...)';
		return false;
	}

	/**
	 * Tell what type of callback this is (a function, an object instance method, a static method, etc.)
	 *
	 *
	 */
	static protected function _type(&$callback, $Driver = null, $ticket = null)
	{
		// This first section turns things like this:   array( 'MyClassName', 'myStaticMethod' )    into this:   'MyClassName::myStaticMethod'
		if (is_array($callback))
		{
			if (isset($callback[0]) and
				isset($callback[1]) and
				is_string($callback[0]) and
				is_string($callback[1]))
			{
				$callback = $callback[0] . '::' . $callback[1];
			}
			else if (isset($callback[0]) and
					 isset($callback[1]) and
					 is_object($callback[0]) and
					 is_string($callback[1]))
			{
				; // Do nothing
			}
			else
			{
				if ($Driver)
				{
					$Driver->log('Invalid callback format: ' . print_r($callback, true), $ticket, QUICKBOOKS_LOG_NORMAL);
				}

				return false;
			}
		}

		// This section actually determines the callback type
		if (!$callback)
		{
			return QUICKBOOKS_CALLBACKS_TYPE_NONE;
		}
		else if (is_array($callback))
		{
			return QUICKBOOKS_CALLBACKS_TYPE_OBJECT_METHOD;
		}
		else if (is_string($callback) and false === strpos($callback, '::'))
		{
			return QUICKBOOKS_CALLBACKS_TYPE_FUNCTION;
		}
		else if (is_string($callback) and false !== strpos($callback, '::'))
		{
			return QUICKBOOKS_CALLBACKS_TYPE_STATIC_METHOD;
		}
		else if (is_object($callback) and $callback instanceof QuickBooks_Hook)
		{
			return QUICKBOOKS_CALLBACKS_TYPE_HOOK_INSTANCE;
		}

		if ($Driver)
		{
			// Log this...
			$Driver->log('Could not determine callback type: ' . gettype($callback), $ticket, QUICKBOOKS_LOG_NORMAL);
		}

		return false;
	}

	/**
	 *
	 *
	 *
	 */

	static public function callAPICallback($Driver, $ticket, $callback, $method, $action, $ID, &$err, $qbxml, $qbobject, $qbres)
	{
		// Determine the type of hook
		$type = QuickBooks_Callbacks::_type($callback, $Driver, $ticket);

		if ($Driver)
		{
			// Log the callback for debugging
			$Driver->log('Calling callback [' . $type . ']: ' . print_r($callback, true), $ticket, QUICKBOOKS_LOG_DEVELOP);
		}

		// The 4th (start at 0: 0, 1, 2, 3) param is the error handler
		$which = 3;

		//             0        1        2    3
		$vars = array( $method, $action, $ID, $err, $qbxml, $qbobject, $qbres );
		if ($type == QUICKBOOKS_CALLBACKS_TYPE_OBJECT_METHOD)			// Object instance method hook
		{
			$object = $callback[0];
			$method = $callback[1];

			if ($Driver)
			{
				$Driver->log('Calling hook instance method: ' . get_class($callback[0]) . '->' . $callback[1], $ticket, QUICKBOOKS_LOG_VERBOSE);
			}

			$ret = QuickBooks_Callbacks::_callObjectMethod( array( $object, $method ), $vars, $err, $which);
			//$ret = call_user_func_array( array( $object, $method ), array( $requestID, $user, $hook, &$err, $hook_data, $callback_config) );
		}
		else if ($type == QUICKBOOKS_CALLBACKS_TYPE_FUNCTION)		// Function hook
		{
			if ($Driver)
			{
				$Driver->log('Calling hook function: ' . $callback, $ticket, QUICKBOOKS_LOG_VERBOSE);
			}

			$ret = QuickBooks_Callbacks::_callFunction($callback, $vars, $err, $which);
			//$ret = $callback($requestID, $user, $hook, $err, $hook_data, $callback_config);
			// 			$requestID, $user, $action, $ident, $extra, $err, $xml, $qb_identifier
		}
		else if ($type == QUICKBOOKS_CALLBACKS_TYPE_STATIC_METHOD)		// Static method hook
		{
			if ($Driver)
			{
				$Driver->log('Calling hook static method: ' . $callback, $ticket, QUICKBOOKS_LOG_VERBOSE);
			}

			//$tmp = explode('::', $callback);
			//$class = trim(current($tmp));
			//$method = trim(end($tmp));

			$ret = QuickBooks_Callbacks::_callStaticMethod($callback, $vars, $err, $which);
			//$ret = call_user_func_array( array( $class, $method ), array( $requestID, $user, $hook, &$err, $hook_data, $callback_config) );
		}
		else
		{
			$err = 'Unsupported callback type for callback: ' . print_r($callback, true);
			return false;
		}

		//QuickBooks_Callbacks::_callFunction($function, &$vars, &$err, $which = null)
		//QuickBooks_Callbacks::_callStaticMethod();
		//QuickBooks_Callbacks::_callObjectMethod();

		// Pass on any error messages
		$err = $vars[$which];

		return $ret;
	}


	/**
	 * Call a hook function / object method / static method
	 *
	 * @param QuickBooks_Driver $Driver		QuickBooks_Driver instance for logging
	 * @param array $hooks					An array of arrays of hooks
	 * @param string $hook					The hook to call
	 * @param string $requestID				The requestID of the request which caused this hook to be called
	 * @param string $user					The username of the QuickBooks user
	 * @param string $ticket				The ticket for the session
	 * @param string $err					Any errors that occur will be passed back here
	 * @param array $hook_data				An array of additional data to be passed to the hook
	 * @param array $callback_config		An array of additional callback data
	 * @return boolean
	 */
	static public function callHook($Driver, &$hooks, $hook, $requestID, $user, $ticket, &$err, $hook_data, $callback_config = array())
	{
		// There's a bug somewhere that passes a null value to this function... ?
		if (!is_array($hooks))
		{
			$hooks = array();
		}

		// First, clean up the hooks array
		foreach ($hooks as $key => $value)
		{
			if (!is_array($value))
			{
				$hooks[$key] = array( $value );
			}
		}

		// Clean up the hook data
		foreach (array( 'requestID' => $requestID, 'user' => $user, 'ticket' => $ticket ) as $key => $value)
		{
			if (empty($hook_data[$key]))
			{
				$hook_data[$key] = $value;
			}
		}

		// Check if the hook is set, if so, call it!
		if (isset($hooks[$hook]))
		{
			// Drop a message in the log
			if ($Driver)
			{
				$Driver->log('Calling hooks for: ' . $hook, $ticket, QUICKBOOKS_LOG_VERBOSE);
			}

			// Loop through the hooks
			foreach ($hooks[$hook] as $callback)
			{
				// Determine the type of hook
				$type = QuickBooks_Callbacks::_type($callback, $Driver, $ticket);

				if ($Driver)
				{
					// Log the callback for debugging
					$Driver->log('Calling callback [' . $type . ']: ' . gettype($callback), $ticket, QUICKBOOKS_LOG_DEVELOP);
				}

				$vars = array( $requestID, $user, $hook, &$err, $hook_data, $callback_config );
				if ($type == QUICKBOOKS_CALLBACKS_TYPE_OBJECT_METHOD)			// Object instance method hook
				{
					$object = $callback[0];
					$method = $callback[1];

					if ($Driver)
					{
						$Driver->log('Calling hook instance method: ' . get_class($callback[0]) . '->' . $callback[1], $ticket, QUICKBOOKS_LOG_VERBOSE);
					}

					$ret = QuickBooks_Callbacks::_callObjectMethod( array( $object, $method ), $vars, $err);
					//$ret = call_user_func_array( array( $object, $method ), array( $requestID, $user, $hook, &$err, $hook_data, $callback_config) );
				}
				else if ($type == QUICKBOOKS_CALLBACKS_TYPE_FUNCTION)		// Function hook
				{
					if ($Driver)
					{
						$Driver->log('Calling hook function: ' . $callback, $ticket, QUICKBOOKS_LOG_VERBOSE);
					}

					$ret = QuickBooks_Callbacks::_callFunction($callback, $vars, $err);
					//$ret = $callback($requestID, $user, $hook, $err, $hook_data, $callback_config);
					// 			$requestID, $user, $action, $ident, $extra, $err, $xml, $qb_identifier
				}
				else if ($type == QUICKBOOKS_CALLBACKS_TYPE_STATIC_METHOD)		// Static method hook
				{
					if ($Driver)
					{
						$Driver->log('Calling hook static method: ' . $callback, $ticket, QUICKBOOKS_LOG_VERBOSE);
					}

					//$tmp = explode('::', $callback);
					//$class = trim(current($tmp));
					//$method = trim(end($tmp));

					$ret = QuickBooks_Callbacks::_callStaticMethod($callback, $vars, $err);
					//$ret = call_user_func_array( array( $class, $method ), array( $requestID, $user, $hook, &$err, $hook_data, $callback_config) );
				}
				else if ($type == QUICKBOOKS_CALLBACKS_TYPE_HOOK_INSTANCE)
				{
					// Just call the ->hook() method

					if ($Driver)
					{
						$Driver->log('Calling hook instance: ' . get_class($callback), $ticket, QUICKBOOKS_LOG_VERBOSE);
					}

					$ret = QuickBooks_Callbacks::_callObjectMethod( array( $callback, 'hook' ), $vars, $err);
				}
				else
				{
					return false;
				}

				// If the hook returns FALSE, then *do not* run all of the other hooks, just return FALSE here
				if ($ret == false)
				{
					return false;
				}
			}
		}

		return true;
	}

	/**
	 *
	 *
	 */
	static public function callRequestHandler($Driver, &$map, $requestID, $action, $user, $ident, $extra, &$err, $last_action_time, $last_actionident_time, $version = '', $locale = array(), $callback_config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks::_callRequestOrResponseHandler($Driver, $map, $requestID, $action, 0, $user, $ident, $extra, $err, $last_action_time, $last_actionident_time, $version, $locale, $callback_config, $qbxml);
	}

	/**
	 *
	 *
	 */
	static public function callResponseHandler($Driver, &$map, $requestID, $action, $user, $ident, $extra, &$err, $last_action_time, $last_actionident_time, $xml = '', $qb_identifiers = array(), $callback_config = array(), $qbxml = null)
	{
		return QuickBooks_Callbacks::_callRequestOrResponseHandler($Driver, $map, $requestID, $action, 1, $user, $ident, $extra, $err, $last_action_time, $last_actionident_time, $xml, $qb_identifiers, $callback_config, $qbxml);
	}

	/**
	 *
	 *
	 * @todo Support for object instance callbacks
	 */
	static protected function _callRequestOrResponseHandler($Driver, &$map, $requestID, $action, $which, $user, $ident, $extra, &$err, $last_action_time, $last_actionident_time, $xml_or_version = '', $qb_identifier_or_locale = array(), $callback_config = array(), $qbxml = null)
	{
		//print_r($map);
		//print('action: ' . $action . "\n");
		//print('which: ' . $which . "\n");

		if (isset($map[$action]))
		{
			$tmp =& $map[$action];
		}
		else if (isset($map['*']))
		{
			$tmp =& $map['*'];
		}
		else
		{
			$tmp = null;
		}

		// Call the appropriate callback function
		if (is_array($tmp))
		{
			if (isset($tmp[$which]))
			{
				$callback = $tmp[$which];
				//$class = '';
				//$method = '';

				/*if (false !== strpos($func, '::'))
				{
					$tmp = explode('::', $func);
					$class = current($tmp);
					$method = end($tmp);
				}*/

				$type = QuickBooks_Callbacks::_type($callback, $Driver, null);

				//$requestID = QuickBooks_Utilities::constructRequestID($action, $ident);
				$vars = array( $requestID, $user, $action, $ident, $extra, &$err, $last_action_time, $last_actionident_time, $xml_or_version, $qb_identifier_or_locale, $callback_config, $qbxml );

				// $class and $method and method_exists($class, $method))
				if ($type == QUICKBOOKS_CALLBACKS_TYPE_OBJECT_METHOD)
				{
					$xml = QuickBooks_Callbacks::_callObjectMethod($callback, $vars, $err);

					return $xml;
				}
				else if ($type == QUICKBOOKS_CALLBACKS_TYPE_STATIC_METHOD)
				{
					$err = '';

					//if (version_compare(PHP_VERSION, '5.3.0', '>='))
					//{
					//	$xml = $class::$method($requestID, $user, $action, $ident, $extra, $err, $xml, $qb_identifier);
					//}
					//else
					//{
						$xml = QuickBooks_Callbacks::_callStaticMethod($callback, $vars, $err);
						//$xml = call_user_func(array( $class, $method ), $requestID, $user, $action, $ident, $extra, $err, $last_action_time, $last_actionident_time, $xml_or_version, $qb_identifier_or_locale, $callback_config, $qbxml);
					//}

					return $xml;
				}
				else if ($type == QUICKBOOKS_CALLBACKS_TYPE_FUNCTION)
				{
					$err = '';

					$xml = QuickBooks_Callbacks::_callFunction($callback, $vars, $err);
					//$xml = $func($requestID, $user, $action, $ident, $extra, $err, $last_action_time, $last_actionident_time, $xml_or_version, $qb_identifier_or_locale, $callback_config, $qbxml);

					return $xml;
				}
				else
				{
					// A function was registered, but the function doesn't exist
					$err = 'Unknown callback type for: ' . $tmp[$which];
				}

				if ($err)
				{
					$Driver->log('A request handler returned an error: ' . $err);
				}
			}
			else
			{
				// There was no function registered for that action and request/response
				$err = 'No function handlers for action: ' . $action;
			}
		}
		else
		{
			// There are *no* functions registered for that action
			$err = 'No registered functions for action: ' . $action;
		}

		return '';
	}

	static public function callAuth($Driver, $callback, $username, $password, &$qb_company_file, &$wait_before_next_update, &$min_run_every_n_seconds, &$err)
	{

	}

	/**
	 *
	 *
	 * @todo Support for object instance error handlers
	 *
	 */
	static public function callErrorHandler($Driver, $errmap, $errnum, $errmsg, $user, $requestID, $action, $ident, $extra, &$errerr, $xml, $callback_config)
	{
		// $Driver, &$map, $action, $which, $user, $action, $ident, $extra, &$err, $last_action_time, $last_actionident_time, $xml_or_version = '', $qb_identifier_or_locale = array(), $callback_config = array(), $qbxml = null

		// Build the requestID
		//$requestID = QuickBooks_Utilities::constructRequestID($action, $ident);

		$callback = '';
		/*if (is_object($this->_instance_onerror) and
			method_exists($this->_instance_onerror, 'e' . $errnum))
		{
			$func = get_class($this->_instance_onerror) . '->e' . $errnum;
		}*/
		//else

		if (isset($errmap[$errnum]))	//  and function_exists($this->_onerror[$errnum])
		{
			$callback = $errmap[$errnum];
		}
		else if (isset($errmap[$action]))
		{
			$callback = $errmap[$action];
		}
		else if (isset($errmap['!']))		// catch-all error handler		//  and function_exists($this->_onerror['!'])
		{
			$callback = $errmap['!'];
		}
		else if (isset($errmap['*']))		// catch-all error handler		//  and function_exists($this->_onerror['*'])
		{
			$callback = $errmap['*'];
		}

		// Determine the type of hook
		$type = QuickBooks_Callbacks::_type($callback, $Driver, null);

		$vars = array( $requestID, $user, $action, $ident, $extra, &$errerr, $xml, $errnum, $errmsg, $callback_config );

		$errerr = '';
		if ($type == QUICKBOOKS_CALLBACKS_TYPE_OBJECT_METHOD)			// Object instance method hook
		{
			$Driver->log('Object method error handler: ' . get_class($callback[0]) . '->' . $callback[1], null, QUICKBOOKS_LOG_VERBOSE);

			$errerr = '';
			$continue = QuickBooks_Callbacks::_callObjectMethod($callback, $vars, $errerr, 5);

			if ($errerr)
			{
				$Driver->log('Error handler returned an error: ' . $errerr, null, QUICKBOOKS_LOG_NORMAL);
				return false;
			}
		}
		else if ($type == QUICKBOOKS_CALLBACKS_TYPE_FUNCTION)		// Function hook
		{
			// It's a callback FUNCTION

			$Driver->log('Function error handler: ' . $callback, null, QUICKBOOKS_LOG_VERBOSE);

			$errerr = '';	// This is an error message *returned by* the error handler function
			$continue = QuickBooks_Callbacks::_callFunction($callback, $vars, $errerr, 5);
			//$continue = $func($requestID, $user, $action, $ident, $extra, $errerr, $xml, $errnum, $errmsg, $callback_config);

			if ($errerr)
			{
				$Driver->log('Error handler returned an error: ' . $errerr, null, QUICKBOOKS_LOG_NORMAL);
				return false;
			}
		}
		else if ($type == QUICKBOOKS_CALLBACKS_TYPE_STATIC_METHOD)		// Static method hook
		{
			// It's a callback STATIC METHOD

			//$tmp = explode('::', $func);
			//$class = trim(current($tmp));
			//$method = trim(end($tmp));

			$Driver->log('Static method error handler: ' . $callback, null, QUICKBOOKS_LOG_VERBOSE);

			$errerr = '';
			$continue = QuickBooks_Callbacks::_callStaticMethod($callback, $vars, $errerr, 5);

			if ($errerr)
			{
				$Driver->log('Error handler returned an error: ' . $errerr, null, QUICKBOOKS_LOG_NORMAL);
				return false;
			}
		}
		else
		{
			return false;
		}

		return $continue;
	}
}
