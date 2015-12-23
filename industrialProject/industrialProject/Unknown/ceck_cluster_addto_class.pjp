
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$data_correct = 1;
		
        //check validation of "name" input
        //todo: check that the accountname doesn't allready exist in database
		if (empty($_POST["cluster_name"])) {
			$data_correct = 0;
			$clusterErr = "account Name is required";
		} else {
			$cluster_name = test_input($_POST["cluster_name"]);
			if (!preg_match("/^[a-zA-Z0-9 ]*$/",$cluster_name)) {
				$clusterErr = "account name shouldn't contain special characters";
				$data_correct = 0;
			}
		}
        // check validation for managerAccount
        //TODO: add a validation check that manager exost in the database
		if (empty($_POST["account_name"])) {
			$data_correct = 0;
			$AccountErr = "at least one new account under the cluster is required";
		} else{
			$account_name = test_input($_POST["account_name"]);
            if (!preg_match("/^[a-zA-Z0-9 ]*$/",$account_name)) {
				$AccountErr = "account name should contain only letters";
				$data_correct = 0;
			}
		}
		echo"data correct?". $data_correct;
		if ($data_correct == 1){

			$query = "SELECT count(*) From `Clusters` WHERE cluster_name LIKE '$cluster_name'";
			$is_user_exist = mysql_query($query) or die(mysql_error());
			$result =  mysql_result($is_user_exist, 0) ;
			if (! ($result == 0)){
				echo "Account already exist";
			} else {
				mysql_query("INSERT INTO Clusters (`cluster_name`,`account_name`)
					VALUES('$cluster_name','$account_name')") or die(mysql_error());
			}
			
		}
	}

    
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
