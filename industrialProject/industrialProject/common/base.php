<?php
    // Start a PHP session
	session_start();

    // Include site constants
    include_once ("../inc/constants.inc.php");

    // Create a database object
	$connection = mysql_connect(dbhost, dbuser, dbpass) ;
	mysql_select_db(db);
?>