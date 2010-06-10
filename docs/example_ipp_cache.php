<?php

$dsn = 'mysql://root:root@localhost/quickbooks_ipp';

$adapter = QuickBooks_IPP_Cache::ADAPTER_QBXML;
//$adapter = QuickBooks_IPP_Cache::ADAPTER_IDS;

$Cache = new QuickBooks_IPP_Cache($dsn, $adapter, $user);

if (!$Cache->




