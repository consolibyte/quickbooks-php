<?php

require_once dirname(__FILE__) . '/config.php';

if ($IntuitAnywhere->disconnect($the_username, $the_tenant))
{
	
}

require_once dirname(__FILE__) . '/views/header.tpl.php';

?>


		<div style="text-align: center; font-family: sans-serif; font-weight: bold;">
			DISCONNECTED! Please wait...
		</div>
		
		
		<script type="text/javascript">
			window.setTimeout('window.location = \'./index.php\';', 2000);
		</script>
			
<?php

require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>