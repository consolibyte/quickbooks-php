<?php

require_once '/Users/kpalmer/Projects/QuickBooks/QuickBooks.php';

/*
$filter = null;
$return_keys = false;
$order_for_mapping = true;

print_r(QuickBooks_Utilities::listObjects($filter, $return_keys, $order_for_mapping));

print('object: ' . QuickBooks_Utilities::actionToObject(QUICKBOOKS_ADD_NONINVENTORYITEM));

print("\n\n");
*/

$Check = new QuickBooks_Object_Check();
$Check->setRefNumber('1234');
$Check->setTxnDate('2009-05-02');

$ItemLine = new QuickBooks_Object_Check_ItemLine();
$ItemLine->setItemName('test');

$Check->addItemLine($ItemLine);

print_r($Check);

print($Check->asQBXML(QUICKBOOKS_ADD_CHECK));

?>