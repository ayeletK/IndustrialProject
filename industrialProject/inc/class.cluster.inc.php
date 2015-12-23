<?php
	/**
     * the function gets data as parameter to correct, and remove spaces from 
     *the beginning of the string ans its end, correct data to be read as string
     *(not runnable, remove special characters 
     * @return the corrected string 
     */    
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
/**
 * Handles user interactions within the app
 *
 *	wanted actions:
 *		Create new Cluster
 *		add new Account to existing cluster
 *      remove existing cluster
 *		remove existing account from cluster
 *
 */
class ClustersTool
{
	/**
     * The database object
     *
     * @var object
     */
    private $_db;

    /**
     * Checks for a database object and creates one if none is found
     *
     * @param object $db
     * @return void
     */
    public function __construct($db=NULL)
    {
        if($db != NULL)
        {
            $this->_db = $db;
        }
        else
        {
			include_once 'inc/constants.inc.php';
            $connection = mysql_connect($dbhost, $dbuser, $dbpass) ;
			mysql_select_db($db);
        }
    }
    


 
	/**
     * Changes the cluster's name
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function updateCluster()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            
            //check validation of "name" input
            //todo: check that the accountname doesn't allready exist in database
            if (empty($_POST["account_name"])) {
                $data_correct = 0;
                $AccountErr = "account Name is required";
            } else {
                $account_name = test_input($_POST["account_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$account_name)) {
                    $AccountErr = "account name shouldn't contain special characters";
                    $data_correct = 0;
                }
            }
            if (empty($_POST["cluster"])) {
                $data_correct = 0;
                $clusterErr = "account Name is required";
            } else {
                $cluster = test_input($_POST["cluster"]);
                if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$cluster)) {
                    $clusterErr = "account name shouldn't contain special characters";
                    $data_correct = 0;
                }
            }
            //echo"data correct?". $data_correct;
            if ($data_correct == 1){
                $query = "SELECT count(*) From `clusters` WHERE account_name LIKE '$account_name' AND cluster_name LIKE '$cluster_name'";
                $is_user_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_user_exist, 0) ;
                if (! ($result == 0)){
                    //echo "Account already exist in this cluster";
                } else {
                    mysql_query("INSERT INTO clusters (`cluster_name`, `account_name`)
                        VALUES('$cluster_name', '$account_name')") or die(mysql_error());
                }
                
            }
        }
     }

     /**
     * insert new cluster into database
     * each new cluster should include at least a new account
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function AddNewCluster()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            
            //====================================================
            //	check validation of "cluster_name" input
            //====================================================
            if (empty($_POST["cluster_name"])) {
                $data_correct = 0;
                $clusterErr = "cluster Name is required";
            } else {
                $cluster_name = test_input($_POST["cluster_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$cluster_name)) {
                    $clusterErr = "account name shouldn't contain special characters";
                    $data_correct = 0;
                }
            }//close the else
            
            //====================================================
            //	check validation of "account_name" input
            //====================================================            
            //todo: check that the accountname doesn't allready exist in database
            if (empty($_POST["account_name"])) {
                $data_correct = 0;
                $AccountErr = "account Name is required";
            } else {
                $account_name = test_input($_POST["account_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$account_name)) {
                    $AccountErr = "account name shouldn't contain special characters";
                    $data_correct = 0;
                }
            }
            
            //====================================================
            //when all inputs are correct-
            //  insert new cluster with account to dbt_name" input
            //====================================================             
            if ($data_correct == 1){
                $query = "SELECT count(*) From `clusters` WHERE account_name LIKE '$account_name' OR cluster_name LIKE '$cluster_name'";
                $is_account_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_account_exist, 0) ;
                if (! ($result == 0)){
                    //header('location: ../industrialProject/addnewcluster.php');
                    echo '<script language="javascript">';
                    echo 'alert("Account or cluster already exist in this cluster")';
                    echo '</script>';
                    //header('location: ../industrialProject/addnewcluster.php');

                    //echo "Account or cluster already exist in this cluster";
                } else {
                    mysql_query("INSERT INTO clusters (`cluster_name`, `account_name`)
                        VALUES('$cluster_name', '$account_name')") or die(mysql_error());
                    echo '<script language="javascript">';
                    echo 'alert("cluster added successfully")';
                    echo '</script>';
                    
                    //header('Location: ../cssmenu/index.html');
                }//closing else 
            }// closing if for adding to db
        }
     }//closing function
	
    
    /**
     * removeCluster the function gets cluster name 
     (we assume the value is always valid)
     * turn cluster and all accounts under this cluster to be expired 
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function RemoveCluster()
    {

        //add are you sure you want to remove this cluster?
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;

            //====================================================
            //	validate cluster was chose and not empty
            //====================================================             
            if (empty($_POST["cluster_name"])) {
                $data_correct = 0;
                $clusterErr = "cluster to remove wasn't selected";
            }
           
            //====================================================
            //	if all the input are correct- turn a cluster and all
            //its related account to expired in db
            //==================================================== 
            if ($data_correct == 1){
                $cluster_name = test_input($_POST["cluster_name"]);
                $date = date("Y-m-d");
                $removeQuery = "UPDATE clusters SET Expired='$date' WHERE cluster_name LIKE '$cluster_name'";
                $removeQuery = mysql_query($removeQuery) or die(mysql_error());
                
            if (! (mysql_errno())){
                    echo '<script language="javascript">';
                    echo 'alert("removed cluster Successfully!")';
                    echo '</script>';                   

                } else {
                    echo '<script language="javascript">';
                    echo 'alert("unable to remove this cluster")';
                    echo '</script>';                
                    }
            }
        }
     }
     
     
     /**
     * addAccountToCluster- 
     * gets through $_POST name of an exist cluster, name for new cluster
     * validate the new account is legal and doesn't exist in db at any cluster
     @ in case the account_name is correct, add account to db
     */    
    public function addAccountToCluster()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            
            //====================================================
            //	validate account_name input
            //====================================================            
            if (empty($_POST["account_name"])) {
                $data_correct = 0;
                $AccountErr = "account Name is required";
            } else {
                $account_name = test_input($_POST["account_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$account_name)) {
                    $AccountErr = "account name shouldn't contain special characters";
                    $data_correct = 0;
                }
            }
            
            //====================================================
            //	validate cluster_name input
            //====================================================            
            if (empty($_POST["cluster_name"])) {
                $data_correct = 0;
                $clusterErr = "cluster to remove wasn't selected";
            } else {
                $cluster_name = test_input($_POST["cluster_name"]);
                $query = "SELECT count(*) From `clusters` WHERE account_name LIKE '$account_name' ";
                $is_user_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_user_exist, 0) ;
                if (! ($result == 0)){
                    $data_correct = 0;
                    echo '<script language="javascript">';
                    echo 'alert("Account already exists in this cluster!")';
                    echo '</script>';                       
                    }
            }
            //====================================================
            //	update db
            //====================================================             
            if ($data_correct == 1){
                mysql_query("INSERT INTO clusters (`cluster_name`, `account_name`, `expired`)
                VALUES('$cluster_name', '$account_name', NULL)") or die(mysql_error());
                    echo '<script language="javascript">';
                    echo 'alert("Account added successfully!")';
                    echo '</script>';            
            }//closing if inserting
        }
     }//closing function
     
     
     /**
     * removeAccountFromCluster- 
     * gets through $_POST name of an exist account,
     * turn this account to expired
     @ in case the account_name is correct, add account to db
     */       
     public function removeAccountFromCluster()
    {
 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
   
            //====================================================
            //	validate account_name input
            //====================================================         
            if (empty($_POST["account_name"])) {
                $data_correct = 0;
                $AccountErr = "account Name is required";
            } else {
                $account_name = test_input($_POST["account_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$account_name)) {
                    $AccountErr = "account name shouldn't contain special characters";
                    $data_correct = 0;
                }
            }
            //====================================================
            //	validate cluster_name input
            //====================================================             
            //echo "$data_correct".$data_correct."\n";
            if (empty($_POST["cluster_name"])) {
                $data_correct = 0;
                $clusterErr = "cluster to remove wasn't selected";
            } else {
                $cluster_name = test_input($_POST["cluster_name"]);
                $query = "SELECT count(*) From `clusters` WHERE account_name LIKE '$account_name' AND cluster_name LIKE '$cluster_name'";
                $is_user_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_user_exist, 0) ;
                if (! ($result == 0)){
                    $data_correct = 0;
                    echo "Account already exists in this cluster"."\n";
                    }
            }
            
            //====================================================
            //	insert data into db
            //==================================================== 
            //echo"data correct?". $data_correct;
            if ($data_correct == 1){
                mysql_query("INSERT INTO clusters (`cluster_name`, `account_name`)
                VALUES('$cluster_name', '$account_name')") or die(mysql_error());
             }
        }
     }
    
} //closing class 

