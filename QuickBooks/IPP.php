<?php

/**
 * QuickBooks IPP class for communicating with the Intuit Partner Platform
 * 
 * @author Keith Palmer <keith@ConsoliBYTE.com>
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
	
	const API_GETDBINFO = 'API_GetDBInfo';
	
	const API_GETDBVAR = 'API_GetDBVar';
	
	const API_GETUSERINFO = 'API_GetUserInfo';
	
	const API_GETUSERROLE = 'API_GetUserRole';
	
	const API_GETSCHEMA = 'API_GetSchema';
	
	const API_SETDBVAR = 'API_SetDBVar';
	
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
	const IDS_ADD = 'ids-add';
	
	/**
	 * An IDS request to modify an object
	 * @deprecated
	 */
	const IDS_MOD = 'ids-mod';
	
	/**
	 * An IDS request to search/query for an object
	 * @deprecated
	 */
	const IDS_QUERY = 'ids-query';
	
	/**
	 * An IDS request to get a report
	 * @deprecated
	 * @var unknown_type
	 */
	const IDS_REPORT = 'ids-report';
	
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
	
	protected $_username;
	protected $_password;
	protected $_ticket;
	protected $_token;
	protected $_application;
	
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
	
	public function __construct($dsn = null)
	{
		// Use a test gateway?
		$this->_test = false;
		
		// Use debug mode?
		$this->_debug = false;
		
		// Mask sensitive data in the logs (tickets, credit card numbers, etc.)
		$this->_masking = true;
		
		// Parse returned IDS responses into objects?
		$this->_ids_parser = true;
		
		// What version of IDS to use
		$this->_ids_version = QuickBooks_IPP_IDS::VERSION_2;
		
		// Driver class for logging
		$this->_driver = null;
		
		if ($dsn)
		{
			
		}
		
		$this->_certificate = null;
		
		$this->_errcode = QuickBooks_IPP::OK;
		$this->_errtext = '';
		$this->_errdetail = '';
		
		$this->_last_request = null;
		$this->_last_response = null;
		$this->_last_debug = array();
	}
	
	/**
	 * Authenticate to the IPP web service
	 *
	 * IMPORTANT NOTE: 
	 * Intuit disallows this method within live applications! You can use it to 
	 * test your application, but when you go live you'll need to instead use 
	 * a SAML gateway for single-sign-on authentication. Take a look at the 
	 * QuickBooks_IPP_Federator class for a working SAML gateway.
	 * 
	 * @param string $username
	 * @param string $password
	 * @param string $token
	 * @return boolean
	 */
	public function authenticate($username, $password, $token)
	{
		$this->_username = $username;
		$this->_password = $password;
		$this->_token = $token;
		
		$url = 'https://workplace.intuit.com/db/main?act=API_Authenticate';
		$action = 'API_Authenticate';
		
		$xml = '<?xml version="1.0" encoding="UTF-8" ?>
			<qdbapi>
				<username>' . $username . '</username>
				<password>' . $password . '</password>
				<apptoken>' . $token . '</apptoken>
			</qdbapi>';
		
		$Context = null;
		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		if (!$this->_hasErrors($response) and 
			$ticket = QuickBooks_XML::extractTagContents('ticket', $response))
		{
			$this->_ticket = $ticket;
			
			$cookies = array(
				'scache', 
				'ptest', 
				'stest', 
				'luid', 
				'TICKET', 
				'qbn.ticket', 
				'qbn.tkt', 
				'qbn.authid', 
				'qbn.gauthid', 
				'qbn.agentid', 
				'iamValidationTime'
				);
			
			foreach ($cookies as $cookie)
			{
				if ($value = $this->_extractCookie($cookie, $response))
				{
					$this->_cookies[$cookie] = $value;
				}
			}
			
			return new QuickBooks_IPP_Context($this, $ticket, $token);
		}
		
		return false;
	}
	
	/**
	 * Create a Context object (used for session management) for a given ticket and token 
	 * 
	 * 
	 */
	public function context($ticket = null, $token = null, $check_if_valid = true)
	{
		if (is_null($ticket))
		{
			$ticket = QuickBooks_IPP_Federator::getCookie();
		}
		
		$Context = new QuickBooks_IPP_Context($this, $ticket, $token);
		
		if ($check_if_valid)
		{
			// Now, let's check to make sure the context is valid
			
			// @todo Implement this
		}
		
		return $Context;
	}
	
	/**
	 * 
	 * 
	 * @deprecated 
	 *
	 */
	public function cookies($glob_them_together = false)
	{
		if ($glob_them_together)
		{
			$tmp = array();
			foreach ($this->_cookies as $cookie => $value)
			{
				$tmp[] = $cookie . '=' . $value;
			}
			
			return implode('; ', $tmp);
		}
		
		return $this->_cookies;
	}
	
	public function username()
	{
		return $this->_username;
	}
	
	public function password()
	{
		return $this->_password;
	}
	
	/*
	public function ticket($ticket = null)
	{
		if ($ticket)
		{
			$this->_ticket = $ticket;
		}

		return $this->_ticket;
	}
	
	public function token($token = null)
	{
		if ($token)
		{
			$this->_token = $token;
		}

		return $this->_token;
	}
	*/
	
	public function application($application = null)
	{
		if ($application)
		{
			$this->_application = $application;
		}
		
		return $this->_application;
	}

	/**
	 * 
	 * 
	 * 
	 */
	protected function _IPP($Context, $url, $action, $xml)
	{
		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
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
	
	public function getIDSRealm($Context)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
		$action = 'API_GetIDSRealm';
		
		$xml = '<qdbapi>
   				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';
		
		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		print($response);
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
	
	public function provisionUser($Context, $email, $fname, $lname, $roleid = null, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
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
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
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
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
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
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
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
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
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
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
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
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
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
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
		$action = 'API_AttachIDSRealm';
		$xml = '<qdbapi>
				<realm>' . $realm . '</realm>
				<ticket>' . $Context->ticket() . '</ticket>
				<apptoken>' . $Context->token() . '</apptoken>
			</qdbapi>';
			
		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		if ($this->_hasErrors($response))
		{
			return false;
		}
		
		return true;
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
	public function IDS($Context, $realmID, $resource, $optype, $xml = '')
	{
		if (substr($resource, 0, 6) == 'Report')
		{
			$resource = substr($resource, 6);
		}
		
		$url = 'https://services.intuit.com/sb/' . strtolower($resource) . '/' . $this->_ids_version . '/' . $realmID;
		
		$action = null;
		//$xml = '';
		
		$response = $this->_request($Context, QuickBooks_IPP::REQUEST_IDS, $url, $action, $xml);
		
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
		
		//$Parser = new QuickBooks_IPP_Parser();
		$Parser = $this->_parserInstance();
		
		$xml_errnum = null;
		$xml_errmsg = null;
		$err_code = null;
		$err_desc = null;
		$err_db = null;
		
		// Try to parse the responses into QuickBooks_IPP_Object_* classes
		$parsed = $Parser->parseIDS($data, $optype, $xml_errnum, $xml_errmsg, $err_code, $err_desc, $err_db);
		
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
	
	protected function _extractCookie($name, $response)
	{
		$lines = explode("\r\n", $response);
		
		foreach ($lines as $line)
		{
			// Set-Cookie: qbn.ticket=V1-47-U2v1RYBuM02GHgOYfulVmQ; expires=Tue, 19-Jan-2038 00:00:00 GMT; path=/; domain=.intuit.com; secure; HttpOnly
			$line = substr($line, 12);
			
			if (substr($line, 0, strlen($name)) == $name and 
				false !== ($pos = strpos($line, ';')))
			{
				return substr($line, strlen($name) + 1, $pos - strlen($name) - 1);
			}
		}
		
		return null;
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
		
		// Does not have any errors
		return false;
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
			// Send it to the driver to be logged 
			$this->_driver->log($message, $this->_ticket_session, $level);
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
	
	protected function _request($Context, $type, $url, $action, $xml)
	{
		$HTTP = new QuickBooks_HTTP($url);
		$post = true;
		
		$headers = array(
			);
			
		if ($type == QuickBooks_IPP::REQUEST_IPP)
		{
			$headers['Content-Type'] = 'application/xml';
			$headers['QUICKBASE-ACTION'] = $action;
		}
		else if ($type == QuickBooks_IPP::REQUEST_IDS) 
		{
			$headers['Content-Type'] = 'text/xml';
			$headers['Authorization'] = 'INTUITAUTH intuit-app-token="' . $Context->token() . '",intuit-token="' . $Context->ticket() . '"';
			$headers['Cookie'] = $this->cookies(true);
		}
		
		$HTTP->setHeaders($headers);
		
		// Turn on debugging for the HTTP object if it's been enabled in the payment processor
		$HTTP->useDebugMode($this->_debug);
		
		// 
		$HTTP->setRawBody($xml);
		
		$HTTP->verifyHost(false);
		$HTTP->verifyPeer(false);
		
		if ($this->_certificate)
		{
			$HTTP->setCertificate($this->_certificate);
		}
		
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
		//$this->_last_request = $HTTP->lastRequest();
		//$this->_last_response = $HTTP->lastResponse();
		
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
