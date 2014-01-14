<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

$err = '';
$reconnected = false;

$expiry = $IntuitAnywhere->expiry($the_username, $the_tenant);

if ($expiry == QuickBooks_IPP_IntuitAnywhere::EXPIRY_SOON)
{
	if ($IntuitAnywhere->reconnect($the_username, $the_tenant))
	{
		$reconnected = true;
	}
	else
	{
		$reconnected = false;
		$err = $IntuitAnywhere->errorNumber() . ': ' . $IntuitAnywhere->errorMessage();
	}
}
else if ($expiry == QuickBooks_IPP_IntuitAnywhere::EXPIRY_NOTYET)
{
	$err = 'This connection is not old enough to require reconnect/refresh.';
}
else if ($expiry == QuickBooks_IPP_IntuitAnywhere::EXPIRY_EXPIRED)
{
	$err = 'This connection has already expired. You\'ll have to go through the initial connection process again.';
}
else if ($expiry == QuickBooks_IPP_IntuitAnywhere::EXPIRY_UNKNOWN)
{
	$err = 'Are you sure you\'re connected? No connection information was found for this user/tenant...';
}

?>

	<?php if ($reconnected): ?>

		<div style="text-align: center; font-family: sans-serif; font-weight: bold; color: green">
			RECONNECTED! (refreshed OAuth tokens)
		</div>
		
	<?php else: ?>

		<div style="text-align: center; font-family: sans-serif; font-weight: bold; color: red">
			ERROR: <?php print($err); ?>
		</div>

	<?php endif; ?>
			
<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>