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
    // define variables and set to empty values
	 $clusterErr="";
	 $cluster_name="";

	//include_once "scripts/showHide.php";
    
    if(!empty($_POST['usersData'])) {
		include_once "../inc/class.users.inc.php";
		$users = new ToolUsers(db);
		echo $users->RemoveUser();
	}
?>

  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h5>Remove user</h5>
      </div>
      <div class='panel-body'> 
        <form class='form-horizontal' role='form' method="post" action="removeuser.php">
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for="realName">Search by real name:  -- not supported yet -- name:</label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="realName" id="realName" size="25" maxlength="30" width="7%" onchange="changeTest(this.form)" />
            </div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
            <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
           </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for="userName">Search by user name:  -- not supported yet --</label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="userName" id="userName" size="25" maxlength="30" width="7%" onchange="changeTest(this.form)" />
               </div>
             <div class='col-md-2' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Ayelet- if you want change here an include only Letters and digits">        
            </div>
           </div>
           <div class='form-group'>
           <div class='col-md-offset-4 col-md-3'>
           	<?php 
					include_once '../helpers/getDropDownListFromTableData.php';
					$columns = array(__users_tl_real_name,__users_tl_user_name);
					echo getColumnsFromTable('users',$columns, 10);
			?>
           </div>
           </div>
          <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-primary' type="submit" name="register" id="register" value="Remove user" onclick="return confirm('Are you sure?')">Remove </button>
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
<script src="addnewcluster.js"></script>
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
