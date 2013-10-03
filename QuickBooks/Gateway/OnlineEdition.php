<?php

QuickBooks_Loader::load('/QuickBooks/Utilities.php');

QuickBooks_Loader::load('/QuickBooks/Callbacks.php');

class QuickBooks_Gateway_OnlineEdition
{
	const HOOK_FINISHED = 'QuickBooks_Gateway_OnlineEdition::hook-finished';

	const OK = QUICKBOOKS_ERROR_OK;
	const ERROR_OK = QUICKBOOKS_ERROR_OK;
	const ERROR_INTERNAL = -971;
	const ERROR_XML = -972;
	const ERROR_SOCKET = -973;
	const ERROR_PARAM = -974;

	const QBXML_VERSION = '6.0';

	const SEVERITY_INFO = 'Info';
	const SEVERITY_WARN = 'Warning';
	const SEVERITY_ERROR = 'Error';

	protected $_ticket_connection = '';
	protected $_ticket_session = '';
	protected $_application_id = null;
	protected $_application_login = null;

	protected $_certificate;

	protected $_user;

	protected $_map;
	protected $_errmap;

	protected $_debug;
	protected $_test;

	protected $_errnum;
	protected $_errmsg;

	protected $_last_request;
	protected $_last_response;

	const GATEWAY_LIVE = 'https://webapps.quickbooks.com/j/AppGateway';
	const GATEWAY_TEST = '';

	public function __construct($app_id, $app_login, $connection_ticket, $certificate = null, $user = null, $map = array(), $errmap = array(), $dsn = null, $driver_options = array(), $hooks = array())
	{
		// @TODO We need a better way of setting the logging level... 
		$this->_hooks = $hooks;
		$log_level = QUICKBOOKS_LOG_DEVELOP;
		
		$this->_driver = null;
		if ($dsn)
		{
			$this->_driver = QuickBooks_Driver_Factory::create($dsn, $driver_options, $hooks, $log_level);
		}
		
		// Masking of sensitive data
		$this->_masking = true;

		$this->_application_id = $app_id;
		$this->_application_login = $app_login;
		$this->_ticket_connection = $connection_ticket;

		$this->_certificate = $certificate;

		$this->_user = $user;
		$this->_map = $map;
		$this->_errmap = $errmap;

		$this->_debug = false;

		$this->_errnum = QuickBooks_Gateway_OnlineEdition::ERROR_OK;
	}

