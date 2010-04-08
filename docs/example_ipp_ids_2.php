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

// Create a new Customer Service for IDS access
$CustomerService = new QuickBooks_IPP_Service_Customer();

// Get a list of Customers from QuickBooks
$customer_list = $CustomerService->findAll($Context, $realmID);

// Create a new Invoice Service for IDS access
$InvoiceService = new QuickBooks_IPP_Service_Invoice();

// Get a list of invoices
$invoice_list = $InvoiceService->findAll($Context, $realmID);


print('
				<table>
					<tr>
						<td>
							<strong>Click a Customer!</strong><br /><br />
						<td>
						<td>
							&nbsp;
						</td>
					</tr>
');

// Print out some HTML
foreach ($customer_list as $key => $Customer)
{
	$line = '';
	$city = '';
	$state = '';
	if ($Address = $Customer->getAddress(0))
	{
		$line = $Address->getLine1();
		$city = $Address->getCity();
		$state = $Address->getCountrySubDivisionCode();
	}
	
	print('
		<tr>
			<td width="250">
				<a href="#" onclick="go(' . $key . '); return false;">' . $Customer->getName() . '</a><br />
				' . $line . '<br />
				' . $city . ', ' . $state . '<br />
				<hr />
			</td>
			<td>
				
				<div id="replacer_' . $key . '" style="visibility: hidden;">
					
					<table width="580">
						<tr>
							<td>
								<strong>Invoice #</strong>
							</td>
							<td>
								<strong>Date</strong>
							</td>
							<td>
								<strong>Account</strong>
							</td>
							<td>
								<strong>Amount</strong>
							</td>
						</tr>
	');
	
	foreach ($invoice_list as $key => $Invoice)
	{
		//print_r($Invoice);
		
		if ($Invoice->getHeader()->getCustomerId() != $Customer->getId())
		{
			continue;
		}
		
		print('
			<tr>
				<td>
					' . $Invoice->getHeader()->getDocNumber() . '
				</td>
				<td>
					' . date('M. jS Y', strtotime($Invoice->getHeader()->getTxnDate())) . '
				</td>
				<td>
					' . $Invoice->getHeader()->getARAccountName() . '
				</td>
				<td>
					$ ' . sprintf('%01.2f', $Invoice->getHeader()->getTotalAmt()) . '
				</td>
			</tr>
		');
	}
	
	print('
					</table>

				</div>

			</td>
		</tr>
	');
}

print('
	</table>
');

print(str_repeat('<br />', 50));

print('<pre>');
print_r($customer_list);
print_r($invoice_list);
print('</pre>');