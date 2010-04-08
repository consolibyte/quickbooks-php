<table>
	<tr>
		<td width="100">
			<?php print($this->_('qb_username')); ?>
		</td>
		<td width="50">
<?php

print('Yes');

?>			
		</td>
		<td width="225">
<?php 

if ($this->_('qb_company_file'))
{
	print($this->_('qb_company_file'));
}
else
{
	print('N/A');
}

print('<br />');

if ($this->_('qbwc_wait_before_next_update'))
{
	print('Wait ' . $this->_('qbwc_wait_before_next_update') . ' seconds <br />'); 
}
else
{
	print('');
}

if ($this->_('qbwc_min_run_every_n_seconds'))
{
	print('Min. run every ' . $this->_('qbwc_min_run_every_n_seconds') . ' seconds <br />');
}
else
{
	print('');
}

?>
		</td>
		<td width="125">
			<?php print(date('M. jS, g:ia', strtotime($this->_('write_datetime')))); ?>
		</td>
		<td>
			<?php print(date('M. jS, g:ia', strtotime($this->_('touch_datetime')))); ?>
		</td>
	</tr>
	<!--<tr>
		<td colspan="5" align="right">

			<form method="get" action="">
				<input type="submit" value="Disable" />
			</form>
			
			<form method="get" action="">
				<input type="submit" value="Change..." />
			</form>
			
		</td>
	</tr>-->
</table>

<hr />