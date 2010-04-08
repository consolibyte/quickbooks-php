<?php

/**
 * 
 * 
 * @package QuickBooks
 * @subpackage Frontend
 */

?>

<h1>
	SOAP Client Results
</h1>

<div class="form">
	
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
			<label>SOAP Server: </label>
			<?php print($this->_('soap_url')); ?>
		</div>
		
		<div>
			<label>SOAP Method: </label> 
			<?php print($this->_('soap_method')); ?>()
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Parsed Response: </label>
			<textarea cols="50" rows="10" readonly="readonly"><?php print(var_export($this->_('result'), true)); ?></textarea>
		</div>

		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Raw SOAP Request: </label> 
			<textarea cols="50" rows="25" readonly="readonly"><?php print($this->_('soap_raw_request')); ?></textarea>
		</div>

		<div>
			<label>Formatted SOAP Request: </label> 
			<textarea cols="50" rows="25" readonly="readonly"><?php print($this->_('soap_formatted_request')); ?></textarea>
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<div>
			<label>Raw SOAP Response: </label> 
			<textarea cols="50" rows="25" readonly="readonly"><?php print($this->_('soap_raw_response')); ?></textarea>
		</div>

		<div>
			<label>Formatted SOAP Response: </label> 
			<textarea cols="50" rows="25" readonly="readonly"><?php print($this->_('soap_formatted_response')); ?></textarea>
		</div>
		
		<div>
			&nbsp;
		</div>
		
		<form method="post" action="<?php print($_SERVER['REQUEST_URI']); ?>">
			<input type="hidden" name="MOD" value="tests" />
			<input type="hidden" name="DO" value="clientForm" />
			
			<input type="hidden" name="soap_method" value="<?php print($this->_('new_soap_method')); ?>" />
			<input type="hidden" name="soap_url" value="<?php print($this->_('soap_url')); ?>" />
		
			<div class="submit">
				<input type="submit" value="Make Another Request..." />
			</div>
	</form>	
</div> 