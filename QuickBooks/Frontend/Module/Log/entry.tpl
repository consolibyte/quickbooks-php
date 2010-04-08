<table>
	<tr>
		<td width="125">
			<?php print(date('M. jS, g:ia', strtotime($this->_('log_datetime')))); ?>
		</td>
		<td>
<?php

if (strlen($this->_('msg')) > 255)
{
	print('
		<textarea cols="55" rows="16">' . htmlentities($this->_('msg')) . '</textarea>
	');
}
else if (false === strpos(trim($this->_('msg')), "\n"))
{
	print('
		<textarea cols="55" rows="2">' . htmlentities($this->_('msg')) . '</textarea>
	');
}
else
{
	print('
		<textarea cols="55" rows="5">' . htmlentities($this->_('msg')) . '</textarea>
	');
}

?>			
			
		</td>
	</tr>
</table>

<hr />