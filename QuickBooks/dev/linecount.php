<?php

$lines = 0;
$files = 0;
$total = linecount_walkdir('/home/library_php/QuickBooks', $lines, $files);

//print("\n\n" . ' TOTAL LINES: ' . number_format($total) . "\n\n");

print("\n");
print('TOTAL: ' . number_format($lines) . ' lines ' . "\n");
print('	in ' . number_format($files) . ' files' . "\n");
print("\n");

function linecount_walkdir($dir, &$lines, &$files)
{
	$total = 0;
	
	$dh = opendir($dir);
	while (false !== ($file = readdir($dh)))
	{
		if ($file{0} == '.')
		{
			continue;
		}
		
		if (is_file($dir . '/' . $file) and substr($file, -3, 3) == 'php')
		{
			$total = $total + linecount_countlines($dir . '/' . $file, $lines, $files);
		}
		else if (is_dir($dir . '/' . $file))
		{
			$total = $total + linecount_walkdir($dir . '/' . $file, $lines, $files);
		}
	}
	
	return $total;
}

function linecount_countlines($file, &$lines, &$files)
{
	$total = 0;
	
	foreach (file($file) as $line)
	{
		$line = trim($line);
		
		if (strlen($line) and 
			substr($line, 0, 2) != '//' and 
			substr($line, 0, 1) != '*')
		{
			$total = $total + 1;
		}
	}
	
	$lines += $total;
	$files += 1;
	
	print('	' . $file . ' has ' . number_format($total) . ' lines' . "\n");
	return $total;
}

?>