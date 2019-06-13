<?php

/**
 * QuickBooks IPP class for communicating with the Intuit Partner Platform
 *
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 *
 * @license LICENSE.txt
 * @author Keith Palmer <Keith@ConsoliBYTE.com>
 *
 * @package QuickBooks
 * @subpackage IPP
 */

// Load the HTTP request class
QuickBooks_Loader::load('/QuickBooks/HTTP.php');

// XML parser
QuickBooks_Loader::load('/QuickBooks/XML.php');

// Context element (holds application information)
QuickBooks_Loader::load('/QuickBooks/IPP/Context.php');

// IPP XML parser
QuickBooks_Loader::load('/QuickBooks/IPP/Parser.php');

// SAML federation of applications
QuickBooks_Loader::load('/QuickBooks/IPP/Federator.php');

// OAuth
QuickBooks_Loader::load('/QuickBooks/IPP/OAuth.php');

// IntuitAnywhere widgets
QuickBooks_Loader::load('/QuickBooks/IPP/IntuitAnywhere.php');

// IDS (Intuit Data Services) base class
QuickBooks_Loader::load('/QuickBooks/IPP/IDS.php');

// Import all IDS service classes
QuickBooks_Loader::import('/QuickBooks/IPP/Service');

/**
 *
 *
 *
 */
class QuickBooks_IPP
{
	const API_ADDRECORD = 'API_AddRecord';

	const API_GETBILLINGSTATUS = 'API_GetBillingStatus';

	/**
	 * This is not a real API call!
	 */
	const API_GETBASEURL = '_getBaseURL_';

	const API_GETDBINFO = 'API_GetDBInfo';

	const API_GETDBVAR = 'API_GetDBVar';

	const API_GETUSERINFO = 'API_GetUserInfo';

	const API_GETUSERROLE = 'API_GetUserRole';

	const API_GETSCHEMA = 'API_GetSchema';

	const API_SETDBVAR = 'API_SetDBVar';

	const API_GETISREALMQBO = 'API_GetIsRealmQBO';

	const API_GETIDSREALM = 'API_GetIDSRealm';

	const API_ATTACHIDSREALM = 'API_AttachIDSRealm';

	const API_DETACHIDSREALM = 'API_DetachIDSRealm';

	const API_RENAMEAPP = 'API_RenameApp';

	const API_ASSERTFEDERATEDIDENTITY = 'API_AssertFederatedIdentity';

	const API_GETENTITLEMENTVALUES = 'API_GetEntitlementValues';

	const API_GETENTITLEMENTVALUESANDUSERROLE = 'API_GetEntitlementValuesAndUserRole';

	const AUTHMODE_FEDERATED = 'federated';
	const AUTHMODE_OAUTHV1 = 'oauthv1';
	const AUTHMODE_OAUTHV2 = 'oauthv2';

	/**
	 *
	 * @var unknown_type
	 */
	const COOKIE = 'ippfedcookie';

	/**
	 *
	 * @var string
	 */
	const REQUEST_IPP = 'ipp';

	/**
	 *
	 * @var string
	 */
	const REQUEST_IDS = 'ids';

	/**
	 * An IDS request to add an object
	 * @deprecated
	 */
	//const IDS_ADD = 'ids-add';

	/**
	 * An IDS request to modify an object
	 * @deprecated
	 */
	//const IDS_MOD = 'ids-mod';

	/**
	 * An IDS request to search/query for an object
	 * @deprecated
	 */
	//const IDS_QUERY = 'ids-query';

	/**
	 * An IDS request to get a report
	 * @deprecated
	 * @var unknown_type
	 */
	//const IDS_REPORT = 'ids-report';

	/**
	 * No error occurred
	 * @var integer
	 */
	const OK = QUICKBOOKS_ERROR_OK;

	/**
	 * No error occurred
	 * @var integer
	 */
	const ERROR_OK = QUICKBOOKS_ERROR_OK;

	/**
	 * Indicates a generic internal error
	 * @param integer
	 */
	const ERROR_INTERNAL = -1091;

	/**
	 * Indicates an error when parsing an XML stream
	 * @param integer
	 */
	const ERROR_XML = -1092;

	/**
	 * Indicates an error establishing a socket connection to QBMS
	 * @param integer
	 */
	const ERROR_SOCKET = -1093;

