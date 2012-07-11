<?php

/**
 * QuickBooks driver base class
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * The Driver classes act as back-end to the Queue class and SOAP server. 
 * Driver classes should extend this base class and implement all abstract 
 * methods.  
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt
 * 
 * @package QuickBooks
 * @subpackage Driver
 */

/**
 * Hook called by the ->authCheck() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHCHECK', 'QuickBooks_Driver::authCheck');

/**
 * Hook called by the ->authCreate() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHCREATE', 'QuickBooks_Driver::authCreate');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHDEFAULT', 'QuickBooks_Driver::authDefault');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHLOGIN', 'QuickBooks_Driver::authLogin');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHLOGOUT', 'QuickBooks_Driver::authLogout');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE', 'QuickBooks_Driver::authResolve');

/**
 * Hook called by the ->authDisable() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHDISABLE', 'QuickBooks_Driver::authDisable');

/**
 * Hook called by the ->authEnable() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHENABLE', 'QuickBooks_Driver::authEnable');

/**
 * 
 */
define('QUICKBOOKS_DRIVER_HOOK_AUTHLAST', 'QuickBooks_Driver::authLast');

/**
 * Hook called by the ->authView() method
 * @var string
 */
//define('QUICKBOOKS_DRIVER_HOOK_AUTHVIEW', 'QuickBooks_Driver::authView');

/**
 * Hook called by the ->authSize() method
 * @var string
 */
//define('QUICKBOOKS_DRIVER_HOOK_AUTHSIZE', 'QuickBooks_Driver::authSize');

/**
 * Hook called by the ->noop() method 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_NOOP', 'QuickBooks_Driver::noop');

/**
 * Hook called by the ->errorLog() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_ERRORLOG', 'QuickBooks_Driver::errorLog');

/**
 * Hook called by the ->errorLast() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_ERRORLAST', 'QuickBooks_Driver::errorLast');

/**
 * Hook called by the ->log() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_LOG', 'QuickBooks_Driver::log');

/**
 * Hook called by the ->logSize() method
 * @var string
 */
//define('QUICKBOOKS_DRIVER_HOOK_LOGSIZE', 'QuickBooks_Driver::logSize');

/**
 * Hook called by the ->logView() method
 * @var string
 */
//define('QUICKBOOKS_DRIVER_HOOK_LOGVIEW', 'QuickBooks_Driver::logView');

/**
 * 
 * @var string
 */
//define('QUICKBOOKS_DRIVER_HOOK_IDENTFETCH', 'QuickBooks_Driver::identFetch');

/**
 * Hook called by the ->identToApplication() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_IDENTTOAPPLICATION', 'QuickBooks_Driver::identToApplication');

/**
 * Hook called by the ->identToQuickBooks() method
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_IDENTTOQUICKBOOKS', 'QuickBooks_Driver::identToQuickBooks');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_IDENTMAP', 'QuickBooks_Driver::identMap');

//define('QUICKBOOKS_DRIVER_HOOK_IDENTVIEW', 'QuickBooks_Driver::identView');

//define('QUICKBOOKS_DRIVER_HOOK_IDENTSIZE', 'QuickBooks_Driver::identSize');

define('QUICKBOOKS_DRIVER_HOOK_QUEUELEFT', 'QuickBooks_Driver::queueLeft');

//define('QUICKBOOKS_DRIVER_HOOK_QUEUEVIEW', 'QuickBooks_Driver::queueView');

define('QUICKBOOKS_DRIVER_HOOK_QUEUEEXISTS', 'QuickBooks_Driver::queueExists');

define('QUICKBOOKS_DRIVER_HOOK_QUEUEREMOVE', 'QuickBooks_Driver::queueRemove');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_QUEUEACTIONLAST', 'QuickBooks_Driver::queueActionLast');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_QUEUEACTIONIDENTLAST', 'QuickBooks_Driver::queueActionIdentLast');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_QUEUEDEQUEUE', 'QuickBooks_Driver::queueDequeue');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_QUEUEENQUEUE', 'QuickBooks_Driver::queueEnqueue');

/**
 * 
 * @var string
 */
/*
define('QUICKBOOKS_DRIVER_HOOK_QUEUEFETCH', 'QuickBooks_Driver::queueFetch');
*/

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_QUEUEPROCESSED', 'QuickBooks_Driver::queueProcessed');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_QUEUEPROCESSING', 'QuickBooks_Driver::queueProcessing');

/**
 * 
 * @var string
 */
//define('QUICKBOOKS_DRIVER_HOOK_QUEUESIZE', 'QuickBooks_Driver::queueSize');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_QUEUESTATUS', 'QuickBooks_Driver::queueStatus');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_RECURDEQUEUE', 'QuickBooks_Driver::recurDequeue');

/**
 * 
 * @var string
 */
define('QUICKBOOKS_DRIVER_HOOK_RECURENQUEUE', 'QuickBooks_Driver::recurEnqueue');

/**
 * 
 */
//define('QUICKBOOKS_DRIVER_HOOK_RECURVIEW', 'QuickBooks_Driver::recurView');

