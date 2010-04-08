<?php



?>

<h1>
	Add a User
</h1>

<p>
	You can use this form to add a new user to the framework. You'll use this 
	user in your Web Connector .QWC file and when you're adding items to the 
	queue. 
</p>

<div class="form">
	
	<style type="text/css">
		
		.hidden
		{
			display: none;
			visibility: hidden;
		}
		
	</style>
	
	<form method="post" action="<?php print($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="MOD" value="auth" />
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
		
			<div>
				<label>Username: </label>
				<input type="text" name="user[username]" value="<?php print($this->_('username')); ?>" />
			</div>
			
			<div>
				&nbsp;
			</div>
	
			<div>
				<label>Password: </label> 
				<input type="password" name="user[password]" value="" />
			</div>
			<div>
				<label>Password (again): </label> 
				<input type="password" name="confirm_password" value="" />
			</div>
			
			<div>
				&nbsp;
			</div>

			<div>
				<label>Path to Company File: </label> 
				<input type="text" name="user[company]" value="<?php print($this->_('company')); ?>" />
				<div class="note">
					Leave this blank to use the currently opened QuickBooks Company. 
				</div>
			</div>
			
		</div>

		<div>
			&nbsp;
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div class="submit">
			<input type="submit" value="Add this User &raquo;" />
		</div>
	</form>	
</div> 