	/**
	 * Indicates an error with a parameter passed to QBMS
	 * @param integer
	 */
	const ERROR_PARAM = -1094;

	/**
	 * Indicates an internal SSL-related error
	 * @param integer
	 */
	const ERROR_SSL = -1095;

	/**
	 *
	 *
	 */
	const ERROR_HTTP = -1096;

	protected $_test;

	protected $_key;

	protected $_username;
	protected $_password;
	protected $_ticket;
	protected $_token;
	protected $_dbid;

	protected $_flavor;
	protected $_baseurl;
	protected $_sandbox;

	protected $_authmode;
	protected $_authuser;
	protected $_authcred;

	/**
	 * Auth signing method (if applicable)
	 * @var string
	 */
	protected $_authsign;

	/**
	 * Auth key (if applicable)
	 * @var string
	 */
	protected $_authkey;

	protected $_debug;

	protected $_last_request;
	protected $_last_response;
	protected $_last_debug;

	protected $_masking;

	protected $_driver;

	protected $_certificate;

	protected $_errcode;
	protected $_errtext;
	protected $_errdetail;

	/**
	 * An array of cookies returned by the deprecated ->authenticate() method
	 * @var array
	 */
	protected $_cookies;

	/**
	 * Whether or not to use the IDS parser and parse XML responses into objects
	 * @var boolean
	 */
	protected $_ids_parser;

	/**
	 * The version of IDS to use
	 * @var string
	 */
	protected $_ids_version;

	public function __construct($dsn, $encryption_key, $config = array(), $log_level = QUICKBOOKS_LOG_NORMAL)
	{
		// Are we in sandbox mode?
		$this->_sandbox = false;

		// Use a test gateway?
		$this->_test = false;

		// Use debug mode?
		$this->_debug = false;

		// Mask sensitive data in the logs (tickets, credit card numbers, etc.)
		$this->_masking = true;

		// Parse returned IDS responses into objects?
		$this->_ids_parser = true;

		// What version of IDS to use
		$this->_ids_version = QuickBooks_IPP_IDS::VERSION_3;

		// Driver class for logging
		$this->_driver = null;

		if ($dsn)
		{
			$this->_driver = QuickBooks_Driver_Factory::create($dsn, $config, $log_level);
			$this->_driver->setLogLevel($log_level);
		}

		$this->_cookies = array();

		$this->_certificate = null;

		$this->_errcode = QuickBooks_IPP::OK;
		$this->_errtext = '';
		$this->_errdetail = '';

		$this->_last_request = null;
		$this->_last_response = null;
		$this->_last_debug = array();

		$this->_authmode = QuickBooks_IPP::AUTHMODE_FEDERATED;
		$this->_authuser = null;
		$this->_authcred = null;

		$this->_authsign = null;
		$this->_authkey = null;

		// Encryption key (used for database storage)
		$this->_key = $encryption_key;
	}

	/**
	 * Create a Context object (used for session management) for a given ticket and token
	 *
	 *
	 */
	public function context()
	{
		$Context = null;

		if ($this->_authmode == QuickBooks_IPP::AUTHMODE_OAUTHV1)
		{
			$Context = new QuickBooks_IPP_Context($this, null, null);
		}
		else if ($this->_authmode == QuickBooks_IPP::AUTHMODE_OAUTHV2)
		{
			$Context = new QuickBooks_IPP_Context($this, null, null);
		}

		return $Context;
	}

	/**
	 *
	 *
	 */
	public function flavor($flavor = null)
	{
		if ($flavor)
		{
			$this->_flavor = $flavor;

			if ($flavor == QuickBooks_IPP_IDS::FLAVOR_DESKTOP)
			{
				$this->baseURL(QuickBooks_IPP_IDS::BASEURL_DESKTOP);
			}
		}

		return $this->_flavor;
	}

	public function sandbox($sandbox = null)
	{
		if (!is_null($sandbox))
		{
			$this->_sandbox = (bool) $sandbox;
		}

		return $this->_sandbox;
	}

	public function baseURL($baseURL = null)
	{
		if ($baseURL)
		{
			$this->_baseurl = $baseURL;
		}

		return $this->_baseurl;
	}

