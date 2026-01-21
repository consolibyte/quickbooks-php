<?php

/** 
 * AES Encryption
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@ConsoliBYTE.com>
 * 
 * @package QuickBooks
 */

// 
QuickBooks_Loader::load('/QuickBooks/Encryption.php');

/**
 * 
 */
class QuickBooks_Encryption_Aes extends QuickBooks_Encryption
{
    /**
     * Encrypt a plaintext string using openssl and the algorithm in self::CIPHER
     *
     * @param	string	$key	The passphrase for the encryption algorithm
     * @param	string	$plain	The plaintext to be encrypted
     * @param	string	$iv		The initialization vector for the encryption algorithm
     *
     * @return false|string
     */
    static function encrypt($key, $plain, $iv = null)
	{
		if (is_null($iv))
		{
			$iv = QuickBooks_Encryption::iv();
		}

        // Encrypt the plaintext
        $encrypted = openssl_encrypt($plain, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);
        // Create a hmac hash to compare when we're decrypting
        $encrypted_hmac = hash_hmac('sha256', $encrypted, $key, true);
        // Include the hmac and encode
        $encrypted_encoded = base64_encode($encrypted_hmac . $encrypted);
        // Prepend this string, so we know how we need to decrypt ( mcrypt(deprecated) vs. openssl )
        $final_encrypted = 'openssl:' . $encrypted_encoded;

        return $final_encrypted;
    }
	
	static function decrypt($key, $raw_encrypted, $iv = null)
	{
        if (is_null($iv))
        {
            return false;
        }

        if (strpos($raw_encrypted, 'openssl:') === 0) // decrypt using openssl
        {
            // remove the openssl tag
            $encrypted = substr($raw_encrypted, 8);
            // Decode
            $decoded_encrypted = base64_decode($encrypted);
            // Remove the hmac
            $sha2len = 32;
            $hmac = substr($decoded_encrypted, 0, $sha2len);
            $encrypted_raw = substr($decoded_encrypted, $sha2len);

            $decrypted = openssl_decrypt($encrypted_raw, self::CIPHER, $key, OPENSSL_RAW_DATA, $iv);

            $calcmac = hash_hmac('sha256', $encrypted_raw, $key, true);
            if (hash_equals($hmac, $calcmac))// timing attack safe comparison
            {
                return $decrypted;
            }
        }
        else
        {

            // This is deprecated
            $crypt = @mcrypt_module_open('rijndael-256', '', 'ofb', '');
            $iv_size = @mcrypt_enc_get_iv_size($crypt);
            $ks = @mcrypt_enc_get_key_size($crypt);
            $key = substr(md5($key), 0, $ks);

            //print('before base64 [' . $encrypted . ']' . "\n");

            $encrypted = base64_decode($raw_encrypted);

            //print('given key was: ' . $key);
            //print('iv size: ' . $iv_size);

            //print('decrypting [' . $encrypted . ']' . '<br />');

            @mcrypt_generic_init($crypt, $key, substr($encrypted, 0, $iv_size));
            $decrypted = trim(@mdecrypt_generic($crypt, substr($encrypted, $iv_size)));
            @mcrypt_generic_deinit($crypt);
            @mcrypt_module_close($crypt);

            //print('decrypted: [[**(' . $salt . ')');
            //print_r($decrypted);
            //print('**]]');

            $tmp = unserialize($decrypted);
            $decrypted = current($tmp);

            return $decrypted;
        }

        return false;
	}
}
