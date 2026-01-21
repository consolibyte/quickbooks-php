<html>
	<head>
		<title>Payments Test App</title>

		<!-- Every page of your app should have this snippet of Javascript in it, so that it can show the Blue Dot menu -->
		<script type="text/javascript" src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere.js"></script>
		<script type="text/javascript">
		intuit.ipp.anywhere.setup({
			menuProxy: '<?php print($quickbooks_menu_url); ?>',
			grantUrl: '<?php print($quickbooks_oauth_url); ?>',
			datasources: {
                 quickbooks : true,
                 payments : true
           }
		});
		</script>

		<style>

		table
		{
			margin-left: 20px;
			margin-right: 20px;
		}

		tr:nth-child(even) {background: #CCC}
		tr:nth-child(odd) {background: #EEE}

		td
		{
			padding: 4px;
		}

		</style>

	</head>
	<body>

		<?php if ($quickbooks_is_connected): ?>
			<ipp:blueDot></ipp:blueDot>
		<?php endif; ?>

