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

class QuickBooks_IPP_IntuitAnywhere 
{
	protected $_this_url;
	protected $_that_url;
	
	protected $_consumer_key;
	protected $_consumer_secret;
	
	protected $_errnum;
	protected $_errmsg;
	
	protected $_debug;
	
	protected $_driver;
	
	protected $_crypt;
	
	protected $_key;
	
	const URL_REQUEST_TOKEN = 'https://oauth.intuit.com/oauth/v1/get_request_token';
	const URL_ACCESS_TOKEN = 'https://oauth.intuit.com/oauth/v1/get_access_token';
	const URL_CONNECT_BEGIN = 'https://appcenter.intuit.com/Connect/Begin';
	const URL_CONNECT_DISCONNECT = 'https://appcenter.intuit.com/api/v1/Connection/Disconnect';
	const URL_APP_MENU = 'https://appcenter.intuit.com/api/v1/Account/AppMenu';
	
	/**
	 * 
	 *
	 * @param string $consumer_key		The OAuth consumer key Intuit gives you
	 * @param string $consumer_secret	The OAuth consumer secret Intuit gives you
	 * @param string $this_url			The URL of your QuickBooks_IntuitAnywhere class instance
	 * @param string $that_url			The URL the user should be sent to after authenticated 
	 */
	public function __construct($dsn, $encryption_key, $consumer_key, $consumer_secret, $this_url = null, $that_url = null) 
	{
		$this->_driver = QuickBooks_Driver_Factory::create($dsn);
		
		$this->_key = $encryption_key;
		
		$this->_this_url = $this_url;
		$this->_that_url = $that_url;
		
		$this->_consumer_key = $consumer_key;
		$this->_consumer_secret = $consumer_secret;
		
		$this->_debug = false;
	}

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
	
