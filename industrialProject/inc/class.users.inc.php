<?php

include_once "../inc/testinput.php";
include_once '../helpers/formatString.php';
include_once "../inc/Security.php";
/**
 * Handles user interactions within the app
 *
 *	wanted actions:
 *		Create an account
 *		Update the account email address
 *		Update the account password
 *		Retrieve a forgotten password
 *		Delete the account
 *
 */
class ToolUsers
{
	/**
     * The database object
     *
     * @var object
     */
    private $_db;
	private $min_password_length =8;

    /**
     * initialize new ToolUsers instance
     */
    public function __construct($db = NULL)
    {
        if($db != NULL)
        {
            $this->_db = $db;
        }
        else
        {
			include_once '../inc/constants.inc.php';
            $connection = mysql_connect(dbhost, dbuser, dbpass);
			mysql_select_db(db);
        }
    }
	
	/**
     * Checks validation of form inputs and inserts a new user into the database
     */
	public function CreateUser()
    {
		$v = sha1(time());
		global $realNameErr, $userNameErr, $passwordErr, $mailErr;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data_correct = 1;
			
		//====================================================
		//	check validation of "realName" input
		//====================================================
			if (empty($_POST["realName"])) {
				$data_correct = 0;
				$realNameErr = "Real name field is required";
			} else {
			//add check that user exist in database
				$realName = test_input($_POST["realName"]);
				if (!preg_match("/^[A-Z][a-zA-Z]*\s([A-Z][a-zA-Z ]*)+$/",$realName)) {
					$realNameErr = 'invalud name. You must enter full name (first + last).<br />'.
								'All names must start with Capital Letter';
					$data_correct = 0;
				}
			}
		//====================================================
		//	check validation of "userName" input
		//====================================================
			$userName='';
			if (empty($_POST["userName"])) {
				$data_correct = 0;
				$userNameErr = "User Name field is required";
			} else {
				$userName = test_input($_POST["userName"]);
				if (!preg_match("/^(?!EXP_)[a-zA-Z0-9_\- ]*$/",$userName)) {
					$userNameErr = 'invalid user name!';
					$data_correct = 0;
				}
			}
		//====================================================
		//       check validation for "password" input
		//====================================================
			if (empty($_POST["password"])) {
				$data_correct = 0;
				$passwordErr = "password is required";
			} else {
				$password = test_input($_POST["password"]);
				if (($password != 'unix11') && (strlen($password) < $this->min_password_length)) {
					$passwordErr = 'invalid password! Default password is \'unix11\'.<br />'.
									'Other passwords must be at least 8 characters.';
					$data_correct = 0;
				}
				else { // hash password for secure storage
					/* $hashed_password = Security.HashSHA1($password);
					echo $hashed_password; */
				}
			}
		//====================================================
		//       check validation for "mail" input
		//====================================================
		   
			if (empty($_POST["mail"])) {
				$data_correct = 0;
				$mailErr = "amdocs mail is required";
			} else {
				$mail = test_input($_POST["mail"]);
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$domain = substr(strrchr($mail, "@"), 1);
					$domain = strtolower($domain);
					if ($domain != 'amdocs.com'){
						$mailErr = "invalid Amdocs mail address!";
						$data_correct = 0;
					}
				}
			}
		//====================================================
		//       check other form fields - phone, role, account
		//====================================================
		
			if (!empty($_POST["phone"])){
				$phone = test_input($_POST["phone"]);
				// $phone = preg_replace("/[^0-9]/","",$phone);
				if (!preg_match("/^0((([57]\d)[\-]\d{7})|([23489][\-][2-9]\d{6}))$/",$phone)) {	// make a better check, allow [- +] characters
					$phoneErr = 'invalid phone number!<br /> Phone number must be 9-10 digits.';
					$data_correct = 0;
				}
			} else{
				$phone = null;
			}
			
			if (!empty($_POST["role"])){
				$role = test_input($_POST["role"]);
			}
			
			if (!empty($_POST["account_name"])){
				$account = test_input($_POST["account_name"]);
			}
			
