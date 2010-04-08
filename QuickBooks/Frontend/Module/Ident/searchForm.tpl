
<h1>
	View Associations
</h1>

<p>
	Associations are stored mappings between QuickBooks unique IDs (ListIDs, 
	TxnIDs, etc.) and the unique primary keys from your application. You can 
	utilize associations within your application to simplify the process of 
	associating records from your application with QuickBooks records. 
</p>

<div class="form">

	<form method="get" action="<?php print($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="MOD" value="ident" />
		<input type="hidden" name="DO" value="searchResult" />
		
		<div class="submit">
			<input type="submit" value="View Associations &raquo;" />
		</div>
	</form>
	
</div>