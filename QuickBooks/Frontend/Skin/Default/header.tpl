<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		
		<title>
			<?php print($this->_('quickbooks_package_name') . ' v' . $this->_('quickbooks_package_version') . ', ' . $this->_('quickbooks_package_frontend')); ?>
		</title>
		
		<style type="text/css">

body
{
	margin:0;
	padding:0;
	line-height: 1.5em;
	font-family: sans-serif;
	font-size: 9pt;
	margin-top: 10px;
	vertical-align: top;
}

table, td
{
	vertical-align: top;
}

#maincontainer
{
	width: 900px; /*Width of main container*/
	margin: 0 auto; /*Center container on page*/
	border: 1px solid #a1a1a1;
	border-top: 1px solid #c3c3c3;
	border-left: 1px solid #c3c3c3;
}

#topsection
{
	background: #EAEAEA;
	height: 60px; /*Height of top section*/
}

#topsection h1 
{
	font-size: 130%;
	margin: 0;
	padding-top: 15px;
}

#contentwrapper
{
	float: left;
	width: 100%;
}

#contentcolumn
{
	margin-left: 220px; /*Set left margin to LeftColumnWidth*/
}

#leftcolumn
{
	float: left;
	width: 220px; /*Width of left column*/
	margin-left: -900px; /*Set left margin to -(MainContainerWidth)*/
	background: #C8FC98;
}

#footer
{
	clear: left;
	width: 100%;
	background: black;
	color: #FFF;
	text-align: center;
	padding: 4px 0;
}

#footer a
{
	color: #FFFF80;
}

.innertube
{
	margin: 10px; /*Margins for inner DIV inside each column (to provide padding)*/
	margin-top: 0;
}

#contentcolumn h1
{
	font-size: 125%;
}

a
{
	text-decoration: none;
}

.menu_1stlevel
{
	padding: 0;
	padding-left: 6px;
	list-style: none;
}

.menu_1stlevel li
{
	font-weight: bold;
}

.menu_2ndlevel
{
	margin-bottom: 8px;
	padding-left: 30px;
	
}

.menu_2ndlevel li
{
	font-weight: normal;
}

.form
{
	border: 1px solid #c3c3c3;
	padding: 10px;
}

.submit
{
	text-align: center;
}

form
{
	display: inline;
}

label
{
	width: 180px;
}

hr
{
	border: 1px solid #c3c3c3;
	border-bottom: 0;
	border-left: 0;
	border-right: 0;
}

label
{
	font-weight: bold;
	text-align: right;
	width: 180px;
	float: left; 
	margin-right: 6px;
}

.error
{
	color: red;
	text-align: center;
	padding: 5px;
	padding-bottom: 12px;
}

.ok
{
	color: green;
	text-align: center;
	padding: 5px;
	padding-bottom: 12px;
}

.note
{
	margin-left: 190px;
	font-size: 80%;
}

		</style>

	</head>
	<body>
		
		<div id="maincontainer">

			<div id="topsection">
				<div class="innertube">
					<h1>
						<?php print($this->_('quickbooks_package_name') . ' v' . $this->_('quickbooks_package_version') . ', ' . $this->_('quickbooks_package_frontend')); ?>
					</h1>
				</div>
			</div>

			<div id="contentwrapper">
				<div id="contentcolumn">
					<div class="innertube">
