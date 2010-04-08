<?php

require_once '/Users/keithpalmerjr/Projects/QuickBooks/QuickBooks.php';

$ServiceItem = new QuickBooks_Object_ServiceItem();

$fullname = QuickBooks_Cast::cast(QUICKBOOKS_OBJECT_SERVICEITEM, 'FullName', 'QuickBooks Services:QuickBooks Foxycart Self-Hosted Integration');

$ServiceItem->setFullName($fullname);

print('original: ' . $fullname . "\n");
print('FullName: ' . $ServiceItem->getFullName() . "\n");
print('Name: ' . $ServiceItem->getName() . "\n");
print('Parent: ' . $ServiceItem->getParentName() . "\n");

print("\n\n");

print_r($ServiceItem->asList(QUICKBOOKS_ADD_SERVICEITEM));

print($ServiceItem->asQBXML(QUICKBOOKS_ADD_SERVICEITEM));