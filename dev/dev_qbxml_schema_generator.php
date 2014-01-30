<?php

chdir(realpath(__DIR__));

require_once realpath("../QuickBooks.php");

QuickBooks_Loader::load('/QuickBooks/QBXML/Schema/Generator');

$generator = new QuickBooks_QBXML_Schema_Generator('../data/qbxmlops130.xml');
$dir = __DIR__ . '/tmp_schema';

$generator->saveAll(dirname(__FILE__) . '/tmp/');