<?php

require_once dirname(__FILE__) . '/config.php';

require_once dirname(__FILE__) . '/views/header.tpl.php';

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
				<li><a href="example_customer_query.php">Show me my QuickBooks customers</a></li>
				<li><a href="example_customer_add.php">Add a customer to QuickBooks</a></li>
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