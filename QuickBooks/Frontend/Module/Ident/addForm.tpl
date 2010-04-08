<?php



?>

<h1>
	Add an Association
</h1>

<p>
	test
</p>

<div class="form">
	
	<style type="text/css">
		
		.hidden
		{
			display: none;
			visibility: hidden;
		}
		
	</style>
	
	<script type="text/javascript" language="javascript">
		
		function swapModes(mode)
		{
			if (mode == 1)
			{
				coming_from = document.getElementById('mode_basic')
				going_to = document.getElementById('mode_advanced')
			}
			else
			{
				coming_from = document.getElementById('mode_advanced')
				going_to = document.getElementById('mode_basic')		
			}
			
			coming_from.className = coming_from.className + ' hidden'
			going_to.className = going_to.className.replace('hidden', '')
		}
		
	</script>
	
	<form method="post" action="<?php print($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="MOD" value="queue" />
		<input type="hidden" name="DO" value="addResult" />

<?php

if ($this->_('error'))
{
	print('
		<div class="error">
			' . $this->_('msg') . '
		</div>
	');
}
else if ($this->_('msg'))
{
	print('
		<div class="ok">
			' . $this->_('msg') . '
		</div>
	');
}

?>

		<div id="mode_basic">
	
			<div>
				<label>User: </label>
				<select name="user">
<?php

foreach ($this->_('users') as $user)
{
	print('<option value="' . $user . '">' . $user . '</option>' . "\n");
}

?>
				</select>
			</div>
			
			<div>
				&nbsp;
			</div>
	
			<div>
				<label>Object Type: </label> 
				<select name="type">
<?php

foreach ($this->_('types') as $type)
{
	print('<option value="' . $type . '">' . $type . '</option>' . "\n");
}

?>			
				</select> 
			</div>
			
			<div>
				<label>QuickBooks ID: </label>
				<input type="text" name="qbid" />
			</div>
			
			<div>
				&nbsp;
			</div>
			
			<div>
				<label>Application ID: </label>
				<input type="text" name="appid" />
			</div>
			
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div class="submit">
			<input type="submit" value="Add to the Queue &raquo;" />
		</div>
	</form>	
</div> 