	public function authcreds()
	{
		return $this->_authcred;
	}

	/**
	 * Set the authorization mode for HTTP requests (Federated, or OAuth)
	 *
	 * @param string $authmode		The new auth mode
	 * @return string				The currently set auth mode
	 */
	public function authMode($authmode = null, $authcred = null, $authsign = null, $authkey = null)
	{
		if ($authmode)
		{
			$this->_authmode = $authmode;
			$this->_authcred = $authcred;

			$this->_authsign = $authsign;
			$this->_authkey = $authkey;
		}

		return $this->_authmode;
	}

	/**
	 * Get or set the DBID of the attached federated app
	 *
	 * @param string $dbid
	 * @return string
	 */
	public function dbid($dbid = null)
	{
		if ($dbid)
		{
			$this->_dbid = $dbid;
		}

		return $this->_dbid;
	}

	/**
	 *
	 *
	 *
	 */
	protected function _IPP($Context, $url, $action, $xml, $post = true)
	{
		// Ick, special case here...
		$type = QuickBooks_IPP::REQUEST_IPP;
		if ($action == QuickBooks_IPP::API_GETBASEURL)
		{
			$type = QuickBooks_IPP::REQUEST_IDS;
		}

		// Make the HTTP request
		$response = $this->_request($Context, $type, $url, $action, $xml, $post);

		if ($this->_hasErrors($response))
		{
			return false;
		}

		// These methods don't need a parsed response. If we've gotten this far,
		//	then we know there wasn't an API error, and we can just return TRUE
		//	because the request succeeded and there's no real meaningful data
		//	that we need to parse out and return in the response.
		switch ($action)
		{
			case QuickBooks_IPP::API_SETDBVAR:
			case QuickBooks_IPP::API_ATTACHIDSREALM:
			case QuickBooks_IPP::API_DETACHIDSREALM:
			case QuickBooks_IPP::API_RENAMEAPP:
				return true;
		}

		// Remove HTTP headers from response
		$data = $this->_stripHTTPHeaders($response);

		$xml_errnum = null;
		$xml_errmsg = null;
		$err_code = null;
		$err_desc = null;
		$err_db = null;

		$Parser = $this->_parserInstance();

		// Try to parse the response from IPP
		$parsed = $Parser->parseIPP($data, $action, $xml_errnum, $xml_errmsg, $err_code, $err_desc, $err_db);

		/*
		print('parsed out: [');
		print_r($parsed);
		print(']');
		*/

		//$this->_setLastDebug(__CLASS__, array( 'ipp_parser_duration' => microtime(true) - $start ));

		if ($xml_errnum != QuickBooks_XML::ERROR_OK)
		{
			// Error parsing the returned XML?
			$this->_setError(QuickBooks_IPP::ERROR_XML, 'XML parser said: ' . $xml_errnum . ': ' . $xml_errmsg);

			return false;
		}
		else if ($err_code != QuickBooks_IPP::ERROR_OK)
		{
			// Some other IPP error
			$this->_setError($err_code, $err_desc, 'Database error code: ' . $err_db);

			return false;
		}

		return $parsed;
	}

	public function getBaseURL($Context, $realmID)
	{
		/*
		$url = 'https://qbo.intuit.com/qbo1/rest/user/v2/' . $realmID;
		$action = QuickBooks_IPP::API_GETBASEURL;
		$xml = null;

		$post = false;
		return $this->_IPP($Context, $url, $action, $xml, $post);
		*/

		return QuickBooks_IPP_IDS::URL_V3;
	}

	public function getIsRealmQBO($Context)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_GETISREALMQBO;

		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
   				<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function assertFederatedIdentity($Context, $provider, $target_url, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/main';
		$action = QuickBooks_IPP::API_ASSERTFEDERATEDIDENTITY;

		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
				<serviceProviderID>' . htmlspecialchars($provider) . '</serviceProviderID>
				<targetURL>' . htmlspecialchars($target_url, ENT_QUOTES) . '</targetURL>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function renameApp($Context, $name)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_RENAMEAPP;

		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
   				<apptoken>' . $Context->token() . '</apptoken>
   				<newappname>' . htmlspecialchars($name) . '</newappname>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function getIDSRealm($Context)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_GETIDSREALM;

		$xml = '<qdbapi>
   				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function getAvailableCompanies($Context)
	{
		$url = 'https://services.intuit.com/sb/company/' . $this->_ids_version . '/available';
		$action = null;
		$xml = null;

		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IDS, $url, $action, $xml);

		if ($this->_hasErrors($response))
		{
			return false;
		}

		// @todo Parse and return an object?
		return $response;
	}

