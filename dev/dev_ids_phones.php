<?php

require_once '../QuickBooks.php';
 
// Create our customer object
$Customer = new QuickBooks_IPP_Object_Customer();

// Set the name of the customer (a UNIQUE PRIMARY KEY in QuickBooks)
$Customer->setName('Brand New Customer #' . mt_rand(0, 100));

// Set the first name
$Customer->setGivenName('Keith');

// Set the last name
$Customer->setFamilyName('Palmer');

// Create the address
$Address = new QuickBooks_IPP_Object_Address();
$Address->setLine1('56 Cowles Road');
$Address->setCity('Willington');
$Address->setCountrySubDivisionCode('CT');
$Address->setPostalCode('06279');
$Address->setTag('Billing');

// Add the address to the customer
$Customer->addAddress($Address);

$Phone = new QuickBooks_IPP_Object_Phone();
$Phone->setFreeFormNumber('1-860-634-1602');

$Customer->addPhone($Phone);

$Phone = new QuickBooks_IPP_Object_Phone();
$Phone->setFreeFormNumber('1-203-687-5504');

$Customer->addPhone($Phone);

print($Customer->asIDSXML());