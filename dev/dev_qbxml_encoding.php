<?php

require_once '../QuickBooks.php';



$arr = array(
	'Cable&Atilde;‚&Acirc;&nbsp;Raceway/Wire Chase,&Atilde;‚&Acirc;&nbsp;1.25&quot; x 6\', White', 
	' Ã â ',
	);

foreach ($arr as $str)
{
	print("\n\n" . '{' . QuickBooks_Cast::cast(QUICKBOOKS_ADD_INVOICE, 'InvoiceLineAdd Desc', html_entity_decode($str)) . '}' . "\n\n");
}