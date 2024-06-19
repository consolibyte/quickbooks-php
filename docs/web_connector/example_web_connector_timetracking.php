<?php

function _quickbooks_timetracking_add_request(string $requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, string $version, $locale)
{
	$data = array(
		'TxnDate' => date('Y-m-d'), 
		'Entity_FullName' => 'My Vendor Name', 
		'Customer_FullName' => 'My Customer Name', 
		'ItemService_FullName' => 'My Item Name', 
		'Duration' => 'PT2H0M0S', 
		'PayrollItemWage_FullName' => 'Payroll Item Name', 
		'Notes' => '', 
		'BillableStatus' => 'Billable', 
		);

	return '<?xml version="1.0" encoding="utf-8"?>
		<?qbxml version="' . $version . '"?>
		<QBXML>
		  <QBXMLMsgsRq onError="stopOnError">
		    <TimeTrackingAddRq requestID="' . $requestID . '">
		      <TimeTrackingAdd>
		        <TxnDate>' . $data['TxnDate'] . '</TxnDate>
		 
		        <EntityRef>
		          <FullName>' . $data['Entity_FullName'] . '</FullName>
		        </EntityRef>
		 
		        <CustomerRef>
		          <FullName>' . $data['Customer_FullName'] . '</FullName>
		        </CustomerRef>
		 
		        <ItemServiceRef>
		          <FullName>' . $data['ItemService_FullName'] . '</FullName>
		        </ItemServiceRef>
		 
		        <Duration>' . $data['Duration'] . '</Duration>
		 
		        <PayrollItemWageRef>
		          <FullName>' . $data['PayrollItemWage_FullName'] . '</FullName>
		        </PayrollItemWageRef>
		 
		        <Notes>' . $data['Notes'] . '</Notes>
		 
		        <!-- BillableStatus may have one of the following values: Billable, NotBillable, HasBeenBilled -->
		        <BillableStatus>' . $data['BillableStatus'] . '</BillableStatus>
		 
		      </TimeTrackingAdd>
		    </TimeTrackingAddRq>
		  </QBXMLMsgsRq>
		</QBXML>';
}

function _quickbooks_timetracking_add_response($requestID, $user, $action, $ID, $extra, &$err, $last_action_time, $last_actionident_time, $xml, $idents)
{	
	
}