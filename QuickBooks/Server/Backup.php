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

define('QUICKBOOKS_SERVER_BACKUP_MODE_QBXMLRESPONSE', 'qbxml-response');
define('QUICKBOOKS_SERVER_BACKUP_MODE_QBXMLREQUEST', 'qbxml-request');
define('QUICKBOOKS_SERVER_BACKUP_MODE_QBXMLRAW', 'raw');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Server.php');

/**
 * 
 */
class QuickBooks_Server_Backup extends QuickBooks_Server
{
	/**
	 * 
	 * 
	 * 
	 * 
	 * @param string $dsn_or_conn
	 * @param char $mode
	 * @param array $types
	 * @param array $soap_options
	 * @param array $handler_options
	 * @param array $driver_options
	 */
	public function __construct($dsn_or_conn, $mode, $types = array(), $soap_options = array(), $handler_options = array(), $driver_options = array())
	{
		
	}
}
