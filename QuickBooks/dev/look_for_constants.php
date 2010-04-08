<?php

require_once '/home/library_php/QuickBooks.php';

$defined = array();
$used = array();
$total = lookforconstants_walkdir('/home/library_php/QuickBooks', $defined, $used);

$total += lookforconstants_look('/home/library_php/QuickBooks.php', $defined, $used);

function lookforconstants_walkdir($dir, &$defined, &$used)
{
	$total = 0;
	
	$dh = opendir($dir);
	while (false !== ($file = readdir($dh)))
	{
		if ($file{0} == '.')
		{
			continue;
		}
		
		if (is_file($dir . '/' . $file) and 
			substr($file, -3, 3) == 'php' and 
			false === strpos($file, 'example') and 
			false === strpos($dir, 'scripts') and 
			false === strpos($dir, 'dev') and 
			false === strpos($dir, 'docs') and 
			false === strpos($dir, 'tmp'))
		{
			$total = $total + lookforconstants_look($dir . '/' . $file, $defined, $used);
		}
		else if (is_dir($dir . '/' . $file))
		{
			$total = $total + lookforconstants_walkdir($dir . '/' . $file, $defined, $used);
		}
	}
	
	return $total;
}

function lookforconstants_look($file, &$defined, &$used)
{
	static $i = 0;
	
	print(' examining: ' . $file . "\n");
	
	require_once $file;
	
	$total = 0;
	
	$tokens = token_get_all(file_get_contents($file));
	
	foreach ($tokens as $arr)
	{
		if (isset($arr[1]))
		{
			if (substr($arr[1], 0, 1) == "'" and ereg('^([A-Z_\']{2,60})$', $arr[1]))
			{
				$defined[] = trim($arr[1], "'");
			}
			else if (ereg('^([A-Z_]){2,60}$', $arr[1]))
			{
				$used[] = $arr[1];
			}
		}
	}
	
	$defined = array_unique($defined);
	$used = array_unique($used);
	
	//if ($i > 2)
	//{
	//	return 0;
	//}
	//$i++;
	
	return $total;
}

print('DEFINED:');
print_r($defined);

print('USED:');
print_r($used);

$diff = array_diff($used, $defined);

print('MISMATCH:');
print_r($diff);

?>