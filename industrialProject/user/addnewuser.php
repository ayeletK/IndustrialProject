<?php
    include_once "../common/base.php";
    $pageTitle = "Add New User";
    include_once "../common/header.php";
    include_once "../common/sidebar.php";
    include_once "../common/section.php";
	
	// check user is logged in and is certified to add new user to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']!='OPS'):
	
	// define variables and set to empty values
	$realNameErr = $userNameErr = $passwordErr = $mailErr = $phoneErr = $roleErr = "";

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
                <input class="form-control" type="text" name="realName" id="realName" size="25" maxlength="30" width="7%" onchange="changeTest(this.form)" />
            </div>
            <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
            </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="userName">User Name: </label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="userName" id="userName" size="25" maxlength="30" width="7%" onchange="changeTest(this.form)" />
            </div>
           <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="password">Password: </label>
            <div class='col-md-2' >
                <input class="form-control" type="password" name="password"  value="unix-11" id="password" size="16" maxlength="30" width="7%" onchange="changeTest(this.form)" />
            </div>
          <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="mail">Amdocs Mail: </label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="mail" id="mail" size="30" maxlength="30" width="7%" onchange="changeTest(this.form)" />
            </div>
                        <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
           </div>
          <div class='form-group'>
           <label class='control-label col-md-2 col-md-offset-2' for="phone">Phone: </label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="phone" id="phone" size="30" maxlength="15" width="7%" onchange="changeTest(this.form)" />
            </div>
            <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
            </div>
          <div class='form-group'>
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
              <button class='btn-lg btn-primary' type="submit" name="register" id="register" value="Register user" onclick="return confirm('Are you sure?')">Remove </button>
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
<script language="javascript" type="text/javascript">
	function changeTest ( form ) 
	{
		form.userName.value = form.realName.value
	}				
</script>


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
	include_once "../common/base.php";
?>