/**
 * 
 */
define('QUICKBOOKS_DRIVER_HOOK_INITIALIZED', 'QuickBooks_Driver::initialized');

/**
 * 
 */
define('QUICKBOOKS_DRIVER_HOOK_INITIALIZE', 'QuickBooks_Driver::initialize');

/**
 * 
 */
define('QUICKBOOKS_DRIVER_HOOK_CONFIGREAD', 'QuickBooks_Driver::configRead');

/**
 * 
 */
define('QUICKBOOKS_DRIVER_HOOK_CONFIGWRITE', 'QuickBooks_Driver::configWrite');

/**
 * 
 */
define('QUICKBOOKS_DRIVER_HOOK_CONNECTIONLOAD', 'QuickBooks_Driver::connectionLoad');

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Encryption.php');

/**
 * QuickBooks driver base class
 */
abstract class QuickBooks_Driver
{
	const HOOK_QUEUEREPORT = 'QuickBooks_Driver::queueReport';
	
	const HOOK_QUEUEGET = 'QuickBooks_Driver::queueGet';
	
	/**
	 * An array of hooks (map of hook-types => array( 'userdef1', 'userdef2', ... )
	 * @var array
	 */
	protected $_hooks;
	
	/**
	 * 
	 * @var integer
	 */
	protected $_loglevel;
	
	/**
	 * Constructor
	 * 
	 * @param string $dsn		A DSN-style connection string
	 * @param array $config		An array of configuration information
	 */
	abstract public function __construct($dsn, $config);
	
	/**
	 * Register the set of user-defined hook functions
	 * 
	 * @param array $hooks
	 * @return void
	 */
	final public function registerHooks($hooks)
	{
		if (!is_array($hooks))
		{
			$hooks = array();
		}
		
		foreach ($hooks as $hook => $funcs)
		{
			if (!is_array($funcs))
			{
				$funcs = array( $funcs );
			}
			
			$this->_hooks[$hook] = $funcs;
		}
	}
	
	/*
	final public function connectionLoad($user)
	{
		$hookdata = array(
			'username' => $user, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_CONNECTIONLOAD, null, $hookerr, $hookdata);
		
		$arr = $this->_connectionLoad($user);
		
		if (!empty($arr['connection_ticket']))
		{
			$crypt = QuickBooks_Encryption_Factory::determine($arr['connection_ticket']);
			
			if ($crypt)
			{
				// Do the decryption... 
			}
		}
		
		return $arr;
	}
	*/
	
	/**
	 * Set the logging level for the driver class
	 * 
	 * @param integer $lvl
	 * @return void
	 */
	final public function setLogLevel($lvl)
	{
		$this->_loglevel = $lvl;
	}
	
	final public function noop()
	{
		$hookdata = array(
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_NOOP, null, $hookerr, $hookdata);
		
		return $this->_noop();
	}
	
	abstract protected function _noop();
	
	/**
	 * Tell the number of records in the idents mapping table
	 * 
	 * @param string $match
	 * @return integer
	 */
	/*final public function identSize($match = '')
	{
		$hookdata = array(
			'match' => $match, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_IDENTSIZE, null, $hookerr, $hookdata);
		
		return $this->_identSize($match);
	}*/
	
	/**
	 * @see QuickBooks_Driver::identSize()
	 */
	/*abstract protected function _identSize($match);*/
	
	/**
	 * Map an application identifier to a QuickBooks identifier
	 * 
	 * @param string $action
	 * @param mixed $ident
	 * @return string
	 */
	/*
	final public function identToQuickBooks($user, $type, $uniqueid, &$editsequence, &$extra)
	{
		$hookdata = array(
			'username' => $user, 
			'type' => $type, 
			'uniqueid' => $uniqueid,
			'webapp_ID' => $uniqueid, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_IDENTTOQUICKBOOKS, null, $hookerr, $hookdata);
		
		switch ($type)
		{
			case QUICKBOOKS_OBJECT_ITEM:
				// The problem with this is it's generic... ServiceItems, InventoryItem, NonInventoryItem, etc... 
				//	We'll try to look up the others if we can't find the generic one
				
				$arr = array(
					QUICKBOOKS_OBJECT_ITEM, 
					QUICKBOOKS_OBJECT_INVENTORYITEM, 
					QUICKBOOKS_OBJECT_GROUPITEM, 
					QUICKBOOKS_OBJECT_NONINVENTORYITEM, 
					QUICKBOOKS_OBJECT_DISCOUNTITEM,
					QUICKBOOKS_OBJECT_FIXEDASSETITEM,
					QUICKBOOKS_OBJECT_PAYMENTITEM,
					QUICKBOOKS_OBJECT_SERVICEITEM,
					QUICKBOOKS_OBJECT_SALESTAXITEM,
					QUICKBOOKS_OBJECT_OTHERCHARGEITEM, 
					QUICKBOOKS_OBJECT_INVENTORYASSEMBLYITEM, 
					// QUICKBOOKS_OBJECT_RECEIPTITEM, 		// This is *not* a type of item, it's a type of transaction!
					);
				
				foreach ($arr as $type)
				{
					if ($ident = $this->_identToQuickBooks($user, $type, $uniqueid, $editsequence, $extra))
					{
						return $ident;
					}
				}
				
				break;
			default:
				return $this->_identToQuickBooks($user, $type, $uniqueid, $editsequence, $extra);
		}
		
		return null;
	}
	*/
	
