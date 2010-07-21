<?php

//$url = 'http://localhost-nysmith/focus/qb/server.php';
//$url = 'http://localhost:8888/QuickBooks/example_mysql_mirror.php';
//$username = 'quickbooks';
//$password = 'password';

$url = 'http://localhost:8888/QuickBooks/example_mysql_mirror.php';
$username = 'quickbooks';
$password = 'password';
$url = 'http://localhost:8888/FiltaGroup/trunk/public/server.php';

if (function_exists('date_default_timezone_set'))
{
	date_default_timezone_set('America/New_York');
}

header('Content-type: text/plain');

print(date('Y-m-d H:i:s: ') . 'URL: ' . $url . "\n");
print(date('Y-m-d H:i:s: ') . 'User: ' . $username . "\n");
print(date('Y-m-d H:i:s: ') . 'Pass: ' . $password . "\n");

$return = tester($url, $username, $password, 'authenticate');

print(date('Y-m-d H:i:s: ') . 'RESPONSE: {{' . $return . '}}');

$pos = strpos($return, '<ns1:string>');
//$ticket = substr($return, $pos + 12, 32);		// FOR MD5 HASH TICKETS
$ticket = substr($return, $pos + 12, 36);		// FOR UUID TICKETS

print("\n\n" . date('Y-m-d H:i:s: ') . 'TICKET IS: [[' . $ticket . ']]' . "\n\n");


//exit;

$max = 1;
for ($i = 0; $i < $max; $i++)
{
	print(date('Y-m-d H:i:s: ') . tester($url, $ticket, null, 'sendRequestXML'));
}

exit;


