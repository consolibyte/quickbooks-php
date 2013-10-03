<?php

require_once '../QuickBooks.php';

$qbxml='<ReceivePaymentRet>
    <TxnID>4ECE-1360116101</TxnID>
    <TimeCreated>2013-02-05T18:01:41-08:00</TimeCreated>
    <TimeModified>2013-02-05T18:01:41-08:00</TimeModified>
    <EditSequence>1360116101</EditSequence>
    <TxnNumber>523</TxnNumber>
    <CustomerRef>
        <ListID>80000017-1331869840</ListID>
        <FullName>Steve Anderson</FullName>
    </CustomerRef>
    <ARAccountRef>
        <ListID>8000000B-1218987298</ListID>
        <FullName>Accounts Receivable</FullName>
    </ARAccountRef>
    <TxnDate>2013-02-05</TxnDate>
    <RefNumber>456</RefNumber>
    <TotalAmount>399.77</TotalAmount>
    <PaymentMethodRef>
        <ListID>80000002-1218985625</ListID>
        <FullName>Check</FullName>
    </PaymentMethodRef>
    <DepositToAccountRef>
        <ListID>8000007C-1333734185</ListID>
        <FullName>Undeposited Funds</FullName>
    </DepositToAccountRef>
    <UnusedPayment>0.00</UnusedPayment>
    <UnusedCredits>0.00</UnusedCredits>
    <AppliedToTxnRet>
        <TxnID>4EB8-1347889479</TxnID>
        <TxnType>Invoice</TxnType>
        <TxnDate>2012-09-17</TxnDate>
        <RefNumber>21</RefNumber>
        <BalanceRemaining>0.00</BalanceRemaining>
        <Amount>100.00</Amount>
    </AppliedToTxnRet>
    <AppliedToTxnRet>
        <TxnID>4EBB-1360044733</TxnID>
        <TxnType>Invoice</TxnType>
        <TxnDate>2013-02-04</TxnDate>
        <BalanceRemaining>0.00</BalanceRemaining>
        <Amount>100.00</Amount>
        <LinkedTxn>
            <TxnID>4EBE-1360045371</TxnID>
            <TxnType>ReceivePayment</TxnType>
            <TxnDate>2013-02-04</TxnDate>
            <RefNumber>100</RefNumber>
            <LinkType>AMTTYPE</LinkType>
            <Amount>-100.00</Amount>
        </LinkedTxn>
    </AppliedToTxnRet>
    <AppliedToTxnRet>
        <TxnID>4EC8-1360116030</TxnID>
        <TxnType>Invoice</TxnType>
        <TxnDate>2013-02-05</TxnDate>
        <RefNumber>22</RefNumber>
        <BalanceRemaining>0.00</BalanceRemaining>
        <Amount>199.77</Amount>
    </AppliedToTxnRet>
</ReceivePaymentRet>';


$Object = QuickBooks_QBXML_Object::fromQBXML($qbxml, QUICKBOOKS_QUERY_RECEIVEPAYMENT);
//print out the object
print_r($Object);

$list = $Object->listAppliedToTxns();
foreach ($list as $AppliedToTxn)
{
	print_r($AppliedToTxn);
}

