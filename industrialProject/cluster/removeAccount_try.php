<!DOCTYPE html>
<?php
	include_once '../common/base.php';
	$query ="SELECT DISTINCT ".__cluster_tl_cluster_name." FROM ".__cluster_table_name." WHERE ".__cluster_tl_expired_date." IS NULL ORDER BY ".__cluster_tl_cluster_name." ASC";
	$results = mysql_query($query) or die("Error");
    	
	// check user is logged in and is certified to add new account to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']=='SM'):
	
	
    if(!empty($_POST['cluster_name']) && !empty($_POST['account_name'])) {
        include_once "../inc/class.cluster.inc.php";
            $cluster_group = new ClustersTool(db);
            echo $cluster_group->removeAccountFromCluster();
       }
?>

<head>
<TITLE>jQuery Dependent DropDown List - Clusters and Accounts</TITLE>

<style>
body{width:610px;}
.frmDronpDown {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 2px 0px;padding:40px;}
.demoInputBox {padding: 10px;border: #F0F0F0 1px solid;border-radius: 4px;background-color: #FFF;width: 50%;}
.row{padding-bottom:15px;}
</style>
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

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>

<script type="text/javascript">
function getAccount(val) {
	$.ajax({
	type: "POST",
	url: "get_account_under_cluster.php",
	data:'cluster_id='+val,
	success: function(data){
		$("#account-list").html(data);
	},
	error: function(data){
		alert("failed");
		alert("data is: "+data);
	}
	});
}

function selectCluster(val) {
	$("#search-box").val(val);
	$("#suggesstion-box").hide();
}

</script>
</head>
<body>
 <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h5>Remove Account from Cluster</h5>
      </div>
      <div class='panel-body'>
         <form class='form-horizontal' role='form' method="post" action="removeAccount_try.php">
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='account_name'>Cluster Name</label>
            <div class='col-md-2' >
                <select name="cluster" id="cluster-list" class="form-control" onChange="getAccount(this.value);">
<option value="">Select Cluster</option>
<?php
while ($row = mysql_fetch_array($results)) {
?>
<option value="<?php echo $row["cluster_name"]; ?>"><?php echo $row["cluster_name"]; ?></option>
<?php
}
?>
</select>

             </div>

          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='account_name'>Account Name</label>
            <div class='col-md-2' >
<select name="account-list" id="account-list" class="form-control">
<option value="">Select Account</option>
</select>


             </div>

          </div>  
          <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-primary' type="submit" name="submit" id="submit">Add Account</button>
            </div>
          </div>          
</form>       
        <div class='col-md-3'>
            <button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel" onclick="return confirm_out('Are you sure?')">Cancel</button>
                <script>
        
                 function confirm_out() {
   
    if (confirm("are you sure?") == true) {
        window.location.href ="../cssmenu/mainPage.php";
     }
    }

                 </script>
        </div>   
          </div>          
          </div>          
 </div>          

</body>
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