$response = '<?xml version="1.0" ?>
<QBXML>
<QBXMLMsgsRs>
<AccountQueryRs requestID="QWNjb3VudFF1ZXJ5fG9sMzZ4c2dy" statusCode="0" statusSeverity="Info" statusMessage="Status OK">
<AccountRet>
<ListID>5B0001-1112732646</ListID>
<TimeCreated>2005-04-05T15:24:06-06:00</TimeCreated>
<TimeModified>2010-04-30T14:24:29-06:00</TimeModified>
<EditSequence>1272655469</EditSequence>
<Name>Bank-First National</Name>
<FullName>Bank-First National</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>Bank</AccountType>
<AccountNumber>1100</AccountNumber>
<Balance>56521.89</Balance>
<TotalBalance>56521.89</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>970002-1115680474</ListID>
<TimeCreated>2005-05-09T18:14:34-06:00</TimeCreated>
<TimeModified>2010-05-03T10:31:38-06:00</TimeModified>
<EditSequence>1267734584</EditSequence>
<Name>Arvest Bank</Name>
<FullName>Arvest Bank</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>Bank</AccountType>
<AccountNumber>1110</AccountNumber>
<Balance>24689.68</Balance>
<TotalBalance>24689.68</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>870001-1140557684</ListID>
<TimeCreated>2006-02-21T15:34:44-06:00</TimeCreated>
<TimeModified>2006-02-28T16:10:47-06:00</TimeModified>
<EditSequence>1140557684</EditSequence>
<Name>Receivable</Name>
<FullName>Receivable</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>AccountsReceivable</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000155-1234967398</ListID>
<TimeCreated>2009-02-18T08:29:58-06:00</TimeCreated>
<TimeModified>2009-02-18T08:29:58-06:00</TimeModified>
<EditSequence>1234967398</EditSequence>
<Name>Undeposited Funds</Name>
<FullName>Undeposited Funds</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>12000</AccountNumber>
<Desc>Funds received, but not yet d</Desc>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000148-1163624812</ListID>
<TimeCreated>2006-11-15T15:06:52-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1163624812</EditSequence>
<Name>FFE Reserve</Name>
<FullName>FFE Reserve</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>60229.49</Balance>
<TotalBalance>60229.49</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000147-1163624701</ListID>
<TimeCreated>2006-11-15T15:05:01-06:00</TimeCreated>
<TimeModified>2010-04-28T10:32:24-06:00</TimeModified>
<EditSequence>1163624701</EditSequence>
<Name>Prepaid Insurance Reserve</Name>
<FullName>Prepaid Insurance Reserve</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>30986.17</Balance>
<TotalBalance>30986.17</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000146-1163624658</ListID>
<TimeCreated>2006-11-15T15:04:18-06:00</TimeCreated>
<TimeModified>2010-04-28T10:32:24-06:00</TimeModified>
<EditSequence>1163624658</EditSequence>
<Name>Prepaid Property tax</Name>
<FullName>Prepaid Property tax</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>39425.64</Balance>
<TotalBalance>39425.64</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000145-1163624362</ListID>
<TimeCreated>2006-11-15T14:59:22-06:00</TimeCreated>
<TimeModified>2009-11-18T09:48:20-06:00</TimeModified>
<EditSequence>1163624362</EditSequence>
<Name>Monthly Prin and Int Reserve</Name>
<FullName>Monthly Prin and Int Reserve</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>7E0001-1134065451</ListID>
<TimeCreated>2005-12-08T12:10:51-06:00</TimeCreated>
<TimeModified>2005-12-08T12:11:04-06:00</TimeModified>
<EditSequence>1134065464</EditSequence>
<Name>Note Receivables</Name>
<FullName>Note Receivables</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>327760.27</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>8000015B-1262895173</ListID>
<TimeCreated>2010-01-07T14:12:53-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1262895173</EditSequence>
<Name>Note Rec. - Wells Fargo Bank</Name>
<FullName>Note Receivables:Note Rec. - Wells Fargo Bank</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>3537.08</Balance>
<TotalBalance>3537.08</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000143-1163521901</ListID>
<TimeCreated>2006-11-14T10:31:41-06:00</TimeCreated>
<TimeModified>2007-06-21T14:36:03-06:00</TimeModified>
<EditSequence>1163521901</EditSequence>
<Name>Note Rec. - AL Partners, LLC</Name>
<FullName>Note Receivables:Note Rec. - AL Partners, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>1E0002-1161358725</ListID>
<TimeCreated>2006-10-20T10:38:45-06:00</TimeCreated>
<TimeModified>2007-08-22T12:19:09-06:00</TimeModified>
<EditSequence>1162311689</EditSequence>
<Name>Note Rec. - Leisure Hospitality</Name>
<FullName>Note Receivables:Note Rec. - Leisure Hospitality</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>2C0002-1160498933</ListID>
<TimeCreated>2006-10-10T11:48:53-06:00</TimeCreated>
<TimeModified>2007-06-21T08:16:49-06:00</TimeModified>
<EditSequence>1160498933</EditSequence>
<Name>Note Rec. - Total Self Storage</Name>
<FullName>Note Receivables:Note Rec. - Total Self Storage</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>8B0002-1150137677</ListID>
<TimeCreated>2006-06-12T13:41:17-06:00</TimeCreated>
<TimeModified>2007-11-28T15:48:53-06:00</TimeModified>
<EditSequence>1153508697</EditSequence>
<Name>Note Rec. - VP Partners 6, LLC</Name>
<FullName>Note Receivables:Note Rec. - VP Partners 6, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>4E0002-1151343549</ListID>
<TimeCreated>2006-06-26T12:39:09-06:00</TimeCreated>
<TimeModified>2008-09-16T15:17:30-06:00</TimeModified>
<EditSequence>1151343549</EditSequence>
<Name>Note Rec. - Whitt, Inc.</Name>
<FullName>Note Receivables:Note Rec. - Whitt, Inc.</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>790001-1145973017</ListID>
<TimeCreated>2006-04-25T08:50:17-06:00</TimeCreated>
<TimeModified>2006-06-20T15:59:45-06:00</TimeModified>
<EditSequence>1145973017</EditSequence>
<Name>Note Rec. - Total Bentonville</Name>
<FullName>Note Receivables:Note Rec. - Total Bentonville</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>1D0001-1144935345</ListID>
<TimeCreated>2006-04-13T08:35:45-06:00</TimeCreated>
<TimeModified>2006-05-25T14:28:29-06:00</TimeModified>
<EditSequence>1144938923</EditSequence>
<Name>Note Rec. - Whitt Properties</Name>
<FullName>Note Receivables:Note Rec. - Whitt Properties</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>860001-1141241905</ListID>
<TimeCreated>2006-03-01T13:38:25-06:00</TimeCreated>
<TimeModified>2006-04-07T08:14:28-06:00</TimeModified>
<EditSequence>1142614351</EditSequence>
<Name>Note Rec. - Tampa Innkeepers</Name>
<FullName>Note Receivables:Note Rec. - Tampa Innkeepers</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>670001-1116284048</ListID>
<TimeCreated>2005-05-16T17:54:08-06:00</TimeCreated>
<TimeModified>2008-09-16T15:17:30-06:00</TimeModified>
<EditSequence>1134065469</EditSequence>
<Name>Note Rec. - CS Partners, LLC</Name>
<FullName>Note Receivables:Note Rec. - CS Partners, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>1C0004-1132008479</ListID>
<TimeCreated>2005-11-14T16:47:59-06:00</TimeCreated>
<TimeModified>2010-03-23T14:01:43-06:00</TimeModified>
<EditSequence>1134065459</EditSequence>
<Name>Note Rec. - CSK Management, LLC</Name>
<FullName>Note Receivables:Note Rec. - CSK Management, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>324223.19</Balance>
<TotalBalance>324223.19</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>4A0000-1099519043</ListID>
<TimeCreated>2004-11-03T16:57:23-06:00</TimeCreated>
<TimeModified>2006-05-24T09:23:00-06:00</TimeModified>
<EditSequence>1134065474</EditSequence>
<Name>Note Rec. - VP Partners 2, LLC</Name>
<FullName>Note Receivables:Note Rec. - VP Partners 2, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>520000-1109109005</ListID>
<TimeCreated>2005-02-22T15:50:05-06:00</TimeCreated>
<TimeModified>2007-06-13T08:17:32-06:00</TimeModified>
<EditSequence>1134065480</EditSequence>
<Name>Note Rec. - VP Partners 3, LLC</Name>
<FullName>Note Receivables:Note Rec. - VP Partners 3, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>650001-1116283279</ListID>
<TimeCreated>2005-05-16T17:41:19-06:00</TimeCreated>
<TimeModified>2008-09-16T15:19:55-06:00</TimeModified>
<EditSequence>1134065485</EditSequence>
<Name>Note Rec. - VP Partners 4, LLC</Name>
<FullName>Note Receivables:Note Rec. - VP Partners 4, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>730001-1142892687</ListID>
<TimeCreated>2006-03-20T17:11:27-06:00</TimeCreated>
<TimeModified>2007-07-31T15:29:14-06:00</TimeModified>
<EditSequence>1142892687</EditSequence>
<Name>Note Rec. - VP Partners 5, LLC</Name>
<FullName>Note Receivables:Note Rec. - VP Partners 5, LLC</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>7E0001-1134065451</ListID>
<FullName>Note Receivables</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>610000-1112730765</ListID>
<TimeCreated>2005-04-05T14:52:45-06:00</TimeCreated>
<TimeModified>2005-04-05T15:32:21-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Current Assets</Name>
<FullName>Current Assets</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>15769.54</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>550002-1141741516</ListID>
<TimeCreated>2006-03-07T08:25:16-06:00</TimeCreated>
<TimeModified>2007-01-20T12:34:41-06:00</TimeModified>
<EditSequence>1148582394</EditSequence>
<Name>Prepaid IT Expense</Name>
<FullName>Current Assets:Prepaid IT Expense</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>E0001-1118851489</ListID>
<TimeCreated>2005-06-15T11:04:49-06:00</TimeCreated>
<TimeModified>2010-04-13T11:38:46-06:00</TimeModified>
<EditSequence>1118851489</EditSequence>
<Name>Hotel Safe</Name>
<FullName>Current Assets:Hotel Safe</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1020</AccountNumber>
<Balance>400.00</Balance>
<TotalBalance>400.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>640000-1112730765</ListID>
<TimeCreated>2005-04-05T14:52:45-06:00</TimeCreated>
<TimeModified>2010-05-03T08:30:13-06:00</TimeModified>
<EditSequence>1118234120</EditSequence>
<Name>Folio Accounts Receivable</Name>
<FullName>Current Assets:Folio Accounts Receivable</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1030</AccountNumber>
<Balance>1652.05</Balance>
<TotalBalance>1652.05</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>200001-1118234584</ListID>
<TimeCreated>2005-06-08T07:43:04-06:00</TimeCreated>
<TimeModified>2010-05-03T08:30:13-06:00</TimeModified>
<EditSequence>1121889719</EditSequence>
<Name>Credit Cards Receivable</Name>
<FullName>Current Assets:Credit Cards Receivable</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1035</AccountNumber>
<Balance>12822.66</Balance>
<TotalBalance>12822.66</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>660000-1112730765</ListID>
<TimeCreated>2005-04-05T14:52:45-06:00</TimeCreated>
<TimeModified>2010-05-03T08:28:35-06:00</TimeModified>
<EditSequence>1116244672</EditSequence>
<Name>Direct Bill</Name>
<FullName>Current Assets:Direct Bill</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1040</AccountNumber>
<Balance>907.60</Balance>
<TotalBalance>907.60</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>B70001-1121903414</ListID>
<TimeCreated>2005-07-20T18:50:14-06:00</TimeCreated>
<TimeModified>2005-07-20T18:51:37-06:00</TimeModified>
<EditSequence>1121903497</EditSequence>
<Name>NSF Checks Receivable</Name>
<FullName>Current Assets:NSF Checks Receivable</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1041</AccountNumber>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>6B0000-1112730765</ListID>
<TimeCreated>2005-04-05T14:52:45-06:00</TimeCreated>
<TimeModified>2009-06-19T09:29:58-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Prepaid Property Ins</Name>
<FullName>Current Assets:Prepaid Property Ins</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1065</AccountNumber>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>6C0000-1112730765</ListID>
<TimeCreated>2005-04-05T14:52:45-06:00</TimeCreated>
<TimeModified>2009-06-19T09:29:58-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Prepaid Work Comp Ins</Name>
<FullName>Current Assets:Prepaid Work Comp Ins</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1066</AccountNumber>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>800002-1133306372</ListID>
<TimeCreated>2005-11-29T17:19:32-06:00</TimeCreated>
<TimeModified>2009-06-19T09:32:07-06:00</TimeModified>
<EditSequence>1133306372</EditSequence>
<Name>Prepaid Fire Alarm Monitoring</Name>
<FullName>Current Assets:Prepaid Fire Alarm Monitoring</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1067</AccountNumber>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>4D0001-1133306419</ListID>
<TimeCreated>2005-11-29T17:20:19-06:00</TimeCreated>
<TimeModified>2009-06-19T09:32:07-06:00</TimeModified>
<EditSequence>1133306419</EditSequence>
<Name>Prepaid Elevator Maintenance</Name>
<FullName>Current Assets:Prepaid Elevator Maintenance</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1068</AccountNumber>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>8000015D-1264520825</ListID>
<TimeCreated>2010-01-26T09:47:05-06:00</TimeCreated>
<TimeModified>2010-04-13T11:45:39-06:00</TimeModified>
<EditSequence>1264520825</EditSequence>
<Name>2010 Water Damage</Name>
<FullName>Current Assets:2010 Water Damage</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>610000-1112730765</ListID>
<FullName>Current Assets</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentAsset</AccountType>
<AccountNumber>1090</AccountNumber>
<Balance>-12.77</Balance>
<TotalBalance>-12.77</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>710000-1112730765</ListID>
<TimeCreated>2005-04-05T14:52:45-06:00</TimeCreated>
<TimeModified>2005-04-05T15:32:21-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Property and Equipment</Name>
<FullName>Property and Equipment</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>3385731.52</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>D0002-1158758856</ListID>
<TimeCreated>2006-09-20T08:27:36-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1169319225</EditSequence>
<Name>Loan Closing Costs</Name>
<FullName>Property and Equipment:Loan Closing Costs</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>2434.87</Balance>
<TotalBalance>2434.87</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000149-1163624926</ListID>
<TimeCreated>2006-11-15T15:08:46-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1169318937</EditSequence>
<Name>Closing costs to amortize</Name>
<FullName>Property and Equipment:Closing costs to amortize</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>72025.29</Balance>
<TotalBalance>72025.29</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>450000-1094051770</ListID>
<TimeCreated>2004-09-01T10:16:10-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1148582278</EditSequence>
<Name>Soft Costs</Name>
<FullName>Property and Equipment:Soft Costs</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>74398.25</Balance>
<TotalBalance>74398.25</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>410000-1093372422</ListID>
<TimeCreated>2004-08-24T13:33:42-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1148582262</EditSequence>
<Name>Franchise Fee</Name>
<FullName>Property and Equipment:Franchise Fee</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>36000.00</Balance>
<TotalBalance>36000.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>420000-1093372451</ListID>
<TimeCreated>2004-08-24T13:34:11-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1148582243</EditSequence>
<Name>Development Fee</Name>
<FullName>Property and Equipment:Development Fee</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>20000.00</Balance>
<TotalBalance>20000.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>700000-1112730765</ListID>
<TimeCreated>2005-04-05T14:52:45-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1148582225</EditSequence>
<Name>Accumulated Depreciation</Name>
<FullName>Property and Equipment:Accumulated Depreciation</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>-880196.73</Balance>
<TotalBalance>-880196.73</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>510000-1108505934</ListID>
<TimeCreated>2005-02-15T16:18:54-06:00</TimeCreated>
<TimeModified>2010-03-10T11:59:56-06:00</TimeModified>
<EditSequence>1148582196</EditSequence>
<Name>Accumulated Amortization</Name>
<FullName>Property and Equipment:Accumulated Amortization</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<Balance>-11979.30</Balance>
<TotalBalance>-11979.30</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>830001-1141572671</ListID>
<TimeCreated>2006-03-05T09:31:11-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1141572671</EditSequence>
<Name>Site Improvements 10 year</Name>
<FullName>Property and Equipment:Site Improvements 10 year</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1088</AccountNumber>
<Balance>20500.00</Balance>
<TotalBalance>20500.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>850002-1141571867</ListID>
<TimeCreated>2006-03-05T09:17:47-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1141572509</EditSequence>
<Name>Site Improvements 15 year</Name>
<FullName>Property and Equipment:Site Improvements 15 year</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1087</AccountNumber>
<Balance>72809.00</Balance>
<TotalBalance>72809.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>4B0000-1100962054</ListID>
<TimeCreated>2004-11-20T08:47:34-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1134062570</EditSequence>
<Name>Land</Name>
<FullName>Property and Equipment:Land</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1070</AccountNumber>
<Balance>727999.03</Balance>
<TotalBalance>727999.03</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>720000-1112730766</ListID>
<TimeCreated>2005-04-05T14:52:46-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Building</Name>
<FullName>Property and Equipment:Building</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1075</AccountNumber>
<Balance>2545414.39</Balance>
<TotalBalance>2545414.39</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>500000-1108505537</ListID>
<TimeCreated>2005-02-15T16:12:17-06:00</TimeCreated>
<TimeModified>2010-02-28T14:51:20-06:00</TimeModified>
<EditSequence>1134080200</EditSequence>
<Name>Construction Period Interest</Name>
<FullName>Property and Equipment:Construction Period Interest</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1078</AccountNumber>
<Balance>83249.62</Balance>
<TotalBalance>83249.62</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>740000-1112730766</ListID>
<TimeCreated>2005-04-05T14:52:46-06:00</TimeCreated>
<TimeModified>2010-03-03T15:09:21-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Furniture and Fixtures</Name>
<FullName>Property and Equipment:Furniture and Fixtures</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1080</AccountNumber>
<Balance>551831.87</Balance>
<TotalBalance>551831.87</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>760000-1112730766</ListID>
<TimeCreated>2005-04-05T14:52:46-06:00</TimeCreated>
<TimeModified>2005-04-05T15:32:21-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Preopening Construction</Name>
<FullName>Property and Equipment:Preopening Construction</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1085</AccountNumber>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>4F0000-1105116411</ListID>
<TimeCreated>2005-01-07T10:46:51-06:00</TimeCreated>
<TimeModified>2010-04-28T10:52:11-06:00</TimeModified>
<EditSequence>1134062638</EditSequence>
<Name>Computer/Communications</Name>
<FullName>Property and Equipment:Computer/Communications</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>710000-1112730765</ListID>
<FullName>Property and Equipment</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>FixedAsset</AccountType>
<AccountNumber>1086</AccountNumber>
<Balance>71245.23</Balance>
<TotalBalance>71245.23</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>4C0001-1134065576</ListID>
<TimeCreated>2005-12-08T12:12:56-06:00</TimeCreated>
<TimeModified>2005-12-08T12:12:56-06:00</TimeModified>
<EditSequence>1134065576</EditSequence>
<Name>Other Assets</Name>
<FullName>Other Assets</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherAsset</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>440000-1094048854</ListID>
<TimeCreated>2004-09-01T09:27:34-06:00</TimeCreated>
<TimeModified>2010-04-30T14:24:01-06:00</TimeModified>
<EditSequence>1112733141</EditSequence>
<Name>Accounts Payable</Name>
<FullName>Accounts Payable</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>AccountsPayable</AccountType>
<Balance>-434.00</Balance>
<TotalBalance>-434.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000150-1206638794</ListID>
<TimeCreated>2008-03-27T12:26:34-06:00</TimeCreated>
<TimeModified>2008-12-10T07:40:05-06:00</TimeModified>
<EditSequence>1206638794</EditSequence>
<Name>Direct Deposit Liabilities</Name>
<FullName>Direct Deposit Liabilities</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentLiability</AccountType>
<AccountNumber>2110</AccountNumber>
<Desc>Direct Deposit Liabilities</Desc>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>530001-1134065758</ListID>
<TimeCreated>2005-12-08T12:15:58-06:00</TimeCreated>
<TimeModified>2005-12-08T12:15:58-06:00</TimeModified>
<EditSequence>1134065758</EditSequence>
<Name>Notes Payable</Name>
<FullName>Notes Payable</FullName>
<IsActive>true</IsActive>
<Sublevel>0</Sublevel>
<AccountType>OtherCurrentLiability</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000159-1249050109</ListID>
<TimeCreated>2009-07-31T09:21:49-06:00</TimeCreated>
<TimeModified>2010-04-30T14:12:19-06:00</TimeModified>
<EditSequence>1249050109</EditSequence>
<Name>Note Payable - CSK AM Express</Name>
<FullName>Notes Payable:Note Payable - CSK AM Express</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>530001-1134065758</ListID>
<FullName>Notes Payable</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentLiability</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>80000151-1210256157</ListID>
<TimeCreated>2008-05-08T09:15:57-06:00</TimeCreated>
<TimeModified>2008-08-15T08:50:52-06:00</TimeModified>
<EditSequence>1210256157</EditSequence>
<Name>Note Payable - VP Partners 3</Name>
<FullName>Notes Payable:Note Payable - VP Partners 3</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>530001-1134065758</ListID>
<FullName>Notes Payable</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentLiability</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet>
<AccountRet>
<ListID>8000014A-1163625919</ListID>
<TimeCreated>2006-11-15T15:25:19-06:00</TimeCreated>
<TimeModified>2010-03-23T14:01:43-06:00</TimeModified>
<EditSequence>1207757400</EditSequence>
<Name>Note Payable - CSK</Name>
<FullName>Notes Payable:Note Payable - CSK</FullName>
<IsActive>true</IsActive>
<ParentRef>
<ListID>530001-1134065758</ListID>
<FullName>Notes Payable</FullName>
</ParentRef>
<Sublevel>1</Sublevel>
<AccountType>OtherCurrentLiability</AccountType>
<Balance>0.00</Balance>
<TotalBalance>0.00</TotalBalance>
</AccountRet></AccountQueryRs>
</QBXMLMsgsRs>
</QBXML>';

