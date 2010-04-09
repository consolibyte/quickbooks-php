<?php

/**
 * 
 * @package QuickBooks
 * @subpackage IPP
 */

// 
QuickBooks_Loader::load('/QuickBooks/HTTP.php');

// 
QuickBooks_Loader::load('/QuickBooks/XML.php');

// 
QuickBooks_Loader::load('/QuickBooks/IPP/Context.php');

// 
QuickBooks_Loader::load('/QuickBooks/IPP/Parser.php');

/**
 * 
 * 
 *
 */
class QuickBooks_IPP
{
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
	
	protected $_masking;
	
	protected $_driver;
	
	protected $_certificate;
	
	protected $_errcode;
	protected $_errtext;
	protected $_errdetail;
	
	protected $_cookies;
	
	public function __construct()
	{
		$this->_test = false;
		$this->_debug = false;
		$this->_masking = true;
		
		$this->_driver = null;
		
		$this->_certificate = null;
		
		$this->_errcode = QuickBooks_IPP::OK;
		$this->_errtext = '';
		$this->_errdetail = '';
		
		
	}
	
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
		
		$response = $this->_request(QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
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
			
			// @todo Fix this so the context is correct
			$Context = new QuickBooks_IPP_Context($this);
			
			return $Context;
		}
		
		return false;
	}
	
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
	
	public function ticket()
	{
		return $this->_ticket;
	}
	
	public function token()
	{
		return $this->_token;
	}
	
	public function application($Context, $application = null)
	{
		if ($application)
		{
			$this->_application = $application;
		}
		
		return $this->_application;
	}
		
	public function getIDSRealm()
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
		$action = 'API_GetIDSRealm';
		
		$xml = '<qdbapi>
   				<ticket>' . $this->_ticket . '</ticket>
				<apptoken>' . $this->_token . '</apptoken>
			</qdbapi>';
		
		$response = $this->_request(QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		print($response);
	}
	
	public function getAvailableCompanies()
	{
		$url = 'https://services.intuit.com/sb/company/v2/available';
		//$url = 'https://services.intuit.com/sb/invoice/v2/133828393';
		$action = null;
		$xml = null;
		
		$response = $this->_request(QuickBooks_IPP::REQUEST_IDS, $url, $action, $xml);
		
		if ($this->_hasErrors($response))
		{
			return false;
		}
		
		// @todo Parse and return an object? 
		return $response;
	}
	
	public function provisionUser($email, $fname, $lname, $roleid = null, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
		$action = 'API_ProvisionUser';
		
		$xml = '<qdbapi>
				<ticket>' . $this->_ticket . '</ticket>
				<apptoken>' . $this->_token . '</apptoken>';
		
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
			
		$response = $this->_request(QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		if ($this->_hasErrors($response))
		{
			return false;
		}
		
		return true;
	}
	
	public function sendInvitation($userid, $usertext, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
		$action = 'API_SendInvitation';
		$xml = '<qdbapi>
				<ticket>' . $this->_ticket . '</ticket>
				<apptoken>' . $this->_token . '</apptoken>
				<userid>' . $userid . '</userid>
				<usertext>' . $usertext . '</usertext>';
		
		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}
				
		$xml .= '
			</qdbapi>';
			
		$response = $this->_request(QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		if ($this->_hasErrors($response))
		{
			return false;
		}
		
		return true;
	}
	
	public function createTable($tname, $pnoun, $udata = null)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
		$action = 'API_CreateTable';		
		$xml = '<qdbapi>
				<ticket>' . $this->_ticket . '</ticket>
				<apptoken>' . $this->_token . '</apptoken>
				<tname>' . $tname . '</tname>
				<pnoun>' . $pnoun . '</pnoun>';
		
		if ($udata)
		{
			$xml .= '<udata>' . $udata . '</udata>';
		}
				
		$xml .= '
			</qdbapi>';
			
		$response = $this->_request(QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		if ($this->_hasErrors($response))
		{
			return false;
		}
		
		return true;
	}
	
	public function attachIDSRealm($realm)
	{
		$url = 'https://workplace.intuit.com/db/' . $this->_application;
		$action = 'API_AttachIDSRealm';
		$xml = '<qdbapi>
				<realm>' . $realm . '</realm>
				<ticket>' . $this->_ticket . '</ticket>
				<apptoken>' . $this->_token . '</apptoken>
			</qdbapi>';
			
		$response = $this->_request(QuickBooks_IPP::REQUEST_IPP, $url, $action, $xml);
		
		if ($this->_hasErrors($response))
		{
			return false;
		}
		
		return true;
	}
	
	public function IDS($Context, $realmID, $resource, $xml = '')
	{
		
		$url = 'https://services.intuit.com/sb/' . strtolower($resource) . '/v2/' . $realmID;
		//$url = 'https://services.intuit.com/sb/invoice/v2/173642438';
		
		//$url = '';
		
		$action = null;
		//$xml = '';
		
		$response = $this->_request(QuickBooks_IPP::REQUEST_IDS, $url, $action, $xml);
		
		if ($this->_hasErrors($response))
		{
			return false;
		}
		
		$data = $this->_stripHTTPHeaders($response);
		
		$Parser = new QuickBooks_IPP_Parser();
		$parsed = $Parser->parseIDS($data);
		
		// @todo Parse and return an object? 
		return $parsed;		
	}
	
	protected function _stripHTTPHeaders($response)
	{
		$pos = strpos($response, "\r\n\r\n");
		
		// @todo Error checking, what if \r\n\r\n isn't present?
		return substr($response, $pos + 4);
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
	
	protected function _hasErrors($response)
	{
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
	
	protected function _request($type, $url, $action, $xml)
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
			$headers['Authorization'] = 'INTUITAUTH intuit-app-token="' . $this->_token . '",intuit-token="' . $this->_ticket . '"';
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
		
		$this->_last_request = $HTTP->lastRequest();
		$this->_last_response = $HTTP->lastResponse();
		
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
}