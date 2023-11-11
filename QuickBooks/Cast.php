<?php

/** 
 * Casts to cast data types to QuickBooks qbXML values and fit values in qbXML fields
 * 
 * Copyright (c) 2010 Keith Palmer / ConsoliBYTE, LLC.
 * All rights reserved. This program and the accompanying materials
 * are made available under the terms of the Eclipse Public License v1.0
 * which accompanies this distribution, and is available at
 * http://www.opensource.org/licenses/eclipse-1.0.php
 * 
 * @package QuickBooks
 * @subpackage Cast
 */

/**
 * QuickBooks casts and data types
 */
class QuickBooks_Cast
{
	static public function datatype($type_or_action, $field)
	{
		
	}
	
	static public function maxlength($type_or_action, $field)
	{
		
	}
	
	/**
	 * Make sure all characters are ASCII (and thus will work with UTF-8)
	 * 
	 * We have a lot of content that gets pasted in from Microsoft Word, which 
	 * often generates some very wierd characters, which seem to not always 
	 * convert correctly to UTF-8 and then get rejected by the QuickBooks Web 
	 * Connector. This method tries to make sure that everything that should 
	 * get converted gets converted, and gets converted cleanly. 
	 * 
	 * There is probably a better way to do this...  
	 *  
	 * @param string $str	The string to convert to ASCII
	 * @return string
	 */
	/*
	static protected function _castCharset($str)
	{
		// These extended ASCII characters get mapped to things in the normal ASCII character set
		$replace = array(
			chr(129) => 'u', 
			chr(130) => 'e', 
			chr(131) => 'a', 
			chr(132) => 'a', 
			chr(133) => 'a',
			chr(134) => 'a',
			chr(136) => 'e', 
			chr(137) => 'e', 
			chr(138) => 'e', 
			chr(139) => 'i', 
			chr(140) => 'i', 
			chr(141) => 'i', 
			chr(142) => 'A', 
			chr(143) => 'A', 
			chr(144) => 'E', 
			chr(145) => 'ae', 
			chr(146) => 'AE', 
			chr(147) => 'o', 
			chr(148) => 'o', 
			chr(149) => 'o', 
			chr(150) => 'u', 
			chr(151) => 'u', 
			chr(152) => '_', 
			chr(153) => 'O', 
			chr(154) => 'U', 
			chr(158) => '_', 
			chr(160) => 'a', 
			chr(161) => 'i', 
			chr(162) => 'o', 
			chr(163) => 'u', 
			chr(164) => 'n', 
			chr(165) => 'N', 
			chr(173) => 'i', 
			chr(174) => '<', 
			chr(175) => '>', 
			chr(179) => '|', 
			chr(196) => '-', 
			chr(242) => '>=', 
			chr(243) => '<=', 
			chr(246) => '/', 
			chr(247) => '~', 
			chr(249) => '.', 
			chr(250) => '.', 
			chr(252) => '_', 
			);
		
		$count = strlen($str);
		for ($i = 0; $i < $count; $i++)
		{
			$ord = ord($str{$i});
			
			if ($ord != ord("\t") and 
				$ord != ord("\n") and 
				$ord != ord("\r") and 
				($ord < 32 or $ord > 126)) 
			{
				if (isset($replace[$ord]))
				{
					$str{$i} = $replace[$ord];
				}
				else
				{
					$str{$i} = ' ';
				}
			}
		}
		
		return $str;
	}
	*/
	
