<?php

/**
 * AES Encryption (selects mcrypt or openssl, if PHP > 7.1)
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

QuickBooks_Loader::load('/QuickBooks/Encryption.php');
QuickBooks_Loader::load('/QuickBooks/Encryption/AES/Mcrypt.php');
QuickBooks_Loader::load('/QuickBooks/Encryption/AES/Openssl.php');

/**
 * @brief Class is layer to AES encryption. Selects best implementation (Mcrypt or OpenSSL), considering backward compatibility
 *
 * @author Evgeniy Bogdanov <e.bogdanov@biz-systems.ru>
 */
final class QuickBooks_Encryption_Aes
{
    /**
     * Encrypts text with specified key
     *
     * @param string $key   Encryption key
     * @param string $plain Plain text to be encrypted
     * @param string $salt  Salt to ba added in encrypted text
     *
     * @return string
     */
    static function encrypt($key, $plain, $salt = null)
    {
        if (is_null($salt))
        {
            $salt = QuickBooks_Encryption::salt();
        }

        $plain = serialize(array( $plain, $salt ));

        return (self::useMCrypt())
            ? QuickBooks_Encryption_AES_Mcrypt::encrypt($key, $plain)
            : QuickBooks_Encryption_AES_Openssl::encrypt($key, $plain);
    }

    /**
     * Decrypt key with specified key
     *
     * @param string $key       Decryption key
     * @param string $encrypted Text to be decrypted
     * @param bool $with_salt   Indicates if we operate with text pre-including salt. In most use cases this is true.
     *
     * @return string
     */
    static function decrypt($key, $encrypted, $with_salt = true)
    {
        return (self::useMCrypt())
            ? QuickBooks_Encryption_AES_Mcrypt::decrypt($key, $encrypted, $with_salt)
            : QuickBooks_Encryption_AES_Openssl::decrypt($key, $encrypted, $with_salt);
    }

    /**
     * Decide if we need o use Mcrypt-way or no
     *
     * @return bool
     */
    static private function useMCrypt()
    {
        return (
            version_compare(PHP_VERSION, '7.1.0', '<')
            && extension_loaded('mcrypt')
        );
    }
}