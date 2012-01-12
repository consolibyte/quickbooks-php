<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

$token = 'a19ded85b43f6b4168b94fcb63a519376019';
$oauth_consumer_key = 'qyprdbbHtE5gH7XXiwRXHqSmRfaeXY';
$oauth_consumer_secret = 'jSNY9vWNUQyu3vB4L4EvENWIAgMdgBizCukW9LdP';

$this_url = 'http://localhost:8888/ianywhere/app.php';
$that_url = 'http://localhost:8888/ianywhere/data.php';


mysql_connect('localhost', 'root', 'root');
mysql_select_db('ianywhere');

