<h1>
	Generate a .QWC File
</h1>

<p>
	QuickBooks .QWC files tell the QuickBooks Web Connector where your web 
	service has been set up so that it can connect and transfer data between 
	your web application and the QuickBooks application. You can generate a 
	.QWC file by filling out the form below. 
</p>
<p>
	Save the generated .QWC file on your computer, and then load the .QWC file 
	into the QuickBooks Web Connector by:
	<ol>
		<li>Opening the Web Connector</li>
		<li>Choosing the 'Add an Application' button in the bottom right</li>
		<li>Selecting the .QWC file you downloaded</li>
		<li>Following the prompts for data access</li>
	</ol>  
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
				panel = document.getElementById('mode_advanced')
				panel.className = panel.className.replace('hidden', '')
			}
			else
			{
				panel = document.getElementById('mode_advanced')
				panel.className = panel.className + ' hidden';
			}
		}
		
	</script>	
	
<?php

if ($this->_('error'))
{
	print('
		<div class="error">
			' . $this->_('error') . '
		</div>
	');
}

?>	
	
	<form method="post" action="<?php print($_SERVER['PHP_SELF']); ?>">
		<input type="hidden" name="MOD" value="setup" />
		<input type="hidden" name="DO" value="qwcGenerate" />
		
		<div>
			<label>Mode: </label> <input type="radio" name="mode" value="0" checked="checked" onclick="swapModes(0)" /> Simple  <br />
			<label>&nbsp;</label>			<input type="radio" name="mode" value="1" onclick="swapModes(1)" /> Advanced   
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Application Name:</label>
			<input type="text" name="qwc[name]" value="<?php print($this->_('name')); ?>" />
		</div>
		<div class="note">
			The application name will be displayed in the Web Connector panel.
		</div>

		<div>
			<label>Description:</label>
			<textarea name="qwc[descrip]" cols="40" rows="3"><?php print($this->_('descrip')); ?></textarea>
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Web Connector Username:</label>
			<input type="text" name="qwc[username]" value="<?php print($this->_('username')); ?>" />
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Server URL:</label>
			<input type="text" name="qwc[appurl]" value="<?php print($this->_('appurl')); ?>" size="50" />
		</div>
		<div class="note">
			This *must* be a valid SOAP server URL!<br />
			You *must* use SSL (example: <strong>https://</strong>domain.com/server.php) unless you're using 'localhost'! 
		</div>

		<div>
			<label>Support URL:</label>
			<input type="text" name="qwc[appsupport]" value="<?php print($this->_('appsupport')); ?>" size="50" />
		</div>
		<div class="note">
			This *must* be a valid URL which returns a valid HTTP 200 OK response!
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Run Every: </label>
			<input type="text" name="qwc[run_every_n_seconds]" value="<?php print($this->_('run_every_n_seconds')); ?>" /> seconds
		</div>
		<div class="note">
			If you do not want to automatically schedule updates, leave this as '0'.
		</div>
		
		<div class="hidden" id="mode_advanced">
			
			<div>
				&nbsp;
			</div>
			
			<div>
				<label>QuickBooks Type:</label>	<input type="radio" name="qwc[qbtype]" value="<?php print(QUICKBOOKS_TYPE_QBFS); ?>" <?php if ($this->_('qbtype') == QUICKBOOKS_TYPE_QBFS) { print(' checked="checked" '); } ?> /> QuickBooks FS (Simple Start, Pro, Premier, Enterprise)<br />
				
				<label>&nbsp;</label>			<input type="radio" name="qwc[qbtype]" value="<?php print(QUICKBOOKS_TYPE_QBPOS); ?>" <?php if ($this->_('qbtype') == QUICKBOOKS_TYPE_QBPOS) { print(' checked="checked" '); } ?> /> Point-of-Sale
			</div>
			
			<div>
				&nbsp;
			</div>
			
			<div>
				<label>File ID:</label>
				<input type="text" name="qwc[fileid]" value="<?php print($this->_('fileid')); ?>" />
			</div>
			<div class="note">
				This should be a properly formatted GUID.
			</div>
			
			<div>
				<label>Owner ID:</label>
				<input type="text" name="qwc[ownerid]" value="<?php print($this->_('ownerid')); ?>" />
			</div>
			<div class="note">
				This should be a properly formatted GUID.
			</div>
			
			personal data
			
			unattended mode
			
			authflags
			
			notify
			
			display name
			
			unique name
			
			app id
			
		</div>

		<div>
			&nbsp;
		</div>
			
		<div class="submit">
			<input type="submit" value="Generate .QWC" />
		</div>
		
	</form>
	
</div>