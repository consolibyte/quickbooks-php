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

/**
 * 
 * @author kpalmer
 *
 */
class QuickBooks_IPP_Federator
{
	const TYPE_SAML;
	
	public function __construct($type, $private_key, $dsn = null, $callback = null, $SAML = null)
	{
		if (is_null($SAML))
		{
			$SAML = base64_decode($_POST['SAMLResponse']);
		}
		
		$fp = fopen($private_key, 'r');
		$private_key_data = fread($fp, 8192);
		fclose($fp);
		
		// 
		$private_key = openssl_get_privatekey($private_key_data);
		//$public_key = openssl_get_publickey($__publicKey);
		
		// Parse the decoded SAML XML string
		$xml = simplexml_load_string($SAML);
				
		$xml->registerXPathNamespace("samlp", "urn:oasis:names:tc:SAML:2.0:protocol");
		$xml->registerXPathNamespace("saml", "urn:oasis:names:tc:SAML:2.0:assertion");
		$xml->registerXPathNamespace("xenc", "http://www.w3.org/2001/04/xmlenc#");
		$xml->registerXPathNamespace("ds", "http://www.w3.org/2000/09/xmldsig#");

		// Get the signatureValue
		$node = $xml->xpath('/samlp:Response/saml:Assertion/ds:Signature/ds:SignatureValue');
		$signatureValue = $node[0];
		
		# Get the signed node
		$signInfo = $xml->xpath('/samlp:Response/saml:Assertion/ds:Signature/ds:SignedInfo');
		
		# Get the encrypted key
		$node = $xml->xpath('/samlp:Response/saml:Assertion/saml:AttributeStatement/saml:EncryptedAttribute/xenc:EncryptedData/ds:KeyInfo/xenc:EncryptedKey/xenc:CipherData/xenc:CipherValue');
		$encryptedKey = $node[0];
		
		# Get the encrypted ticket
		$node = $xml->xpath('/samlp:Response/saml:Assertion/saml:AttributeStatement/saml:EncryptedAttribute/xenc:EncryptedData/xenc:CipherData/xenc:CipherValue');
		$encryptedTicket = $node[0];
		
		# Get the authId
		$node = $xml->xpath('/samlp:Response/saml:Assertion/saml:Subject/saml:NameID');
		$this->authId = $node[0];
		
		# Get the targetUrl
		$node = $xml->xpath('/samlp:Response/saml:Assertion/saml:AttributeStatement/saml:Attribute[@Name="targetUrl"]/saml:AttributeValue');
		$this->targetUrl = $node[0];
				
		# Decode the encrypted key and encrypted ticket
		$base64DecodedKey = base64_decode($encryptedKey);
		$base64DecodedTicket = base64_decode($encryptedTicket);
		
		# Decrypt the key, and store as $decryptedKey
		$result = openssl_private_decrypt($base64DecodedKey,$decryptedKey,$privateKey);
		
		# Get the appropriate iv size for this encryption algorithm - rijndael128 is the same as AES
		$ivSize = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		
		# The iv is the first $ivSize (16) bytes...
		$cipherText = $base64DecodedTicket;
		$iv = substr($cipherText,0,$ivSize);
		# ...and the cipherText is the latter part
		$cipherText = substr($cipherText,$ivSize);
		
		# Decrypt the ticket and store as $decryptedTicket
		$decryptedTicket = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $decryptedKey, $cipherText, MCRYPT_MODE_CBC, $iv); 
		
		# The last byte tells us how much padding there is on the decryptedTicket - then remove those bytes
		$lastByte = substr($decryptedTicket,-1,1);
		$padding = -ord($lastByte);
		$decryptedTicket = substr($decryptedTicket,0,$padding);

		
		# Parse the $decryptedTicket as XML, and get the actual ticket (finally)
		$xml = simplexml_load_string($decryptedTicket);
		$node = $xml->children("urn:oasis:names:tc:SAML:2.0:assertion");
		$this->ticket = $node->AttributeValue;
	}					   
	
	/**
	 * 
	 *
	 */
	static public function setCookie($value, $expire = 0, $path = null, $domain = null, $secure = false, $httponly = false)
	{
		setcookie(QuickBooks_IPP::COOKIE, $value, $expire, $path, $domain, $secure, $httponly);
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
