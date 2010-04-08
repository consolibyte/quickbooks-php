
<div style="margin-top: 5px; margin-bottom: 5px;">

<?php

if ($this->_('offset') > 0)
{
	print('
		<a href="?MOD=auth&amp;DO=searchResult&amp;offset=0">Beginning</a> | 
		
		<a href="?MOD=auth&amp;DO=searchResult&amp;offset=' . ($this->_('offset') - $this->_('perpage')) . '&amp;limit=' . $this->_('limit') . '">&laquo; Previous</a> |
	');
}
else
{
	print('
		Beginning |
		&laquo; Previous | 
	');
}

$thispage = $this->_('offset') / $this->_('perpage');

$start = max($thispage - 5, 0);
$end = min($thispage + 5, $this->_('total') / $this->_('perpage'));

for ($i = $start; $i < $end; $i++)
{
	if (($i * $this->_('perpage')) == $this->_('offset'))
	{
		print($i + 1);
	}
	else
	{
		print('
			<a href="?MOD=auth&amp;DO=searchResult&amp;offset=' . ($i * $this->_('perpage')) . '">' . ($i + 1) . '</a>
		');
	}
}

?>
	| 
<?php

if ($this->_('offset') + $this->_('perpage') < $this->_('total'))
{
	print('
		<a href="?MOD=auth&amp;DO=searchResult&amp;offset=' . ($this->_('offset') + $this->_('perpage')) . '&amp;limit=' . $this->_('limit') . '">Next &raquo;</a>
	');
}
else
{
	print('Next &raquo;');
}

?>

</div>