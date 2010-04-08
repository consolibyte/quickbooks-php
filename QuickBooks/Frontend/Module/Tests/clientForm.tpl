<?php

/**
 * 
 * 
 * @package QuickBooks
 * @subpackage Frontend
 */

?>

<h1>
	SOAP Client
</h1>

<p>
	This SOAP client allows you to test your QuickBooks SOAP Server by issuing 
	fake SOAP requests directly to the server. Essentially, it pretends to by 
	an interactive version of the QuickBooks Web Connector, although it doesn't 
	actually connect to QuickBooks. 
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
		
		function swapActions(action)
		{
			var actions = [ 'clientVersion', 'serverVersion', 'authenticate', 'sendRequestXML', 'receiveResponseXML', 'closeConnection' ]
			
			for (var i = 0; i < actions.length - 1; i++)
			{
				turn_this_off = document.getElementById(actions[i])
				
				if (turn_this_off && null == turn_this_off.className.match('hidden'))
				{
					turn_this_off.className = turn_this_off.className + ' hidden'
				}
			}
			
			turn_this_on = document.getElementById(action)
			turn_this_on.className = turn_this_on.className.replace('hidden', '')
		}
		
	</script>
	
	<form method="post" action="<?php print($_SERVER['REQUEST_URI']); ?>">
		<input type="hidden" name="MOD" value="tests" />
		<input type="hidden" name="DO" value="clientResult" />

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
			<label>SOAP Method: </label> 
			<select name="soap_method" onchange="swapActions(this.value)">
<?php

$methods = array(
	'authenticate', 
	'sendRequestXML', 
	'receiveResponseXML', 
	'closeConnection', 
	'getInteractiveURL', 
	'interactiveDone', 
	'interactiveRejected', 
	'connectionError', 
	'getLastError', 
	'clientVersion', 
	'serverVersion', 
	);

foreach ($methods as $method)
{
	print('<option value="' . $method . '" ');
	
	if ($method == $this->_('soap_method'))
	{
		print(' selected="selected" ');
	}
	
	print('>' . $method . '()</option>' . "\n");
}

?>

			</select>   
		</div>

		<div>
			&nbsp; 
		</div>
		
		<div>
			<label>SOAP Server: </label>
			<input type="text" name="soap_url" size="50" value="<?php print($this->_('soap_url')); ?>" />
		</div>

		<div id="authenticate">
	
			<div>
				&nbsp; 
			</div>
		
			<div>
				<label>Username: </label>
				<input type="text" name="authenticate[username]" />
			</div>
			
			<div>
				<label>Password: </label> 
				<input type="text" name="authenticate[password]" />
			</div>
		</div>
		
		<div id="serverVersion" class="hidden">
			server version
		</div>
		
		<div id="clientVersion" class="hidden">
			client version
		</div>
		
		<div id="sendRequestXML" class="hidden">
			
			<div>
				&nbsp; 
			</div>
		
			<div>
				<label>Ticket: </label>
				<input type="text" name="sendRequestXML[ticket]" size="35" />
			</div>
			
			<div>
				&nbsp; 
			</div>
			
			<div>
				<label>qbXML Country Code:</label>
				<input type="text" name="sendRequestXML[country]" size="10" />
			</div>

			<div>
				<label>qbXML Major Version:</label>
				<select name="sendRequestXML[majorversion]">
<?php

for ($i = 1; $i < 20; $i++)
{
	print('<option value="' . $i . '">' . $i . '</option>' . "\n");
}

?>				
				</select>
			</div>

			<div>
				<label>qbXML Minor Version:</label>
				<select name="sendRequestXML[minorversion]">
<?php

for ($i = 0; $i < 20; $i++)
{
	print('<option value="' . $i . '">' . $i . '</option>' . "\n");
}

?>				
				</select>
			</div>
				
			<div>
				&nbsp; 
			</div>

			<div>
				<label>qbXML Company File:</label>
				<input type="text" name="sendRequestXML[company]" size="50" />
			</div>

			<div>
				<label>XML HCP Response:</label>
				<textarea name="sendRequestXML[hcpresponse]" rows="5" cols="40"></textarea>
			</div>
		</div>
		
		<div id="receiveResponseXML" class="hidden">

			<div>
				&nbsp; 
			</div>
		
			<div>
				<label>Ticket: </label>
				<input type="text" name="receiveResponseXML[ticket]" size="35" />
			</div>

			<div>
				&nbsp; 
			</div>

			<div>
				<label>Error Code: </label>
				<input type="text" name="receiveResponseXML[hresult]" size="35" />
			</div>

			<div>
				<label>Error Message: </label>
				<input type="text" name="receiveResponseXML[message]" size="35" />
			</div>
			
			<div>
				&nbsp; 
			</div>
			
			<div>
				<label>Response:</label>
				<textarea name="receiveResponseXML[response]" rows="5" cols="40"></textarea>
			</div>

		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div class="submit">
			<input type="submit" value="Send SOAP Request &raquo;" />
		</div>
	</form>	
</div> 

<script type="text/javascript" language="javascript">

<?php

if ($this->_('soap_method'))
{
	print('
		swapActions(\'' . $this->_('soap_method') . '\')
	');
}

?>		
		
</script>
