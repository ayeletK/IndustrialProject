<?php
	echo $_SERVER['REQUEST_METHOD'];
	include_once '../common/base.php';
	echo '<h3>in get_account_under_cluster.php</h3><br><br><br><br>';
	if(!empty($_POST["cluster_id"])) {
	$query ="SELECT * FROM ".__cluster_table_name." WHERE ".__cluster_tl_cluster_name." = '" . $_POST["cluster_id"] . "' AND ".__cluster_tl_expired_date." IS NULL ORDER BY account_name ASC ";
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