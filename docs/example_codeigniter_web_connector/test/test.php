<?php

require_once dirname(__FILE__) . '/../mockci.php';
require_once dirname(__FILE__) . '/../controllers/quickbooks.php';

$tmp = new QuickBooks();
$tmp->qbwc();
//$tmp->config();