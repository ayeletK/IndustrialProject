<?php
    include_once "../common/base.php";
	
	// check user is logged in and is certified to add new user to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']!='OPS'):
	
	// define variables and set to empty values
	$realNameErr = $userNameErr = $passwordErr = $mailErr = $phoneErr = $roleErr = "";
	
	// regEx for client side validation check
	$realNameRegEx = '/^[A-Z][a-zA-Z]*(\s[A-Z][a-zA-Z]*[a-zA-Z]*)+$/';
	$userNameRegEx = '/^(?!EXP_)[a-zA-Z0-9_\- ]*$/';
	$amdocsMailRegEx = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@amdocs\.com$/';
	$phoneRegEx = '/^0((([57]\d)-{8})|([23489]-[2-9]\d{6}$/';

	//include_once "scripts/showHide.php";
	
    if(!empty($_POST['realName']) && !empty($_POST['userName']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
		include_once "../inc/class.users.inc.php";
		$users = new ToolUsers(db);
		echo $users->CreateUser();
	}
?>
<!DOCTYPE html>
<html>
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
	<style>
		.error {
			color: #FF0033; 
			font-style: italic; 
			font-size: 12px; 
			font-weight: bold; 
			vertical-align:-17px;
			text-decoration: underline;
		}
	</style>
</head>
<body>
	<div class='container'>
		<div class='panel panel-primary dialog-panel'>
			<div class='panel-heading'>
				<h5>Add new User</h5>
			</div>
			<div class='panel-body'> 
				<script>
					$(document).ready(function(){
						$('[data-toggle="tooltip"]').tooltip();   
					});
				</script>
				<form class='form-horizontal' role='form' method="post" action="addnewuser.php" id="registerform">
					<div class='form-group'>
				
						<!-- ________  Real name  ________ -->
						<label class='control-label col-md-2 col-md-offset-2' for="realName">Real Name:</label>
						<div class='col-md-2' >
							<input class="form-control" type="text" name="realName" id="realName" size="25" maxlength="30" 
								width="7%" onblur="return validate_input(id, <?php echo $realNameRegEx; ?>, 'realNameErr');" required />
						</div>
						<div class='col-md-2' >
							<img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" 
								data-toggle="tooltip" title="First and last names. Input should be capitalized.">        
						</div>
						<div class="error" id="realNameErr"></div>
					</div>
					<div class='form-group'>
		  
						<!-- ________  User name  ________ -->
						<label class='control-label col-md-2 col-md-offset-2' for="userName">User Name: </label>
						<div class='col-md-2' >
							<input class="form-control" type="text" name="userName" id="userName" size="25" maxlength="30" 
								width="7%" onblur="return validate_input(id, <?php echo $userNameRegEx; ?>, 'userNameErr');" required />
						</div>
						<div class='col-md-2' >
							<img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" 
								data-toggle="tooltip" title="User name may contain letters, digits and underscore. It should not start with 'EXP_'">        
						</div>
						<div class="error" id="userNameErr"></div>
					</div>
					<div class='form-group'>
						
						<!-- ________  Password  ________ -->
						<label class='control-label col-md-2 col-md-offset-2' for="password">Password: </label>
						<div class='col-md-2' >
							<input class="form-control" type="password" name="password" id="password" size="16" maxlength="30" 
								width="7%" onblur="return validate_input(id, 8, 'passwordErr');" required />
						</div>
						<div class='col-md-2' >
							<img src="../common/eye.png" id="eye" alt="eye icon" height="20" width="20" data-placement="right" 
								data-toggle="tooltip" title="show password">	Not working yet!
							<script src="../scripts/showHide.js"></script>
							<br><img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" 
								data-toggle="tooltip" title="password must be at least 8 characters. Use letters, digits and special 
									characters in order to generate a strong password">        
						</div>
						<div class="error" id="passwordErr"></div>
					</div>
					<div class='form-group'>
				
						<!-- ________  Amdocs mail  ________ -->
						<label class='control-label col-md-2 col-md-offset-2' for="mail">Amdocs Mail: </label>
						<div class='col-md-2' >
							<input class="form-control" type="email" name="mail" id="mail" size="30" maxlength="30" 
								width="7%" onblur="return validate_input(id, <?php echo $amdocsMailRegEx; ?>, 'mailErr');" required />
						</div>
                        <div class='col-md-2' >
							<img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" 
								data-toggle="tooltip" title="Amdoc domain email address.">        
						</div>
						<div class="error" id="mailErr"></div>
					</div>
					<div class='form-group'>
				
						<!-- ________  Phone  ________ -->
						<label class='control-label col-md-2 col-md-offset-2' for="phone">Phone: </label>
						<div class='col-md-2' >
							<input class="form-control" type="tel" name="phone" id="phone" size="30" maxlength="15" 
								width="7%" onblur="return validate_input(id, <?php echo $phoneRegEx; ?>, 'phoneErr');" />
						</div>
						<div class='col-md-2' >
							<img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" 
								data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
            </div>
          <div class='form-group'>
		  
				<!-- Role -->
           <label class='control-label col-md-2 col-md-offset-2' for="role">Role: </label>
            <div class='col-md-2' >
                <?php
					include_once '../helpers/getEnumValuesFromTable.php';
					echo enumDropdown('users',__users_tl_role);
				?>
            </div>
            <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
           </div>                
          <div class='form-group'>
				
				<!-- Account -->
           <label class='control-label col-md-2 col-md-offset-2' for="account">Account: </label>
            <div class='col-md-2' >
            <?php
            include_once '../helpers/getDropDownListFromTableData.php';
            echo dataDropdown('clusters',__cluster_tl_account_name);
			?>
                </div>
            <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
           </div>
           <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
			  <button class='btn-lg btn-primary' type="submit" name="register" id="register" value="Register user" onclick="return confirm('Are you sure?')">Add User </button>
            </div>
          </div>
        </form>
        <div class='col-md-3'>
            <button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel">Cancel</button>
                <script>
                 $('#cancelButton').on('click', function (e) {
                    window.location.href ="../cssmenu/mainPage.php";
                    }
                 )
                 </script>
        </div>
      </div>
    </div>
  </div>
 </body>
<script src="../scripts/formDataValidation.js"></script>
</html>

<!-- option for representation. -->
<?php 
	else:
		if(!(isset($_SESSION['LoggedIn'])) || $_SESSION['LoggedIn']==0):
?>
	<meta http-equiv="refresh" content="0;../user/login.php">
<?php
		else:
		echo "<script type=\"text/javascript\"> alert(\"This page is not available for OPS employees.\"); </script>";
?>
	<meta http-equiv="refresh" content="0;../cssmenu/mainPage.php">
<?php
		endif;
	endif;
?>