	/**
	 * Get the error number of the last error that occured
	 * 
	 * @return mixed		The error number (or error code, some QuickBooks error codes are hex strings)
	 */
	public function errorNumber()
	{
		return $this->_errnum;
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
	public function errorMessage()
	{
		return $this->_errmsg;
	}
	
	/**
	 * Get the last raw response that the data source sent us (usually a qbXML response)
	 * 
	 * @return string
	 */
	public function lastResponse()
	{
		return $this->_last_response;
	}
	
	/**
	 * Get the last raw request that the data source issued (qbXML request or otherwise)
	 * 
	 * @return string
	 */
	public function lastRequest()
	{
		return $this->_last_request;
	}

	/**
	 *
	 */
	public function processQueue($max = 25)
	{
		if ($this->_driver and 
			$this->connect())
		{
			$count = 0;

			// Set up connection first
			$company_file = null;
			$wait_before_next_update = null;
			$min_run_every_n_seconds = null;

			$override = true;

			$ticket = $this->_driver->authLogin($this->_user, 'abcd1234', $company_file, $wait_before_next_update, $min_run_every_n_seconds, $override);

			while ($count <= $max and 
				$next = $this->_driver->queueDequeue($this->_user, true))
			{
				$this->_log('Dequeued: ( ' . $next['qb_action'] . ', ' . $next['ident'] . ' ) ', null, QUICKBOOKS_LOG_DEBUG);
				
				$this->_driver->queueStatus($ticket, $next['quickbooks_queue_id'], QUICKBOOKS_STATUS_PROCESSING);

				$extra = '';
				if ($next['extra'])
				{
					$extra = unserialize($next['extra']);
				}
				
				$err = '';
				
				$requestID = $next['quickbooks_queue_id'];
				
				$last_action_time = null;
				$last_actionident_time = null;

				$xml_or_version = QuickBooks_Gateway_OnlineEdition::QBXML_VERSION;
				$qb_identifier_or_locale = QUICKBOOKS_LOCALE_UNITED_STATES;
				$callback_config = array();
				$qbxml = null;
				
				// Call the mapped function that should generate an appropriate qbXML request
				$xml = QuickBooks_Callbacks::callRequestHandler($this->_driver, $this->_map, 
					$requestID, $next['qb_action'], $this->_user, $next['qb_action'], $next['ident'], $extra, $err, $last_action_time, $last_actionident_time, $xml_or_version, $qb_identifier_or_locale, $callback_config, $qbxml);
				
				if (!$err)
				{
					$retr = $this->qbxml($xml);

					$qboe_code = QuickBooks_XML::extractTagAttribute('statusCode', $retr, 1);
					$qboe_message = QuickBooks_XML::extractTagAttribute('statusMessage', $retr, 0);	// 0th instance, because QBMS doesn't return a statusMessage for the first sucessful request
					$qboe_severity = QuickBooks_XML::extractTagAttribute('statusSeverity', $retr, 1);

					$this->_log('QBOE Response: ' . $qboe_severity . '/' . $qboe_code . ': ' . $qboe_message, QUICKBOOKS_LOG_DEBUG);

					$is_error = false;
					$is_continue = true;
		
					//if ($qbms_code != QuickBooks_MerchantService::ERROR_OK)
					//if (!$qboe_severity or $qboe_severity == QuickBooks_Gateway_OnlineEdition::SEVERITY_ERROR)
					if ($qboe_code != QuickBooks_Gateway_OnlineEdition::ERROR_OK)
					{
						$this->_driver->queueStatus($ticket, $requestID, QUICKBOOKS_STATUS_ERROR, $qboe_code . ': ' . $qboe_message);

						$is_error = true;

						$errerr = null;
						$is_continue = QuickBooks_Callbacks::callErrorHandler(
							$this->_driver, 
							$this->_errmap, 
							$qboe_code, 
							$qboe_message, 
							$this->_user, 
							$requestID, 
							$next['qb_action'], 
							$next['ident'], 
							$extra, 
							$errerr, 
							$xml, 
							array());		// callback config

						if ($is_continue)
						{
							$this->_driver->queueStatus($ticket, $requestID, QUICKBOOKS_STATUS_HANDLED, $qboe_code . ': ' . $qboe_message);
						}
					}
					else if ($qboe_severity == QuickBooks_Gateway_OnlineEdition::SEVERITY_WARN)
					{
						; // No big deal, just a warning
					}
					else if ($qboe_severity == QuickBooks_Gateway_OnlineEdition::SEVERITY_INFO)
					{
						; // Do nothing...
					}

					//if ($qboe_code == QuickBooks_Gateway_OnlineEdition::ERROR_OK or $qboe_severity == QuickBooks_Gateway_OnlineEdition::SEVERITY_WARN or $qboe_severity == QuickBooks_Gateway_OnlineEdition::SEVERITY_INFO)
					if ($is_continue and !$is_error)
					{
						if ($qboe_code == QuickBooks_Gateway_OnlineEdition::ERROR_OK or $qboe_severity == QuickBooks_Gateway_OnlineEdition::SEVERITY_WARN or $qboe_severity == QuickBooks_Gateway_OnlineEdition::SEVERITY_INFO)
						{
							$this->_driver->queueStatus($ticket, $requestID, QUICKBOOKS_STATUS_SUCCESS);
						}
					
						$idents = $this->_extractIdentifiers($retr);

						QuickBooks_Callbacks::callResponseHandler($this->_driver, $this->_map, 
							$requestID, $next['qb_action'], $this->_user, $next['qb_action'], $next['ident'], $extra, $err, $last_action_time, $last_actionident_time, $retr, $idents, $callback_config, $qbxml);
					}
					else if (!$is_continue)
					{
						break;		// break out of the loop and stop processing 
					}

					$count++;
				}
				else
				{
					$this->_driver->queueStatus($ticket, $next['quickbooks_queue_id'], QUICKBOOKS_STATUS_ERROR, 'Callback error [' . $err . ']');
				}
			}

			// Call any hooks now that we've completed processing the queue
			$hookerr = null;
			$hookdata = array(
				'user' => $this->_user, 
				'percentage' => 100, 
				'items_left' => 0, 
				'items_processed' => $count, 
				);
			$this->_callHook(QuickBooks_Gateway_OnlineEdition::HOOK_FINISHED, null, null, $hookerr, $hookdata);

			return $count;
		}

		return false;
	}

	protected function _callHook($hook, $action, $ident, &$err, $hook_data)
	{
		// Call the hook 
		$ticket = null;
		$requestID = null;

		$ret = QuickBooks_Callbacks::callHook($this->_driver, $this->_hooks, $hook, $requestID, $this->_user, $ticket, $err, $hook_data);
		
		return true;
	}	

	/**
	 * Extract a unique record identifier from an XML response
	 * 
	 * Some (most?) records within QuickBooks have unique identifiers which are 
	 * returned with the qbXML responses. This method will try to extract all  
	 * identifiers it can find from a qbXML response and return them in an 
	 * associative array. 
	 * 
	 * For example, Customers have unique ListIDs, Invoices have unique TxnIDs, 
	 * etc. For an AddCustomer request, you'll get an array that looks like 
	 * this:
	 * <code>
	 * array(
	 * 	'ListID' => '2C0000-1039887390'
	 * )
	 * </code>
	 * 
	 * Other transactions might have more than one identifier. For instance, a 
	 * call to AddInvoice returns both a ListID and a TxnID:
	 * <code>
	 * array(
	 * 	'ListID' => '200000-1036881887', // This is actually part of the 'CustomerRef' entity in the Invoice XML response 
	 * 	'TxnID' => '11C26-1196256987', // This is the actual transaction ID for the Invoice XML response
	 * )
	 * </code>
	 * 
	 * *** IMPORTANT *** If there are duplicate fields (i.e.: 3 different 
	 * ListIDs returned) then only the first value encountered will appear in 
	 * the associative array.  
	 * 
	 * The following elements/attributes are supported:
	 * 	- ListID
	 * 	- TxnID
	 * 	- iteratorID
	 * 	- OwnerID
	 * 	- TxnLineID
	 * 
	 * @param string $xml	The XML stream to look for an identifier in
	 * @return array		An associative array mapping identifier fields to identifier values
	 */
	protected function _extractIdentifiers($xml)
	{
		$fetch_tagdata = array(
			'ListID', 
			'TxnID', 
			'OwnerID', 
			'TxnLineID', 
			'EditSequence',
			'FullName', 
			'Name', 
			'RefNumber', 
			);
		
		$fetch_attributes = array(
			'requestID',			
			'iteratorID',
			'iteratorRemainingCount',
			'metaData', 
			'retCount', 
			'statusCode', 
			'statusSeverity', 
			'statusMessage', 
			'newMessageSetID', 
			'messageSetStatusCode', 
			);
		
		$list = array();
		
		foreach ($fetch_tagdata as $tag)
		{
			if (false !== ($start = strpos($xml, '<' . $tag . '>')) and 
				false !== ($end = strpos($xml, '</' . $tag . '>')))
			{
				$list[$tag] = substr($xml, $start + 2 + strlen($tag), $end - $start - 2 - strlen($tag));
			}
		}
		
		foreach ($fetch_attributes as $attribute)
		{
			if (false !== ($start = strpos($xml, ' ' . $attribute . '="')) and 
				false !== ($end = strpos($xml, '"', $start + strlen($attribute) + 3)))
			{
				$list[$attribute] = substr($xml, $start + strlen($attribute) + 3, $end - $start - strlen($attribute) - 3);
			}
		}
		
		return $list;
	}
	
	/**
	 * Extract the status code from an XML response
	 * 
	 * Each qbXML response should return a status code and a status message 
	 * indicating whether or not an error occured. 
	 * 
	 * @param string $xml	The XML stream to look for a response status code in
	 * @return integer		The response status code (0 if OK, another positive integer if an error occured)
	 */
	protected function _extractStatusCode($xml)
	{
		if (false !== ($start = strpos($xml, ' statusCode="')) and 
			false !== ($end = strpos($xml, '"', $start + 13)))
		{
			return substr($xml, $start + 13, $end - $start - 13);
		}
		
		return QUICKBOOKS_ERROR_OK;
	}
	
	/**
	 * Extract the status message from an XML response
	 * 
	 * Each qbXML response should return a status code and a status message 
	 * indicating whether or not an error occured. 
	 * 
	 * @param string $xml	The XML stream to look for a response status message in
	 * @return string		The response status message
	 */
	protected function _extractStatusMessage($xml)
	{
		if (false !== ($start = strpos($xml, ' statusMessage="')) and 
			false !== ($end = strpos($xml, '"', $start + 16)))
		{
			return substr($xml, $start + 16, $end - $start - 16);
		}
		
		return '';
	}	

	/**
	 * Get the HTTP/HTTPS gateway to use 
	 * 
	 * @return string
	 */	
	protected function _gateway()
	{
		if ($this->_test)
		{
			return QuickBooks_Gateway_OnlineEdition::GATEWAY_TEST;
		}
		
		return QuickBooks_Gateway_OnlineEdition::GATEWAY_LIVE;
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
			// Mask credit card numbers, session tickets, and connection tickets
			$message = QuickBooks_Utilities::mask($message);
		}
		
		if ($this->_debug)
		{
			print($message . QUICKBOOKS_CRLF);
		}
		
		if ($this->_driver)
		{
			$this->_driver->log($message, null, $level);
		}
		
		return true;
	}