	/**
	 * Convert certain strings to their abbreviations
	 * 
	 * QuickBooks often uses unusually short field lengths. This function will 
	 * convert common long words to shorter abbreviations in an attempt to make 
	 * a string fit cleanly into the very short fields.
	 * 
	 * @param string $value		The value to apply the abbreviations to
	 * @return string
	 */
	static protected function _castAbbreviations($value)
	{
		$abbrevs = array(
			'Administration' => 'Admin.', 
			'Academic' => 'Acad.', 
			'Academy' => 'Acad.', 
			'Association' => 'Assn.',
			'Boulevard' => 'Blvd.', 
			'Building' => 'Bldg.', 
			'College' => 'Coll.', 
			'Company' => 'Co.', 
			'Consolidated' => 'Consol.', 
			'Corporation' => 'Corp.', 
			'Incorporated' => 'Inc.', 
			'Department' => 'Dept.', 
			'Division' => 'Div.', 
			'District' => 'Dist.', 
			'Eastern' => 'E.', 
			'Government' => 'Govt.', 
			'International' => 'Intl.', 
			'Institute' => 'Inst.', 
			'Institution' => 'Inst.', 
			'Laboratory' => 'Lab.',
			'Liberty' => 'Lib.', 
			'Library' => 'Lib.', 
			'Limited' => 'Ltd.', 
			'Manufacturing' => 'Mfg.', 
			'Manufacturer' => 'Mfr.', 
			'Miscellaneous' => 'Misc.', 
			'Museum' => 'Mus.', 
			'Northern' => 'N.', 
			'Northeastern' => 'NE', // This is *before* Northeast so we don't get "NEern"
			'Northeast' => 'NE', 
			'Regional' => 'Reg.', // This is *before* Region so we don't get "Reg.al" 
			'Region' => 'Reg.', 
			'School' => 'Sch.',
			'Services' => 'Svcs.', // This is *before* Service so that we don't get "Svc.s"			
			'Service' => 'Svc.', 
			'Southern' => 'S.', 
			'Southeastern' => 'SE', 
			'Southeast' => 'SE', 
			'University' => 'Univ.', 
			'Western' => 'W.', 
			);
			
		return str_ireplace(array_keys($abbrevs), array_values($abbrevs), $value);
	}
	
	/**
	 * Shorten a string to a specific length by truncating or abbreviating the string
	 * 
	 * QuickBooks often uses unusually short field lengths. This function can 
	 * be used to try to make long strings fit cleanly into the QuickBooks 
	 * fields. It tries to do a few things:
	 * 	- Convert long words to shorter abbreviations
	 * 	- Remove non-ASCII characters
	 * 	- Truncate the string if it's still too long
	 * 
	 * @param string $value				The string to shorten
	 * @param integer $length			The max. length the string should be
	 * @param boolean $with_abbrevs		Whether or not to abbreviate some long words to shorten the string
	 * @return string					The shortened string
	 */
	static protected function _castTruncate($value, $length, $with_abbrevs = true)
	{
		//$value = QuickBooks_Cast::_castCharset($value);
		
		if (strlen($value) > $length)
		{
			if ($with_abbrevs)
			{
				$value = QuickBooks_Cast::_castAbbreviations($value);
			}
			
			if (strlen($value) > $length)
			{
				$value = substr($value, 0, $length);
			}
		}
		
		// This breaks the UTF8 encoding
		//return utf8_encode($value);
		
		// Just return the data
		return $value;
	}
	
	/**
	 * 
	 * 
	 * 
	 */
	static protected function _fnmatch($pattern, $str)
	{
		$arr = array(
			'\*' => '.*', 
			'\?' => '.'
			);
		return preg_match('#^' . strtr(preg_quote($pattern, '#'), $arr) . '$#i', $str);
	}
	
