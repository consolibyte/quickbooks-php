<?php

/**
 * QuickBooks encryption library base class
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 *  
 * @package QuickBooks
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/Encryption/Factory.php');

/**
 * 
 * 
 */
abstract class QuickBooks_Encryption
{
    const CIPHER = 'aes-256-cfb';

	/**
	 * 
	 * 
	 * 
	 */
	public function prefix($str)
	{
		return '{' . strlen(get_class($this)) . ':' . strtolower(get_class($this)) . '}' . $str;
	}
	
	/**
	 * AES encryption
	 *
	 * @param string $key
	 * @param string $data		Content to be encrypted
	 * @param bool $hex 	
	 * @return string
	 */
	static function salt()
	{
		return self::iv();
	}

    /**
     * Create an initialization vector to be used with our encryption algorithm
     *
     * @return string
     */

    static function iv()
    {
        $ivlen = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivlen);

        return $iv;
    }
}