	/**
	 * Returns TRUE if an OAuth token exists for this user, FALSE otherwise
	 * 
	 * @param string $app_username
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
	 */
	public function test($app_username, $app_tenant)
	{
		if ($creds = $this->load($app_username, $app_tenant))
		{
			$IPP = new QuickBooks_IPP();
			
			$IPP->authMode(
				QuickBooks_IPP::AUTHMODE_OAUTH, 
				$app_username, 
				$creds);
			
			if ($Context = $IPP->context())
			{
				// Set the DBID
				$IPP->dbid($Context, 'something');
				
				// Set the IPP flavor
				$IPP->flavor($creds['qb_flavor']);
				
				// Get the base URL if it's QBO
				if ($creds['qb_flavor'] == QuickBooks_IPP_IDS::FLAVOR_ONLINE)
				{
					$IPP->baseURL($IPP->getBaseURL($Context, $creds['qb_realm']));
				}
				else
				{
					$companies = $IPP->getAvailableCompanies($Context);
				}
				
				/*
				print('[[' . $IPP->lastRequest() . ']]');
				print('[[' . $IPP->lastResponse() . ']]');
				print('here we are! [' . $IPP->errorCode() . ']');
				*/
				
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
	 * @return array
	 */
	public function load($app_username, $app_tenant)
	{
		if ($arr = $this->_driver->oauthLoad($this->_key, $app_username, $app_tenant) and 
			strlen($arr['oauth_access_token']) > 0 and 
			strlen($arr['oauth_access_token_secret']) > 0)
		{
			$arr['oauth_consumer_key'] = $this->_consumer_key;
			$arr['oauth_consumer_secret'] = $this->_consumer_secret;
			
			return $arr;
		}
			
		return false;
	}
	
	public function disconnect($app_username, $app_tenant, $force = false)
	{
		if ($arr = $this->_driver->oauthLoad($this->_key, $app_username, $app_tenant) and
			strlen($arr['oauth_access_token']) > 0 and
			strlen($arr['oauth_access_token_secret']) > 0)
		{
			$arr['oauth_consumer_key'] = $this->_consumer_key;
			$arr['oauth_consumer_secret'] = $this->_consumer_secret;
			
			$retr = $this->_request(QuickBooks_IPP_OAuth::METHOD_GET, 
				QuickBooks_IPP_IntuitAnywhere::URL_CONNECT_DISCONNECT, 
				array(), 
				$arr['oauth_access_token'], 
				$arr['oauth_access_token_secret']);
			
			// Extract the error code
			$code = (int) QuickBooks_XML::extractTagContents('ErrorCode', $retr);
			
			if ($code == 0 or $force)
			{
				return $this->_driver->oauthAccessDelete($arr['app_username'], $arr['app_tenant']);
			}
		}
		
		return false;
	}
	
	public function fudge($request_token, $access_token, $access_token_secret, $realm, $flavor)
	{
		$this->_driver->oauthAccessWrite(
			$this->_key, 
			$request_token, 
			$access_token, 
			$access_token_secret,
			$realm, 
			$flavor);
	}
	
	/**
	 * Handle an OAuth request login thing
	 *
	 * 
	 */
	public function handle($app_username, $app_tenant)
	{
		if ($this->check($app_username, $app_tenant) and 		// We have tokens ...
			$this->test($app_username, $app_tenant))			// ... and they are valid
		{
			// They are already logged in, send them on to exchange data
			header('Location: ' . $this->_that_url);
			exit;
		}
		else
		{
			if (isset($_GET['oauth_token']))
			{
				// We're in the middle of an OAuth token session
				
				/*
				$arr = mysql_fetch_array(mysql_query("
					SELECT
						*
					FROM
						quickbooks_oauth
					WHERE
						oauth_request_token = '" . $_REQUEST['oauth_token'] . "' "));
				*/
				
				if ($arr = $this->_driver->oauthRequestResolve($_GET['oauth_token']))
				{
					$info = $this->_getAccessToken(
						$arr['oauth_request_token'], 
						$arr['oauth_request_token_secret'], 
						$_GET['oauth_verifier']);
					
					//print('got back [' . $info . ']');
					//print_r($info);
					//exit;
					
					if ($info)
					{
						/*
						mysql_query("
							UPDATE
								quickbooks_oauth
							SET
								oauth_access_token = '" . $info['oauth_token'] . "', 
								oauth_access_token_secret = '" . $info['oauth_token_secret'] . "', 
								qb_realm = '" . $_REQUEST['realmId'] . "', 
								qb_flavor = '" . $_REQUEST['dataSource'] . "'
							WHERE
								quickbooks_oauth_id = " . $arr['quickbooks_oauth_id']);
						*/
						
						$this->_driver->oauthAccessWrite(
							$this->_key, 
							$arr['oauth_request_token'], 
							$info['oauth_token'], 
							$info['oauth_token_secret'],
							$_GET['realmId'], 
							$_GET['dataSource']);
						
						//print_r($_REQUEST);
						//exit;
						//print_r($info);
		
						//print('authd now, go here <a href="exchange_data.php">exchange_data.php</a>');
						header('Location: ' . $this->_that_url);
						exit;
					}
					else
					{
						// Something went wrong when fetching the user token...?
						print('something went wrong fetching user token');
					}
				}
				else
				{
					print('something went wrong... invalid oauth token?');
				}
			}
			else
			{
				$auth_url = $this->_getAuthenticateURL($app_username, $app_tenant, $this->_this_url);
				
				// Forward them to the auth page
				header('Location: ' . $auth_url);
				exit;
			}
		}
		
		return true;
	}

	/**
	 * 
	 * 
	 * @param string $url
	 * @return string
	 */	
	protected function _getAuthenticateURL($app_username, $app_tenant, $url) 
	{
		// Fetch a request token from the OAuth service
		$info = $this->_request(QuickBooks_IPP_OAuth::METHOD_GET, QuickBooks_IPP_IntuitAnywhere::URL_REQUEST_TOKEN, array( 'oauth_callback' => $url ));
		
		//print('info [' . $info . ']');
		
		$vars = array();
		parse_str($info, $vars);
		
		// Write the request tokens to the database
		$this->_driver->oauthRequestWrite($app_username, $app_tenant, $vars['oauth_token'], $vars['oauth_token_secret']);
		
		/*
		mysql_query("
			INSERT INTO 
				quickbooks_oauth
			(
				oauth_request_token,
				oauth_request_token_secret
			) VALUES (
				'" . $vars['oauth_token'] . "',
				'" . $vars['oauth_token_secret'] . "'
			)");
		*/
		
		// Return the auth URL
		return QuickBooks_IPP_IntuitAnywhere::URL_CONNECT_BEGIN . '?oauth_callback=' . urlencode($url) . '&oauth_consumer_key=' . $this->_consumer_key . '&oauth_token=' . $vars['oauth_token'];	
	}
	
	protected function _getAccessToken($oauth_token, $oauth_token_secret, $verifier) 
	{
		if ($str = $this->_request(QuickBooks_IPP_OAuth::METHOD_GET, QuickBooks_IPP_IntuitAnywhere::URL_ACCESS_TOKEN, 
			array( 
				'oauth_token' => $oauth_token, 
				'oauth_secret' => $oauth_token_secret, 
				'oauth_verifier' => $verifier, 
				)))
		{
			$info = array();
			parse_str($str, $info);
			
			return $info;		
		}
		
		return false;
	}
	
	public function widgetConnect()
	{
		
	}
    
	/**
	 * This function returns the html for displaying the "Blue Dot" menu
	 * 
	 * As per Intuit's recommendation, your app should call this function before the user clicks the
	 * blue dot menu and cache it. This will improve the user's experience and prevent unnecessary API
	 * calls to Intuit's web service. See:
	 * https://ipp.developer.intuit.com/0010_Intuit_Partner_Platform/0025_Intuit_Anywhere/1000_Getting_Started_With_IA/0500_Add_IA_Widgets/3000_Blue_Dot_Menu/Menu_Proxy_Code
	 *
	 * Example usage:
	 *     // Your app should read from cache here if possible before calling widgetMenu()
	 *     $html = $object->widgetMenu($app_username, $app_tenant);
	 *     if (strlen($html)) {
	 *         // Your app should write to cache here if possible
	 *         print $html;
	 *         exit;
	 *     }
	 * 
	 * @param string $app_username
	 * @param string $app_tenant
	 * @return html string
	 */
	public function widgetMenu($app_username, $app_tenant)
	{
		$token = null;
		$secret = null;
		
		if ($creds = $this->load($app_username, $app_tenant))
		{
			return $this->_request(
				QuickBooks_IPP_OAuth::METHOD_GET, 
				QuickBooks_IPP_IntuitAnywhere::URL_APP_MENU, 
				array(), 
				$creds['oauth_access_token'], 
				$creds['oauth_access_token_secret']);
		}
		
		return '';
	}

	protected function _request($method, $url, $params = array(), $token = null, $secret = null, $data = null) 
	{
		$OAuth = new QuickBooks_IPP_OAuth($this->_consumer_key, $this->_consumer_secret);
		
		// This returns a signed request
		// 
		// 0 => signature base string
		// 1 => signature
		// 2 => normalized url
		// 3 => header string
		$signed = $OAuth->sign($method, $url, $token, $secret, $params);
		
		//print_r($signed);
		
		// Create the new HTTP object
		//$HTTP = new QuickBooks_HTTP($url);
		$HTTP = new QuickBooks_HTTP($signed[2]);
		
		$headers = array(
			//'Authorization' => $signed[3], 
			);
		
		$HTTP->setHeaders($headers);
		
		// 
		$HTTP->setRawBody($data);
		
		$HTTP->verifyHost(false);
		$HTTP->verifyPeer(false);
		
		// We need the headers back
		//$HTTP->returnHeaders(true);
		
		// Send the request
		$return = $HTTP->GET();
		
		$errnum = $HTTP->errorNumber();
		$errmsg = $HTTP->errorMessage();
		
		if ($errnum)
		{
			// An error occurred!
			$this->_setError(QuickBooks_IPP::ERROR_HTTP, $errnum . ': ' . $errmsg);
			return false;
		}
		
		// Everything is good, return the data!
		$this->_setError(QuickBooks_IPP::ERROR_OK, '');
		return $return;		
	}
}


