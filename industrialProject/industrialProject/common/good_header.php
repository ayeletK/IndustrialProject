<!DOCTYPE HTML> 
<html lang="en">
<head>
    <title>task management tool login</title>
</head>
<body> 
    <h2>Welcome to task management tool app !</h2> 
    <div class="container form-signin">
<?php
	include_once 'base.php';
	// define variables and set to empty values
	$nameErr = $passwordErr = "";
	$name = $password =  "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$data_correct = 1;
		
      
	//====================================================
	//	check validation of "name" input
	//====================================================
		if (empty($_POST["name"])) {
			$data_correct = 0;
			$nameErr = "Name is required";
		} else {
        //add check that user exist in database
			$name = test_input($_POST["name"]);
			if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$name)) {
				$nameErr = "cannot find this user";
				$data_correct = 0;
			}
		}
    //====================================================
	//       check validation for password
	//====================================================
       
		if (empty($_POST["password"])) {
			$data_correct = 0;
			$passwordErr = "password is required";
		} else {
			$password = test_input($_POST["password"]);
            }
	//====================================================
	//check if username and password describe an exist user in db
	//====================================================
		if ($data_correct == 1){
    /* include  'create.php';
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=create.php">'; 
	exit;  */ 
			$query = "SELECT count(*) From `users` WHERE UserName LIKE '$name' AND Password LIKE '$password'";
			$is_user_exist = mysql_query($query) or die(mysql_error());
            $result =  mysql_result($is_user_exist, 0) ;

            
            if (! ($result == 1)){
				echo "incorrect username or password";
			} else {
                    header('Location: mainpage.html');
                    echo "<script language='JavaScript' type='text/JavaScript'>
                    <!--
                    window.location='welcome.php';
                    //-->
                    </script>";
			}
			
		}
	}

    
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
 </div> <!-- /container -->
 <div class="container">
<h2>PHP Form Validation Example</h2>
<form class="form-signin" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   <input class="form-control" type="text" maxlength="30" name="name" placeholder="enter here your username" size="25" required autofocus></br>
   <span class="error"><?php echo $nameErr;?></span>
   <br><br>
   <input type="password" class="form-control" maxlength="16" name="password" placeholder="password" size="25" required>
   <span class="error"><?php echo $passwordErr;?></span>
   <br><br>
   <button class="btn btn-lg btn-primary btn-block" type="submit" name="login">Login</button></br></br>
   <input type='reset' value='Reset'></br></br>
   <!-- TODO: update href with update url assress -->
   <td class="login_form_label_field"><a href="resetpassword.php"> Forgot your password? </a> </td></br></br>
   <td class="login_form_label_field"><a href="addnewaccount.php"> new account </a> </td>
   
   </form>
  </div>

<?php
	include_once 'base.php';

	$query = "SELECT * from users";
	
	$result = mysql_query($query);
	while ($user = mysql_fetch_array($result)){
		echo "<h3>" . $user['Username'] . "</h3>";
	}
?>

</body>
</html>