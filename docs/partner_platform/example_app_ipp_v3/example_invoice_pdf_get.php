<?php

require_once dirname(__FILE__) . '/config.php';

$InvoiceService = new QuickBooks_IPP_Service_Invoice();

$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice STARTPOSITION 1 MAXRESULTS 1");
$invoice = reset($invoices);
$id = substr($invoice->getId(), 2, -1);

header("Content-Disposition: attachment; filename='example_invoice.pdf'");
header("Content-type: application/x-pdf");
print $InvoiceService->pdf($Context, $realm, $id);
