<!DOCTYPE html>
<?php
    include_once "common/base.php";
    $pageTitle = "Register";
	
	// define variables and set to empty values
	$realNameErr = $userNameErr = $passwordErr = $mailErr = $phoneErr = $roleErr = "";
	
	//include_once "common/myFiles/header.php";
	//include_once "scripts/showHide.php";
	
    if(!empty($_POST['realName']) && !empty($_POST['userName']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
		include_once "inc/class.users.inc.php";
		$users = new ToolUsers($db);
		echo $users->CreateUser();
	}
?>

<head>
  <link href='http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
  <link href='http://davidstutz.github.io/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='http://davidstutz.github.io/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>
</head>
<body>
  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading' aligment="center">
        <h5>Add new User</h5>
      </div>
		<p><center><span class="error">* required field.</span></center></p>
       <div class='panel-body'>
      
		<form class='form-horizontal' role='form' method="post" action="addnewuser.php" id="registerform">
			<table style="width:300%" cellspacing="20px">
				<tr>
					<td width="100"><label for="realName">Real Name: </label></td>
					<td width="150"><input type="text" name="realName" id="realName" size="25" maxlength="30" 
						value="<?php if (isset($_POST['realName'])) { echo $_POST['realName']; }?>" required/></td>
					<td><span class="error"> * <?php echo $realNameErr;?></span></td>
				</tr>
				<tr>
					<td><label for="userName">User Name: </label></td>
					<td><input type="text" name="userName" id="userName" size="25" maxlength="30" 
							value="<?php if (isset($_POST['userName'])) { echo $_POST['userName']; }?>" required/></td>
					<td><span class="error"> * <?php echo $userNameErr;?></span></td>
				</tr>
				<tr>
					<td><label for="password">Password: </label></td>
					<td><input type="password" name="password" id="password" size="25" maxlength="16" value="unix11" required/>
<?php //						<a href="#"><input valign="bottom" type="image" src="eye.png" onclick="toggle_password('password')" id="showhide" width="25" value="Show"/></a>
?>
					</td>
					<td><span class="error"> * <?php echo $passwordErr;?></span></td>
				</tr>
				<tr>
					<td><label for="mail">Amdocs Mail: </label></td>
					<td><input type="text" name="mail" id="mail" size="30" value="<?php if (isset($_POST['mail'])) { echo $_POST['mail']; }?>" required/></td>
								
					<td><span class="error"> * <?php echo $mailErr;?></span></td>
				</tr>
				<tr>
					<td><label for="phone">Phone: </label></td>
					<td><input type="text" name="phone" id="phone" maxlength="10" value="<?php if (isset($_POST['phone'])) { echo $_POST['phone']; }?>" /></td>
					<td><span class="error"> <?php echo $phoneErr;?></span></td>
				</tr>
				<tr>
					<td><label for="role">Role: </label></td>
					<td>
						<?php
							include_once 'helpers/getEnumValuesFromTable.php';
							echo enumDropdown('users','Role');
						?>
					</td>
					<td><span class="error"> <?php echo $roleErr;?></span></td>
				</tr>
				<tr>
					<td><label for="account">Account: </label></td>
					<td>
						<?php
							include_once 'helpers/getDropDownListFromTableData.php';
							echo dataDropdown('clusters','account_name');
						?>
					</td>
					<td><span class="error"> <?php echo $roleErr;?></span></td>
				</tr>
				<tr>
					<td></td>
					<td align="center"><input type="submit" name="register" id="register" value="Add user" /></td>
				</tr>
			</table>
		</form>	
        </div>
    </div>
</body>
<?php
//    endif;
   // include_once 'common/close.php';
?>