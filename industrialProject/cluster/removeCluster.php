<!DOCTYPE HTML> 
<html>
<head>
    <style>

    </style>
<style>
.error {color: #00FF00;}
</style>
</head>
<body> 
<?php

	include '../common/base.php';

	// define variables and set to empty values
	global $clusterErr ,$cluster_name ;
    $clusterErr = $cluster_name = "";

    if(!empty($_POST['cluster_name'])) {
		include_once "../inc/class.cluster.inc.php";
		$cluster_group = new ClustersTool(db);
        echo $cluster_group->RemoveCluster();
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
        <h5>remove cluster from system</h5>
      </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" action="removeCluster.php">
          <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2' for='cluster_name'>cluster name:</label>
              <div class='col-md-2'>
                <div class='form-group internal'>                
                <?php
                
                $query = mysql_query("SELECT DISTINCT ".__cluster_tl_cluster_name." FROM `clusters` WHERE ".__cluster_tl_expired_date." IS NULL"); // Run your query

                echo '<select class="form-control" name="cluster_name">'; // Open your drop down box

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
              <button class='btn-lg btn-primary' type="submit" name="submit" id="submit">Remove Cluster</button>
            </div>
          </div>
        </form>
        <div class='col-md-3'>
            <button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel" onclick="return confirm('Are you sure?')">Cancel</button>
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

