<?php

$url = 'http://localhost/~kpalmer/QuickBooks%20Bridge/example_bridge_server.php';


$data = 'method=enqueue&qbxml=' . urlencode('<?xml=><qbxml>...</qbxml>');

//curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

curl_setopt($curl, CURLOPT_HEADER, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
curl_setopt($curl, CURLOPT_MAXCONNECTS, 1);

curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$return = curl_exec($curl);

print($return);

?>