	/**
	 * Cast a value to ensure that it will fit in a particular field within QuickBooks
	 * 
	 * QuickBooks has some strange length limits on some fields (the max. 
	 * length of the CompanyName field for Customers is only 41 characters, 
	 * etc.) so this method provides an easy way to cast the data type and data 
	 * length of a value to the correct type and length for a specific field.
	 * 
	 * @param string $object_type	The QuickBooks object type (Customer, Invoice, etc.)
	 * @param string $field_name	The QuickBooks field name (these correspond to the qbXML field names: Addr1, Name, CompanyName, etc.)
	 * @param mixed $value			The value you want to cast
	 * @param boolean $use_abbrevs	There are a lot of strings which can be abbreviated to shorten lengths, this is whether or not you want to use those abbrevaitions ("University" to "Univ.", "Incorporated" to "Inc.", etc.)
	 * @param boolean $htmlspecialchars
	 * @return string
	 */
	static public function cast($type_or_action, $field, $value, $use_abbrevs = true, $htmlspecialchars = true)
	{
		$type_or_action = strtolower($type_or_action);
		
		static $files = array();
		
		if (!count($files))
		{
			$dh = opendir(dirname(__FILE__) . '/QBXML/Schema/Object');
			while (false !== ($file = readdir($dh)))
			{
				if ($file{0} == '.' or substr($file, -6, 6) != 'Rq.php')
				{
					continue;
				}
				
				$files[] = $file;
			}
			
			sort($files);
		}
		
		/*
		if ($htmlspecialchars)
		{			
			$entities = array(
				'&' => '&amp;', 
				'<' => '&lt;', 
				'>' => '&gt;',
				//'\'' => '&apos;', 
				'"' => '&quot;', 
				);
			
			// First, *unreplace* things so that we don't double escape them
			$value = str_replace(array_values($entities), array_keys($entities), $value);
			
			// Then, replace XML entities
			$value = str_replace(array_keys($entities), array_values($entities), $value);
			
			//$value = htmlspecialchars($value, ENT_QUOTES, null, false);
		}		
		*/
		
		$types = array();
		$types3 = array();
		$types5 = array();
		
		reset($files);		
		foreach ($files as $file)
		{
			$substr = substr($file, 0, -4);
			$substrlower = strtolower($substr);
			
			$types[$substrlower] = $substr;
			
			$substr3 = substr($file, 0, -3 + -3);
			$substr3lower = strtolower($substr3);
			
			$substr5 = substr($file, 0, -3 + -6);
			$substr5lower = strtolower($substr5);
			
			if (!isset($types3[$substr3lower]))
			{
				$types3[$substr3lower] = $substr;
			}
			
			if (!isset($types5[$substr5lower]))
			{
				$types5[$substr5lower] = $substr;
			}
		}
		
		/*
		print('	looking for schema: ' . $type_or_action . "\n");
		print_r($types);
		print_r($types3);
		print_r($types5);
		*/
		
		$class = null;
		$schema = null;
		
		if (isset($types[$type_or_action]))
		{
			QuickBooks_Loader::load('/QuickBooks/QBXML/Schema/Object/' . $types[$type_or_action] . '.php');
			$class = 'QuickBooks_QBXML_Schema_Object_' . $types[$type_or_action];
			$schema = new $class();
		}
		else if (isset($types3[$type_or_action]))		// substr -3
		{
			QuickBooks_Loader::load('/QuickBooks/QBXML/Schema/Object/' . $types3[$type_or_action] . '.php');
			$class = 'QuickBooks_QBXML_Schema_Object_' . $types3[$type_or_action];
			$schema = new $class();
		}
		else if (isset($types5[$type_or_action]))		// substr -5
		{
			QuickBooks_Loader::load('/QuickBooks/QBXML/Schema/Object/' . $types5[$type_or_action] . '.php');
			$class = 'QuickBooks_QBXML_Schema_Object_' . $types5[$type_or_action];
			$schema = new $class();
		}
		//else
		//{
		//	return $value;
		//}
		
		//print('	casting using schema: ' . get_class($schema) . "\n");
		
		if ($class and $schema)
		{
			if (!$schema->exists($field) and false !== strpos($field, '_'))
			{
				$field = str_replace('_', ' ', $field);
			}
			
			if ($schema->exists($field))
			{
				switch ($schema->dataType($field))
				{
					case QUICKBOOKS_DATATYPE_STRING:
						
						$maxlength = $schema->maxLength($field);
						
						// Use only ASCII characters
						//$value = QuickBooks_Cast::_castCharset($value);
						
						// Make sure it'll fit in the allocated field length
						if (is_int($maxlength) and $maxlength > 0)
						{
							$value = QuickBooks_Cast::_castTruncate($value, $maxlength, $use_abbrevs);
						}
						
						break;
					case QUICKBOOKS_DATATYPE_DATE:
						if ($value)
						{
							$value = date('Y-m-d', strtotime($value));
						}
						break;
					case QUICKBOOKS_DATATYPE_DATETIME:
						if ($value)
						{
							$value = date('Y-m-d', strtotime($value)) . 'T' . date('H:i:s', strtotime($value));
						}
						break;
					case QUICKBOOKS_DATATYPE_ENUM:
						// do nothing
						break;
					case QUICKBOOKS_DATATYPE_ID:
						// do nothing
						break;
					case QUICKBOOKS_DATATYPE_FLOAT:
						$value = (float) $value;
						break;
					case QUICKBOOKS_DATATYPE_BOOLEAN:
						
						if ($value and $value !== 'false')
						{
							$value = 'true';
						}
						else
						{
							$value = 'false';
						}
						
						break;
					case QUICKBOOKS_DATATYPE_INTEGER:
						$value = (int) $value;
						break;
				}			
			}
		}
			
		/*
		if ($htmlspecialchars)
		{			
			$entities = array(
				'&' => '&amp;', 
				'<' => '&lt;', 
				'>' => '&gt;',
				//'\'' => '&apos;', 
				'"' => '&quot;', 
				);
			
			// First, *unreplace* things so that we don't double escape them
			$value = str_replace(array_values($entities), array_keys($entities), $value);
			
			// Then, replace XML entities
			$value = str_replace(array_keys($entities), array_values($entities), $value);
			
			//$value = htmlspecialchars($value, ENT_QUOTES, null, false);
		}
		*/
		
		if ($htmlspecialchars)
		{
			//print("DECODING");
			
			$entities = array(
				'&' => '&amp;', 
				'<' => '&lt;', 
				'>' => '&gt;',
				//'\'' => '&apos;', 
				'"' => '&quot;', 
				);
			
			// First, *unreplace* things so that we don't double escape them
			$value = str_replace(array_values($entities), array_keys($entities), $value);
			
			// Then, replace XML entities
			$value = str_replace(array_keys($entities), array_values($entities), $value);
			
			//$value = htmlspecialchars($value, ENT_QUOTES, null, false);
			
			//print($value . "\n\n\n");
		
			// UTF8 character handling, decode UTF8 to character decimal codes
			$value = QuickBooks_Cast::_decodeUTF8($value);
			
			//die($value . "\n\n");
		}
		
		return $value;
	}
		
