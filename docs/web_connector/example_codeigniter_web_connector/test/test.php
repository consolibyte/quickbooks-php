<?php

require_once dirname(__FILE__) . '/../mockci.php';
require_once dirname(__FILE__) . '/../controllers/quickbooks.php';
require_once dirname(__FILE__) . '/../controllers/mydemo.php';

$tmp = new QuickBooks();
$tmp->qbwc();
//$tmp->config();

//$tmp2 = new MyDemo();
//$tmp2->do_something();