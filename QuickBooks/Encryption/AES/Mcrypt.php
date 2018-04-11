<?php

/** 
 * AES Encryption (depends on mcrypt for now)
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 *
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 */

//
QuickBooks_Loader::load('/QuickBooks/Encryption.php');

/**
 * @brief Mcrypt implementation of AES-256. This method is deprecated since 7.1,
 *        so it will be selected only if library running < 7.1 and there is mcrypt extension installed.
 *        Otherwise QuickBooks/Encryption/AES/Openssl.php will be selected
 */
class QuickBooks_Encryption_AES_Mcrypt extends QuickBooks_Encryption
{
    /**
     * Encrypt text with specified key
     *
     * @param string $key   Encryption key
     * @param string $plain Plain text to be encrypted
     *
     * @return string
     */
	static function encrypt($key, $plain)
	{
		$crypt = mcrypt_module_open('rijndael-256', '', 'ofb', '');

		if (false !== stripos(PHP_OS, 'win') and 
			version_compare(PHP_VERSION, '5.3.0')  == -1) 
		{
			$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($crypt), MCRYPT_RAND);	
		}
		else
		{
			$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($crypt), MCRYPT_DEV_URANDOM);
		}

		$ks = mcrypt_enc_get_key_size($crypt);
		$key = substr(md5($key), 0, $ks);
		
		mcrypt_generic_init($crypt, $key, $iv);
		$encrypted = base64_encode($iv . mcrypt_generic($crypt, $plain));
		mcrypt_generic_deinit($crypt);
		mcrypt_module_close($crypt);
		
		return $encrypted;
	}

    /**
     * Decrypt key with specified key
     *
     * @param string $key       Decryption key
     * @param string $encrypted Text to be decrypted
     * @param bool $with_salt   Indicates if we operate with text with salt. If yes - encryption code added some salt, we handle this case.
     *
     * @see QuickBooks/Encryption/Aes.php
     *
     * @return string
     */
	static function decrypt($key, $encrypted, $with_salt = true)
	{
		$crypt = mcrypt_module_open('rijndael-256', '', 'ofb', '');
		$iv_size = mcrypt_enc_get_iv_size($crypt);
		$ks = mcrypt_enc_get_key_size($crypt);
		$key = substr(md5($key), 0, $ks);
		
		//print('before base64 [' . $encrypted . ']' . '<br />');
		
		$encrypted = base64_decode($encrypted);
		
		//print('given key was: ' . $key);
		//print('iv size: ' . $iv_size);
		
		//print('decrypting [' . $encrypted . ']' . '<br />');
		
		mcrypt_generic_init($crypt, $key, substr($encrypted, 0, $iv_size));
		$decrypted = trim(mdecrypt_generic($crypt, substr($encrypted, $iv_size)));
		mcrypt_generic_deinit($crypt);
		mcrypt_module_close($crypt);
		
		//print('decrypted: [[**(' . $salt . ')');
		//print_r($decrypted);
		//print('**]]');

        if ($with_salt)
        {
            $tmp = @unserialize($decrypted);
            $decrypted = current($tmp);
        }

		return $decrypted;
	}
}
