<?php
	include_once '../common/base.php';
		
	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}

	function check_empty_input($data){
		if ($_SERVER["REQUEST_METHOD"] == "POST"){
			if (empty($_POST($data))){
				return $data.' is required!';
			}
		}
	}
	
	
	/* 
$blank_fields = "";
		if (empty($_POST['mail'])){
			$blank_fields .= "- Amdocs Mail\\n";
		}
		if (empty($_POST['phone'])){
			$blank_fields .= "- phone\\n";
		}
		if ($blank_fields != ''){
			$message = "You left blank fields:\\n\\n".$blank_fields;
			$confirmation = 0;
			echo "<script type='text/javascript'>confirm('$message');</script>";
			if ($confirmation = 1) {
				include_once "inc/class.users.inc.php";
				$users = new ToolUsers($db);
				echo $users->createAccount();
			}
			//echo "<script > confirm('Are you sure you don't want to fill the next form fields?'.$blank_fields) <script>";
			//header("Location: 'addnewuser.php'");
		}
	
	*/
?>