<?php

		# Usage:
		# # Grab the SAML Response from the post and decode it
		# $response = $_POST["SAMLResponse"];
		# $base64DecodedSaml = base64_decode($response);
		# # Select and open the private key from the filesystem
		# $keyFile = 'ipp.key';
		# $fp=fopen($keyFile,"r");
		# $privKey=fread($fp,8192);
		# # Construct IppAuth and get values back
		# $ipp = new ippAuth($base64DecodedSaml,$privKey);
		# echo "<br />targetUrl: ".$ipp->targetUrl;
		# echo "<br />ticket: ".$ipp->ticket;
		# echo "<br />authId: ".$ipp->authId;

/*

function federator_callback($ticket, $target_url, $auth_id)
{
	
	
	return TRUE;		// return TRUE to let the Federator instance redirect to $target_url
	return FALSE;		// return FALSE to handle whatever happens next yourself
}


if you don't provide a callback function, a default callback will be used 
which stores the data in the database defined by $dsn, and then forwards 
the user on to the target URL.

*/

// 
QuickBooks_Loader::load('/QuickBooks/XML/Parser.php');

// 
QuickBooks_Loader::load('/QuickBooks/Callbacks.php');

/**
 * 
 * @author kpalmer
 *
 */
class QuickBooks_IPP_Federator
{
	const TYPE_SAML = 'saml';
	
	const TYPE_OAUTH = 'oauth';
	
	const ERROR_OK = QUICKBOOKS_ERROR_OK;
	
	const ERROR_KEY = 1;
	
	const ERROR_XML = 2;
	
	const ERROR_SAML = 3;
	
	protected $_type;
	
	protected $_key;
	
	protected $_callback;
	
	protected $_driver;
	
	protected $_debug;
	
	protected $_errnum;
	
	protected $_errmsg;
	
	protected $_last_request;
	
	protected $_last_response;
	
	protected function _log($msg)
	{
		if ($this->_debug)
		{
			print(date('Y-m-d H:i:s') . ': ' . $msg . QUICKBOOKS_CRLF);
		}
		
		if ($this->_driver)
		{
			
		}
	}
	
	public function useDebugMode($true_or_false)
	{
		$this->_debug = (boolean) $true_or_false;
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
	protected function _setError($errnum, $errmsg = '')
	{
		$this->_errnum = $errnum;
		$this->_errmsg = $errmsg;
	}
	
	public function __construct($type, $private_key, $dsn = null, $callback = null)
	{
		$this->_type = $type;
		$this->_key = $private_key;
		$this->_callback = $callback;
	}					   
	
	public function handle($input = null)
	{
		// We only support SAML for now
		return $this->_handleSAML($input);
	}
	
	protected function _handleSAML($SAML = null)
	{
		$this->_log('Starting up (initialized with ' . strlen($SAML) . ' bytes)');
		
		if (!$SAML)
		{
			if (!empty($_POST['SAMLResponse']))
			{
				$SAML = base64_decode($_POST['SAMLResponse']);
			}
			else
			{
				return false;
			}
		}
		
		if (false === strpos($SAML, '<'))
		{
			$SAML = base64_decode($SAML);
		}
		
		$this->_log('Incoming SAML request: ' . substr($SAML, 0, 64) . '...');
		
		//print("\n\n" . $SAML . "\n\n");
		
		$fp = fopen($this->_key, 'r');
		$private_key_data = fread($fp, 8192);
		fclose($fp);
		
		// 
		$private_key = openssl_get_privatekey($private_key_data);
		//$public_key = openssl_get_publickey($__publicKey);
		
		$Parser = new QuickBooks_XML_Parser($SAML);
		if ($Doc = $Parser->parse($errnum, $errmsg))
		{
			$Root = $Doc->getRoot();
			
			$auth_id = $Root->getChildDataAt('samlp:Response saml:Assertion saml:Subject saml:NameID');
			$this->_log('Auth ID: [' . $auth_id . ']');
			
			if (!$auth_id)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract Auth ID from SAML response.');
				return false;
			}
			
			$encrypted_key = $Root->getChildDataAt('samlp:Response saml:Assertion saml:AttributeStatement saml:EncryptedAttribute xenc:EncryptedData ds:KeyInfo xenc:EncryptedKey xenc:CipherData xenc:CipherValue');
			$this->_log('Encrypted key: [' . $encrypted_key . ']');
			
			if (!$encrypted_key)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract encrypted key from SAML response.');
				return false;
			}
			
			$encrypted_ticket = $Root->getChildDataAt('samlp:Response saml:Assertion saml:AttributeStatement saml:EncryptedAttribute xenc:EncryptedData xenc:CipherData xenc:CipherValue');
			$this->_log('Encrypted ticket: [' . $encrypted_ticket . ']');

			if (!$encrypted_ticket)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract encrypted ticket from SAML response.');
				return false;
			}
			
