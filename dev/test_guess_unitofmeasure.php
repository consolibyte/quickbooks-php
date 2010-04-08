<?php

require_once '../QuickBooks.php';

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

$cart_unitofmeasure = null;
$cart_weight = 2.5; $cart_quantity = 1;
$cart_weight = 5.0; $cart_quantity = 2;

$Driver = QuickBooks_Driver_Factory::create('mysql://root:root@localhost/quickbooks_foxycart');
$API = new QuickBooks_API('mysql://root:root@localhost/quickbooks_foxycart', 'test.consolibyte.com', QUICKBOOKS_API_SOURCE_WEB);

$Integrator = new QuickBooks_Integrator_Foxycart($Driver, array(), $API);

$arr_qb_unitofmeasure_names = $Integrator->_listUnitOfMeasureMap();

//print_r($arr_qb_unitofmeasure_names);

$choice = QuickBooks_Integrator::_guessQuickBooksUnitOfMeasure($cart_unitofmeasure, $cart_weight, $cart_quantity, $arr_qb_unitofmeasure_names);

print('CHOICE: ' . $choice);

print("\n\n");