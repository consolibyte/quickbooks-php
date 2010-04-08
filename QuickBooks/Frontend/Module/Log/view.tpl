<h1>
	View Server Log: Records <?php print(number_format($this->_('offset') + 1) . ' to ' . number_format($this->_('offset') + $this->_('perpage'))); ?>
</h1>

<?php

$this->display('Log/listnav.tpl', false);

?>

<table>
	<tr>
		<td width="7">
			&nbsp;
		</td>
		<td width="125">
			<strong>Date/Time</strong>
		</td>
		<td>
			<strong>Message</strong>
		</td>
	</tr>
</table>

<div class="form">

<?php

while ($entry = $this->_('Iterator')->next())
{
	$this->assignArray($entry);
	$this->display('Log/entry.tpl', false);
}

?>

</div>

<?php

$this->display('Log/listnav.tpl', false);

?>

