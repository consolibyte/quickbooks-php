<?php



?>

<h1>
	Add to the Queue
</h1>

<p>
	You can use this form to add a new item into the queue. Change the mode to
	'Advanced' if you can't find one or more of the features you're looking 
	for. 
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

		<div>
			<label>Mode: </label> <input type="radio" name="mode" value="0" checked="checked" onclick="swapModes(0)" /> Simple  <br />
			<label>&nbsp;</label>			<input type="radio" name="mode" value="1" onclick="swapModes(1)" /> Advanced   
		</div>

		<div id="mode_basic">
	
			<div>
				&nbsp; 
			</div>
		
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
				<label>Action: </label> 
				<select name="action">
<?php

foreach ($this->_('actions') as $action)
{
	print('<option value="' . $action . '">' . $action . '</option>' . "\n");
}

?>			
				</select> 
			</div>
			
			<div>
				<label>ID: </label>
				<input type="text" name="ident" />
			</div>
			
			<div>
				&nbsp;
			</div>
			
			<div>
				<label>Priority: </label>
				<select name="priority">
<?php

for ($i = 0; $i < 100; $i++)
{
	print('<option value="' . $i . '">' . $i . '</option>' . "\n");
}

?>			
				</select>
			</div>
			
		</div>
		
		<div id="mode_advanced" class="hidden">
			
			<div>
				&nbsp; 
			</div>
		
			<div>
				<label>User: </label>
				<input type="text" name="user_advanced" />
			</div>
			
			<div>
				&nbsp;
			</div>
	
			<div>
				<label>Action: </label> 
				<input type="text" name="action_advanced" />
			</div>
			
			<div>
				<label>ID: </label>
				<input type="text" name="ident_advanced" />
			</div>
			
			<div>
				&nbsp;
			</div>
			
			<div>
				<label>Priority: </label> 
				<input type="text" name="priority_advanced" size="5" />
			</div>
			
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Extra Data: </label>
			<textarea name="extra" rows="3" cols="25"></textarea>
		</div>
		
		<div>
			<label>Type: </label>
			<select name="extra_type">
<?php

$arr = array(
	QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_ARRAY => 'Array',
	QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_STRING => 'String',
	QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_INTEGER => 'Integer',
	QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_FLOAT => 'Float',
	QUICKBOOKS_FRONTEND_MODULE_QUEUE_TYPE_BOOLEAN => 'Boolean',
	);

foreach ($arr as $datatype => $descrip)
{
	print('<option value="' . $datatype . '">' . $descrip . '</option>' . "\n");
}

?>
			</select>			
		</div>

		<div>
			&nbsp;
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div class="submit">
			<input type="submit" value="Add to the Queue &raquo;" />
		</div>
	</form>	
</div> 