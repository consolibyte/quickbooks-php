<?php

require_once '/home/library_php/QuickBooks.php';

$dsn = 'mysql://root:Odnotnev9@localhost/quickbooks';

$user = 'mapping_test';

QuickBooks_Utilities::createMapping($dsn, $user, QUICKBOOKS_OBJECT_CUSTOMER, '1234-1234', 15);
print("\n");
print("\n");

print('App ID: ' . QuickBooks_Utilities::fetchApplicationID($dsn, $user, QUICKBOOKS_OBJECT_CUSTOMER, '1234-1234'));
print("\n");
print("\n");

print('QB ID: ' . QuickBooks_Utilities::fetchQuickbooksID($dsn, $user, QUICKBOOKS_OBJECT_CUSTOMER, 15));
print("\n");
print("\n");

?>