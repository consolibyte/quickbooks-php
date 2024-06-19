<?php

require_once __DIR__ . '/../QuickBooks.php';



$arr = array(
	'Cable&Atilde;‚&Acirc;&nbsp;Raceway/Wire Chase,&Atilde;‚&Acirc;&nbsp;1.25&quot; x 6\', White', 
	' Ã â ',
	'desempeños artísticos', 
	'Zugängliche', 
	'investigación',
	'desempeños artísticos', 
	'desempeños artísticos', 
	'Zugängliche investigación', 
	);

foreach ($arr as $str)
{
	print('

{' . QuickBooks_Cast::cast(QUICKBOOKS_ADD_INVOICE, 'InvoiceLineAdd Desc', html_entity_decode($str)) . '}' . "\n\n");
}