	/*
	public function getEntitlementValues($Context)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_GETENTITLEMENTVALUES;

		$xml = '<qdbapi>
			<ticket>' . $Context->ticket() . '</ticket>
			<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function getEntitlementValuesAndUserRole($Context)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_GETENTITLEMENTVALUESANDUSERROLE;

		$xml = '<qdbapi>
			<ticket>' . $Context->ticket() . '</ticket>
			<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}
	*/

	public function provisionUser($Context, $email, $fname, $lname, $roleid = null, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = 'API_ProvisionUser';

		$xml = '<qdbapi>
					<ticket>' . $Context->ticket() . '</ticket>
					<apptoken>' . $Context->token() . '</apptoken>';

		if ($roleid)
		{
			$xml .= '<roleid>' . $roleid . '</roleid>';
		}

		$xml .= '
				<email>' . $email . '</email>
				<fname>' . $fname . '</fname>
				<lname>' . $lname . '</lname>';

		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);

		if ($this->_hasErrors($response))
		{
			return false;
		}

		return true;
	}

	public function getUserRoles($Context, $userid, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_GETUSERROLE;
		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
				<userid>' . htmlspecialchars($userid) . '</userid>';

		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function getUserInfo($Context, $email = null, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/main';
		$action = QuickBooks_IPP::API_GETUSERINFO;
		$xml = '<qdbapi>
   				<ticket>' . $Context->ticket() . '</ticket>
   				<apptoken>' . $Context->token() . '</apptoken>';

		if ($email)
		{
			$xml .= '<email>' . htmlspecialchars($email) . '</email>';
		}

		if ($udata)
		{
			$xml .= '<udata>' . htmlspecialchars($udata) . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function sendInvitation($Context, $userid, $usertext, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = 'API_SendInvitation';
		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
				<userid>' . htmlspecialchars($userid) . '</userid>
				<usertext>' . htmlspecialchars($usertext) . '</usertext>';

		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);

		if ($this->_hasErrors($response))
		{
			return false;
		}

		return true;
	}

	public function getDBInfo($Context, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_GETDBINFO;
		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>';

		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function setDBVar($Context, $varname, $value, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_SETDBVAR;
		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
				<varname>' . QuickBooks_XML::encode($varname) . '</varname>
				<value>' . QuickBooks_XML::encode($value) . '</value>';

		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function getDBVar($Context, $varname, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_GETDBVAR;
		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
				<varname>' . QuickBooks_XML::encode($varname) . '</varname>';

		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function createTable($Context, $tname, $pnoun, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = 'API_CreateTable';
		$xml = '<qdbapi>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
				<tname>' . $tname . '</tname>
				<pnoun>' . $pnoun . '</pnoun>';

		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}

		$xml .= '
			</qdbapi>';

		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);

		if ($this->_hasErrors($response))
		{
			return false;
		}

		return true;
	}

	public function attachIDSRealm($Context, $realm)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_ATTACHIDSREALM;
		$xml = '<qdbapi>
				<realm>' . $realm . '</realm>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	public function detachIDSRealm($Context, $realm)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_dbid;
		$action = QuickBooks_IPP::API_DETACHIDSREALM;
		$xml = '<qdbapi>
				<realm>' . $realm . '</realm>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';

		return $this->_IPP($Context, $url, $action, $xml);
	}

	/**
	 *
	 *
	 *
	 * @param boolean $true_or_false
	 * @return boolean
	 */
	public function useIDSParser($true_or_false)
	{
		$this->_ids_parser = (boolean) $true_or_false;
		return $this->_ids_parser;
	}

	/**
	 * Get or set the IDS version to use
	 *
	 * @param string $version		One of QuickBooks_IPP_IDS::VERSION_1, QuickBooks_IPP_IDS::VERSION_2, QuickBooks_IPP_IDS::VERSION_LATEST
	 * @return string				The IDS version currently being used
	 */
	public function version($version = null)
	{
		if ($version)
		{
			$this->_ids_version = $version;
		}

		return $this->_ids_version;
	}

	/**
	 * Make an IDS request (Intuit Data Services) to the remote server
	 *
	 * @param QuickBooks_IPP_Context $Context		The context (token and ticket) to use
	 * @param integer $realmID						The realm to query against
	 * @param string $resource						A QuickBooks_IDS::RESOURCE_* constant
	 * @param string $optype
	 * @param string $xml
	 * @return QuickBooks_IPP_Object
	 */
	public function IDS($Context, $realm, $resource, $optype, $xml = '', $ID = null)
	{
		$IPP = $Context->IPP();

		// Do any renewals we need to do first
		$this->_handleRenewal();

		switch ($IPP->version())
		{
			case QuickBooks_IPP_IDS::VERSION_3:
			default:
				return $this->_IDS_v3($Context, $realm, $resource, $optype, $xml, $ID);
		}
	}

	/**
	 * Do we need to renew the OAuth access token? If so, renew it
	 */
	protected function _handleRenewal()
	{
		static $attempted_renew = false;

		if (!$attempted_renew and
			is_object($this->_driver) and
			$this->_authmode == QuickBooks_IPP::AUTHMODE_OAUTHV2 and
			strtotime($this->_authcred['oauth_access_expiry']) + 60 < time())
		{
			$attempted_renew = true;

			if ($discover = QuickBooks_IPP_IntuitAnywhere::discover($this->_sandbox))
			{
				$ch = curl_init($discover['token_endpoint']);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);   // Do not follow; security risk here

				curl_setopt($ch, CURLOPT_USERPWD, $this->_authcred['oauth_client_id'] . ':' . $this->_authcred['oauth_client_secret']);

				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(
					'grant_type' => 'refresh_token',
					'refresh_token' => $this->_authcred['oauth_refresh_token']
					)));

				$retr = curl_exec($ch);
				$info = curl_getinfo($ch);

				if ($info['http_code'] == 200)
				{
					$json = json_decode($retr, true);

					$this->_driver->oauthAccessRefreshV2(
						$this->_key,
						$this->_authcred['quickbooks_oauthv2_id'],
						$json['access_token'],
						$json['refresh_token'],
						date('Y-m-d H:i:s', time() + (int) $json['expires_in']),
						date('Y-m-d H:i:s', time() + (int) $json['x_refresh_token_expires_in']));

					// Replace our auth creds with the new ones
					$this->_authcred = $this->_driver->oauthLoadV2($this->_key, $this->_authcred['app_tenant']);

					// Successfully renewed!
					return true;
				}
			}

			return false;
		}

		// No renewal needed
		return true;
	}

	protected function _IDS_v3($Context, $realm, $resource, $optype, $xml_or_query, $ID)
	{
		// All v3 URLs have the same baseURL
		$this->baseURL(QuickBooks_IPP_IDS::URL_V3);

		// If we're in sandbox mode, use the sandbox URL instead
		if ($this->sandbox())
		{
			$this->baseURL(QuickBooks_IPP_IDS::URL_V3_SANDBOX);
		}

		$post = false;
		$xml = null;
		$query = null;

		$guid = QuickBooks_Utilities::GUID();

		if ($optype == QuickBooks_IPP_IDS::OPTYPE_ADD or $optype == QuickBooks_IPP_IDS::OPTYPE_MOD)
		{
			$post = true;
			$url = $this->baseURL() . '/company/' . $realm . '/' . strtolower($resource) . '?requestid=' . $guid . '&minorversion=6';
			$xml = $xml_or_query;
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_QUERY)
		{
			$post = false;
			$url = $this->baseURL() . '/company/' . $realm . '/query?query=' . $xml_or_query . '&requestid=' . $guid . '&minorversion=6';
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_CDC)
		{
			$post = false;
			$url = $this->baseURL() . '/company/' . $realm . '/cdc?entities=' . implode(',', $xml_or_query[0]) . '&changedSince=' . $xml_or_query[1] . '&minorversion=6';
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_ENTITLEMENTS)
		{
			$post = false;
			$url = 'https://qbo.sbfinance.intuit.com/manage/entitlements/v3/' . $realm;
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_DELETE)
		{
			$post = true;
			$url = $this->baseURL() . '/company/' . $realm . '/' . strtolower($resource) . '?operation=delete&requestid=' . $guid . '&minorversion=6';
			$xml = $xml_or_query;
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_VOID)
		{
			$qs = '?operation=void&requestid=' . $guid . '&minorversion=6';        // Used for invoices...

			if ($resource == QuickBooks_IPP_IDS::RESOURCE_PAYMENT)    // ... and something different used for payments *sigh*
			{
				$qs = '?operation=update&include=void&requestid=' . $guid . '&minorversion=6';
			}

			$post = true;
			$url = $this->baseURL() . '/company/' . $realm . '/' . strtolower($resource) . $qs;
			$xml = $xml_or_query;
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_PDF)
		{
			$post = false;
			$url = $this->baseURL() . '/company/' . $realm . '/' . strtolower($resource) . '/' . $ID . '/pdf?requestid=' . $guid . '&minorversion=6';
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_DOWNLOAD)
		{
			$post = false;
			$url = $this->baseURL() . '/company/' . $realm . '/' . strtolower($resource) . '/' . $ID;
		}
		else if ($optype == QuickBooks_IPP_IDS::OPTYPE_SEND)
		{
			$post = true;
			$url = $this->baseURL() . '/company/' . $realm . '/' . strtolower($resource) . '/' . $ID . '/send?requestid=' . $guid . '&minorversion=6';
		}

		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IDS, $url, $optype, $xml, $post);

		// print('URL is [' . $url . ']');
		//die('RESPONSE IS [' . $response . ']');

		// Check for generic IPP errors and HTTP errors
		if ($this->_hasErrors($response))
		{
			return false;
		}

		$data = $this->_stripHTTPHeaders($response);

		if (!$this->_ids_parser)
		{
			// If they don't want the responses parsed into objects, then just return the raw XML data
			return $data;
		}

		$start = microtime(true);

		$Parser = $this->_parserInstance();

		$xml_errnum = null;
		$xml_errmsg = null;
		$err_code = null;
		$err_desc = null;
		$err_db = null;

		// Try to parse the responses into QuickBooks_IPP_Object_* classes
		$parsed = $Parser->parseIDS($data, $optype, $this->flavor(), QuickBooks_IPP_IDS::VERSION_3, $xml_errnum, $xml_errmsg, $err_code, $err_desc, $err_db);

		$this->_setLastDebug(__CLASS__, array( 'ids_parser_duration' => microtime(true) - $start ));

		if ($xml_errnum != QuickBooks_XML::ERROR_OK)
		{
			// Error parsing the returned XML?
			$this->_setError(QuickBooks_IPP::ERROR_XML, 'XML parser said: ' . $xml_errnum . ': ' . $xml_errmsg);

			return false;
		}
		else if ($err_code != QuickBooks_IPP::ERROR_OK)
		{
			// Some other IPP error
			$this->_setError($err_code, $err_desc, 'Database error code: ' . $err_db);

			return false;
		}

		// Return the parsed response
		return $parsed;
	}

	/**
	 *
	 *
	 * @param string $response
	 * @return string
	 */
	protected function _stripHTTPHeaders($response)
	{
		$pos = strpos($response, "\r\n\r\n");

		// @todo Error checking, what if \r\n\r\n isn't present?
		$stripped = substr($response, $pos + 4);

		// To handle "HTTP/1.1 100 Continue\r\n\r\nHTTP/1.1 200 OK\r\n .... " responses
		if (substr($stripped, 0, 8) == 'HTTP/1.1')
		{
			return $this->_stripHTTPHeaders($stripped);
		}

		return $stripped;
	}

	protected function _parserInstance()
	{
		static $Parser = null;
		if (is_null($Parser))
		{
			$Parser = new QuickBooks_IPP_Parser();
		}

		return $Parser;
	}

	/**
	 *
	 */
	protected function _hasErrors($response)
	{
		// @todo This should first check for HTTP errors
		// ...

		// v3 errors
		if (false !== strpos($response, '<Error'))
		{
			$errcode = QuickBooks_XML::extractTagAttribute('code', $response);
			$errtext = QuickBooks_XML::extractTagContents('Message', $response);
			$errdetail = QuickBooks_XML::extractTagContents('Detail', $response);

			$this->_setError($errcode, $errtext, $errdetail);

			return true;		// Yes, there's an error!
		}
		else if (false !== strpos($response, '<title>504 Gateway Time-out'))
		{
			// QBO v3 sometimes blows up with a 504 gateway error, catch these!

			$errcode = QUICKBOOKS_ERROR_INTERNAL;
			$errtext = '504 Gateway Time-out';
			$errdetail = 'A service call to the QuickBooks Online gateway has timed out and returned a 504 HTTP error.';

			$this->_setError($errcode, $errtext, $errdetail);

			return true;
		}
		else
		{
			// Check for generic IPP XML node errors
			$errcode = QuickBooks_XML::extractTagContents('errcode', $response);
			$errtext = QuickBooks_XML::extractTagContents('errtext', $response);
			$errdetail = QuickBooks_XML::extractTagContents('errdetail', $response);

			if ($errcode != QuickBooks_IPP::OK)
			{
				// Has errors!
				$this->_setError($errcode, $errtext, $errdetail);
				return true;
			}

			// Check for IDS XML error codes
			$errorcode = QuickBooks_XML::extractTagContents('ErrorCode', $response);
			$errordesc = QuickBooks_XML::extractTagContents('ErrorDesc', $response);

			if ($errorcode)
			{
				$this->_setError($errorcode, $errordesc);
				return true;
			}

			// Does not have any errors
			return false;
		}
	}

	/**
	 * If masking is enabled (default) then credit card numbers, connection tickets, and session tickets will be masked when output or logged
	 *
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useMasking($yes_or_no)
	{
		$this->_masking = (boolean) $yes_or_no;
	}

	/**
	 * Turn debugging mode on or off
	 *
	 * Turning debugging mode on will result in a large amount of output being
	 * printed directly to stdout (the web browser or the console)
	 *
	 * @param boolean $yes_or_no
	 * @return void
	 */
	public function useDebugMode($yes_or_no)
	{
		$this->_debug = (boolean) $yes_or_no;
	}


	/**
	 *
	 *
	 *
	 * @param string $message
	 * @param integer $level
	 * @return boolean
	 */
	protected function _log($message, $level = QUICKBOOKS_LOG_NORMAL)
	{
		if ($this->_masking)
		{
			$message = QuickBooks_Utilities::mask($message);
		}

		if ($this->_debug)
		{
			print($message . QUICKBOOKS_CRLF);
		}

		if ($this->_driver)
		{
			//die('logging to driver: [' . $level . ']');
			// Send it to the driver to be logged
			$this->_driver->log($message, null, $level);
		}

		return true;
	}

	/**
	 * Log a message
	 *
	 *
	 */
	public function log($message, $level = QUICKBOOKS_LOG_NORMAL)
	{
		return $this->_log($message, $level);
	}

	protected function _request($Context, $type, $url, $action, $data, $post = true)
	{
		$headers = array(
			);

		if ($action == QuickBooks_IPP_IDS::OPTYPE_ADD or
			$action == QuickBooks_IPP_IDS::OPTYPE_MOD or
			$action == QuickBooks_IPP_IDS::OPTYPE_VOID or
			$action == QuickBooks_IPP_IDS::OPTYPE_DELETE)
		{
			$headers['Content-Type'] = 'application/xml';
		}
		else
		{
			$headers['Content-Type'] = 'text/plain';
		}

		// Authorization stuff
		if ($this->_authmode == QuickBooks_IPP::AUTHMODE_OAUTHV2)
		{
			if ($this->_authcred['oauth_access_token'])
			{
				$headers['Authorization'] = 'Bearer ' . $this->_authcred['oauth_access_token'];
			}
		}
		else if ($this->_authmode == QuickBooks_IPP::AUTHMODE_OAUTHV1)
		{
			// If we have credentials, sign the request
			if ($this->_authcred['oauth_access_token'] and
				$this->_authcred['oauth_access_token_secret'])
			{
				// Sign the request
				$OAuth = new QuickBooks_IPP_OAuthv1($this->_authcred['oauth_consumer_key'], $this->_authcred['oauth_consumer_secret']);

				// Different than default signature method?
				if ($this->_authsign)
				{
					$OAuth->signature($this->_authsign, $this->_authkey);
				}

				if ($post)
				{
					$action = QuickBooks_IPP_OAuthv1::METHOD_POST;
				}
				else
				{
					$action = QuickBooks_IPP_OAuthv1::METHOD_GET;
				}

				$signdata = null;
				if ($data and
					$data[0] == '<')
				{
					// It's an XML body, we don't sign that
					$signdata = null;
				}
				else
				{
					// It's form-encoded data, parse it so we can sign it
					$signdata = array();
					parse_str($data, $signdata);
				}

				$signed = $OAuth->sign($action, $url, $this->_authcred['oauth_access_token'], $this->_authcred['oauth_access_token_secret'], $signdata);

				// Always use the header, regardless of POST or GET
				$headers['Authorization'] = $signed[3];

				if ($post)
				{
					// Remove any whitespace padding before checking
					$data = trim($data);

					if ($data and $data[0] == '<')
					{
						// Do nothing
					}
					else
					{
						$data = http_build_query($signdata);
					}
				}
				else
				{
					;
				}
			}
		}

		// Our HTTP requestor
		$HTTP = new QuickBooks_HTTP($url);

		// Set the headers
		$HTTP->setHeaders($headers);

		// Turn on debugging for the HTTP object if it's been enabled in the payment processor
		$HTTP->useDebugMode($this->_debug);

		//
		$HTTP->setRawBody($data);

		// We need the headers back
		$HTTP->returnHeaders(true);

		// Send the request
		if ($post)
		{
			$return = $HTTP->POST();
		}
		else
		{
			$return = $HTTP->GET();
		}

		$this->_setLastRequestResponse($HTTP->lastRequest(), $HTTP->lastResponse());
		$this->_setLastDebug(__CLASS__, array( 'http_request_response_duration' => $HTTP->lastDuration() ));

		//
		$this->_log($HTTP->getLog(), QUICKBOOKS_LOG_DEBUG);

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

	/**
	 * Get the last raw XML response that was received
	 *
	 * @return string
	 */
	public function lastResponse()
	{
		return $this->_last_response;
	}

	/**
	 * Get the last raw XML request that was sent
	 *
	 * @return string
	 */
	public function lastRequest()
	{
		return $this->_last_request;
	}

	public function lastDebug()
	{
		return $this->_last_debug;
	}

	/**
	 * Get the error number of the last error that occured
	 *
	 * @return mixed		The error number (or error code, some QuickBooks error codes are hex strings)
	 */
	public function errorCode()
	{
		return $this->_errcode;
	}

	/**
	 * Alias if ->errorCode()   (here for consistency with rest of framework)
	 */
	public function errorNumber()
	{
		return $this->errorCode();
	}

	/**
	 * Get the last error message that was reported
	 *
	 * Remember that issuing new commands may cause previous unchecked errors
	 * to be *cleared*, so make sure you check for errors if you expect an
	 * error might occur!
	 *
	 * @return string
	 */
	public function errorText()
	{
		return $this->_errtext;
	}

	/**
	 * Alias of ->errorText()   (here for consistency with rest of framework)
	 */
	public function errorMessage()
	{
		return $this->errorText();
	}

	/**
	 *
	 */
	public function errorDetail()
	{
		return $this->_errdetail;
	}

	public function hasErrors()
	{
		return $this->_errcode != QuickBooks_IPP::ERROR_OK;
	}

	public function lastError()
	{
		return $this->_errcode . ': [' . $this->_errtext . ', ' . $this->_errdetail . ']';
	}

	/**
	 * Set an error message
	 *
	 * @param integer $errnum	The error number/code
	 * @param string $errmsg	The text error message
	 * @return void
	 */
	protected function _setError($errcode, $errtext = '', $errdetail = '')
	{
		$this->_errcode = $errcode;
		$this->_errtext = $errtext;
		$this->_errdetail = $errdetail;
	}

	protected function _setLastRequestResponse($request, $response)
	{
		$this->_last_request = $request;
		$this->_last_response = $response;
	}

	protected function _setLastDebug($class, $arr)
	{
		$existing = array();
		if (isset($this->_last_debug[$class]))
		{
			$existing = $this->_last_debug[$class];
		}

		$this->_last_debug[$class] = array_merge($existing, $arr);
	}
}
