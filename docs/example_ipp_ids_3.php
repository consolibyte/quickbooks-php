<html>
	<head>
		<title>Intuit IPP/IDS + PHP Test - Keith Palmer</title>
		
		<style type="text/css">
			
			body
			{
				font-family: sans-serif;
			}
			
		</style>
		
		<script type="text/javascript">
		
			function go(which)
			{
				for (var i = 0; i < 100; i++)
				{
					if (document.getElementById('replacer_' + i))
					{
						document.getElementById('replacer_' + i).style.visibility = 'hidden';
					}
				}
				
				document.getElementById('replacer_' + which).style.visibility = 'visible';
			}
		
		</script>
		
	</head>
	<body>

		<h1>
			Keith Palmer's Intuit IPP/IDS + PHP Test
		</h1>

<?php

//header('Content-Type: text/plain');

require_once '../QuickBooks.php';

// 
$username = 'keith@consolibyte.com';
$password = 'password42';
$token = 'tex3r7hwifx6cci3zk43ibmnd';
$realmID = 173642438;

// 
$IPP = new QuickBooks_IPP();
$Context = $IPP->authenticate($username, $password, $token);
$IPP->application($Context, 'be9mh7qd5');

// Create a new Check Service for IDS access
$CheckService = new QuickBooks_IPP_Service_Check();

// Get a list of Customers from QuickBooks
$check_list = $CheckService->findAll($Context, $realmID);

print('<pre>');
print_r($check_list);
print('</pre>');

print(str_repeat('<br />', 50));

print('<textarea cols="120" rows="20">');
print($Context->lastRequest());
print('</textarea>');
print('<textarea cols="120" rows="20">');
print($Context->lastResponse());
print('</textarea>');