	/**
	 * Test a string to see if it has 8 bit symbols in it
	 *
	 * @param string $string
	 * @param string $charset
	 * @return bool 
	 */
	static protected function _is8Bit($string, $charset = '') 
	{
		if (preg_match("/^iso-8859/i", $charset)) 
		{
			$needle = '/\240|[\241-\377]/';
		} 
		else 
		{
			$needle = '/[\200-\237]|\240|[\241-\377]/';
		}
		
		return preg_match("$needle", $string);
	}
		
	/**
	 * Converts string from an encoded string to UTF8
	 * 
	 * @param string $string 		Text with numeric unicode entities
	 * @return string 				UTF-8 text
	 */
	static protected function _encodeUTF8($string) 
	{
		// Don't run encoding function, if there is no encoded characters
		if (!preg_match("'&#[0-9]+;'", $string)) 
		{
			return $string;
		}
		
		$string = preg_replace("/&#([0-9]+);/e", "QuickBooks_Cast_unicodetoutf8('\\1')", $string);
		// $string=preg_replace("/&#[xX]([0-9A-F]+);/e","unicodetoutf8(hexdec('\\1'))",$string);
		
		return $string;
	}
	
	/**
	 * Decode a UTF-8 string to an entity encoded string
	 * 
	 * @param string $string 	Encoded string
	 * @return string 			Decoded string
	 */
	static protected function _decodeUTF8($string)
	{
		// don't do decoding when there are no 8bit symbols
		if (!QuickBooks_Cast::_is8Bit($string, 'utf-8'))
		{
			return $string;
		}
		
		// decode four byte unicode characters
		$string = preg_replace_callback("/([\360-\367])([\200-\277])([\200-\277])([\200-\277])/",
		function($arr)
		{
		    $val = ((ord($arr[1])-240)*262144+(ord($arr[2])-128)*4096+(ord($arr[3])-128)*64+(ord($arr[4])-128));
		    return "&#" . $val . ";";
		}, $string);
			
	
		// decode three byte unicode characters
		$string = preg_replace_callback("/([\340-\357])([\200-\277])([\200-\277])/",
		function($arr)
		{
		    $val = ((ord($arr[1])-224)*4096+(ord($arr[2])-128)*64+(ord($arr[3])-128));
		    return "&#" . $val . ";";
		}, $string);
			
	
		// decode two byte unicode characters
		$string = preg_replace_callback("/([\300-\337])([\200-\277])/",
		function($arr)
		{
		    $val = ((ord($arr[1])-192)*64+(ord($arr[2])-128));
		    return "&#" . $val . ";";
		}, $string);
	
		// remove broken unicode
		$string = preg_replace("/[\200-\237]|\240|[\241-\377]/", '?', $string);
	
		return $string;
	}
}

