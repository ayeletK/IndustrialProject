<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = '';
	$db = 'industrial project';
	
	$connection = mysql_connect($dbhost, $dbuser, $dbpass) ;
	mysql_select_db($db);
?>