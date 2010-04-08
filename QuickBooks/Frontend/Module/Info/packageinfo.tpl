<?php



?>

<h1>
	Package Information
</h1>

<p>
	test
</p>

<div class="form">
	
	<div>
		<label>Package Name: </label> <?php print($this->_('quickbooks_package_name')); ?>
	</div>
	
	<div>
		<label>Package Version: </label> <?php print($this->_('quickbooks_package_version')); ?>
	</div>
	
	<div>
		<label>Package Author: </label> <?php print(htmlspecialchars($this->_('quickbooks_package_author'))); ?>
	</div>
	
	<div>
		<label>Package Website: </label> <?php print($this->_('quickbooks_package_website')); ?>
	</div>
	
	<div>
		&nbsp;
	</div>
	
	<div>
		<label>Driver Class: </label> <?php print($this->_('driver_class')); ?>
	</div>
	<div>
		<label>Driver Version: </label> <?php print($this->_('driver_version')); ?>
	</div>
	<div>
		<label>Driver Is Initialized: </label> <?php if ($this->_('initialized')) { print('Yes'); } else { print('No'); } ?>
	</div>

	<div>
		&nbsp;
	</div>
	
	<div>
		<label>Front-end Skin: </label> <?php print($this->_('quickbooks_package_frontend')); ?>
	</div>
	
	<div>
		<label>Front-end Modules: </label> 
		<?php
		
		$start = true;
		foreach ($this->_('modules') as $module)
		{
			if (!$start)
			{
				print('<label>&nbsp;</label>');
			}
			
			print('' . $module . '<br />');
			
			$start = false;
		}
		
		?>
	</div>
	
</div>