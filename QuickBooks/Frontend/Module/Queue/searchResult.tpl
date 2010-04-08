<h1>
	View the Queue: Records <?php print(number_format($this->_('offset') + 1) . ' to ' . number_format($this->_('offset') + $this->_('perpage'))); ?>
</h1>

<?php

$this->display('Queue/listnav.tpl', false);

?>

<table>
	<tr>
		<td width="7">
			&nbsp;
		</td>
		<td width="125">
			<strong>Date/Time</strong>
		</td>
		<td width="150">
			<strong>User</strong>
		</td>
		<td width="150">
			<strong>Action/Ident</strong>
		</td>
		<td width="50">
			<strong>Priority</strong>
		</td>
		<td>
			<strong>Status</strong>
		</td>
	</tr>
</table>

<div class="form">

<?php

while ($entry = $this->_('Iterator')->next())
{
	$this->assignArray($entry);
	$this->display('Queue/entry.tpl', false);
}

?>

</div>

<?php

$this->display('Queue/listnav.tpl', false);

?>

