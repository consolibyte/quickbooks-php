<?php

ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR . realpath('../../'));

require_once 'QuickBooks.php';

require_once 'QuickBooks/Server/API/Callbacks.php';

$xml = file_get_contents('responses/class.xml');
$xml = file_get_contents('responses/account.xml');

$requestID = '';
$user = 'api';
$action = 'ClassQuery';
$action = 'AccountQuery';
$ID = 'adsga';
$extra = array( 'callbacks' => array( 'callback_test' ) );
$err = '';
$last_action_time = '';
$last_actionident_time = '';
$idents = array();



//QuickBooks_Server_API_Callbacks::ClassQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);
QuickBooks_Server_API_Callbacks::AccountQueryResponse($requestID, $user, $action, $ID, $extra, $err, $last_action_time, $last_actionident_time, $xml, $idents);

function callback_test($method, $action, $ID, $err, $qbxml, $qbiterator, $qbres)
{
	//print($qbxml);
	
	print_r($qbiterator);
}

?>