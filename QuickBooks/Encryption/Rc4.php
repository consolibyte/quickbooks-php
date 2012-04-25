<?php

/** 
 * 
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 */

// 
QuickBooks_Loader::load('/QuickBooks/Encryption.php');

/**
 * 
 */
class QuickBooks_Encryption_Rc4 extends QuickBooks_Encryption
{
	/**
	 * RC4 encrypt
	 *
	 * @param string $key
	 * @param string $data		Content to be encrypted
	 * @param bool $hex 	
	 * @return string
	 */
	public function encrypt($key, $data, $hex = false)
	{
		if ($hex)
		{
			$key = pack('H*', $key); 
		}
		
		$keys[] = '';
		$boxs[] = '';
		$cipher = '';

		$key_length = strlen($key);
		$data_length = strlen($data);

		for ($i = 0; $i < 256; $i++)
		{
			$keys[$i] = ord($key[$i % $key_length]);
			$boxs[$i] = $i;
		}
		
		$j = 0;
		for ($i = 0; $i < 256; $i++)
		{
			$j = ($j + $boxs[$i] + $keys[$i]) % 256;
			$tmp = $boxs[$i];
			$boxs[$i] = $boxs[$j];
			$boxs[$j] = $tmp;
		}
		
		$a = 0; 
		$j = 0;
		for ($i = 0; $i < $data_length; $i++)
		{
			$a = ($a + 1) % 256;
			$j = ($j + $boxs[$a]) % 256;
			$tmp = $boxs[$a];
			$boxs[$a] = $boxs[$j];
			$boxs[$j] = $tmp;
			$k = $boxs[(($boxs[$a] + $boxs[$j]) % 256)];
			$cipher .= chr(ord($data[$i]) ^ $k);
		}
		
		return $cipher;
	}
	
	public function decrypt($key, $data, $hex = false)
	{
		return $this->encrypt($key, $data, $hex);
	}
}