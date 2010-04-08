
<h1>
	View the Queue
</h1>

<p>
	This section of the module allows you to view and search for actions which 
	have previously been placed in the queue, and/or actions which are 
	currently in the queue. 
</p>

<div class="form">

	<form method="get" action="<?php print($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="MOD" value="queue" />
		<input type="hidden" name="DO" value="searchResult" />
		
		<div class="submit">
			<input type="submit" value="View the Queue &raquo;" />
		</div>
	</form>
	
</div>