/**
 * Return UTF8 symbol when unicode character number is provided
 *
 * @param int $var		Decimal unicode value
 * @return string		UTF-8 character
 */
function QuickBooks_Cast_unicodetoutf8($var) 
{
	if ($var < 128) 
	{
		$ret = chr ($var);
	} 
	else if ($var < 2048) 
	{
		// Two byte utf-8
		$binVal = str_pad (decbin ($var), 11, '0', STR_PAD_LEFT);
		$binPart1 = substr ($binVal, 0, 5);
		$binPart2 = substr ($binVal, 5);

		$char1 = chr (192 + bindec ($binPart1));
		$char2 = chr (128 + bindec ($binPart2));
		$ret = $char1 . $char2;
	} 
	else if ($var < 65536) 
	{
		// Three byte utf-8
		$binVal = str_pad (decbin ($var), 16, '0', STR_PAD_LEFT);
		$binPart1 = substr ($binVal, 0, 4);
		$binPart2 = substr ($binVal, 4, 6);
		$binPart3 = substr ($binVal, 10);

		$char1 = chr (224 + bindec ($binPart1));
		$char2 = chr (128 + bindec ($binPart2));
		$char3 = chr (128 + bindec ($binPart3));
		$ret = $char1 . $char2 . $char3;
	} 
	else if ($var < 2097152) 
	{
		// Four byte utf-8
		$binVal = str_pad (decbin ($var), 21, '0', STR_PAD_LEFT);
		$binPart1 = substr ($binVal, 0, 3);
		$binPart2 = substr ($binVal, 3, 6);
		$binPart3 = substr ($binVal, 9, 6);
		$binPart4 = substr ($binVal, 15);

		$char1 = chr (240 + bindec ($binPart1));
		$char2 = chr (128 + bindec ($binPart2));
		$char3 = chr (128 + bindec ($binPart3));
		$char4 = chr (128 + bindec ($binPart4));
		$ret = $char1 . $char2 . $char3 . $char4;
	} 
	else if ($var < 67108864) 
	{
		// Five byte utf-8
		$binVal = str_pad (decbin ($var), 26, '0', STR_PAD_LEFT);
		$binPart1 = substr ($binVal, 0, 2);
		$binPart2 = substr ($binVal, 2, 6);
		$binPart3 = substr ($binVal, 8, 6);
		$binPart4 = substr ($binVal, 14,6);
		$binPart5 = substr ($binVal, 20);

		$char1 = chr (248 + bindec ($binPart1));
		$char2 = chr (128 + bindec ($binPart2));
		$char3 = chr (128 + bindec ($binPart3));
		$char4 = chr (128 + bindec ($binPart4));
		$char5 = chr (128 + bindec ($binPart5));
		$ret = $char1 . $char2 . $char3 . $char4 . $char5;
	} 
	else if ($var < 2147483648) 
	{
		// Six byte utf-8
		$binVal = str_pad(decbin($var), 31, '0', STR_PAD_LEFT);
		$binPart1 = substr($binVal, 0, 1);
		$binPart2 = substr($binVal, 1, 6);
		$binPart3 = substr($binVal, 7, 6);
		$binPart4 = substr($binVal, 13,6);
		$binPart5 = substr($binVal, 19,6);
		$binPart6 = substr($binVal, 25);

		$char1 = chr(252 + bindec($binPart1));
		$char2 = chr(128 + bindec($binPart2));
		$char3 = chr(128 + bindec($binPart3));
		$char4 = chr(128 + bindec($binPart4));
		$char5 = chr(128 + bindec($binPart5));
		$char6 = chr(128 + bindec($binPart6));
		$ret = $char1 . $char2 . $char3 . $char4 . $char5 . $char6;
	} 
	else 
	{
		// there is no such symbol in utf-8
		$ret = '?';
	}
	
	return $ret;
}

