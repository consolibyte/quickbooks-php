<?php

ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

require_once '../QuickBooks.php';

$Customer = new QuickBooks_IPP_Object_Customer();
$Customer->setFamilyName('Palmer');


$Customer->setName('ConsoliBYTE & Ryke Labs');


$Customer->setSomething('Else');

$Address = new QuickBooks_IPP_Object_Address();
$Address->setCity('Willington');
$Address->setLine2('Suite D');
$Address->setPostalCode('06279');
$Address->setLine1('56 Cowles Road');

$Customer->addAddress($Address);


$Customer->setGivenName('Keith');


//print($Customer->asXML());

print($Customer->asIDSXML());