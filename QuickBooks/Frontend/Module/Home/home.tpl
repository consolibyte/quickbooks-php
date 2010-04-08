
<h1>
	Welcome to <?php print($this->_('quickbooks_package_name') . ' v' . $this->_('quickbooks_package_version')); ?>!
</h1>

<p>
	Welcome to <?php print($this->_('quickbooks_package_name') . ' v' . $this->_('quickbooks_package_version')); ?>! 
	This front-end application will help you get started developing, integrating, and debugging web applications 
	with QuickBooks Accounting software. 
</p>

<?php

if ($this->_('initialized'))
{
	print('
		<p>
			Choose a menu item from the options on the left to get started. 
		</p>
	');	
}
else
{
	print('
		<p>
			test 
		</p>
	');
}

?>

