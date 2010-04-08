<?php

require_once '../../QuickBooks.php';

$value = 'KeithPalmerJrFirstNameHere';

print(QuickBooks_Cast::cast(QUICKBOOKS_OBJECT_CUSTOMER, 'Name', $value));

?>