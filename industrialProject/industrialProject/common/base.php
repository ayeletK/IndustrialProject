<?php
    // Set the error reporting level
   // error_reporting(E_ALL);
    //ini_set("display_errors", 1);

    // Start a PHP session
    if(!isset($_SESSION)) {
		session_start();
	}

    // Include site constants
    include_once "../inc/constants.inc.php";

    // Create a database object
	$connection = mysql_connect(dbhost, dbuser, dbpass) ;
	mysql_select_db(db);
?>