			$Node = $Root->getChildAt('samlp:Response saml:Assertion saml:AttributeStatement');
			
			foreach ($Node->children() as $ChildNode)
			{
				if ($ChildNode->getAttribute('Name') == 'targetUrl')
				{
					$ChildChildNode = $ChildNode->getChild(0);
					$target_url = $ChildChildNode->data();
					break;
				}
			}
			
			$this->_log('Target URL: [' . $target_url . ']');

			if (!$target_url)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract target URL from SAML response.');
				return false;
			}

			/*
			// Get the signatureValue
			$node = $xml->xpath('/samlp:Response/saml:Assertion/ds:Signature/ds:SignatureValue');
			$signatureValue = $node[0];
			
			# Get the signed node
			$signInfo = $xml->xpath('/samlp:Response/saml:Assertion/ds:Signature/ds:SignedInfo');
			*/
			
			// The key and ticket are base64 encoded, decode them
			$decoded_key = base64_decode($encrypted_key);
			$decoded_ticket = base64_decode($encrypted_ticket);
			
			// Decrypt the key
			$decrypted_key = null;
			$result = openssl_private_decrypt($decoded_key, $decrypted_key, $private_key_data);
			$this->_log('Key: [' . $decrypted_key . ']');

			if (!$decrypted_key)
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_INTERNAL, 'Could not extract decrypted key from SAML response.');
				return false;
			}
			
			// @todo Swap out for QuickBooks_Encrypt implementation 
			// Get the key size for decryption
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
			
			// $decoded_ticket is stored as: 
			//	16-byte IV  
			//		CONCAT WITH 
			// 	XX-byte actual encrypted ticket in XML format 
			
			// Get the IV
			$iv = substr($decoded_ticket, 0, $iv_size);
			
			// This is the actual encrypted ticket
			$cipher = substr($decoded_ticket, $iv_size);
			
			// @todo Swap out for QuickBooks_Encrypt implementation 
			// Decrypt the ticket
			$decrypted_ticket = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $decrypted_key, $cipher, MCRYPT_MODE_CBC, $iv); 
			
			// Remove the padding from the ticket
			$last_byte = substr($decrypted_ticket, -1, 1);
			$padding = -ord($last_byte);
			$decrypted_ticket = substr($decrypted_ticket, 0, $padding);
			
			// Parse the XML format to get at the actual ticket value
			$ticket = null;
			$errnum = null;
			$errmsg = null;
			$Parser = new QuickBooks_XML_Parser($decrypted_ticket);
			if ($Doc = $Parser->parse($errnum, $errmsg))
			{
				$Root = $Doc->getRoot();
				
				$ticket = $Root->getChildDataAt('Attribute saml:AttributeValue');
				$this->_log('Ticket: [' . $ticket . ']');
				
				return $this->_doCallback($auth_id, $ticket, $target_url);
			}
			else
			{
				$this->_setError(QuickBooks_IPP_Federator::ERROR_XML, 'XML parser error while parsing SAML ticket: ' . $errnum . ':' . $errmsg);
				return false;
			}
		}
		else
		{
			$this->_setError(QuickBooks_IPP_Federator::ERROR_XML, 'XML parser error while parsing SAML response: ' . $errnum . ': ' . $errmsg);
			return false;
		}
	}
	
	protected function _doCallback($auth_id, $ticket, $target_url)
	{
		if ($this->_callback)
		{
			
			$return = false;
		}
		else
		{
			// Just set the cookie
			QuickBooks_IPP_Federator::setCookie($ticket);
			$return = true;
		}
		
		if ($return)
		{
			$this->_doRedirect($target_url);
		}
		
		return true;
	}
	
	protected function _doRedirect($target_url)
	{
		$html = '<html><head><meta http-equiv="refresh" content="0;url=' . htmlspecialchars($target_url) . '"></head><body></body></html>';
		print($html);
		return true;
	}
	
	/**
	 * 
	 *
	 */
	static public function setCookie($value, $expire = 0, $path = null, $domain = null)
	{
		$secure = true;		// This is required per IPP security guidelines
		$httponly = true;
		
		return setcookie(QuickBooks_IPP::COOKIE, $value, $expire, $path, $domain, $secure, $httponly);
	}
	
	/**
	 * 
	 *
	 */
	static public function getCookie()
	{
		if (isset($_COOKIE[QuickBooks_IPP::COOKIE]))
		{
			return $_COOKIE[QuickBooks_IPP::COOKIE];
		}
		
		return null;
	}
}
