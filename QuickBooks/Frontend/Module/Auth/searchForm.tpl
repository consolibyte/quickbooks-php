
<h1>
	View Users
</h1>

<p>
	This section of the module allows you to view and search for 
	<?php print($this->_('quickbooks_package_name')); ?> users. 
</p>

<div class="form">

	<form method="get" action="<?php print($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="MOD" value="auth" />
		<input type="hidden" name="DO" value="searchResult" />
		
		<div class="submit">
			<input type="submit" value="View Users &raquo;" />
		</div>
	</form>
	
</div>