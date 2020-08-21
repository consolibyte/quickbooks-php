<?php

ini_set('display_errors', true);

$file = str_replace(array('.', '/', '\\', ':'), '', $_GET['file']);
$file = substr($file, 0, -3) . '.php';

highlight_file(dirname(__FILE__) . '/' . $file);