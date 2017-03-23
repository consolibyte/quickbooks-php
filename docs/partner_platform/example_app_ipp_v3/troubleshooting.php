<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

header('Content-Type: text/plain');

require_once dirname(__FILE__) . '/../../../QuickBooks.php';

$urls = array(
	QuickBooks_IPP_IntuitAnywhere::URL_REQUEST_TOKEN,
	QuickBooks_IPP_IntuitAnywhere::URL_CONNECT_RECONNECT,
	);

for ($i = 0; $i <= 1; $i++)
{
	foreach ($urls as $url)
	{
		ob_start();
		$out = fopen('php://output', 'w');

		$params = array(
			CURLOPT_RETURNTRANSFER => true,
			);

		$ch = curl_init($url);
		curl_setopt_array($ch, $params);

		curl_setopt($ch, CURLOPT_VERBOSE, true);
		curl_setopt($ch, CURLOPT_STDERR, $out);

		if ($i == 1)
		{
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		}

		$response = curl_exec($ch);

		fclose($out);
		$debug = ob_get_clean();

		print('Trying to hit URL: ' . $url . "\n\n");
		print('   Did we disable SSL checks? ' . trim(var_export((bool) $i, true)) . "\n");
		print($debug);
		print("\n\n");
		print($response);

		print("\n\n\n\n\n\n\n");
	}
}

print('php version: ' . phpversion() . "\n");
print('mcrypt extension? ' . var_export(function_exists('mcrypt_module_open'), true) . "\n");
print('  mcrypt module rijndael-256? ' . var_export(mcrypt_module_open('rijndael-256', '', 'ofb', ''), true) . "\n");
print('curl extension? ' . var_export(function_exists('curl_init'), true) . "\n");