print(tester($url, $ticket, null, 'receiveResponseXML', $response));

exit;

function tester($url, $username_or_ticket, $password, $method, $data = null)
{
	print(date('Y-m-d H:i:s: ') . 'Sending request method: ' . $method . "\n");
	
	switch ($method)
	{
		case 'authenticate':
			$soap = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
 xmlns:xsd="http://www.w3.org/2001/XMLSchema"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
 xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
 SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"
 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
	<SOAP-ENV:Body>
		<authenticate xmlns="http://developer.intuit.com/">
			<strUserName xsi:type="xsd:string">' . $username_or_ticket . '</strUserName>
			<strPassword xsi:type="xsd:string">' . $password . '</strPassword>
		</authenticate>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
			break;
		case 'sendRequestXML':
			$soap = '<?xml version="1.0" encoding="UTF-8"?>
	<SOAP-ENV:Envelope 
	 xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
	 xmlns:ns1="http://developer.intuit.com/">
		<SOAP-ENV:Body>
			<ns1:sendRequestXML>
				<ns1:ticket>' . $username_or_ticket . '</ns1:ticket>
				<ns1:strHCPResponse></ns1:strHCPResponse>
				<ns1:strCompanyFileName></ns1:strCompanyFileName>
				<ns1:qbXMLCountry>UK</ns1:qbXMLCountry>
				<ns1:qbXMLMajorVers>3</ns1:qbXMLMajorVers>
				<ns1:qbXMLMinorVers>0</ns1:qbXMLMinorVers>
			</ns1:sendRequestXML>
		</SOAP-ENV:Body>
	</SOAP-ENV:Envelope>';
			break;
		case 'receiveResponseXML':
			$soap = '<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
				<soap:Body>
					<receiveResponseXML xmlns="http://developer.intuit.com/">
						<ticket>' . $username_or_ticket . '</ticket>
						<response>' . htmlspecialchars($data, ENT_QUOTES) . '</response>
						<hresult />
						<message />
					</receiveResponseXML>
				</soap:Body>
			</soap:Envelope>';
			break;
	}
	
	$headers = array(
		'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; MS Web Services Client Protocol 2.0.50727.1433)', 
		'Content-Type: text/xml; charset=utf-8',
		'Soapaction: "http://developer.intuit.com/' . $method . '"',
		);

	if (function_exists('curl_init'))
	{
		$curl = curl_init($url); 
		
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		
		
		curl_setopt($curl, CURLOPT_POSTFIELDS, $soap);
		
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FORBID_REUSE, true);
		curl_setopt($curl, CURLOPT_FRESH_CONNECT, true);
		curl_setopt($curl, CURLOPT_MAXCONNECTS, 1);
		
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		
		$return = curl_exec($curl);
	}
	else
	{
		$parse = parse_url($url);
		if (empty($parse['port']))
		{
			$parse['port'] = 80;
		}
		
		if ($parse['scheme'] == 'https')
		{
			die('sorry, you need curl to test https (for now at least)');
		}
		
		if ($fp = fsockopen($parse['host'], $parse['port']))
		{
			$request = '';
			$request .= 'POST ' . $parse['path'] . '?' . $parse['query'] . ' HTTP/1.0' . "\r\n";
			$request .= 'Host: ' . $parse['host'] . "\r\n";
			
			foreach ($headers as $key => $value)
			{
				//$request .= $key . ': ' . $value . "\r\n";
				$request .= $value . "\r\n";
			}
			
			$request .= 'Content-Length: ' . strlen($soap) ."\r\n"; 
			$request .= 'Connection: close' . "\r\n";
			$request .= "\r\n"; 
			$request .= $soap; 
			
			print(str_repeat('-', 20) . ' REQUEST ' . str_repeat('-', 20) . "\n");
			print($request . "\n");
			print(str_repeat('-', 48) . "\n");
			
			fputs($fp, $request);
				
			$bytes = 0;
			$resp = '';
			while (!feof($fp) and $bytes < 10000) 
			{ 
				$tmp = fgets($fp, 128);
				$bytes += strlen($tmp);
				
				$resp .= $tmp; 
			}
			
			print(str_repeat('-', 19) . ' RESPONSE ' . str_repeat('-', 19) . "\n");	
			print($resp . "\n");
			print(str_repeat('-', 48) . "\n");
			print("\n\n");
				
			fclose($fp);	
		}
		else
		{
			die('Connection failed!');
		}
			
		$return = $resp;
	}
	
	return $return;
}
