<?php


$url = '';
$username = 'keithtest';
$password = 'password';

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

global $DATA;
$DATA = '';

header('Content-type: text/plain');

print(date('Y-m-d H:i:s: ') . 'URL: ' . $url . "\n");
print(date('Y-m-d H:i:s: ') . 'User: ' . $username . "\n");
print(date('Y-m-d H:i:s: ') . 'Pass: ' . $password . "\n");

//print($return);

//exit;

$return = tester($url, $username, $password, 'authenticate');

print(date('Y-m-d H:i:s: ') . 'RESPONSE: {{' . $return . '}}');

//$pos = strpos($return, '<string>');
$pos = strpos($return, '<ns1:string>');
//$pos = strpos($return, '<s0:string xsi:type="xs:string">');
//$ticket = substr($return, $pos + 12, 32);		// FOR MD5 HASH TICKETS
$ticket = substr($return, $pos + 12, 36);		// FOR UUID TICKETS

//$ticket = 'eda2daf8-6482-11e0-aea8-0030487fb92c';

print("\n\n" . date('Y-m-d H:i:s: ') . 'TICKET IS: [[' . $ticket . ']]' . "\n\n");



//exit;


$max = 1;
for ($i = 0; $i < $max; ++$i)
{
	//print(date('Y-m-d H:i:s: ') . tester($url, $ticket, null, 'sendRequestXML'));
	
	$resp = tester($url, $ticket, null, 'sendRequestXML');
	
	$pos = strpos($resp, 'requestID=&quot;');
	
	print('got back [' . $resp . ']');
	
	//sleep(10);
}

exit;
