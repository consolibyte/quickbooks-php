<?php

header('Content-Type: text/plain');

require_once dirname(__FILE__) . '/config.php';

$check = $IntuitAnywhere->check($the_username, $the_tenant);
$test = $IntuitAnywhere->test($the_username, $the_tenant);

$creds = $IntuitAnywhere->load($the_username, $the_tenant);

$diagnostics = array_merge(array(
	'check' => $check,
	'test' => $test,
	), $creds);

print_r($diagnostics);