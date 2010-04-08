<table>
	<tr>
		<td width="115">
			<?php print($this->_('qb_username')); ?>
		</td>
		<td width="115">
			<?php print($this->_('qb_object')); ?>
		</td>
		<td width="150">
			<?php print($this->_('qb_ident')); ?>
		</td>
		<td width="125">
			<?php print($this->_('unique_id')); ?>
		</td>
		<td>
			<?php print(date('M. jS, g:ia', strtotime($this->_('map_datetime')))); ?>
		</td>
	</tr>
</table>

<hr />