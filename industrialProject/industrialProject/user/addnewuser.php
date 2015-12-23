<!DOCTYPE HTML> 
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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>
<body>
<?php
    
    include_once "../common/base.php";
    $pageTitle = "Register";
	
	// define variables and set to empty values
	$realNameErr = $userNameErr = $passwordErr = $mailErr = $phoneErr = $roleErr = "";

    //include_once "../common/header.php";
	//include_once "scripts/showHide.php";
    
    if(!empty($_POST['realName']) && !empty($_POST['userName']) && !empty($_POST['password']) && !empty($_POST['mail'])) {
		include_once "../inc/class.users.inc.php";
		$users = new ToolUsers(db);
		echo $users->CreateUser();
	}
?>

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
           <label class='control-label col-md-2 col-md-offset-2' for="realName">Real Name:</label>
            <div class='col-md-2' >
                <a href="#" data-placement="top" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">
                <input class="form-control" type="text" name="realName" id="realName" size="25" maxlength="30" width="7%" onchange="changeTest(this.form)" />
                <!--onblur="return validate_account_name(value);"-->
                </a>
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="userName">User Name: </label>
            <div class='col-md-2' >
                <a href="#" data-placement="top" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">
                <input class="form-control" type="text" name="userName" id="userName" size="25" maxlength="30" width="7%" onchange="changeTest(this.form)" />
                <!--onblur="return validate_account_name(value);"-->
                </a>
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="password">Password: </label>
            <div class='col-md-2' >
                <a href="#" data-placement="top" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">
                <input class="form-control" type="password" name="password"  value="unix-11" id="password" size="16" maxlength="30" width="7%" onchange="changeTest(this.form)" />
                <!--onblur="return validate_account_name(value);"-->
                </a>
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="mail">Amdocs Mail: </label>
            <div class='col-md-2' >
                <a href="#" data-placement="top" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">
                <input class="form-control" type="text" name="mail" id="mail" size="30" maxlength="30" width="7%" onchange="changeTest(this.form)" />
                <!--onblur="return validate_account_name(value);"-->
                </a>
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="phone">Phone: </label>
            <div class='col-md-2' >
                <a href="#" data-placement="top" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">
                <input class="form-control" type="text" name="phone" id="phone" size="30" maxlength="15" width="7%" onchange="changeTest(this.form)" />
                <!--onblur="return validate_account_name(value);"-->
                </a>
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="role">Role: </label>
            <div class='col-md-2' >
                <a href="#" data-placement="top" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">
                <?php
                include_once '../helpers/getEnumValuesFromTable.php';
                echo enumDropdown('users',__users_tl_role);
						?>
                </a>
            </div>
           </div>                
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="account">Account: Mail: </label>
            <div class='col-md-2' >
            <?php
            include_once '../helpers/getDropDownListFromTableData.php';
            echo dataDropdown('clusters',__cluster_tl_account_name);
			?>
                <a href="#" data-placement="top" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">
                <input class="form-control" type="text" name="mail" id="mail" size="30" maxlength="30" width="7%" onchange="changeTest(this.form)" />
                <!--onblur="return validate_account_name(value);"-->
                </a>
            </div>
           </div>
           <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-primary' type="submit" name="register" id="register" value="Register user" onclick="return confirm('Are you sure?')">Remove </button>
            </div>
          </div>
        </form>
        <div class='col-md-3'>
            <button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel">Cancel</button>
                <script>
                 $('#cancelButton').on('click', function (e) {
                    window.location.href ="../cssmenu/index.html";
                    }
                 )
                 </script>
        </div>
          
      </div>
    </div>
  </div>
</body>
<script language="javascript" type="text/javascript">
	function changeTest ( form ) 
	{
		form.userName.value = form.realName.value
	}				
</script>


<!-- option for representation. -->
<?php /*$sql = "SELECT * FROM users";
                            $res = mysql_query($sql);
                            if (mysql_num_rows($res)) {
                            //$query = mysql_query("SELECT * FROM users ORDER BY real_name");
                            $i=1;
                            while($row =  mysql_fetch_array($res)){
                            ?>

<input type="checkbox" name="checkboxstatus[<?php echo $i; ?>]" value="<?php echo $row['real_name']; ?>" /><?php echo $row['real_name']; ?></option>

<?php $i++; }}*/ ?>
