<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt  
 * 
 * @package QuickBooks
 * @subpackage Server
 */

/**
 * 
 * 
 * 
 */
class QuickBooks_Server_Bridge_Callbacks
{
	static public function prebuiltBridgeRequest($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $version, $locale, $config = array(), $qbxml = null)
	{
		return $qbxml;
	}
	
	static public function prebuiltBridgeResponse($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents, $config = array())
	{
		//print_r($config);
		//print_r($extra);
		
		if (is_object($config['__transport_output']))
		{
			$Transport =& $config['__transport_output'];
			$Driver = QuickBooks_Driver_Singleton::getInstance();
			
			$Transport->output(
				$Driver, 
				$extra['__method'], 
				$action, 
				$ID, 
				$extra['__replace'], 
				$extra['__priority'], 
				$extra['__extra'], 
				$xml, 
				$extra['__id']);
		}
	}
}