	/**
	 * 
	 * 
	 * @param string $xml
	 * @param string $version
	 * @param string $onerror
	 * @return string
	 */
	protected function _makeValidQBXML($xml, $version = '{$version}', $onerror = '{$onerror}')
	{
		$pre = '';
		$pre .= '<?xml version="1.0" ?>' . QUICKBOOKS_CRLF;
		$pre .= '<?qbxml version="6.0"?>' . QUICKBOOKS_CRLF;
		$pre .= '<QBXML>' . QUICKBOOKS_CRLF; 
		$pre .= '	<SignonMsgsRq>' . QUICKBOOKS_CRLF;
		$pre .= '		<SignonTicketRq>' . QUICKBOOKS_CRLF;
		$pre .= '			<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime>' . QUICKBOOKS_CRLF;
		$pre .= '			<SessionTicket>' . $this->_ticket_session . '</SessionTicket>' . QUICKBOOKS_CRLF;
		$pre .= '			<Language>English</Language>' . QUICKBOOKS_CRLF;
		$pre .= '			<AppID>' . $this->_application_id . '</AppID>' . QUICKBOOKS_CRLF;
		$pre .= '			<AppVer>1</AppVer>' . QUICKBOOKS_CRLF;
		$pre .= '		</SignonTicketRq>' . QUICKBOOKS_CRLF;
		$pre .= '	</SignonMsgsRq>' . QUICKBOOKS_CRLF;
		//$pre .= '	<QBXMLMsgsRq onError="continueOnError">';
		
		//$post = '	</QBXMLMsgsRq>' . QUICKBOOKS_CRLF;
		$post = '';
		$post .= '</QBXML>';
		
		// If the request they passed is a full request, then we don't need to prepend/append the extra XML
		if (false !== stripos($xml, '<QBXML>'))
		{
			//return $pre . $xml . $post;

			$pos1 = strpos($xml, '<QBXML>');
			$pos2 = strpos($xml, '</QBXML>');

			$xml = substr($xml, $pos1 + 7, $pos2 - $pos1 - 7);
		}
		
		return $pre . $xml . $post;
	}	

