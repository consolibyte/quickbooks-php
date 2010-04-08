<h1>
	View Users: Records <?php print(number_format($this->_('offset') + 1) . ' to ' . number_format($this->_('offset') + $this->_('perpage'))); ?>
</h1>

<?php

$this->display('Auth/listnav.tpl', false);

?>

<table>
	<tr>
		<td width="7">
			&nbsp;
		</td>
		<td width="100">
			<strong>User</strong>
		</td>
		<td width="50">
			<strong>Enable</strong>
		</td>
		<td width="225">
			<strong>Company File/Options</strong>
		</td>
		<td width="125">
			<strong>Created Date/Time</strong>
		</td>
		<td>
			<strong>Access Date/Time</strong>
		</td>
	</tr>
</table>

<div class="form">

<?php

while ($entry = $this->_('Iterator')->next())
{
	$this->assignArray($entry);
	$this->display('Auth/entry.tpl', false);
}

?>

</div>

<?php

$this->display('Auth/listnav.tpl', false);

?>

