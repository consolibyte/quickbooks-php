<html>
	<head>
		<title>QuickBooks Web Connector example</title>
	</head>
	<body>
	
		<form method="post" action="handler.php">
			<input type="hidden" name="submitted" value="1" />
			
			<table>
				<tr>
					<td>
						Company Name
					</td>
					<td>
						<input type="text" name="name" value="" />
					</td>
				</tr>
				<tr>
					<td>
						First Name
					</td>
					<td>
						<input type="text" name="fname" value="" />
					</td>
				</tr>
				<tr>
					<td>
						Last Name
					</td>
					<td>
						<input type="text" name="lname" value="" />
					</td>
				</tr>
			</table>
			
			<input type="submit" value="Queue up the customer!" />
			
		</form>
		
	</body>
</html>