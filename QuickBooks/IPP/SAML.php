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


class QuickBooks_IPP_SAML
{
	protected $_target_url;
	
	protected $_ticket;
	
	protected $_auth_id;
	
	function __construct($__samlXml, $__privateKey)
	{
                
                # Iniitialize the private key in openssl
                $privateKey=openssl_get_privatekey($__privateKey);
                $publicKey = openssl_get_publickey($__publicKey);

                # Parse the decoded SAML, and the important values out
                $xml = simplexml_load_string($__samlXml);
                                
                $xml->registerXPathNamespace("samlp", "urn:oasis:names:tc:SAML:2.0:protocol");
                $xml->registerXPathNamespace("saml", "urn:oasis:names:tc:SAML:2.0:assertion");
                $xml->registerXPathNamespace("xenc", "http://www.w3.org/2001/04/xmlenc#");
                $xml->registerXPathNamespace("ds", "http://www.w3.org/2000/09/xmldsig#");

                # Get the signatureValue
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
        
}

                