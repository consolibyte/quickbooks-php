<?php

$url = 'http://localhost:8888/saas/installs/92/interspire/qbus/108/public/interspire/qbwc.php';
$username = 'user92';
$password = 'abcd1234';

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

header('Content-type: text/plain');

print(date('Y-m-d H:i:s: ') . 'URL: ' . $url . "\n");
print(date('Y-m-d H:i:s: ') . 'User: ' . $username . "\n");
print(date('Y-m-d H:i:s: ') . 'Pass: ' . $password . "\n");

$return = tester($url, $username, $password, 'authenticate');

print(date('Y-m-d H:i:s: ') . 'RESPONSE: {{' . $return . '}}');

$pos = strpos($return, '<ns1:string>');
//$ticket = substr($return, $pos + 12, 32);		// FOR MD5 HASH TICKETS
$ticket = substr($return, $pos + 12, 36);		// FOR UUID TICKETS

print("\n\n" . date('Y-m-d H:i:s: ') . 'TICKET IS: [[' . $ticket . ']]' . "\n\n");


//exit;

$max = 1;
for ($i = 0; $i < $max; $i++)
{
	print(date('Y-m-d H:i:s: ') . tester($url, $ticket, null, 'sendRequestXML'));
}

exit;

$response = '';

print(tester($url, $ticket, null, 'receiveResponseXML', $response));

exit;

function tester($url, $username_or_ticket, $password, $method, $data = null)
{
	print(date('Y-m-d H:i:s: ') . 'Sending request method: ' . $method . "\n");
	
	switch ($method)
	{
		case 'authenticate':
			$soap = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
 xmlns:xsd="http://www.w3.org/2001/XMLSchema"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
 SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
	<SOAP-ENV:Body>
		<authenticate xmlns="http://developer.intuit.com/">
			<strUserName xsi:type="xsd:string">' . $username_or_ticket . '</strUserName>
			<strPassword xsi:type="xsd:string">' . $password . '</strPassword>
		</authenticate>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
			break;
		case 'sendRequestXML':
			$soap = '<?xml version="1.0" encoding="UTF-8"?>
	<SOAP-ENV:Envelope 
	 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
	 xmlns:ns1="http://developer.intuit.com/">
		<SOAP-ENV:Body>
			<ns1:sendRequestXML>
				<ns1:ticket>' . $username_or_ticket . '</ns1:ticket>
				<ns1:strHCPResponse></ns1:strHCPResponse>
				<ns1:strCompanyFileName></ns1:strCompanyFileName>
				<ns1:qbXMLCountry>UK</ns1:qbXMLCountry>
				<ns1:qbXMLMajorVers>3</ns1:qbXMLMajorVers>
				<ns1:qbXMLMinorVers>0</ns1:qbXMLMinorVers>
			</ns1:sendRequestXML>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>';
			break;
		case 'receiveResponseXML':
			$soap = '<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
				<soap:Body>
					<receiveResponseXML xmlns="http://developer.intuit.com/">
						<ticket>' . $username_or_ticket . '</ticket>
						<response>' . htmlspecialchars($data, ENT_QUOTES) . '</response>
						<hresult />
						<message />
					</receiveResponseXML>
				</soap:Body>
			</soap:Envelope>';
			break;
	}
	
	$headers = array(
		'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 2.0.50727.1433)', 
		'Content-Type: text/xml; charset=utf-8',
		'Soapaction: "http://developer.intuit.com/' . $method . '"',
		);

	if (function_exists('curl_init'))
	{
		$curl = curl_init($url); 
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, $soap);
		
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_MAXCONNECTS, 1);
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$return = curl_exec($curl);
	}
	else
	{
		$parse = parse_url($url);
		if (empty($parse['port']))
		{
			$parse['port'] = 80;
		}
		
		if ($parse['scheme'] == 'https')
		{
			die('sorry, you need curl to test https (for now at least)');
		}
		
		if ($fp = fsockopen($parse['host'], $parse['port']))
		{
			$request = '';
			$request .= 'POST ' . $parse['path'] . '?' . $parse['query'] . ' HTTP/1.0' . "\r\n";
			$request .= 'Host: ' . $parse['host'] . "\r\n";
			
			foreach ($headers as $key => $value)
			{
				//$request .= $key . ': ' . $value . "\r\n";
				$request .= $value . "\r\n";
			}
			
			$request .= 'Content-Length: ' . strlen($soap) ."\r\n"; 
			$request .= 'Connection: close' . "\r\n";
			$request .= "\r\n"; 
			$request .= $soap; 
			
			print(str_repeat('-', 20) . ' REQUEST ' . str_repeat('-', 20) . "\n");
			print($request . "\n");
			print(str_repeat('-', 48) . "\n");
			
			fputs($fp, $request);
				
			$bytes = 0;
			$resp = '';
			while (!feof($fp) and $bytes < 10000) 
			{ 
				$tmp = fgets($fp, 128);
				$bytes += strlen($tmp);
				
				$resp .= $tmp; 
			}
			
			print(str_repeat('-', 19) . ' RESPONSE ' . str_repeat('-', 19) . "\n");	
			print($resp . "\n");
			print(str_repeat('-', 48) . "\n");
			print("\n\n");
				
			fclose($fp);	
		}
		else
		{
			die('Connection failed!');
		}
			
		$return = $resp;
	}
	
	return $return;
}
