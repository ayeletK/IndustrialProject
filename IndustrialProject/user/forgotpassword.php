<?php
    include_once '../common/base.php';
	
	// if user is logged in
	if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == 1){
		header('Location: ../cssmenu/mainPage.php');
	}
	
	// regEx for client side validation check
	$amdocsMailRegEx = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@amdocs[\.]com$/';
 
    if (!empty($_POST['mail'])) {
        include_once "../inc/class.users.inc.php";
        $users = new ToolUsers(db);
		echo $users->ResetForgottenPassword();
    }
?>
<!DOCTYPE html>
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

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
				<form class='form-horizontal' role='form' method="post" action="forgotpassword.php" id="registerform">
					<div class='form-group'>
				
						<!-- ________  Amdocs mail  ________ -->
						<label class='control-label col-md-2 col-md-offset-2' for="mail">Amdocs Mail: </label>
						<div class='col-md-2' >
							<input class="form-control" type="email" name="mail" id="mail" size="30" maxlength="30" 
								width="7%" onblur='return validate_input(id, <?php echo $amdocsMailRegEx; ?>, "mailErr");' required />
						</div>
                        <div class='col-md-1' style="width: auto;">
							<img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" 
								data-toggle="tooltip" title="Amdoc domain email address.">        
						</div>
						<div class="error" id="mailErr"></div>
					</div>
					<div class='form-group'>
						
						<!-- ________  Submit  ________ -->
						<div class='col-md-offset-4 col-md-3'>
							<button class='btn-lg btn-primary' type="submit" name="forgottenPassword" id="forgottenPassword" 
							value="Reset password" onclick="return confirm('Are you sure?')">Reset Password </button>
						</div>
					</div>
				</form>
				<div class='col-md-3'>
						
						<!-- ________  Cancel  ________ -->
					<button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel">Cancel</button>
					<script>
						$('#cancelButton').on('click', function (e) {
						window.location.href ="../cssmenu/mainPage.php";
						})
					</script>
				</div>
			</div>
		</div>
	</div>
</body>
<script src="../scripts/formDataValidation.js"></script>
</html>
