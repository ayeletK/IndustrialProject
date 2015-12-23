<?php
    include_once '../common/base.php';
	$pageTitle = "Update My Info";
	
	// check user is logged in and is certified to add new account to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']=='SM'):
	
	// regEx for client side validation check
	$realNameRegEx = '/^[A-Z][a-zA-Z]*(\s+[A-Z][a-zA-Z]*[a-zA-Z]*)+$/';
	$userNameRegEx = '/^(?!EXP_)[a-zA-Z0-9_\-][a-zA-Z0-9_\- ]*$/';
	$amdocsMailRegEx = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@amdocs[\.]com$/';
	$phoneRegEx = '/^0((([2457]\d)[\-]\d{7})|([23489][\-][2-9]\d{6}))$/';
	
	if(!empty($_POST['realName']) && !empty($_POST['userName']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
		include_once "../inc/class.users.inc.php";
		$users = new ToolUsers(db);
		$res = $users->CreateUser();
		echo $res.'<br><br>';
		if ($res){
			echo "<script type=\"text/javascript\"> alert(\"User was Updated successfully!\"); </script>";
?>
	<meta http-equiv="refresh" content="0;../cssmenu/mainPage.php">
<?php
		}
	}
?>
?>
        <h2 aligment="center">Update User Information</h2>
		<form class="form-signin" method="post" action="addnewuser.php" id="registerform">
			<table style="width:300%" cellspacing="40px">
				<tr>
					<td width="100"><label for="realName">Real Name: </label></td>
					<td width="150"><input type="text" name="realName" id="realName" size="25" maxlength="30" 
						value="<?php if (isset($_POST['realName'])) { echo $_POST['realName']; }?>" required/></td>
					<td><span class="error"><?php echo $realNameErr;?></span></td>
				</tr>
				<tr>
					<td><label for="userName">User Name: </label></td>
					<td><input type="text" name="userName" id="userName" size="25" maxlength="30" 
							value="<?php if (isset($_POST['userName'])) { echo $_POST['userName']; }?>" required/></td>
					<td><span class="error"><?php echo $userNameErr;?></span></td>
				</tr>
				<tr>
					<td width="150"><label for="oldPassword">Old Password: </label><br><br>
					<label for="newPassword">New Password: </label><br><br>
					<label for="verifyPassword">Verify New Password: </label></td>
					<td><input type="password" name="oldPassword" id="oldPassword" size="25" maxlength="16" required/><br>
					<input type="password" name="newPassword" id="newPassword" size="25" maxlength="16" required/><br>
					<input type="password" name="verifyPassword" id="verifyPassword" size="25" maxlength="16" required/></td>
					<td><span class="error"><?php echo $oldPasswordErr;?></span><br>
					<span class="error"><?php echo $newPasswordErr;?></span><br>
					<span class="error"><?php echo $verifyPasswordErr;?></span></td>
				</tr>
				<tr>
					<td><label for="mail">Amdocs Mail: </label></td>
					<td><input type="text" name="mail" id="mail" size="30" value="<?php if (isset($_POST['mail'])) { echo $_POST['mail']; }?>" required/></td>
								
					<td><span class="error"><?php echo $mailErr;?></span></td>
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
							echo dataDropdown('clusters','AccountName');
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
		
<?php
//    endif;
    include_once 'common/close.php';
?>