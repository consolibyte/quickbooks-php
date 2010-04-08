
<h1>
	View Server Log
</h1>

<p>
	This module allows you to view the <?php print($this->_('quickbooks_package_name')); ?> 
	log file or database table. 
</p>

<div class="form">

	<form method="get" action="<?php print($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="MOD" value="log" />
		<input type="hidden" name="DO" value="view" />
		
		<div class="submit">
			<input type="submit" value="View Log &raquo;" />
		</div>
	</form>
	
</div>