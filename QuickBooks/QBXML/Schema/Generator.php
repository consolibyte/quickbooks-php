<?php

/**
 * 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * @license LICENSE.txt 
 * 
 * @package QuickBooks
 * @subpackage QBXML
 */

/**
 * 
 */
QuickBooks_Loader::load('/QuickBooks/XML.php');

/**
 * 
 */
class QuickBooks_QBXML_Schema_Generator
{
	protected $_xml;
	
	public function __construct($xml)
	{
		ini_set('memory_limit', '128M');
		
		$this->_xml = $xml;
	}
	
	public function saveAll($dir)
	{
		$quickBooksXML = new QuickBooks_XML($this->_xml);
		
		$arr_actions_adds = QuickBooks_Utilities::listActions('*Add', false);
		$arr_actions_mods = QuickBooks_Utilities::listActions('*Mod', false);
		
		//print_r($arr_actions_mods);
		//exit;
		
		$i = 0;
		
		$errnum = 0;
		$errmsg = '';
		if ($Doc = $quickBooksXML->parse($errnum, $errmsg))
		{
			$children = $Doc->children();
			$children = $children[0]->children();
			
			foreach ($children as $child)
			{
				print('Action name is: ' . $child->name() . "\n");
				
				//if ($Action->name() != 'VendorAddRq')
				//{
				//	continue;
				//}
				
				//print_r($Action);
				
				$section = $this->_extractSectionForTag($this->_xml, $child->name());
				
				//print($section);
				
				$wrapper = '';
				if ($child->hasChildren())
				{
					$first = $child->getChild(0);
					
					//print_r($first);
					
					
					
					if (in_array($first->name(), $arr_actions_mods) || in_array($first->name(), $arr_actions_adds))
					{
						$wrapper = $first->name();
						
						print('	WRAPPER NODE IS: ' . $wrapper . "\n");
					}
				}
				
				//exit;
				
				$paths_datatype = array();
				$paths_maxlength = array();
				$paths_isoptional = array();
				$paths_sinceversion = array();
				$paths_isrepeatable = array();
				$paths_reorder = array();
				
				//$curdepth = 0;
				$lastdepth = 0;
				$paths = $child->asArray(QUICKBOOKS_XML_ARRAY_PATHS);
				foreach ($paths as $path => $datatype)
				{
					$tmp = explode(' ', $path);
					$tag = end($tmp);
					
					$comment = $this->_extractCommentForTag($section, $tag);
					//print("\t{" . $path . '} => ' . $datatype . ' (' . $comment . ')' . "\n");
					$parse = $this->_parseComment($comment);
					//print_r($parse);
					//print("\n");
					
					$path = trim(substr($path, strlen($child->name())));
					
					if (strlen($wrapper) && substr($path, 0, strlen($wrapper)) == $wrapper)
					{
						$path = substr($path, strlen($wrapper) + 1);
					}
					
					$paths_datatype[$path] = $datatype;
					$paths_maxlength[$path] = $parse['maxlength'];
					$paths_isoptional[$path] = $parse['isoptional'];
					$paths_sinceversion[$path] = $parse['version'];
					$paths_isrepeatable[$path] = $parse['mayrepeat'];
					
					$curdepth = substr_count($path, ' ');
					if ($curdepth - $lastdepth > 1)
					{
						$tmp2 = explode(' ', $path);
      $counter = count($tmp2);
						for ($i = 1; $i < $counter; ++$i)
						{
							$paths_reorder[] = implode(' ', array_slice($tmp2, 0, $i));
						}
					}
     
					$lastdepth = substr_count($path, ' ');
					
					$paths_reorder[] = $path;
				}
				
				//print(var_export($paths_datatype));
				//print(var_export($paths_maxlength));
				//print(var_export($paths_isoptional));
				//print(var_export($paths_sinceversion));
				//print(var_export($paths_isrepeatable));
				//print(var_export($paths_reorder));
				
				$contents = file_get_contents('/home/asdg/QuickBooks/QBXML/Schema/Object/Template.php');
				
				$contents = str_replace('Template', $child->name(), $contents);
				$contents = str_replace("'_qbxmlWrapper'", var_export($wrapper, true), $contents);
				$contents = str_replace("'_dataTypePaths'", var_export($paths_datatype, true), $contents);
				$contents = str_replace("'_maxLengthPaths'", var_export($paths_maxlength, true), $contents);
				$contents = str_replace("'_isOptionalPaths'", var_export($paths_isoptional, true), $contents);
				$contents = str_replace("'_sinceVersionPaths'", var_export($paths_sinceversion, true), $contents);
				$contents = str_replace("'_isRepeatablePaths'", var_export($paths_isrepeatable, true), $contents);
				$contents = str_replace("'_reorderPaths'", var_export($paths_reorder, true), $contents);
				
				$fp = fopen('/home/adg/QuickBooks/tmp/' . $child->name() . '.php', 'w+');
				fwrite($fp, $contents);
				fclose($fp);
				
				print("\n\n");
				
				if ($i > 150)
				{
					exit;
				}
				
				++$i;
			}
		}
	}
	
	protected function _parseComment($comment)
	{
		$defaults = array(
			'maxlength' => 0, 
			'isoptional' => false,
			'mayrepeat' => false,  
			'version' => 999.99,
			);
		
		if (false !== strpos($comment, 'rep'))
		{
			$defaults['mayrepeat'] = true;
		}
		
		if (false !== strpos($comment, 'opt'))
		{
			$defaults['isoptional'] = true;
		}
		
		if (false !== ($pos = strpos($comment, 'max length')))
		{
			$defaults['maxlength'] = (int) trim(substr($comment, $pos + 10), ' =');
		}
		
		if (false !== ($pos = strpos($comment, 'v')))
		{
			$defaults['version'] = (float) trim(substr($comment, $pos + 1));
		}
		
		return $defaults;
	}
	
	protected function _extractCommentForTag($section, string $tag)
	{
		if (false !== ($start_open = strpos($section, '<' . $tag)) && false !== ($start_close = strpos($section, '>', $start_open)) && false !== ($stop_open = strpos($section, '</' . $tag . '>')))
		{
			$str = substr($section, $stop_open + strlen($tag) + 3);
			$arr = explode("\n", $str);
			
			$line = current($arr);
			
			return trim($line, "<!- >\n\r");
		}
		
		return '';
	}
	
	protected function _extractSectionForTag($xml, string $tag)
	{
		if (false !== ($start_open = strpos($xml, '<' . $tag)) && false !== ($start_close = strpos($xml, '>', $start_open)) && false !== ($stop_open = strpos($xml, '</' . $tag . '>')))
		{
			return substr($xml, $start_open, $stop_open - $start_open + strlen($tag) + 3);
		}
		
		return '';
	}
}

?>