<?php

require_once dirname(__FILE__) . '/config.php';

$InvoiceService = new QuickBooks_IPP_Service_Invoice();

print $InvoiceService->send($Context, $realm, 280);
