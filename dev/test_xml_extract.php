<?php

require_once '../QuickBooks.php';

$data = '<QBXML><something>stuff</something><CustomerQueryRs iteratorRemainingCount="364q34" iteratorID="{1234-1234-1234}">...</CustomerQueryRs></QBXML>';

print('contents: ' . QuickBooks_XML::extractTagContents('something', $data) . "\n");
print('attribute: ' . QuickBooks_XML::extractTagAttribute('iteratorRemainingCount', $data) . "\n");

$data = '<CustomerQueryRs iteratorRemainingCount="123" iteratorID="{1234-1234-1234}">';
print('attribuets: ' . print_r(QuickBooks_XML::extractTagAttributes($data, true), true) . "\n");