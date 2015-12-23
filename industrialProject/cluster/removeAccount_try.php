<?php
	include_once '../common/base.php';
	$query ="SELECT DISTINCT cluster_name FROM clusters";
	$results = mysql_query($query) or die("Error");
?>
<html>
<head>
<TITLE>jQuery Dependent DropDown List - Clusters and Accounts</TITLE>
<head>

<style>
body{width:610px;}
.frmDronpDown {border: 1px solid #F0F0F0;background-color:#C8EEFD;margin: 2px 0px;padding:40px;}
.demoInputBox {padding: 10px;border: #F0F0F0 1px solid;border-radius: 4px;background-color: #FFF;width: 50%;}
.row{padding-bottom:15px;}
</style>

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
		alert("dete is: "+data);
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
<div class="frmDronpDown">
<div class="row">
<label>Cluster:</label><br/>
<select name="cluster" id="cluster-list" class="demoInputBox" onChange="getAccount(this.value);">
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
<div class="row">
<label>Account:</label><br/>
<select name="account-list" id="account-list" class="demoInputBox">
<option value="">Select Account</option>
</select>
</div>
</div>
</body>
</html>