	/**
	 * Get (or set) the session ticket 
	 * 
	 * @param string $sticket		The new session ticket to set (or null if you only want to get it)
	 * @return string				The session ticket currently in use
	 */
	protected function _sessionTicket($sticket)
	{
		$this->_setError(QuickBooks_Gateway_OnlineEdition::ERROR_OK);
		
		// Make sure we have a session ticket so we can actually return it... 
		if (!$this->_isSignedOn())
		{
			$this->_signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}
		
		return $this->_ticket_session;
	}	

	/**
	 * 
	 * 
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return void
	 */
	protected function _setError($errnum, $errmsg = '')
	{
		$this->_errnum = $errnum;
		$this->_errmsg = $errmsg;
	}	
	
	/**
	 * 
	 * 
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return void
	 */
	protected function _setLastResponse($response)
	{
		$this->_last_response = $response;
	}	
	
	/**
	 * 
	 * 
	 * @param integer $errnum
	 * @param string $errmsg
	 * @return void
	 */
	protected function _setLastRequest($request)
	{
		$this->_last_request = $request;
	}	

	/**
	 * 
	 */
	public function connect()
	{
		return $this->_signOn();
	}

	/**
	 * 
	 *
	 * @return boolean
	 */
	protected function _signOn()
	{
		$this->_setError(QuickBooks_Gateway_OnlineEdition::ERROR_OK);
		
		$xml = '';
		$xml .= '<?xml version="1.0" ?>' . QUICKBOOKS_CRLF;
		$xml .= '<?qbxml version="6.0"?> ' . QUICKBOOKS_CRLF;
		$xml .= '<QBXML>' . QUICKBOOKS_CRLF;
		$xml .= '	<SignonMsgsRq>' . QUICKBOOKS_CRLF;
		
		if ($this->_certificate)
		{
			$this->_log('Signing on as a HOSTED QBOE application.', QUICKBOOKS_LOG_DEBUG);
			
			$xml .= '		<SignonAppCertRq>' . QUICKBOOKS_CRLF;
			$xml .= '			<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ApplicationLogin>' . $this->_application_login . '</ApplicationLogin> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ConnectionTicket>' . $this->_ticket_connection . '</ConnectionTicket> ' . QUICKBOOKS_CRLF;
			$xml .= '			<Language>English</Language> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppID>' . $this->_application_id . '</AppID> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppVer>1</AppVer> ' . QUICKBOOKS_CRLF;
			$xml .= '		</SignonAppCertRq> ' . QUICKBOOKS_CRLF;
		}
		else
		{
			$this->_log('Signing on as a DESKTOP QBOE application.', QUICKBOOKS_LOG_DEBUG);
			
			$xml .= '		<SignonDesktopRq>' . QUICKBOOKS_CRLF;
			$xml .= '			<ClientDateTime>' . date('Y-m-d') . 'T' . date('h:i:s') . '</ClientDateTime> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ApplicationLogin>' . $this->_application_login . '</ApplicationLogin> ' . QUICKBOOKS_CRLF;
			$xml .= '			<ConnectionTicket>' . $this->_ticket_connection . '</ConnectionTicket> ' . QUICKBOOKS_CRLF;
			$xml .= '			<Language>English</Language> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppID>' . $this->_application_id . '</AppID> ' . QUICKBOOKS_CRLF;
			$xml .= '			<AppVer>1</AppVer> ' . QUICKBOOKS_CRLF;
			$xml .= '		</SignonDesktopRq> ' . QUICKBOOKS_CRLF;			
		}
		
		$xml .= '	</SignonMsgsRq> ' . QUICKBOOKS_CRLF;
		$xml .= '</QBXML>';
		
		$errnum = QuickBooks_Gateway_OnlineEdition::ERROR_OK;
		$errmsg = '';
		
		$response = $this->_request($xml, $errnum, $errmsg);
		
		if ($errnum)
		{
			$this->_setError(QuickBooks_Gateway_OnlineEdition::ERROR_SOCKET, $errnum . ': ' . $errmsg);
			return false;
		}
		
		$code = QuickBooks_XML::extractTagAttribute('statusCode', $response);
		$message = QuickBooks_XML::extractTagAttribute('statusMessage', $response);
		
		if ($code != QuickBooks_Gateway_OnlineEdition::ERROR_OK)
		{
			$this->_setError($code, $message);
			return false;
		}
		
		if ($ticket = QuickBooks_XML::extractTagContents('SessionTicket', $response))
		{
			$this->_ticket_session = $ticket;
			
			return true;
		}
		
		$this->_setError(QuickBooks_Gateway_OnlineEdition::ERROR_INTERNAL, 'Could not locate SessionTicket in response.');
		
		return false;
	}	