	/**
	 * @see QuickBooks_Driver::identFetch()
	 */
	/*
	abstract protected function _identToQuickBooks($user, $action, $uniqueid, &$editsequence, &$extra);
	
	final public function identToApplication($user, $type, $qbid, &$extra)
	{
		$hookdata = array(
			'username' => $user, 
			'type' => $type, 
			'ident' => $qbid,
			'ListID_or_TxnID' => $qbid,   
			'extra' => $extra, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_IDENTTOAPPLICATION, null, $hookerr, $hookdata);
		
		return $this->_identToApplication($user, $type, $qbid, $extra);
	}
	
	abstract protected function _identToApplication($user, $action, $qbid, &$extra);
	*/
	
	/**
	 * 
	 * 
	 * 
	 */
	/*
	final public function identMap($user, $type, $uniqueid, $qb_ident, $editsequence = '', $extra = null)
	{
		$hookdata = array(
			'username' => $user, 
			'action' => $type,
			'type' => $type,  
			'uniqueid' => $uniqueid, 
			'webapp_ID' => $uniqueid, 
			'ident' => $qb_ident, 
			'ListID_or_TxnID' => $qb_ident, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_IDENTMAP, null, $hookerr, $hookdata);
		
		return $this->_identMap($user, $type, $uniqueid, $qb_ident, $editsequence);
	} 
	*/
	
	/**
	 * @see QuickBooks_Driver::identMap()
	 */
	/*
	abstract protected function _identMap($user, $action, $uniqueid, $qb_ident, $editsequence = '', $extra = null);
	*/
	
	/**
	 * 
	 * 
	 * @param integer $offset
	 * @param integer $limit
	 * @param string $match
	 * @return QuickBooks_Iterator
	 */
	/*final public function identView($offset, $limit, $match = '')
	{
		$offset = max(0, (int) $offset);
		$limit = max(1, (int) $limit);
		
		$hookdata = array(
			'offset' => $offset, 
			'limit' => $limit, 
			'match' => $match, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_IDENTVIEW, null, $hookerr, $hookdata);
		
		return $this->_identView($offset, $limit, $match);
	}*/
	
	/**
	 * @see QuickBooks_Driver::identView()
	 */
	/*abstract protected function _identView($offset, $limit, $match);*/

	/**
	 * Place an action into the queue, along with a unique identifier (if neccessary)
	 * 
	 * Example: 
	 * <code>
	 * 	$driver->queueEnqueue('CustomerAdd', 1234); // Push customer #1234 over to QuickBooks
	 * </code>
	 * 
	 * @param string $action	The QuickBooks action to do
	 * @param mixed $ident		A unique identifier 
	 * @return boolean
	 */
	final public function queueEnqueue($user, $action, $ident, $replace = true, $priority = 0, $extra = null, $qbxml = null)
	{
		if (!strlen($ident))
		{
			// If they didn't provide an $ident, generate a random, unique one
			
			$tmp = array_merge(range('a', 'z'), range(0, 9));
			shuffle($tmp);
			$ident = substr(implode('', $tmp), 0, 8);
		}
		
		$hookdata = array(
			'username' => $user, 
			'action' => $action, 
			'ident' => $ident, 
			'replace' => $replace, 
			'priority' => $priority, 
			'extra' => $extra, 
			'qbxml' => $qbxml, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, null, $hookerr, $hookdata);
		
		return $this->_queueEnqueue($user, $action, $ident, $replace, $priority, $extra, $qbxml);
	}
	
	/**
	 * @see QuickBooks_Driver::queueEnqueue()
	 */
	abstract protected function _queueEnqueue($user, $action, $ident, $replace = true, $priority = 0, $extra = null, $qbxml = null);
	
	/**
	 * Remove an item from the queue
	 * 
	 * @param boolean $by_priority	If TRUE, remove the item with the highest priority next
	 * @return boolean
	 */
	final public function queueDequeue($user, $by_priority = false)
	{
		$hookdata = array(
			'username' => $user, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, null, $hookerr, $hookdata);
		
		return $this->_queueDequeue($user, $by_priority);
	}
	
	/**
	 * @see QuickBooks_Driver::queueDequeue()
	 */
	abstract protected function _queueDequeue($user, $by_priority = false);
	
	/**
	 * Fetch the item currently being processed by QuickBooks
	 * 
	 * @param string $user
	 * @return array
	 */
	final public function queueProcessing($user)
	{
		$hookdata = array(
			'username' => $user, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUEPROCESSING, null, $hookerr, $hookdata);
		
		return $this->_queueProcessing($user);		
	}
	
	/**
	 * @see QuickBooks_Driver::queueProcessing()
	 */
	abstract protected function _queueProcessing($user);
	