		//====================================================
		//       inserting valid data to database.
		//====================================================
			if ($data_correct == 1){
				$query = "SELECT count(*) As theCount From `users` WHERE '__users_tl_user_name'='$userName' AND '__users_tl_expired' IS NULL";
				//$query = "SELECT * From `users` WHERE '__users_tl_user_name' LIKE '$userName'";
				//$result = mysql_query($query);
				/* while ($user = mysql_fetch_array($result)){
						echo 'in while loop';
						echo "<h3>" . $user['role'] . "</h3>";
				}
				echo 'after while loop';
				exit(); */
				$is_user_exist = mysql_query($query) or die(mysql_error());
				$rows =  mysql_num_rows($is_user_exist);
				if ($rows > 0){
					unset($_POST['userName']);
					echo "<script type=\"text/javascript\"> alert(\"The given user name is occupied. Please try another user name.\"); </script>'";
					//header('Location: cssmenu/mainPage.php');
				} else {
					$columns = __users_tl_real_name.','.__users_tl_user_name.','.__users_tl_password.','.__users_tl_amdocs_mail.','.
						__users_tl_phone.','.__users_tl_role.','.__users_tl_account.','.__users_tl_date_modified.','.__users_tl_modifying_user.','.
						__users_tl_date_created.','.__users_tl_creating_user;
					$modifierName = $_SESSION['UserName'];
					$modifierQuery = "SELECT ".__users_tl_user_id." FROM users WHERE ".__users_tl_user_name."='".$modifierName."'
										AND ".__users_tl_expired." IS NULL";
					$modifierResult = mysql_query($modifierQuery) or die(mysql_error());
					$modifierId = mysql_result($modifierResult, 0);
					$date = date("Y-m-d");
					$insertQuery = "INSERT INTO users ($columns) VALUES('$realName','$userName','$password','$mail','$phone','$role','$account',
									'$date','$modifierId','$date','$modifierId')";
					$insertResult = mysql_query($insertQuery) or die(mysql_error());
					
					if(mysql_errno()){
						echo "MySQL error ".mysql_errno().": "
						.mysql_error()."\n<br>When executing <br>\n$insertQuery\n<br>";
					}
					else {
						// if insert succeeded
						return true;
						echo "<script type=\"text/javascript\"> alert(\"User was added successfully!\"); </script>";
						//header('Location: ../cssmenu/mainPage.php');
					}
				}
			}
			else {
				//header('Location: addnewuser.php');
			}
		}
	}
	
	/**
     * Remove user by marking it as expired.
     */
	public function RemoveUser()
    {
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			
			$option_selected = test_input($_POST["usersData"]);
			echo '/'.niceValue(__users_tl_user_name).':.*/<br>';
			preg_match('/'.niceValue(__users_tl_user_name).':.*/', $option_selected, $matches);
			echo $matches[0];
			$userName = trim(substr($matches[0], 10), ',');
			echo '<br><br> user name: '.$userName.'<br>';
			
			$date = date("Y-m-d");
			
			$removeQuery = 'UPDATE users SET `'.__users_tl_user_name." = 'EXP_".$userName."', ".__users_tl_expired."` = '".$date."' WHERE `".__users_tl_user_name."` = '".trim($userName, ' ')."'";
							//UPDATE `users` SET `user_name` = 'EXP_ca', `expired` = '2015-12-04' WHERE `users`.`user_name` = 'ca'
			//', '.__users_tl_user_name.'='.$expUserName.
			echo '<br><br>'.$removeQuery.'<br>';
			$removeQuery_res = mysql_query($removeQuery) or die(mysql_error());
			//_______$removeQuery_res = mysql_query($removeQuery"UPDATE users SET `expired` = 2015/12/04 WHERE `user_name` = ' nce093'") or die(mysql_error());
			if ($removeQuery_res == FALSE) {echo '<br><h3>FALSE </h3><br>'; } else {
			if(mysql_errno()){
				echo "MySQL error ".mysql_errno().": "
				.mysql_error()."\n<br>When executing <br>\n$removeQuery\n<br>";
			}
			else {
				// if insert succeeded
				echo "<script type=\"text/javascript\"> alert(\"User $userName was removed successfully!\"); </script>";
			}
			}
		}
	}
	/**
     * Perform user long in to system.
     */
	public function LogInUser(){
		global $userNameErr, $passwordErr;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data_correct = 1;
	
			//====================================================
			//	check validation of "userName" input
			//====================================================
				if (empty($_POST["userName"])) {
					$data_correct = 0;
					$userNameErr = " * User Name field is required";
				} else {
					$userName = test_input($_POST["userName"]);
				}
			//====================================================
			//       check user with "userName" exists in database
			//====================================================
			$selectQuery = "SELECT ".__users_tl_real_name.",".__users_tl_user_name.",".__users_tl_password.",
				".__users_tl_role." FROM users WHERE ".__users_tl_user_name."='".$userName."'";
			$selectResult = mysql_query($selectQuery) or die(mysql_error());
			$num_rows = mysql_num_rows($selectResult);
			
			if (! ($num_rows == 1)){
				$data_correct = 0;
				$userNameErr = ' * There is no user in the system with that user name.</br>'.
				'Please make sure you typed your user name correctly';
			}
			else {	// get user information from database (Password, Role)
				$userInfo = mysql_fetch_array($selectResult);
				$userPassword = $userInfo[__users_tl_password];
				$userRole = $userInfo[__users_tl_role];
				$userRealName = $userInfo[__users_tl_real_name];
			}
			//====================================================
			//       check validation for "password" input
			//====================================================
			   
			if (empty($_POST["password"])) {
				$data_correct = 0;
				$passwordErr = " * password is required";
			} else {
				$password = test_input($_POST["password"]);
				if (strcmp($password, $userPassword) != 0) { // wrong password
					$data_correct = 0;
					$passwordErr = " * Wrong password!";
				}
			}
			if ($data_correct == 1){ // user name & user password are legal and in database
				// save user info in session
				$_SESSION['LoggedIn'] = 1;
				$_SESSION['UserName'] = $userInfo[__users_tl_user_name];
				$_SESSION['Role'] = $userRole;
				
				echo "<script type=\"text/javascript\"> alert(\"Welcome $userRealName!\"); </script>";
				header('Location: ../cssmenu/mainPage.php');
			}
		}
	}
	
	/**
     * Reset forgotten password of the user
	 * 
	 * given an email address of user, send reset mail to the user with
	 * new temp password.
     */
	public function ResetForgottenPassword(){
		global $userNameErr, $passwordErr;
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data_correct = 1;
	
			//====================================================
			//       check validation for "mail" input
			//====================================================
			$mail='';
			if (empty($_POST["mail"])) {
				$data_correct = 0;
				$mailErr = "amdocs mail is required";
			} else {
				$mail = test_input($_POST["mail"]);
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$domain = substr(strrchr($mail, "@"), 1);
					$domain = strtolower($domain);
					if ($domain != 'amdocs.com'){
						$mailErr = "invalid Amdocs mail address!";
						$data_correct = 0;
					}
				}
			}
			//====================================================
			//       check user with "userName" exists in database
			//====================================================
			$selectQuery = "SELECT ".__users_tl_real_name.",".__users_tl_password.
				" FROM users WHERE ".__users_tl_amdocs_mail."='".$mail."'";
			$selectResult = mysql_query($selectQuery) or die(mysql_error());
			$num_rows = mysql_num_rows($selectResult);
			
			if (! ($num_rows == 1)){
				$data_correct = 0;
				$mailErr = ' * There is no user in the system with that email address.</br>'.
				'Please make sure you typed your email address correctly';
			}
			else {	// get user information from database (Password, Role)
				$userInfo = mysql_fetch_array($selectResult);
				$userRealName = $userInfo[__users_tl_real_name];
				$userPassword = $userInfo[__users_tl_password];
			}
			
			if ($data_correct == 1){ // email is valid email address and exists in database.
				// generate temp password
				$firstName = strtok(trim($userRealName), ' ');
				$randNumber = rand(10000, 99999);
				$tempPass = $firstName.$randNumber;
				
				echo $tempPass.'<br>';
				
				// send the mail
				$to = "kravkrav@gmail.com";
				$subject = "Test Mail";
				$txt = "Hello world!";
				$headers = "From: Ayelet Hayelet";

				$mailSentResult = mail($to,$subject,$txt,$headers);
				echo $mailSentResult.'<br><br>';
				if ($mailSentResult == false)
					echo 'Error occurred when sending mail!';
				
				// echo "<script type=\"text/javascript\"> alert(\"Welcome $userRealName!\"); </script>";
				// header('Location: ../cssmenu/mainPage.php');
			}
			else {
				echo "<script type=\"text/javascript\"> alert(\"Email not in database!\"); </script>";
			}
		}
	}
	
	/**
     * Update user information such as:
	 * - Real Name
	 * - User Name
	 * - Amdocs Mail Address
	 * - Phone
     */
	public function UpdateUserInfo(){
		
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$data_correct = 1;
			
		//====================================================
		//	check validation of "realName" input
		//====================================================
			if (empty($_POST["realName"])) {
				$data_correct = 0;
				$realNameErr = "Real name field is required";
			} else {
			//add check that user exist in database
				$realName = test_input($_POST["realName"]);
				if (!preg_match("/^[A-Z][a-zA-Z]*\s([A-Z][a-zA-Z ]*)+$/",$realName)) {
					$realNameErr = 'invalud name. You must enter full name (first + last).<br />'.
								'All names must start with Capital Letter';
					$data_correct = 0;
				}
			}
		//====================================================
		//	check validation of "userName" input
		//====================================================
			$userName='';
			if (empty($_POST["userName"])) {
				$data_correct = 0;
				$userNameErr = "User Name field is required";
			} else {
				$userName = test_input($_POST["userName"]);
				if (!preg_match("/^(?!EXP_)[a-zA-Z0-9_\- ]*$/",$userName)) {
					$userNameErr = 'invalid user name!';
					$data_correct = 0;
				}
			}
		//====================================================
		//       check validation for "password" input
		//====================================================
			if (empty($_POST["password"])) {
				$data_correct = 0;
				$passwordErr = "password is required";
			} else {
				$password = test_input($_POST["password"]);
				if (($password != 'unix11') && (strlen($password) < $this->min_password_length)) {
					$passwordErr = 'invalid password! Default password is \'unix11\'.<br />'.
									'Other passwords must be at least 8 characters.';
					$data_correct = 0;
				}
				else { // hash password for secure storage
					/* $hashed_password = Security.HashSHA1($password);
					echo $hashed_password; */
				}
			}
		//====================================================
		//       check validation for "mail" input
		//====================================================
		   
			if (empty($_POST["mail"])) {
				$data_correct = 0;
				$mailErr = "amdocs mail is required";
			} else {
				$mail = test_input($_POST["mail"]);
				if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
					$domain = substr(strrchr($mail, "@"), 1);
					$domain = strtolower($domain);
					if ($domain != 'amdocs.com'){
						$mailErr = "invalid Amdocs mail address!";
						$data_correct = 0;
					}
				}
			}
		//====================================================
		//       check other form fields - phone, role, account
		//====================================================
		
			if (!empty($_POST["phone"])){
				$phone = test_input($_POST["phone"]);
				// $phone = preg_replace("/[^0-9]/","",$phone);
				if (!preg_match("/^0((([57]\d)[\-]\d{7})|([23489][\-][2-9]\d{6}))$/",$phone)) {	// make a better check, allow [- +] characters
					$phoneErr = 'invalid phone number!<br /> Phone number must be 9-10 digits.';
					$data_correct = 0;
				}
			} else{
				$phone = null;
			}
			
			if (!empty($_POST["role"])){
				$role = test_input($_POST["role"]);
			}
			
			if (!empty($_POST["account_name"])){
				$account = test_input($_POST["account_name"]);
			}
			
		//====================================================
		//       inserting valid data to database.
		//====================================================
			if ($data_correct == 1){
				$query = "SELECT count(*) As theCount From `users` WHERE '__users_tl_user_name'='$userName' AND '__users_tl_expired' IS NULL";
				//$query = "SELECT * From `users` WHERE '__users_tl_user_name' LIKE '$userName'";
				//$result = mysql_query($query);
				/* while ($user = mysql_fetch_array($result)){
						echo 'in while loop';
						echo "<h3>" . $user['role'] . "</h3>";
				}
				echo 'after while loop';
				exit(); */
				$is_user_exist = mysql_query($query) or die(mysql_error());
				$rows =  mysql_num_rows($is_user_exist);
				if ($rows > 0){
					unset($_POST['userName']);
					echo "<script type=\"text/javascript\"> alert(\"The given user name is occupied. Please try another user name.\"); </script>'";
					//header('Location: cssmenu/mainPage.php');
				} else {
					$columns = __users_tl_real_name.','.__users_tl_user_name.','.__users_tl_password.','.__users_tl_amdocs_mail.','.
						__users_tl_phone.','.__users_tl_role.','.__users_tl_account.','.__users_tl_date_modified.','.__users_tl_modifying_user.','.
						__users_tl_date_created.','.__users_tl_creating_user;
					$modifierName = $_SESSION['UserName'];
					$modifierQuery = "SELECT ".__users_tl_user_id." FROM users WHERE ".__users_tl_user_name."='".$modifierName."'
										AND ".__users_tl_expired." IS NULL";
					$modifierResult = mysql_query($modifierQuery) or die(mysql_error());
					$modifierId = mysql_result($modifierResult, 0);
					$date = date("Y-m-d");
					$insertQuery = "INSERT INTO users ($columns) VALUES('$realName','$userName','$password','$mail','$phone','$role','$account',
									'$date','$modifierId','$date','$modifierId')";
					$insertResult = mysql_query($insertQuery) or die(mysql_error());
					
					if(mysql_errno()){
						echo "MySQL error ".mysql_errno().": "
						.mysql_error()."\n<br>When executing <br>\n$insertQuery\n<br>";
					}
					else {
						// if insert succeeded
						return true;
						echo "<script type=\"text/javascript\"> alert(\"User was added successfully!\"); </script>";
						//header('Location: ../cssmenu/mainPage.php');
					}
				}
			}
			else {
				//header('Location: addnewuser.php');
			}
		}
	}
}


?>