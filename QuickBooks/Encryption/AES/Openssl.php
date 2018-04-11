<?php

/**
 * AES Encryption (depends on openssl)
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
 * @brief OpenSSL implementation for AES encryption
 *
 * @author Evgeniy Bogdanov <e.bogdanov@biz-systems.ru>
 */
class QuickBooks_Encryption_AES_Openssl extends QuickBooks_Encryption
{
    const CIPHER = 'aes-256-ecb';

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
        $cipher    = self::CIPHER;

        $key       = hex2bin(md5($key));

        $ivlen     = openssl_cipher_iv_length($cipher);
        $iv        = openssl_random_pseudo_bytes($ivlen);

        $encrypted = openssl_encrypt($plain, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $return    = base64_encode($iv . $encrypted);

        return $return;
    }

    /**
     * Decrypt key with specified key
     *
     * @param string $key       Decryption key
     * @param string $encrypted Text to be decrypted
     * @param bool $with_salt   Indicates if we operate with text with salt. If yes - encryption code added some salt, we handle this case
     *
     * @see QuickBooks/Encryption/Aes.php
     *
     * @return string
     */
    static function decrypt($key, $encrypted, $with_salt = true)
    {
        $cipher = self::CIPHER;

        $key = hex2bin(md5($key));

        $decrypted = base64_decode($encrypted);
        $ivlen     = openssl_cipher_iv_length($cipher);
        $iv        = substr($decrypted, 0, $ivlen);

        $decrypted = substr($decrypted, $ivlen);
        $decrypted = openssl_decrypt($decrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);

        if ($with_salt)
        {
            $tmp       = @unserialize($decrypted);
            $decrypted = current($tmp);
        }

        return $decrypted;
    }
}
