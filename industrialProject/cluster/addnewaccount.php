<?php
    include_once '../common/base.php';
	
	// check user is logged in and is certified to add new account to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']=='SM'):
	
	// define variables and set to empty values
	//global $clusterErr, $AccountErr ,$cluster_name ,$account_name;
    $clusterErr = $AccountErr = $cluster_name = $account_name = "";
 
    if(!empty($_POST['cluster_name']) && !empty($_POST['account_name'])) {
        include_once "../inc/class.cluster.inc.php";
            $cluster_group = new ClustersTool(db);
            echo $cluster_group->addAccountToCluster();
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
        <h5>Adding new account to Cluster</h5>
      </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" action="addnewaccount.php">
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='account_name'>Account Name</label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="account_name" id="account_name" size="25" maxlength="30" width="7%" onblur="return validate_input(id, <?php echo $clusterNameRegEx; ?>, 'error1');" required />
            </div>
            <div class='col-md-2' >       
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Can include only Letters or digits">        
            </div>
            <div class="error" id="error1"></div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
          </div>
            <div class='form-group'>

            <!--	account dispersion		-->
            <label class='control-label col-md-2 col-md-offset-2' for='mailing_list:'>Account Mail</label>
            <div class='col-md-2'>
                <input class="form-control" type="text" name="mailing_list" id="mailing_list" size="25" maxlength="150" 
                    width="7%" onblur="return validate_input(id, <?php echo $dispersionMailRegEx; ?>, 'error1');" required />
            </div>
                        <div class='col-md-2' >       
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="For E-mail alerts about task enhancement for this account ">        
            </div>
            <div class="error" id="error1"></div>
            </div>
          <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2' for='cluster_name'>Under Cluster</label>
              <div class='col-md-2'>
                <div class='form-group internal'>                
                <?php
                $query = mysql_query("SELECT DISTINCT ".__cluster_tl_cluster_name." FROM ".__cluster_table_name." ORDER BY ".__cluster_tl_cluster_name." ASC "); // Run your query

                echo '<select class="form-control" name="cluster_name" required>'; // Open your drop down box

                // Loop through the query results, outputing the options one by one
                while ($row = mysql_fetch_array($query)) {
                   echo '<option value="'.$row['cluster_name'].'">'.$row['cluster_name'].'</option>';
                }

                echo '</select>';
                ?> 
      
                </div>
              </div>
              </div>
          <div class='form-group'>
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-primary' type="submit" name="submit" id="submit">Add Account</button>
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
<script src="addnewcluster.js"></script>
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
