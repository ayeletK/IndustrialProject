<!DOCTYPE HTML> 
<html>
<head>
    <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #F3FFE3;
			text-align: .center;
         }
         
         .form-remove {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #000000;
         }
         
         .form-remove .form-remove-heading,
         .form-remove .checkbox {
            margin-bottom: 10px;
         }
         
         .form-remove .checkbox {
            font-weight: normal;
         }
         
         .form-remove .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-remove .form-control:focus {
            z-index: 2;
         }
         
         .form-remove input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#000000;
         }
         
         .form-remove input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#000000;
         }
         
         h2{
            text-align: center;
            color: #000000;
         }
        .error {color: #00FF00;}
    </style>
<style>
.error {color: #00FF00;}
</style>
</head>
<body> 


<?php
    
    include_once "common/base.php";
    // define variables and set to empty values
	 $clusterErr="";
	 $cluster_name="";

    //include_once "common/myFiles/header.php";
	//include_once "scripts/showHide.php";
    
    if(!empty($_POST['usersData'])) {
		include_once "inc/class.users.inc.php";
		$users = new ToolUsers(db);
		echo $users->RemoveUser();
	}
?>


<script language="javascript" type="text/javascript">
	function changeTest ( form ) 
	{
		form.userName.value = form.realName.value
	}				
</script>

<h2>Remove user</h2>
<form class="form-remove" role="form" method="post" action="removeuser.php"> 
   <table style="width:120%" cellspacing="20px">
		<tr>
			<td><label for="realName">Search by real name:  -- not supported yet --</label></td>
		</tr>
		<tr>
			<td><input type="text" name="realName" id="realName" size="25" maxlength="30" onchange="changeTest(this.form)" /></td>
		</tr>
		<tr>
			<td><label for="userName">Search by user name:  -- not supported yet --</label></td>
			
		</tr>
		<tr>
			<td><input type="text" name="userName" id="userName" size="25" maxlength="30" /></td>
		</tr>
		<tr>
			<td>
				<?php 
					include_once 'helpers/getDropDownListFromTableData.php';
					$columns = array(__users_tl_real_name,__users_tl_user_name);
					echo getColumnsFromTable('users',$columns, 10);
				?>
			</td>
		</tr>
		<tr>
			<td align="right"><input type="submit" name="register" id="register" value="Remove user" onclick="return confirm('Are you sure?')"/></td>
		</tr>
	</table>
</form>

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

</body>
</html>