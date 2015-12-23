<?php
    include_once "../common/base.php";
	
	// check user is logged in and is certified to add new user to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1):
	
    $pageTitle = "Main Page";
    include_once "../common/header.php";
    include_once "../common/sidebar.php";
    include_once "../common/section.php";
	
?>
	<h5>Welcome!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:)</h5>
	
<?php
	include_once "../common/close.php";
	else:
?>
	<meta http-equiv="refresh" content="0;../user/login.php">
<?php
	endif;
?>
