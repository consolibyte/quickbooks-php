<?php



?>

<h1>
	Platform Information
</h1>

<p>
	test
</p>

<div class="form">
	
	<div>
		<label>Platform Information: </label> <?php print($this->_('php_uname')); ?>
	</div>
	
	<div>
		<label>PHP Version: </label> <?php print($this->_('php_version')); ?>
	</div>
	
	<div>
		&nbsp;
	</div>

	<div>
		<label>PHP SOAP/ext Support: </label> <?php if ($this->_('soap_phpext')) { print('Yes'); } else { print('No'); } ?>
	</div>
	
	<div>
		<label>PEAR SOAP Support: </label> <?php if ($this->_('soap_pear')) { print('Yes'); } else { print('No'); } ?>
	</div>

	<div>
		<label>nuSOAP SOAP Support: </label> <?php if ($this->_('soap_nusoap')) { print('Yes'); } else { print('No'); } ?>
	</div>
	
	<div>
		<label>Built-in SOAP Support: </label> <?php if ($this->_('soap_builtin')) { print('Yes'); } else { print('No'); } ?>
	</div>
	
	<div>
		&nbsp;
	</div>

</div>
	