	/**
	 * 
	 * 
	 * 
	 * 
	 */
	protected function _isSignedOn()
	{
		return strlen($this->_ticket_session) > 0;
	}	

	/**
	 *  
	 * 
	 */
	public function useTestEnvironment($yes_or_no)
	{
		$this->_test = (boolean) $yes_or_no;
	}
	
	/**
	 * 
	 * 
	 */
	public function useLiveEnvironment($yes_or_no)
	{
		$this->_test = ! (boolean) $yes_or_no;
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
	 * Issue a qbXML request to the API, and retrieve the qbXML response 
	 * 
	 * @param string $qbxml			A valid qbXML request
	 * @param mixed $callbacks		A valid callback value (function name, object and method, or class name and method) or an array of callbacks
	 * @param mixed $webapp_ID		Your web application's primary ID value for this record (if applicable)
	 * @param integer $priority		The priority of this request (if using a queued model of communication)
	 * @return boolean				
	 */
	public function qbxml($qbxml)
	{
		$method = null;
		$action = null;
		$type = null;
		
		$err = '';
		$tmp = $this->_handleQBXML($method, $action, $type, $qbxml, $err);
		
		return $tmp;
	}
	

	/**
	 * 
	 * 
	 * @param string $method
	 * @param string $action
	 * @param string $type
	 * @param string $qbxml
	 * @param array $callbacks
	 * @param mixed $uniqueid
	 * @param integer $priority
	 * @param string $err
	 * @param integer $recur
	 * @return boolean
	 */
	protected function _handleQBXML($method, $action, $type, $qbxml, &$err, $recur = null)
	{
		$this->_setError(QuickBooks_Gateway_OnlineEdition::ERROR_OK);
		
		// Make sure we have a session ticket 
		if (!$this->_isSignedOn())
		{
			$this->_signOn();
			
			if ($this->errorNumber())
			{
				return false;
			}
		}

		//$this->_log('Outgoing XML request: ' . $qbxml, null, QUICKBOOKS_LOG_DEBUG);

		// The qbXML requests that get passed to this function are without the 
		//	typical qbXML wrapper info, so we need to modify them to make them 
		// 	into complete, valid requests. 
		$qbxml = $this->_makeValidQBXML($qbxml, '6.0', 'continueOnError');

		// Send the request to QuickBooks Online Edition
		$response = $this->_request($qbxml);

		// Extract any error codes 
		$code = QuickBooks_XML::extractTagAttribute('statusCode', $response, 1);
		$message = QuickBooks_XML::extractTagAttribute('statusMessage', $response);

		if ($code != QuickBooks_Gateway_OnlineEdition::ERROR_OK)
		{
			$this->_setError($code, $message);
			return false;
		}

		//die($code . ': ' . $message);
		
		return $response;
	}
	
	/**
	 * Send an XML request to QuickBooks Online Edition
	 * 
	 * This function will auto-detect if CURL is enabled, and if so, use CURL. 
	 * Otherwise, it will fall back to using fsockopen(). 
	 * 
	 * @param string $qbxml
	 * @return string
	 */
	protected function _request($qbxml)
	{
		if (function_exists('curl_init'))
		{
			return $this->_requestCurl($qbxml);
		}
		

		return false;
	}
	
	/**
	 * Send a request to QuickBooks Online Edition using the CURL PHP module
	 * 
	 * @param string $xml
	 * @return string
	 */
	protected function _requestCurl($xml)
	{
		$ch = curl_init(); 
	
		$header[] = 'Content-Type: application/x-qbxml'; 
		$header[] = 'Content-Length: ' . strlen($xml); 
		
		//$this->_certificate = '/Users/kpalmer/Projects/QuickBooks/QuickBooks/dev/test_qboe.pem';
		
		$params = array();
		$params[CURLOPT_HTTPHEADER] = $header; 
		$params[CURLOPT_POST] = true; 
		$params[CURLOPT_RETURNTRANSFER] = true; 
		$params[CURLOPT_URL] = $this->_gateway(); 
		$params[CURLOPT_TIMEOUT] = 30; 
		$params[CURLOPT_POSTFIELDS] = $xml; 
		$params[CURLOPT_VERBOSE] = $this->_debug; 
		$params[CURLOPT_HEADER] = true;
		
		if (file_exists($this->_certificate))
		{
			$params[CURLOPT_SSLCERT] = $this->_certificate; 
		}
		
		// Some Windows servers will fail with SSL errors unless we turn this off
		$params[CURLOPT_SSL_VERIFYPEER] = false;
		$params[CURLOPT_SSL_VERIFYHOST] = 0;		
		
		// Diagnostic information: https://merchantaccount.quickbooks.com/j/diag/http
		// curl_setopt($ch, CURLOPT_INTERFACE, '<myipaddress>');
		
		$ch = curl_init();
		curl_setopt_array($ch, $params);
		$response = curl_exec($ch);
		
		//$this->_log('CURL options: ' . print_r($params, true), QUICKBOOKS_LOG_DEBUG);
		
		// @todo Strip credit card numbers from logged XML... (or should this be within the _log() method?)
		
		$this->_setLastRequest($xml);
		$this->_log('Outgoing QBOE request: ' . $xml, QUICKBOOKS_LOG_DEBUG);	// Set as DEBUG so that no one accidentally logs all the credit card numbers...
		
		$this->_setLastResponse($response);
		$this->_log('Incoming QBOE response: ' . $response, QUICKBOOKS_LOG_VERBOSE);
		
		if (curl_errno($ch)) 
		{
			$errnum = curl_errno($ch);
			$errmsg = curl_error($ch);
			
			$this->_log('CURL error: ' . $errnum . ': ' . $errmsg, QUICKBOOKS_LOG_NORMAL);
			
			return false;
		} 
		
		// Close the connection 
		@curl_close($ch);
		
		// Remove the HTTP headers from the response
		$pos = strpos($response, "\r\n\r\n");
		$response = ltrim(substr($response, $pos));
		
		return $response;		
	}	
}