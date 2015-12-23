<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #00FF00;}
</style>
</head>
<body> 

<?php

	include 'include/connection.php';
	// define variables and set to empty values
	$nameErr = $passwordErr = $emailErr = "";
    $min_password_length =8;
	$name = $password = $email =  "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$data_correct = 1;
		
        //check validation of "name" input
		if (empty($_POST["name"])) {
			$data_correct = 0;
			$nameErr = "Name is required";
		} else {
			$name = test_input($_POST["name"]);
			if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$name)) {
				$nameErr = "Only letters and white space allowed";
				$data_correct = 0;
			}
		}
		
        // check validation of "password" input
		if (empty($_POST["password"])) {
			$data_correct = 0;
			$passwordErr = "password is required";
		} else{
			$password = test_input($_POST["password"]);
            if (strlen($password) < $min_password_length){
                $passwordErr = "password is too short";
				$data_correct = 0;
            }
		}
		
		// check validation of "email" input
		if (empty($_POST["email"])) {
			$data_correct = 0;
			$emailErr = "Email is required";
		} else {
			$email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$emailErr = "Invalid email format!";
				$data_correct = 0;			  
			}
		}
		
		if ($data_correct == 1){
    /* include  'create.php';
	echo '<META HTTP-EQUIV="Refresh" Content="0; URL=create.php">'; 
	exit;  */ 
			$query = "SELECT count(*) From `users` WHERE UserName LIKE '$name'";
			$is_user_exist = mysql_query($query) or die(mysql_error());
			$result =  mysql_result($is_user_exist, 0) ;
			if (! ($result == 0)){
				echo "user already exist";
			} else {
				mysql_query("INSERT INTO users (`UserName`,`Password`,`EmailAddress`)
					VALUES('$name','$password', '$email')") or die(mysql_error());
			}
			
		}
	}

function test_string_name($name_field){
		if (empty($_POST["name"])) {
			$data_correct = 0;
			$nameErr = "Name is required";
		} else {
			$name = test_input($_POST["name"]);
			if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$name)) {
				$nameErr = "Only letters and white space allowed";
				$data_correct = 0;
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

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Name: <input type="text" maxlength="30" name="name">
   <span class="error">* <?php echo $nameErr;?></span>
   <br><br>
   Password: <input type="text" maxlength="16" name="password">
   <span class="error">* <?php echo $passwordErr;?></span>
   <br><br>
   E-mail: <input type="text" maxlength="50" name="email">
   <span class="error">* <?php echo $emailErr;?></span>
   <br><br>

   <input type="submit" name="submit" value="Submit"> 
</form>

<?php
	include 'include/connection.php';

	/* $query = "SELECT * from users";
	
	$result = mysql_query($query);
	while ($user = mysql_fetch_array($result)){
		echo "<h3>" . $user['UserName'] . "</h3>";
	} */
?>

</body>
</html>