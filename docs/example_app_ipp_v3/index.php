<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

$examples = array();

$dh = opendir(dirname(__FILE__));
while (false !== ($file = readdir($dh)))
{
	if (substr($file, 0, 7) != 'example') 
	{ 
		continue; 
	}

	$tmp = explode('_', $file);
	switch (end($tmp))
	{
		case 'add.php':
			$examples[$file] = 'Add a ' . implode(' ', array_slice($tmp, 1, -1));
			break;
		case 'query.php':
			$examples[$file] = 'Query for ' . implode(' ', array_slice($tmp, 1, -1));
			break;
		case 'cdc.php';
			$examples[$file] = 'Get objects that have changed since a timestamp';
			break;
	}
}

?>

<div>
	<h1>
		Welcome to the QuickBooks PHP DevKit - IPP Intuit Anywhere Demo App!
	</h1>

	<p>
		QuickBooks connection status: 

		<?php if ($quickbooks_is_connected): ?>
			<div style="border: 2px solid green; text-align: center; padding: 8px; color: green;">
				CONNECTED!<br>
			</div>

			<h2>Example QuickBooks Stuff</h2>

			<ul>
				<?php foreach ($examples as $file => $title): ?>
					<li><a href="<?php print($file); ?>"><?php print($title); ?></a></li>
				<?php endforeach; ?>
			</ul>
			<ul>
				<li><a href="disconnect.php">Disconnect from QuickBooks</a></li>
			</ul>
			<ul>
				<li><a href="diagnostics.php">Diagnostics about QuickBooks connection</a></li>
			</ul>
		<?php else: ?>
			<div style="border: 2px solid red; text-align: center; padding: 8px; color: red;">
				<b>NOT</b> CONNECTED!<br>
				<br>
				<ipp:connectToIntuit></ipp:connectToIntuit>
			</div>	
		<?php endif; ?>		

	</p>
</div>

<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>