	/**
	 * Create a recurring event which will be queued up every so often...
	 * 
	 * @param integer $run_every
	 * @param string $action
	 * @param mixed $ident
	 * @param boolean $replace
	 * @param integer $priority
	 * @param mixed $extra
	 * @return boolean
	 */
	final public function recurEnqueue($user, $run_every, $action, $ident, $replace = true, $priority = 0, $extra = null, $qbxml = null)
	{
		$hookdata = array(
			'username' => $user, 
			'interval' => $run_every, 
			'action' => $action, 
			'ident' => $ident, 
			'replace' => $replace, 
			'priority' => $priority, 
			'extra' => $extra, 
			'qbxml' => $qbxml, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, null, $hookerr, $hookdata);
		
		return $this->_recurEnqueue($user, $run_every, $action, $ident, $replace, $priority, $extra, $qbxml);
	}
	
	/**
	 * @see QuickBooks_Driver::recurEnqueue()
	 */
	abstract protected function _recurEnqueue($user, $run_every, $action, $ident, $replace = true, $priority = 0, $extra = null, $qbxml = null);
	
	/**
	 * Fetch the next recurring event from the recurring event queue
	 * 
	 * @param boolean $by_priority
	 * @return boolean
	 */
	final public function recurDequeue($user, $by_priority = false)
	{
		$hookdata = array(
			'username' => $user, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, null, $hookerr, $hookdata);
		
		return $this->_recurDequeue($user, $by_priority);
	}
	
	/**
	 * @see QuickBooks_Driver::recurDequeue()
	 */
	abstract protected function _recurDequeue($user, $by_priority = false);
	
	/** 
	 * 
	 * 
	 * 
	 */ 
	final public function configWrite($user, $module, $key, $value, $type = null, $opts = null)
	{
		//$module = strtolower($module);
		
		$hookdata = array(
			'username' => $user, 
			'module' => $module, 
			'key' => $key, 
			'value' => $value, 
			'type' => $type, 
			'opts' => $opts, 
			);
		$hookerr = '';	
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_CONFIGWRITE, null, $hookerr, $hookdata);
		
