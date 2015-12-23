<?php
	echo $_SERVER['REQUEST_METHOD'];
	include_once '../common/base.php';
	echo '<h3>in get_account_under_cluster.php</h3><br><br><br><br>';
	if(!empty($_POST["cluster_id"])) {
	$query ="SELECT * FROM clusters WHERE cluster_name = '" . $_POST["cluster_id"] . "'";
	echo $query.'<br>';
	$results = mysql_query($query) or die (mysql_error());
?>
<!--	<option value="">Select Account</option>	-->
<?php
	while ($row = mysql_fetch_array($results)) {
?>
	<option value="<?php echo $row["account_id"]; ?>"><?php echo $row["account_name"]; ?></option>
<?php
	}
}
?>