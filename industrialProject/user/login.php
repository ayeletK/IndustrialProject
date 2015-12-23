<?php
	include_once '../common/base.php';
	
	// if user is logged in
	if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1){
		header('Location: ../cssmenu/mainPage.php');
	}
	
	// define variables and set to empty values
	$userNameErr = $passwordErr = "";
	
	if(!empty($_POST['userName']) && !empty($_POST['password'])) {
 		include_once "../inc/class.users.inc.php";
		$users = new ToolUsers(db);
		echo $users->LogInUser();
	}
?>

<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Production Schedule Tool</title>
    
    
        <link rel="stylesheet" href="../login_addition/css/style.css">	
  </head>

  <body>
	
    <div class="wrapper">
		<div class="container">
			
			<h1>Welcome to Production Schedule Tool</h1>
			<br />
			<form method="post" action="login.php">
				<input type="text" placeholder="User Name" name="userName" id="userName" required>
				<span class="error"> <?php echo $userNameErr;?></span>
				<input type="password" placeholder="Password" name="password" id="password" required>
				<span class="error"><?php echo $passwordErr;?></span>
				<input type="submit" name="login-button" id="login-button" value="Login" />
			</form>
			<a id="resetPass" href="resetpassword.php"> Forgot your password? </a>
		</div>
		<ul class="bg-bubbles">
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
			<li></li>
		</ul>
	</div>
 <!--   <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>	-->

        <script src="../login_addition/js/index.js"></script>

    
    
    
  </body>
</html>
