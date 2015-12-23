<?php
    include_once "common/base.php";
    $pageTitle = "Register";
	
	// define variables and set to empty values
	$realNameErr = $userNameErr = $passwordErr = $mailErr = $phoneErr = $roleErr = "";
	
	include_once "common/myFiles/header.php";
	//include_once "scripts/showHide.php";
	
    if(!empty($_POST['realName']) && !empty($_POST['userName']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
		include_once "inc/class.users.inc.php";
		$users = new ToolUsers(db);
		echo $users->CreateUser();
	}
?>
        <h2 aligment="center">Add new User</h2>
		<p><center><span class="error">* required field.</span></center></p>
		<form class="form-signin" method="post" action="addnewuser.php" id="registerform">
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
					<td><input type="password" name="password" id="password" size="25" maxlength="16" value="<?php if (isset($_POST['mail'])) { echo $_POST['mail']; } else { echo 'unix11';} ?>" required/>

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
							echo enumDropdown('users',__users_tl_role);
						?>
					</td>
					<td><span class="error"> <?php echo $roleErr;?></span></td>
				</tr>
				<tr>
					<td><label for="account">Account: </label></td>
					<td>
						<?php
							include_once 'helpers/getDropDownListFromTableData.php';
							echo dataDropdown('clusters',__cluster_tl_account_name);
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