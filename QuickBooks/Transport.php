<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt  
 * 
 * @package QuickBooks
 * @subpackage Transport
 */

/**
 *
 */
define('QUICKBOOKS_TRANSPORT_MODE_INPUT', 'input');

/**
 * 
 */
define('QUICKBOOKS_TRANSPORT_MODE_OUTPUT', 'output');

define('QUICKBOOKS_TRANSPORT_QUEUE_ACTION', 'Bridge');

define('QUICKBOOKS_TRANSPORT_METHOD_ENQUEUE', 'enqueue');

define('QUICKBOOKS_TRANSPORT_METHOD_EXISTS', 'exists');

define('QUICKBOOKS_TRANSPORT_METHOD_RECUR', 'recur');

define('QUICKBOOKS_TRANSPORT_ERROR_OK', 0);
define('QUICKBOOKS_TRANSPORT_ERROR_MISSING', 1);
define('QUICKBOOKS_TRANSPORT_ERROR_VALIDATE', 2);

define('QUICKBOOKS_TRANSPORT_STATUS_ERR', 'Error');
define('QUICKBOOKS_TRANSPORT_STATUS_OK', 'OK');


/**
 * 
 * 
 * 
 * 
 */
abstract class QuickBooks_Transport
{
	/**
	 * 
	 */
	abstract public function __construct($dsn, $mode, $user, $action, $config = array());
	
	/**
	 *
	 */
	abstract public function input($Driver);
	
	/**
	 *
	 */
	abstract public function output($Driver, $method, $action, $ident, $replace, $priority, $extra, $qbxml, $id);
	
	/**
	 *
	 */
	abstract public function ready();
}
