<?php

require_once '../QuickBooks.php';

$Customer = new QuickBooks_QBXML_Object_Customer();

$Customer->setName('Child Derpé Customer Name');

$Customer->setPhone('860-634-1602');
$Customer->setEmail('keith@uglyslug.com');

$Customer->setFirstName('Keith');
$Customer->setLastName('Palmer');

// Set the parent of the customer
$Customer->setParentFullName('Parent & Customer Name');

// You could also set the parent customer by ListID too
//$Customer->setParentListID('ABCD-1234');

print($Customer->asQBXML(QUICKBOOKS_ADD_CUSTOMER, 6.0, QUICKBOOKS_LOCALE_ONLINE_EDITION));
