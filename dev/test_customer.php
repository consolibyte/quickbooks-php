<?php

require_once '../QuickBooks.php';

$Customer = new QuickBooks_Object_Customer();

$Customer->setFullName('web:Keith Palmer');

print('FullName: ' . $Customer->getFullName() . "\n");
print('Name: ' . $Customer->getName() . "\n");
print('Parent: ' . $Customer->getParentName() . "\n");
print("\n");
print($Customer->asQBXML(QUICKBOOKS_ADD_CUSTOMER));