<?php

/**
 * 
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
class QuickBooks_Callbacks_API_Errors
{
	/**
	 * Alias of QuickBooks_Server_API_Errors::e500_notfound    (QuickBooks sometimes returns a 1 error code, sometimes a 500 error code)
	 */
	static public function e1_notfound($requestID, $user, $action, $ident, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		return QuickBooks_Callbacks_API_Errors::e500_notfound($requestID, $user, $action, $ident, $extra, $err, $xml, $errnum, $errmsg, $config);
	}
	
	/**
	 * Handle a QuickBooks error indicating that nothing matched a search
	 * 
	 * For whatever strange reason, instead of returning an empty result set 
	 * when you do a search that returns no results, QuickBooks instead returns 
	 * an error message. The error message code might be either 1 or 500 
	 * depending on what filters you use in your query.  
	 * 
	 * @TODO This should use the QuickBooks_Callbacks class, and not it's own custom callback code
	 * 
	 * @param string $requestID
	 * @param string $user
	 * @param string $action
	 * @param mixed $ident
	 * @param mixed $extra
	 * @param string $err
	 * @param string $xml
	 * @param integer $errnum
	 * @param string $errmsg
	 * @param array $config
	 * @return boolean
	 */
	static public function e500_notfound($requestID, $user, $action, $ident, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		//$requestID, $user, $action, $ident, $extra, $errerr, $xml, $errnum, $errmsg, $this->_callback_config
		// Not found, *still call the callback!*
		
		/*
		$extra['callbacks'], $method, $action, $ID, $err, $qbxml, $qbobject, $qbres
		*/
		
		// Get the driver instance
		$Driver = QuickBooks_Driver_Singleton::getInstance();
		
		if (!isset($extra['callbacks']))
		{
			$extra['callbacks'] = array();
		} 
		
		if (!is_array($extra['callbacks']))
		{
			$extra['callbacks'] = array( $extra['callbacks'] );
		}
		
		$method = null;
		if (isset($extra['method']))
		{
			$method = $extra['method'];
		}
		
		$err = '';
		
		$qbobject = new QuickBooks_Iterator(array());
		$qbres = null;
		
		foreach ($extra['callbacks'] as $func)
		{
			if (false !== strpos($func, '::') and 
				true) // method_exists()) 	// is this safe to do?
			{
				// Callback *static method*
				
				$tmp = explode('::', $func);
				
				$return = call_user_func(array( $tmp[0], $tmp[1] ), $method, $action, $ident, $err, $xml, $qbobject, $qbres);
			}
			else if (function_exists($func))
			{
				// Callback *function* 
				
				$return = call_user_func($func, $method, $action, $ident, $err, $xml, $qbobject, $qbres);
			}
			else
			{
				$err = 'Could not call function or method: ' . $func;
				$Driver->log('API: ' . $err, null, QUICKBOOKS_LOG_NORMAL);
				return false;
			}
			
			if (!$return)
			{
				break;
			}
		}
		
		if ($err)
		{
			return false;
		}
		
		return true;
	}
	
	static public function catchall($requestID, $user, $action, $ident, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		
		return false;
	}
}
