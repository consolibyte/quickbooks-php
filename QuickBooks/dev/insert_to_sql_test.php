<?php

require_once '../../QuickBooks.php';

$instance = QuickBooks_Driver_Singleton::getInstance('mysql://root:@localhost/quickbooks');

$requestID = '';
$user = 'sql';
$ID = 'bla';
$extra = null;
$err = '';
$xml = '';
$idents = array();
$last_action_time = 0;
$last_actionident_time = 0;

$action = 'CustomerQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/CustomerQuery.xml');
QuickBooks_Server_SQL_Callbacks::CustomerQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

$action = 'InvoiceQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/InvoiceQuery.xml');
QuickBooks_Server_SQL_Callbacks::InvoiceQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

$action = 'AccountQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/AccountQuery.xml');
QuickBooks_Server_SQL_Callbacks::AccountQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

$action = 'EmployeeQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/EmployeeQuery.xml');
QuickBooks_Server_SQL_Callbacks::EmployeeQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

$action = 'ClassQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/ClassQuery.xml');
QuickBooks_Server_SQL_Callbacks::ClassQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

$action = 'ItemQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/ItemQuery.xml');
QuickBooks_Server_SQL_Callbacks::ItemQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

$action = 'VendorQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/VendorQuery.xml');
QuickBooks_Server_SQL_Callbacks::VendorQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

$action = 'TermsQuery';
$xml = file_get_contents(dirname(__FILE__) . '/../docs/responses/TermsQuery.xml');
QuickBooks_Server_SQL_Callbacks::TermsQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);


?>
