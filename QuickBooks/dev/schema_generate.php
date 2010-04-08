<?php

require_once '/home/library_php/QuickBooks.php';

require_once 'QuickBooks/QBXML/Schema/Generator.php';

$xml = file_get_contents('/home/library_php/QuickBooks/data/qbxmlops70.xml');

$Generator = new QuickBooks_QBXML_Schema_Generator($xml);

$Generator->saveAll('/home/library_php/QuickBooks/tmp');

//require_once 'QuickBooks/QBXML/Schema/Object/CustomerAdd.php';

//$class = new QuickBooks_QBXML_Schema_Object_CustomerAdd();
//print('first name data type: ' . $class->dataType('FirstName'));

?>