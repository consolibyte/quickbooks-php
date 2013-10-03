<?php

require_once dirname(__FILE__) . '/config.php';

// Display the menu
die($IntuitAnywhere->widgetMenu($the_username, $the_tenant));