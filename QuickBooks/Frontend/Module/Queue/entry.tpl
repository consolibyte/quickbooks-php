<table>
	<tr>
		<td width="125">
			<?php print(date('M. jS, g:ia', strtotime($this->_('enqueue_datetime')))); ?>
		</td>
		<td width="150">
			<?php print($this->_('qb_username')); ?>
		</td>
		<td width="150">
<?php

print($this->_('qb_action') . '<br />');
print($this->_('ident') . '<br />');
print($this->_('extra') . '<br />');

?>
		</td>
		<td width="50">
			<?php print($this->_('priority')); ?>
		</td>
		<td>
<?php

switch ($this->_('qb_status'))
{
	case QUICKBOOKS_STATUS_QUEUED:
		print('Queued');
		break;
	case QUICKBOOKS_STATUS_PROCESSING:
		print('Processing...');
		break;
	case QUICKBOOKS_STATUS_ERROR:
		print('Error: ' . $this->_('msg'));
		break;
	case QUICKBOOKS_STATUS_SUCCESS:
		print('Success!');
		break;
	default:
		print('Unknown: ' . $this->_('msg'));
		break;
}

?>			
			
		</td>
	</tr>
</table>

<hr />