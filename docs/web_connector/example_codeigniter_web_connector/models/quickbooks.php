<?php

class Quickbooks extends CI_Model
{
	public $_dsn;

 public function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Set the DSN connection string for the queue class
	 */
	public function dsn($dsn)
	{
		$this->_dsn = $dsn;
	}
	
	/**
	 * Queue up a request for the Web Connector to process
	 */
	public function enqueue($action, $ident, $priority = 0, $extra = null, $user = null)
	{
		$quickBooksWebConnectorQueue = new QuickBooks_WebConnector_Queue($this->_dsn);
		
		return $quickBooksWebConnectorQueue->enqueue($action, $ident, $priority, $extra, $user);
	}
}