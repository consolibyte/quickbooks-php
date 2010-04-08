					</div>
				</div>
			</div>
		
			<div id="leftcolumn">
				<div class="innertube">
		
					<div id="menu">
						<ul class="menu_1stlevel">
							<li><a href="?MOD=home">HOME</a></li>
<?php

$banned = array(
	'zen cart', 
	'oscommerce', 
	'oscmax', 
	);

foreach ($this->_('skin_menu')->modules() as $module)
{
	if (in_array(strtolower($module), $banned))
	{
		continue;
	}
	
	$methods = $this->_('skin_menu')->methods($module);
	
	if (count($methods))
	{
		print('
			<li>' . strtoupper($module) . '</li>
			<ul class="menu_2ndlevel">
		');
		
		foreach ($methods as $url => $text)
		{
			print('
				<li><a href="' . $url . '">' . $text . ' '); 
			
			if (substr($url, 0, 4) == 'http')
			{
				//print(' <img src="" width="12" height="12" /> ');
				print(' &raquo; ');
			}
				
			print('</a></li>
			');
		}
		
		print('
			</ul>
		');
	}
}

?>				
						</ul>
					</div>
		
		
				</div>
			</div>
		
			<div id="footer">
				<a href="<?php print($this->_('quickbooks_package_website')); ?>"><?php print($this->_('quickbooks_package_name') . ' v' . $this->_('quickbooks_package_version') . ', ' . $this->_('quickbooks_package_frontend')); ?></a>
			</div>

		</div>
	</body>
</html>

