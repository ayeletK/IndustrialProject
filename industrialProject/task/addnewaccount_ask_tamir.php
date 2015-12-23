<!DOCTYPE html>
<?php

	include '../common/base.php';
	
    // define variables and set to empty values
	//global $clusterErr, $AccountErr ,$cluster_name ,$account_name;
    $clusterErr = $AccountErr = $cluster_name = $account_name = "";
    
    if(!empty($_POST['cluster_name']) && !empty($_POST['account_name'])) {
		include_once "../inc/class.cluster.inc.php";
		$cluster_group = new ClustersTool(db);
		echo $cluster_group->AddNewCluster();
     }
?>    
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
</head>
<body>
  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h5>Adding new cluster to system</h5>
      </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" onsubmit="return validateClusterForm();" action="addnewCluster.php">
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='cluster_name:'>new cluster name:</label>
            <div class='col-md-2'>
            <input class="form-control" type="text" name="cluster_name" id="cluster_name" size="25" maxlength="30" width="7%"/>
            </div>
            <span class="error" id='error1'>*<?php echo $clusterErr;?></span>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='account_name'>Account name:</label>
            <div class='col-md-2'>
                <input class="form-control" type="text" name="account_name" id="account_name" size="25" maxlength="30" width="7%"/>
            </div>
            <td><span class="error"> *<?php echo $AccountErr;?></span></td>
          </div>
          <div class='form-group'>
              <button class='btn-lg btn-primary' type="submit" name="new_task" id="new_task">Add new Cluster</button>
            <div class='col-md-offset-4 col-md-3'>
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