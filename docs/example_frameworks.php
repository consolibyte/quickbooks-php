<?php

header('Content-Type: text/plain');

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . '/Users/kpalmer/Projects/QuickBooks');
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

$start = microtime(true);

require_once 'QuickBooks/Frameworks.php';

// Include *just* items neccessary for a traditional Web Connector integration
//define('QUICKBOOKS_FRAMEWORKS', QUICKBOOKS_FRAMEWORK_WEBCONNECTOR);

// Include *just* the constants, but no actual objects
//define('QUICKBOOKS_FRAMEWORKS', QUICKBOOKS_FRAMEWORK_CONSTANTS);

// Include *just* stuff we need to queue actions up
define('QUICKBOOKS_FRAMEWORKS', QUICKBOOKS_FRAMEWORK_QUEUE);

require_once 'Quickbooks.php';

print('TIME: ' . (microtime(true) - $start) . "\n\n");

print('VERSION: ' . QUICKBOOKS_PACKAGE_VERSION . "\n\n");

$classes = get_declared_classes();
foreach ($classes as $class)
{
	if (false !== strpos($class, 'QuickBooks'))
	{
		print("\t" . $class . "\n");
	}
}