		return $this->_configWrite($user, $module, $key, $value, $type, $opts);
	}
	
	/**
	 * @see QuickBooks_Driver::configWrite()
	 */
	abstract protected function _configWrite($user, $module, $key, $value, $type, $opts);
	
	/**
	 * 
	 * 
	 * 
	 */
	final public function configRead($user, $module, $key, &$type, &$opts)
	{
		//$module = strtolower($module);
		
		$hookdata = array(
			'username' => $user, 
			'module' => $module, 
			'key' => $key, 
			);
		$hookerr = '';	
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_CONFIGREAD, null, $hookerr, $hookdata);
		
		return $this->_configRead($user, $module, $key, $type, $opts);
	}
	
	/** 
	 * @see QuickBooks_Driver::configRead()
	 */
	abstract protected function _configRead($user, $module, $key, &$type, &$opts);
	
	/**
	 * Forcibly remove an item from the queue
	 * 
	 * @param string $user
	 * @param string $action
	 * @param mixed $ident
	 * @return boolean
	 */
	final public function queueRemove($user, $action, $ident)
	{
		$hookdata = array(
			'username' => $user, 
			'action' => $action, 
			'ident' => $ident
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUEREMOVE, null, $hookerr, $hookdata);
		
		return $this->_queueRemove($user, $action, $ident);
	}
	
	/**
	 * @see QuickBooks_Driver::queueRemove()
	 */
	abstract protected function _queueRemove($user, $action, $ident);
	
	/**
	 * Update the status of a particular item in the queue
	 * 
	 * @param string $ticket		The ticket of the process which is updating the status
	 * @param string $action		The action
	 * @param mixed $ident			The ident string
	 * @param char $new_status		The new status code (QUICKBOOKS_STATUS_SUCCESS, QUICKBOOKS_STATUS_ERROR, etc.)
	 * @param string $msg			An error message (if an error message occured)
	 * @return boolean
	 */
	//final public function queueStatus($ticket, $action, $ident, $new_status, $msg = '')
	final public function queueStatus($ticket, $requestID, $new_status, $msg = '')
	{
		$user = $this->_authResolve($ticket);
		
		$hookdata = array(
			'username' => $user, 
			//'action' => $action, 
			//'ident' => $ident, 
			'requestID' => $requestID, 
			'status' => $new_status, 
			'message' => $msg, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUESTATUS, $ticket, $hookerr, $hookdata);
		
		//return $this->_queueStatus($ticket, $action, $ident, $new_status, $msg);
		return $this->_queueStatus($ticket, $requestID, $new_status, $msg);
	}
	
	/**
	 * @see QuickBooks_Driver::queueStatus()
	 */
	//abstract protected function _queueStatus($ticket, $action, $ident, $new_status, $msg = '');
	abstract protected function _queueStatus($ticket, $requestID, $new_status, $msg = '');

	final public function queueGet($user, $requestID, $status = QUICKBOOKS_STATUS_QUEUED)
	{
		//$user = $this->_authResolve($ticket);
		
		$hookdata = array(
			'username' => $user, 
			//'action' => $action, 
			//'ident' => $ident, 
			'requestID' => $requestID, 
			'status' => $status, 
			);
		$hookerr = '';
		$this->_callHook(QuickBooks_Driver::HOOK_QUEUEGET, null, $hookerr, $hookdata);
		
		//return $this->_queueStatus($ticket, $action, $ident, $new_status, $msg);
		return $this->_queueGet($user, $requestID, $status);
	}
	
	/**
	 * @see QuickBooks_Driver::queueStatus()
	 */
	//abstract protected function _queueStatus($ticket, $action, $ident, $new_status, $msg = '');
	abstract protected function _queueGet($user, $requestID, $status = QUICKBOOKS_STATUS_QUEUED);
	
	/**
	 * Tell the number of items left in the queue
	 * 
	 * @todo For consistency, this should *not* accept a user parameter, maybe use queueLeft() instead?
	 * 
	 * @return integer
	 */
	/*final public function queueSize($match = '')
	{
		$hookdata = array(
			'match' => $match,   
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUESIZE, null, $hookerr, $hookdata);
		
		return $this->_queueSize($match);
	}*/
	
	/**
	 * @see QuickBooks_Driver::queueSize()
	 */
	/*abstract protected function _queueSize($match = '');*/
	
	/**
	 * Tell the number of queued items left in the queue for a given user
	 * 
	 * @param string $user
	 * @param boolean $queued
	 * @return integer 
	 */
	final public function queueLeft($user, $queued = true)
	{
		$hookdata = array(
			'username' => $user,
			'queued' => $queued,  
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUELEFT, null, $hookerr, $hookdata);
		
		return $this->_queueLeft($user, $queued);
	}
	
	/**
	 * @see QuickBooks_Driver::queueLeft()
	 */
	abstract protected function _queueLeft($user, $queued = true);
	
	/**
	 * Get a list of records from the queue for use in a report
	 *
	 * @param string $date_from
	 * @param string $date_to
	 * @param integer $offset
	 * @param integer $limit
	 * @return array
	 */
	final public function queueReport($user, $date_from, $date_to, $offset = 0, $limit = null)
	{
		$offset = max(0, (int) $offset);
		$limit = min(999999999, (int) $limit);
		
		$hookdata = array(
			'offset' => $offset, 
			'limit' => $limit, 
			'from' => $date_from, 
			'to' => $date_to, 
			);
		$hookerr = '';
		$this->_callHook(QuickBooks_Driver::HOOK_QUEUEREPORT, null, $hookerr, $hookdata);
		
		return $this->_queueReport($user, $date_from, $date_to, $offset, $limit);
	}
	
	/**
	 * @see QuickBooks_Driver::queueReport()
	 */
	abstract protected function _queueReport($user, $date_from, $date_to, $offset, $limit);	
	
	/**
	 * 
	 * 
	 * @param integer $offset
	 * @param integer $limit
	 * @param string $match
	 * @return QuickBooks_Iterator
	 */
	/*final public function queueView($offset, $limit, $match = '')
	{
		$offset = max(0, (int) $offset);
		$limit = max(1, (int) $limit);
		
		$hookdata = array(
			'offset' => $offset, 
			'limit' => $limit, 
			'match'=> $match
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUEVIEW, null, $hookerr, $hookdata);
		
		return $this->_queueView($offset, $limit, $match);
	}*/
	
	/**
	 * @see QuickBooks_Driver::queueView()
	 */
	/*abstract protected function _queueView($offset, $limit, $match);*/
	
	/**
	 * Fetch a specific item from the queue
	 * 
	 * @param string $action
	 * @param mixed $ident
	 * @param char $status
	 * @return array 
	 */
	/*
	final public function queueFetch($user, $action, $ident, $status = QUICKBOOKS_STATUS_QUEUED)
	{
		$hookdata = array(
			'username' => $user, 
			'action' => $action, 
			'ident' => $ident, 
			'status' => $status, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUEFETCH, null, $hookerr, $hookdata);
		
		return $this->_queueFetch($user, $action, $ident, $status);
	}
	*/
	
	/**
	 * @see QuickBooks_Driver::queueFetch()
	 */
	/*
	abstract protected function _queueFetch($user, $action, $ident, $status = QUICKBOOKS_STATUS_QUEUED);
	*/
	
	/**
	 * Tell how many commands have been processed during this login session
	 * 
	 * @param string $ticket		The ticket for the login session
	 * @return integer				The number of commands processed so far
	 */
	final public function queueProcessed($ticket)
	{
		$hookdata = array();
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUEPROCESSED, $ticket, $hookerr, $hookdata);
		
		return $this->_queueProcessed($ticket);
	}

	/**
	 * @see QuickBooks_Driver::queueProcessed()
	 */
	abstract protected function _queueProcessed($ticket);
	
	/**
	 * Tell whether or not an item exists in the queue
	 * 
	 * @param string $action
	 * @param mixed $ident
	 * @return boolean
	 */
	final public function queueExists($user, $action, $ident)
	{
		$hookdata = array(
			'username' => $user, 
			'action' => $action, 
			'ident' => $ident, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_QUEUEEXISTS, null, $hookerr, $hookdata);
		
		return $this->_queueExists($user, $action, $ident);
	}
	
	/**
	 * @see QuickBooks_Driver::queueExists()
	 */
	abstract protected function _queueExists($user, $action, $ident);
	
	/**
	 * Tell when the last time an action of this type was dequeued
	 * 
	 * @param string $user		Username of the user 
	 * @param string $action	The action to find the last dequeue time for
	 * @return integer			A UNIX timestamp
	 */
	/*
	final public function queueActionLast($user, $action)
	{
		$hookdata = array(
			'username' => $user, 
			'action' => $action, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, null, $hookerr, $hookdata);
		
		return $this->_queueActionLast($user, $action);
	}
	*/
	
	/**
	 * @see QuickBooks_Driver::queueActionLast()
	 */
	/*
	abstract protected function _queueActionLast($user, $action);
	*/
	
	/**
	 * Tell when the last time this combination of action/ident was dequeued 
	 * 
	 * @param string $user		Username of the user to look at
	 * @param string $action	The action to find the last dequeue time for
	 * @param mixed $ident		The ident string/integer to find the last dequeue time for
	 * @return integer			An UNIX timestamp indicating the last time this combo was dequeued
	 */
	/*
	final public function queueActionIdentLast($user, $action, $ident)
	{
		$hookdata = array(
			'username' => $user, 
			'action' => $action, 
			'ident' => $ident, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, null, $hookerr, $hookdata);
		
		return $this->_queueActionIdentLast($user, $action, $ident);
	}
	*/
	
	/**
	 * @see QuickBooks_Driver::queueActionIdentLast()
	 */
	/*
	abstract protected function _queueActionIdentLast($user, $action, $ident);
	*/
	
	/**
	 * Log an error that occured for a specific ticket
	 * 
	 * @param string $ticket
	 * @param string $errno
	 * @param string $errstr
	 * @return boolean
	 */
	final public function errorLog($ticket, $errno, $errstr)
	{
		$hookdata = array(
			'errno' => $errno, 
			'errstr' => $errstr, 
			);
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, $ticket, $hookerr, array());
				
		return $this->_errorLog($ticket, $errno, $errstr);
	}
	
	/**
	 * @see QuickBooks_Driver::errorLog()
	 */
	abstract protected function _errorLog($ticket, $errno, $errstr);
	
	/**
	 * Get the last error that occured
	 * 
	 * @param string $ticket
	 * @return string
	 */
	final public function errorLast($ticket)
	{
		$hookerr = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, $ticket, $hookerr, array());
		
		return $this->_errorLast($ticket);
	}
	
	/**
	 * @see QuickBooks_Driver::errorLast()
	 */
	abstract protected function _errorLast($ticket);
	
	/**
	 * Establish a session for a user (log that user in)
	 * 
	 * The QuickBooks Web Connector will pass a username and password to the 
	 * SOAP server. There is a SOAP ->authenticate() method which logs the user 
	 * in. 
	 * 
	 * @param string $username		The username for the QuickBooks Web Connector user
	 * @param string $password		The password for the QuickBooks Web Connector user
	 * @param boolean $override		If set to TRUE, a correct password will not be required
	 * @return string				The ticket for the login session
	 */
	final public function authLogin($username, $password, &$company_file, &$wait_before_next_update, &$min_run_every_n_seconds, $override = false)
	{
		$hookdata = array(
			'username' => $username, 
			'password' => $password, 
			'override' => $override, 
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHLOGIN, null, $err, $hookdata);
		
		return $this->_authLogin($username, $password, $company_file, $wait_before_next_update, $min_run_every_n_seconds, $override);
	}
	
	/**
	 * @see QuickBooks_Driver::authLogin()
	 */
	abstract protected function _authLogin($username, $password, &$company_file, &$wait_before_next_update, &$min_run_every_n_seconds, $override = false);
	
	/**
	 * Return the default QuickBooks user's username
	 * 
	 * @return string
	 */
	final public function authDefault()
	{
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHDEFAULT, null, $err, array());
		
		return $this->_authDefault();
	}
	
	/**
	 * @see QuickBooks_Driver::authDefault()
	 */
	abstract protected function _authDefault();
	
	/**
	 * Resolve a ticket string to a QuickBooks username
	 * 
	 * @param string $ticket
	 * @return string
	 */
	final public function authResolve($ticket)
	{
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHRESOLVE, $ticket, $err, array());
		
		return $this->_authResolve($ticket);
	}
	
	/**
	 * @see QuickBooks_Driver::authResolve()
	 */
	abstract protected function _authResolve($ticket);
	
	/**
	 * Get the last date/time stamp the user logged in
	 *
	 * @param string $username		The username of the user 
	 * @return array				An array containing two date/time stamps in YYYY-MM-DD HH:II:SS format, one to indicate login time, and one to indicate log out time
	 */
	final public function authLast($username)
	{
		$ticket = null;
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHLAST, $ticket, $err, array());
		
		return $this->_authLast($username);
	}
	
	/**
	 * @see QuickBooks_Driver::authLast()
	 */
	abstract protected function _authLast($username);
	
	/**
	 * Get a list of users
	 * 
	 * @param string $match
	 * @return QuickBooks_Iterator
	 */
	/*final public function authView($offset, $limit, $match = '')
	{
		$offset = max(0, (int) $offset);
		$limit = max(1, (int) $limit);
		
		$hookdata = array(
			'offset' => $offset, 
			'limit' => $limit,
			'match' => $match,  
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHVIEW, null, $err, $hookdata);
		
		return $this->_authView($offset, $limit, $match);
	}*/
	
	/**
	 * @see QuickBooks_Driver::authView()
	 */
	/*abstract protected function _authView($offset, $limit, $match = '');*/
	
	/**
	 * Get a count of the number of QuickBooks Web Connector users
	 * 
	 * @return integer
	 */
	/*final public function authSize()
	{
		$hookdata = array();
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHSIZE, null, $err, $hookdata);
		
		return $this->_authSize();
	}*/
	
	/**
	 * $see QuickBooks_Driver::authSize()
	 */
	/*abstract protected function _authSize();*/
	
	/**
	 * Check to see whether or not a ticket is for a valid, unexpired login session
	 * 
	 * @param string $ticket	The login session ticket to check
	 * @return boolean 			Whether or not the ticket is valid
	 */
	final public function authCheck($ticket)
	{
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHCHECK, $ticket, $err, array());
		
		return $this->_authCheck($ticket);
	}
	
	/**
	 * @see QuickBooks_Driver::authCheck()
	 */
	abstract protected function _authCheck($ticket);
	
	/**
	 * End a log-in session
	 * 
	 * @param string $ticket	The ticket for the session
	 * @return boolean
	 */
	final public function authLogout($ticket)
	{
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHLOGOUT, $ticket, $err, array());
		
		return $this->_authLogout($ticket);
	}
	
	/**
	 * @see QuickBooks_Driver::authLogout()
	 */
	abstract protected function _authLogout($ticket);
	
	/**
	 * Create a user account with the given username and password
	 * 
	 * @param string $username	The desired username
	 * @param string $password	The desired password
	 * @return boolean 			Whether or not the user was created
	 */
	final public function authCreate($username, $password, $company_file = null, $wait_before_next_update = null, $min_run_every_n_seconds = null)
	{
		$hookdata = array(
			'username' => $username, 
			'password' => $password, 
			'qb_company_file' => $company_file, 
			'qbwc_wait_before_next_update' => $wait_before_next_update, 
			'qbwc_min_run_every_n_seconds' => $min_run_every_n_seconds, 
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHCREATE, null, $err, $hookdata);
		
		return $this->_authCreate($username, $password, $company_file, $wait_before_next_update, $min_run_every_n_seconds);
	}
	
	/**
	 * @see QuickBooks_Driver::authCreate()
	 */
	abstract protected function _authCreate($username, $password, $company_file = null, $wait_before_next_update = null, $min_run_every_n_seconds = null);
	
	/**
	 * @see QuickBooks_Driver::authEnable()
	 */
	abstract protected function _authEnable($username);
	
	/** 
	 * Enable a username
	 * 
	 * @param string $username
	 * @return boolean
	 */
	final public function authEnable($username)
	{
		$hookdata = array(
			'username' => $username, 
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHENABLE, null, $err, $hookdata);
		
		return $this->_authEnable($username);
	}
	
	/**
	 * @see QuickBooks_Driver::authDisable()
	 */
	abstract protected function _authDisable($username);
	
	/**
	 * Disable a username
	 * 
	 * @param string $username
	 * @return boolean
	 */
	final public function authDisable($username)
	{
		$hookdata = array(
			'username' => $username, 
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_AUTHDISABLE, null, $err, $hookdata);
		
		return $this->_authDisable($username);
	}
	
	/**
	 * Initialize the driver class
	 * 
	 * @param array $options
	 * @return boolean
	 */
	public function initialize($options)
	{
		$hookdata = array(
			'options' => $options, 
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_INITIALIZE, null, $err, $hookdata);
		
		return $this->_initialize($options);
	}
	
	/**
	 * @see QuickBooks_Driver::initialize()
	 */
	abstract protected function _initialize($options = array()); 
	
	/**
	 * Tell whether or not the driver class has been initialized
	 * 
	 * @return boolean
	 */
	public function initialized()
	{
		$hookdata = array();
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_INITIALIZED, null, $err, $hookdata);
		
		return $this->_initialized();
	}
	
	/**
	 * @see QuickBooks_Driver::initialized()
	 */
	abstract protected function _initialized();
	
	public function oauthLoad($key, $app_username, $app_tenant)
	{
		if ($data = $this->_oauthLoad($app_username, $app_tenant))
		{
			if (strlen($data['oauth_access_token']) > 0)
			{
				$AES = QuickBooks_Encryption_Factory::create('aes');
				
				$data['oauth_access_token'] = $AES->decrypt($key, $data['oauth_access_token']);
				$data['oauth_access_token_secret'] = $AES->decrypt($key, $data['oauth_access_token_secret']);
			}
			
			return $data;
		}
		
		return false;
	}
	
	abstract protected function _oauthLoad($app_username, $app_tenant);
	
	public function oauthAccessWrite($key, $request_token, $token, $token_secret, $realm, $flavor)
	{
		$AES = QuickBooks_Encryption_Factory::create('aes');
		
		$encrypted_token = $AES->encrypt($key, $token);
		$encrypted_token_secret = $AES->encrypt($key, $token_secret);
		
		return $this->_oauthAccessWrite($request_token, $encrypted_token, $encrypted_token_secret, $realm, $flavor);
	}
	
	abstract protected function _oauthAccessWrite($request_token, $token, $token_secret, $realm, $flavor);
	
	
	public function oauthAccessDelete($app_username, $app_tenant)
	{
		return $this->_oauthAccessDelete($app_username, $app_tenant);
	}
	
	abstract protected function _oauthAccessDelete($app_username, $app_tenant);
	
	
	public function oauthRequestWrite($app_username, $app_tenant, $token, $token_secret)
	{
		/*
		$AES = QuickBooks_Encryption_Factory::create('aes');
		
		$token = $AES->encrypt($key, $token);
		$token_secret = $AES->encrypt($key, $token_secret);
		*/
		
		return $this->_oauthRequestWrite($app_username, $app_tenant, $token, $token_secret);
	}
	
	abstract protected function _oauthRequestWrite($app_username, $app_tenant, $token, $token_secret);
	
	public function oauthRequestResolve($token)
	{
		return $this->_oauthRequestResolve($token);
	}
	
	abstract protected function _oauthRequestResolve($token);
	
	/**
	 * Log a message to the QuickBooks log
	 * 
	 * @param string $msg		The message to place in the log
	 * @param string $ticket	The ticket for the login session
	 * @param integer $lvl		
	 * @return boolean 			Whether or not the message was logged successfully
	 */
	final public function log($msg, $ticket = null, $lvl = QUICKBOOKS_LOG_NORMAL)
	{
		/*
		$hookdata = array(
			'message' => $msg, 
			'level' => $lvl, 
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_LOG, $ticket, $err, $hookdata);
		*/
		
		if (is_null($lvl) or $this->_loglevel >= $lvl)
		{
			return $this->_log($msg, $ticket, $lvl);
		}
		
		return true;
	}
	
	/**
	 * @see QuickBooks_Driver::log()
	 */
	abstract protected function _log($msg, $ticket = null, $lvl = QUICKBOOKS_LOG_NORMAL);
	
	/**
	 * 
	 * 
	 * @param integer $offset
	 * @param integer $limit
	 * @param string $match
	 * @return QuickBooks_Iterator
	 */
	/*final public function logView($offset, $limit, $match = '')
	{
		$offset = max(0, (int) $offset);
		$limit = max(1, (int) $limit);
		
		$hookdata = array(
			'offset' => $offset, 
			'limit' => $limit, 
			'match' => $match,  
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_LOGVIEW, null, $err, $hookdata);
				
		return $this->_logView($offset, $limit, $match);
	}*/
	
	/**
	 * @see QuickBooks_Utilities::logView()
	 */
	/*abstract protected function _logView($offset, $limit, $match);*/
	
	/*final public function logSize($match = '')
	{
		$hookdata = array(
			'match' => $match,  
			);
		$err = '';
		$this->_callHook(QUICKBOOKS_DRIVER_HOOK_LOGSIZE, null, $err, $hookdata);
		
		return $this->_logSize($match);
	}*/
	
	/*abstract protected function _logSize($match);*/
		
	/**
	 * One-way hash a password for storage in the database
	 * 
	 * @param string $password
	 * @return string
	 */	
	final protected function _hash($password)
	{
		$func = QUICKBOOKS_HASH;
		return $func($password . QUICKBOOKS_SALT);
	}
	
	/**
	 * Call any user-defined hooks hooked into a particular type of event
	 * 
	 * Hooks will be executed in the order they were added in. If any hook 
	 * returns FALSE, then execution for that type of hook will be stopped and 
	 * no other hooks will run. Errors reported via the $err parameter will be 
	 * logged using the driver logging mechanism. 
	 * 
	 * @param string $hook			The type of hook we're to execute
	 * @param string $ticket		The Web Connector ticket 
	 * @param string $err			Any error messages that should be reported 
	 * @param array $hook_data		An array of hook data
	 * @return boolean
	 */
	final protected function _callHook($hook, $ticket, &$err, $hook_data)
	{
		$user = '';
		if ($ticket)
		{
			$user = (string) $this->_authResolve($ticket);
		}
		
		// Call the hook
		QuickBooks_Callbacks::callHook($this, $this->_hooks, $hook, null, $user, $ticket, $err, $hook_data, null, __FILE__, __LINE__);
		
		if ($err)
		{
			// Log errors reporting by hooks
			$this->errorLog($ticket, QUICKBOOKS_ERROR_HOOK, $err);
		}
		
		return true;
	}
}
