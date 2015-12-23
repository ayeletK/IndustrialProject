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
    
    include_once "common/base.php";
	
    // define variables and set to empty values
	 global $clusterErr, $cluster_name;
	 $clusterErr= $cluster_name="";

    //include_once "common/myFiles/header.php";
	//include_once "scripts/showHide.php";
    
    if(!empty($_POST['cluster_name'])) {
		include_once "../inc/class.cluster.inc.php";
            $cluster_group = new ClustersTool($db);
            echo $cluster_group->removeAccountFromCluster();
    }
?>

<h2>remove An Account from Cluster</h2>
<form class="form-signin" role="form" method="post" action="removeAccount.php"> 
   <br><br>
   <?php
    $query = mysql_query("SELECT DISTINCT cluster_name FROM `clusters`"); // Run your query

echo '<select name="cluster_name">'; // Open your drop down box

// Loop through the query results, outputing the options one by one
while ($row = mysql_fetch_array($query)) {
   echo '<option value="'.$row['cluster_name'].'">'.$row['cluster_name'].'</option>';
}

echo '</select>';

    $cluster_name = test_input($_POST["cluster_name"]);
    
    $query = mysql_query("SELECT DISTINCT ".__cluster_tl_account_name." FROM clusters WHERE ".__cluster_tl_cluster_name." LIKE '$cluster_name' "); // Run your query

echo '<select name="account_name">'; // Open your drop down box

// Loop through the query results, outputing the options one by one
while ($row = mysql_fetch_array($query)) {
   echo '<option value="'.$row['account_name'].'">'.$row['account_name'].'</option>';
}

echo '</select>';
?>
    <br><br>
   <input type="submit" name="submit" value="Are you sure you want to remove this cluster">    <br><br>
   <button onclick="goBack()">Back to main</button>
<!-- TODO: change the back to main page and not back page-->
    <script>
    function goBack() {
        window.history.back();
    }
    </script>
</form>

</body>
</html>