<?php

require_once '../QuickBooks.php';

$cart_paymentmethod = 'Visa';

$arr_qb_paymentmethod_names = array(
	'Cash', 
	'Check', 
	'American Express', 
	'Discover', 
	'Visa/Mastercard', 
	'Credit Card', 
	'Credit on Ad Account', 
	'Wire Transfer', 
	'PayPal', 
	'Mastercard', 
	);

$choice = QuickBooks_Integrator::_guessQuickBooksPaymentMethod($cart_paymentmethod, $arr_qb_paymentmethod_names);

print('CHOICE: ' . $choice);

print("\n\n");