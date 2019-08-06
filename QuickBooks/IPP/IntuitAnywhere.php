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
	protected $_oauth_version;
	protected $_oauth_scope;

	protected $_sandbox;

	protected $_this_url;
	protected $_that_url;

	protected $_consumer_key;
	protected $_consumer_secret;

	protected $_client_id;
	protected $_client_secret;

	protected $_errnum;
	protected $_errmsg;

	protected $_debug;

	protected $_dsn;
	protected $_driver;

	protected $_crypt;

	protected $_key;

	protected $_last_request;
	protected $_last_response;

	const URL_REQUEST_TOKEN = 'https://oauth.intuit.com/oauth/v1/get_request_token';
	const URL_ACCESS_TOKEN = 'https://oauth.intuit.com/oauth/v1/get_access_token';
	const URL_CONNECT_BEGIN = 'https://appcenter.intuit.com/Connect/Begin';
	const URL_CONNECT_DISCONNECT = 'https://appcenter.intuit.com/api/v1/Connection/Disconnect';
	const URL_CONNECT_RECONNECT = 'https://appcenter.intuit.com/api/v1/Connection/Reconnect';
	const URL_APP_MENU = 'https://appcenter.intuit.com/api/v1/Account/AppMenu';

	const URL_DISCOVERY_SANDBOX = 'https://developer.api.intuit.com/.well-known/openid_sandbox_configuration';
	const URL_DISCOVERY_PRODUCTION = 'https://developer.api.intuit.com/.well-known/openid_configuration';

	const EXPIRY_EXPIRED = 'expired';
	const EXPIRY_NOTYET = 'notyet';
	const EXPIRY_SOON = 'soon';
	const EXPIRY_UNKNOWN = 'unknown';

	const OAUTH_V1 = 'oauthv1';
	const OAUTH_V2 = 'oauthv2';

	/**
	 *
	 *
	 * @param string $consumer_key		The OAuth consumer key Intuit gives you
	 * @param string $consumer_secret	The OAuth consumer secret Intuit gives you
	 * @param string $this_url			The URL of your QuickBooks_IntuitAnywhere class instance
	 * @param string $that_url			The URL the user should be sent to after authenticated
	 */
	public function __construct($oauth_version, $sandbox, $scope, $dsn, $encryption_key, $consumer_key_or_client_id, $consumer_secret_or_client_secret, $this_url = null, $that_url = null)
	{
		$this->_dsn = $dsn;
		$this->_driver = QuickBooks_Driver_Factory::create($dsn);

		$this->_key = $encryption_key;

		$this->_this_url = $this_url;
		$this->_that_url = $that_url;

		$this->_oauth_version = $oauth_version;
		$this->_oauth_scope = $scope;

		$this->_sandbox = (bool) $sandbox;

		$this->_consumer_key = $this->_client_id = $consumer_key_or_client_id;
		$this->_consumer_secret = $this->_client_secret = $consumer_secret_or_client_secret;

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
	 * @param   string  $app_tenant   The tenant to check to see if they are connected/auth'd
	 * @return  bool
	 */
	public function check($app_tenant)
	{
		if ($arr = $this->load($app_tenant))
		{
			return true;
		}

		return false;
	}

	/**
	 * Test to see if a connection actually works (make sure you haven't been disconnected on Intuit's end)
	 *
	 * @param string   $app_tenant
	 *
	 */
	public function test($app_tenant)
	{
		if ($creds = $this->load($app_tenant))
		{
			$IPP = new QuickBooks_IPP($this->_dsn, $this->_key);

			if ($this->_oauth_version == self::OAUTH_V1)
			{
				$authmode = QuickBooks_IPP::AUTHMODE_OAUTHV1;
			}
			else if ($this->_oauth_version == self::OAUTH_V2)
			{
				$authmode = QuickBooks_IPP::AUTHMODE_OAUTHV2;
			}

			$IPP->authMode(
				$authmode,
				$creds);

			if ($this->_sandbox)
			{
				$IPP->sandbox(true);
			}

			if ($Context = $IPP->context())
			{
				// Set the IPP flavor
				$IPP->flavor($creds['qb_flavor']);

				// Get the base URL if it's QBO
				if ($creds['qb_flavor'] == QuickBooks_IPP_IDS::FLAVOR_ONLINE)
				{
					$cur_version = $IPP->version();

					$IPP->version(QuickBooks_IPP_IDS::VERSION_3);		// Need v3 for this

					$CustomerService = new QuickBooks_IPP_Service_Customer();
					$customers = $CustomerService->query($Context, $creds['qb_realm'], "SELECT * FROM Customer MAXRESULTS 1");

					$IPP->version($cur_version);		// Revert back to whatever they set
				}
				else
				{
					$companies = $IPP->getAvailableCompanies($Context);
				}

				// Check the last error code now...
				if ($IPP->errorCode() == 401 or 			// most calls return this
					$IPP->errorCode() == 3100 or            // OAuth token error
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
	public function load($app_tenant)
	{
		if ($this->_oauth_version == self::OAUTH_V1)
		{
			if ($arr = $this->_driver->oauthLoadV1($this->_key, $app_tenant) and
				strlen($arr['oauth_access_token']) > 0 and
				strlen($arr['oauth_access_token_secret']) > 0)
			{
				$arr['oauth_consumer_key'] = $this->_consumer_key;
				$arr['oauth_consumer_secret'] = $this->_consumer_secret;

				return $arr;
			}
		}
		else if ($this->_oauth_version == self::OAUTH_V2)
		{
			if ($arr = $this->_driver->oauthLoadV2($this->_key, $app_tenant) and
				strlen($arr['oauth_access_token']) > 0 and
				strlen($arr['oauth_refresh_token']) > 0)
			{
				$arr['oauth_client_id'] = $this->_client_id;
				$arr['oauth_client_secret'] = $this->_client_secret;

				$arr['qb_flavor'] = QuickBooks_IPP_IDS::FLAVOR_ONLINE;

				return $arr;
			}
		}

		return false;
	}

	/**
	 * Check whether a connection is due for refresh/reconnect
	 *
	 * @param string $app_username
	 * @param string $app_tenant
	 * @param integer $within
	 * @return One of the QuickBooks_IPP_IntuitAnywhere::EXPIRY_* constants
	 */
	public function expiry($app_username, $app_tenant, $within = 2592000)
	{
		$lifetime = 15552000;

		if ($arr = $this->_driver->oauthLoadV1($this->_key, $app_username, $app_tenant) and
			strlen($arr['oauth_access_token']) > 0 and
			strlen($arr['oauth_access_token_secret']) > 0)
		{
			$expires = $lifetime + strtotime($arr['access_datetime']);

			$diff = $expires - time();

			if ($diff < 0)
			{
				// Already expired
				return QuickBooks_IPP_IntuitAnywhere::EXPIRY_EXPIRED;
			}
			else if ($diff < $within)
			{
				return QuickBooks_IPP_IntuitAnywhere::EXPIRY_SOON;
			}

			return QuickBooks_IPP_IntuitAnywhere::EXPIRY_NOTYET;
		}

		return QuickBooks_IPP_IntuitAnywhere::EXPIRY_UNKNOWN;
	}

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
	public function reconnect($app_username, $app_tenant)
	{
		if ($arr = $this->_driver->oauthLoadV1($this->_key, $app_username, $app_tenant) and
			strlen($arr['oauth_access_token']) > 0 and
			strlen($arr['oauth_access_token_secret']) > 0)
		{
			$arr['oauth_consumer_key'] = $this->_consumer_key;
			$arr['oauth_consumer_secret'] = $this->_consumer_secret;

			$retr = $this->_request(QuickBooks_IPP_OAuthv1::METHOD_GET,
				QuickBooks_IPP_IntuitAnywhere::URL_CONNECT_RECONNECT,
				array(),
				$arr['oauth_access_token'],
				$arr['oauth_access_token_secret']);

			// Extract the error code
			$code = (int) QuickBooks_XML::extractTagContents('ErrorCode', $retr);
			$message = QuickBooks_XML::extractTagContents('ErrorMessage', $retr);

			if ($message)
			{
				$this->_setError($code, $message);
				return false;
			}
			else
			{
				// Success! Update the tokens
				$token = QuickBooks_XML::extractTagContents('OAuthToken', $retr);
				$secret = QuickBooks_XML::extractTagContents('OAuthTokenSecret', $retr);

				$this->_driver->oauthAccessWrite(
					$this->_key,
					$arr['oauth_request_token'],
					$token,
					$secret,
					null,
					null);

				return true;
			}
		}
	}

	public function disconnect($app_username, $app_tenant, $force = false)
	{
		if ($arr = $this->_driver->oauthLoadV1($this->_key, $app_username, $app_tenant) and
			strlen($arr['oauth_access_token']) > 0 and
			strlen($arr['oauth_access_token_secret']) > 0)
		{
			$arr['oauth_consumer_key'] = $this->_consumer_key;
			$arr['oauth_consumer_secret'] = $this->_consumer_secret;

			$retr = $this->_request(QuickBooks_IPP_OAuthv1::METHOD_GET,
				QuickBooks_IPP_IntuitAnywhere::URL_CONNECT_DISCONNECT,
				array(),
				$arr['oauth_access_token'],
				$arr['oauth_access_token_secret']);

			// Extract the error code
			$code = (int) QuickBooks_XML::extractTagContents('ErrorCode', $retr);

			if ($code == 0 or
				$code == 270 or 	// Sometimes it returns "270: OAuth Token rejected" for some reason?
				$force)
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
	public function handle($app_tenant)
	{
		if ($this->check($app_tenant) and 		// We have tokens ...
			$this->test($app_tenant))			// ... and they are valid
		{
			// They are already logged in, send them on to exchange data
			header('Location: ' . $this->_that_url);
			exit;
		}
		else
		{
			error_log(print_r($_REQUEST, true));

			if ($this->_oauth_version == self::OAUTH_V1 and
				isset($_GET['oauth_token']))
			{
				// We're in the middle of an OAuth v1 token session

				if ($arr = $this->_driver->oauthRequestResolveV1($_GET['oauth_token']))
				{
					$info = $this->_getAccessToken(
						$arr['oauth_request_token'],
						$arr['oauth_request_token_secret'],
						$_GET['oauth_verifier']);

					if ($info)
					{
						$this->_driver->oauthAccessWriteV1(
							$this->_key,
							$arr['oauth_request_token'],
							$info['oauth_token'],
							$info['oauth_token_secret'],
							$_GET['realmId'],
							$_GET['dataSource']);

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
			else if ($this->_oauth_version == self::OAUTH_V2 and
				!empty($_GET['code']) and
				!empty($_GET['state']) and
				$info = $this->_driver->oauthRequestResolveV2($_GET['state']))
			{
				// Try to get an access/refresh token here

				if ($discover = $this->_discover())
				{
					$ch = curl_init($discover['token_endpoint']);

					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
						'code' => $_GET['code'],
						'redirect_uri' => $this->_this_url,
						'grant_type' => 'authorization_code',
						)));

					curl_setopt($ch, CURLOPT_USERPWD, $this->_client_id . ':' . $this->_client_secret);

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);   // Do not follow; security risk here
					$retr = curl_exec($ch);
					$info = curl_getinfo($ch);

					if ($info['http_code'] == 200)
					{
						$json = json_decode($retr, true);

						$this->_driver->oauthAccessWriteV2(
							$this->_key,
							$_GET['state'],
							$json['access_token'],
							$json['refresh_token'],
							date('Y-m-d H:i:s', time() + (int) $json['expires_in']),
							date('Y-m-d H:i:s', time() + (int) $json['x_refresh_token_expires_in']),
							$_GET['realmId']);

						header('Location: ' . $this->_that_url);
						exit;
					}
					else
					{
						print('An error occurred fetching the access/refresh token.');
						return false;
					}
				}

			}
			else
			{
				if ($this->_oauth_version == self::OAUTH_V1)
				{
					$auth_url = $this->_getAuthenticateURLV1($app_tenant, $this->_this_url);
				}
				else
				{
					$auth_url = $this->_getAuthenticateURLV2($app_tenant, $this->_this_url);
				}

				if (!$auth_url)
				{
					print('Could not build an authorization URL.');
					return false;
				}

				// Forward them to the auth page
				header('Location: ' . $auth_url);
				exit;
			}
		}

		return true;
	}

	protected function _getAuthenticateURLV2($app_tenant, $url)
	{
		if ($discover = $this->_discover())
		{
			// Write the request to the database
			$state = md5(mt_rand() . microtime(true));

			$this->_driver->oauthRequestWriteV2($app_tenant, $state);

			$url = $discover['authorization_endpoint'] . '?' . http_build_query(array(
				'client_id' => $this->_client_id,
				'scope' => $this->_oauth_scope,
				'redirect_uri' => $url,
				'response_type' => 'code',
				'state' => $state,
				));

			return $url;
		}

		return false;
	}

	protected function _discover()
	{
		return self::discover($this->_sandbox);
	}

	static public function discover($sandbox)
	{
		$url = self::URL_DISCOVERY_PRODUCTION;
		if ($sandbox)
		{
			$url = self::URL_DISCOVERY_SANDBOX;
		}

		// Make a request to the discovery URL
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);   // Do not follow; security risk here
		$retr = curl_exec($ch);
		$info = curl_getinfo($ch);

		if ($info['http_code'] == 200)
		{
			$out = json_decode($retr, true);

			return $out;
		}

		return false;
	}

	/**
	 *
	 *
	 * @param string $url
	 * @return string
	 */
	protected function _getAuthenticateURLV1($app_tenant, $url)
	{
		// Fetch a request token from the OAuth service
		$info = $this->_request(QuickBooks_IPP_OAuthv1::METHOD_GET, QuickBooks_IPP_IntuitAnywhere::URL_REQUEST_TOKEN, array( 'oauth_callback' => $url ));

		$vars = array();
		parse_str($info, $vars);

		// Write the request tokens to the database
		$this->_driver->oauthRequestWriteV1($app_tenant, $vars['oauth_token'], $vars['oauth_token_secret']);

		// Return the auth URL
		return QuickBooks_IPP_IntuitAnywhere::URL_CONNECT_BEGIN . '?oauth_callback=' . urlencode($url) . '&oauth_consumer_key=' . $this->_consumer_key . '&oauth_token=' . $vars['oauth_token'];
	}

	protected function _getAccessToken($oauth_token, $oauth_token_secret, $verifier)
	{
		if ($str = $this->_request(QuickBooks_IPP_OAuthv1::METHOD_GET, QuickBooks_IPP_IntuitAnywhere::URL_ACCESS_TOKEN,
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
				QuickBooks_IPP_OAuthv1::METHOD_GET,
				QuickBooks_IPP_IntuitAnywhere::URL_APP_MENU,
				array(),
				$creds['oauth_access_token'],
				$creds['oauth_access_token_secret']);
		}

		return '';
	}

	protected function _request($method, $url, $params = array(), $token = null, $secret = null, $data = null)
	{
		$OAuth = new QuickBooks_IPP_OAuthv1($this->_consumer_key, $this->_consumer_secret);

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

		// We need the headers back
		//$HTTP->returnHeaders(true);

		// Send the request
		$return = $HTTP->GET();

		$errnum = $HTTP->errorNumber();
		$errmsg = $HTTP->errorMessage();

		$this->_last_request = $HTTP->lastRequest();
		$this->_last_response = $HTTP->lastResponse();

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


