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
class QuickBooks_Server_Bridge_Errors
{
	static public function catchall($requestID, $user, $action, $ident, $extra, &$err, $xml, $errnum, $errmsg, $config)
	{
		$idents = array();
		
		return QuickBooks_Server_Bridge_Callbacks::prebuiltBridgeResponse($requestID, $user, $action, $ident, $extra, $err, null, null, $xml, $idents, $config);
	}
}

