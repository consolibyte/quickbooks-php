
<div style="margin-top: 5px; margin-bottom: 5px;">
	<a href="?MOD=log&amp;DO=view&amp;offset=0">Beginning</a> | 

	<a href="?MOD=log&amp;DO=view&amp;offset=<?php print($this->_('offset') - $this->_('perpage')); ?>&amp;limit=<?php print($this->_('limit')); ?>">&laquo; Previous</a> | 

<?php

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
			<a href="?MOD=log&amp;DO=view&amp;offset=' . ($i * $this->_('perpage')) . '">' . ($i + 1) . '</a>
		');
	}
}

?>
	| 
	<a href="?MOD=log&amp;DO=view&amp;offset=<?php print($this->_('offset') + $this->_('perpage')); ?>&amp;limit=<?php print($this->_('limit')); ?>">Next &raquo;</a>
</div>