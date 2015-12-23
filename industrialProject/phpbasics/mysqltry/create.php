<?php
	include 'include/connection.php';
	
	$inputName = $_POST['name'];
	$inputpass = $_POST['password'];
	$inputMail = $_POST['email'];
	
	echo $inputName  ."\n";
	$query = "SELECT count(*) From `users` WHERE UserName LIKE '$inputName'";
	$is_user_exist = mysql_query($query) or die(mysql_error());

    $result =  mysql_result($is_user_exist, 0) ;
	echo $result . "\r\n";
	 if (! ($result == 0)){
		echo "user already exist";
		/*header('Location: index.php');*/
	} 
	 
	if(!$_POST['submit']){
		echo "please fill out the form";
		//header('Location: index.php');
	} else {
		mysql_query("INSERT INTO users (`UserName`,`Password`,`EmailAddress`)
					VALUES('$inputName','$inputpass', '$inputMail')") or die(mysql_error());
		echo "user has been added";
		//header('Location: index.php');
	}
?>