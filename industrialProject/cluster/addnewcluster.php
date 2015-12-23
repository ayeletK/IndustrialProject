<?php
	include_once '../common/base.php';
	
	// check user is logged in and is certified to add new cluster to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']=='SM'):
	
	// regEx for client side validation check
	$clusterNameRegEx = $accountNameRegEx = '/^[a-zA-Z0-9_\- ]+$/';
	
    // define variables and set to empty values
    $cluster_name = $account_name = "";				//Ayelt-TODO: is it needed?
    
    if(!empty($_POST['cluster_name']) && !empty($_POST['account_name'])) {
		include_once "../inc/class.cluster.inc.php";
		$cluster_group = new ClustersTool(db);
		echo $cluster_group->AddNewCluster();
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
				<h5>Adding new cluster to system</h5>
			</div>
			<div class='panel-body'>
				<form class='form-horizontal' role='form' method="post" type="submit" action="addnewCluster.php">
					<div class='form-group'>
					
						<!--	Cluster name		-->
						<label class='control-label col-md-2 col-md-offset-2' for='cluster_name:'>new cluster name:</label>
						<div class='col-md-2'>
							<input class="form-control" type="text" name="cluster_name" id="cluster_name" size="25" maxlength="30" 
								width="7%" onblur="return validate_input(id, <?php echo $clusterNameRegEx; ?>, 'error1');" required />
<!--						<span id="cluster_err" style="display: none;">you must enter a legal cluster which doesnt already exist</span>	-->
						</div>
						<div class="error" id="error1"></div>
					</div>
					<div class='form-group'>
					
						<!--	Account name		-->
						<label class='control-label col-md-2 col-md-offset-2' for='account_name'>Account name:</label>
						<div class='col-md-2'>
							<input class="form-control" type="text" name="account_name" id="account_name" size="25" maxlength="30" 
								width="7%" onblur="return validate_input(id, <?php echo $accountNameRegEx; ?>, 'error2');" required/>
<!--						<span id="account_err" style="display: none;">you must enter a legal account which doesnt already exist</span>		-->
						</div>
						<div class="error" id="error2"></div>
					</div>
					<div class='form-group'>
					
						<!--	Submit		-->
						<button class='btn-lg btn-primary' type="submit" name="new_task" id="new_task">Add new Cluster</button>
						<div class='col-md-offset-4 col-md-3'></div>
					</div>
        
				</form>
				<div class='col-md-3'>
				
					<!--	Cancel		-->
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

<?php 
	else:
		if(!(isset($_SESSION['LoggedIn'])) || $_SESSION['LoggedIn']==0):
?>
	<meta http-equiv="refresh" content="0;../user/login.php">
<?php
		else:
		echo "<script type=\"text/javascript\"> alert(\"This page is available for SM employees only!\"); </script>";
?>
	<meta http-equiv="refresh" content="0;../cssmenu/mainPage.php">
<?php
		endif;
	endif;
	//include_once "../common/close.php";
?>