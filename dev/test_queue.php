<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

$dsn = 'mysqli://root:root@localhost/quickbooks_server';
$Queue = new QuickBooks_Queue($dsn);

$Queue->user('quickbooks');
for ($i = 1; $i <= 3; $i++)
{
	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $i);
}

print('Current queue size for user: ' . $Queue->user() . ': ' . $Queue->size() . "\n");

$Queue->user('demo');
print('Current queue size for user: ' . $Queue->user() . ': ' . $Queue->size() . "\n");

$Queue->user('quickbooks');
$Queue->remove(QUICKBOOKS_ADD_CUSTOMER, 2);
print('Current queue size for user: ' . $Queue->user() . ' after removing an item: ' . $Queue->size() . "\n");