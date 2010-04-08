<h1>
	View Associations: Records <?php print(number_format($this->_('offset') + 1) . ' to ' . number_format($this->_('offset') + $this->_('perpage'))); ?>
</h1>

<?php

$this->display('Ident/listnav.tpl', false);

?>

<table>
	<tr>
		<td width="7">
			&nbsp;
		</td>
		<td width="115">
			<strong>User</strong>
		</td>
		<td width="115">
			<strong>Type</strong>
		</td>
		<td width="150">
			<strong>QuickBooks ID</strong>
		</td>
		<td width="125">
			<strong>Application ID</strong>
		</td>
		<td>
			<strong>Date/Time</strong>
		</td>
	</tr>
</table>

<div class="form">

<?php

while ($entry = $this->_('Iterator')->next())
{
	$this->assignArray($entry);
	$this->display('Ident/entry.tpl', false);
}

?>

</div>

<?php

$this->display('Ident/listnav.tpl', false);

?>

