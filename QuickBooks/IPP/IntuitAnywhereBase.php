<?php

/**
 * QuickBooks PHP DevKit
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 */

abstract class QuickBooks_IPP_IntuitAnywhereBase
{
	protected $_this_url;
	protected $_that_url;

	protected $_errnum;
	protected $_errmsg;
	
	protected $_debug;

    /**
     * @var QuickBooks_Driver
     */
	protected $_driver;
	
	protected $_crypt;
	
	protected $_key;

	protected $_last_request;
	protected $_last_response;

	protected $_auth_mode;

    const URL_APP_MENU = 'https://appcenter.intuit.com/api/v1/Account/AppMenu';

	const EXPIRY_EXPIRED = 'expired';
	const EXPIRY_NOTYET  = 'notyet';
	const EXPIRY_SOON    = 'soon';
	const EXPIRY_UNKNOWN = 'unknown';

	/**
	 * Turn on/off debug mode
	 * 
	 * @param boolean $true_or_false
	 */
	public function useDebugMode($true_or_false)
	{
		$this->_debug = (boolean) $true_or_false;
	}
	
	/**
	 * Get the last error number
	 * 
	 * @return integer
	 */
	public function errorNumber()
	{
		return $this->_errnum;
	}
	
	/**
	 * Get the last error message
	 * 
	 * @return string
	 */
	public function errorMessage()
	{
		return $this->_errmsg;
	}
	
	/**
	 * Set an error message
	 * 
	 * @param integer $errnum	The error number/code
	 * @param string $errmsg	The text error message
	 * @return void
	 */
	protected function _setError($errnum, $errmsg = '')
	{
		$this->_errnum = $errnum;
		$this->_errmsg = $errmsg;
	}

	public function lastRequest()
	{
		return $this->_last_request;
	}

	public function lastResponse()
	{
		return $this->_last_response;
	}
	
	/**
	 * Returns TRUE if an OAuth token exists for this user, FALSE otherwise
	 * 
	 * @param string $app_username
     * @param string $app_tenant
     *
	 * @return bool
	 */
	public function check($app_username, $app_tenant)
	{
		if ($arr = $this->load($app_username, $app_tenant))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * Test to see if a connection actually works (make sure you haven't been disconnected on Intuit's end)
	 *
     * @param string $app_username
     * @param string $app_tenant
     *
     * @return bool
	 */
	public function test($app_username, $app_tenant)
	{
		if ($creds = $this->load($app_username, $app_tenant))
		{
			$IPP = new QuickBooks_IPP();
			
			$IPP->authMode(
				isset($this->_auth_mode) ? $this->_auth_mode : QuickBooks_IPP::AUTHMODE_OAUTH,
				$app_username, 
				$creds);
			
			if ($Context = $IPP->context())
			{
				// Set the DBID
				$IPP->dbid($Context);
				
				// Set the IPP flavor
				$IPP->flavor($creds['qb_flavor']);
				
				// Get the base URL if it's QBO
				if ($creds['qb_flavor'] == QuickBooks_IPP_IDS::FLAVOR_ONLINE)
				{
					$cur_version = $IPP->version();

					$IPP->version(QuickBooks_IPP_IDS::VERSION_3);		// Need v3 for this 

					$CustomerService = new QuickBooks_IPP_Service_Customer();
					$CustomerService->query(
					    $Context,
                        $creds['qb_realm'],
                        "SELECT * FROM Customer MAXRESULTS 1"
                    );

					$IPP->version($cur_version);		// Revert back to whatever they set 

					//$IPP->baseURL($IPP->getBaseURL($Context, $creds['qb_realm']));
				}
				else
				{
					$IPP->getAvailableCompanies($Context);
				}
				
				//print('[[' . $IPP->lastRequest() . ']]' . "\n\n");
				//print('[[' . $IPP->lastResponse() . ']]' . "\n\n");
				//print('here we are! [' . $IPP->errorCode() . ']');
				
				// Check the last error code now... 
				if ($IPP->errorCode() == 401 or 			// most calls return this
					$IPP->errorCode() == 3200)				// but for some stupid reason the getAvailableCompanies call returns this
				{
					return false;
				}
				
				return true;
			}
		}
		
		return false;
	}
	
	/**
	 * Load OAuth credentials from the database
	 *
	 * @param string $app_username
     * @param string $app_tenant
     *
	 * @return array
	 */
	abstract public function load($app_username, $app_tenant);

	/**
	 * Check whether a connection is due for refresh/reconnect
	 * 
	 * @param string $app_username
	 * @param string $app_tenant
	 * @param integer $within
	 * @return string One of the QuickBooks_IPP_IntuitAnywhere::EXPIRY_* constants
	 */
	abstract public function expiry($app_username, $app_tenant, $within = 2592000);

	/**
	 * Reconnect/refresh the OAuth tokens 
	 * 
	 * For this to succeed, the token expiration must be within 30 days of the 
	 * date that this method is called (6 months after original token was 
	 * created). This is an Intuit-imposed security restriction. Calls outside 
	 * of that date range will fail with an error.
	 * 
	 * @param string $app_username
	 * @param string $app_tenant
	 */
	abstract public function reconnect($app_username, $app_tenant);

	abstract public function disconnect($app_username, $app_tenant, $force = false);
	
	/**
	 * Handle an OAuth request login thing
	 *
	 * @param string $app_username
     * @param string $app_tenant
	 */
	abstract public function handle($app_username, $app_tenant);

	abstract protected function _loadSettings($key, $app_username, $app_tenant);
}


