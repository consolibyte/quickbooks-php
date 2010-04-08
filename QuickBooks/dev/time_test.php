<?php

date_default_timezone_set('America/New_York');

$str = '2008-06-24T23:53:54-05:00';

print('Date/Time is: ' . date('Y-m-d H:i:s', strtotime($str)) . "\n\n");

?>