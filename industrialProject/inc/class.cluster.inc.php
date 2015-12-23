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
 *		Create an Cluster
 *		Verify the user account
 *		Update the account email address
 *      Update the account phone number
 *		Update the account password
 *		Retrieve a forgotten password
 *		Delete the account
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
//            account_dispersion
            //echo"data correct?". $data_correct;
            if ($data_correct == 1){
                $query = "SELECT count(*) From `clusters` WHERE account_name LIKE '$account_name' AND cluster_name LIKE '$cluster_name'";
                $is_user_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_user_exist, 0) ;
                if (! ($result == 0)){
                    echo "Account already exist in this cluster";
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
            //echo $data_correct;
            if (empty($_POST["cluster_name"])) {
                $data_correct = 0;
                //echo "$data_correct".$data_correct;
                $clusterErr = "cluster Name is required";
            } else {
                $cluster_name = test_input($_POST["cluster_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$cluster_name)) {
                    $clusterErr = "account name shouldn't contain special characters";
                    $data_correct = 0;
                    //echo "line 129: $data_correct".$data_correct;
                }
            }//close the else
            
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
            //echo "line 14:$data_correct".$data_correct;
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

                    echo "Account or cluster already exist in this cluster";
                } else {
                    mysql_query("INSERT INTO clusters (`cluster_name`, `account_name`)
                        VALUES('$cluster_name', '$account_name')") or die(mysql_error());
                    echo '<script language="javascript">';
                    echo 'alert("cluster added successfully")';
                    echo '</script>';
                    

                    //header('Location: ../cssmenu/mainPage.php');
                    
                }
                
            }
        }
     }
	/**
     * Changes the cluster's name
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function RemoveCluster()
    {
        echo "RemoveCluster";
        //add are you sure you want to remove this cluster?
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            if (empty($_POST["cluster_name"])) {
                $data_correct = 0;
                echo "<script type=\"text/javascript\"> alert(\"cluster to remove wasn't selected\"); </script>";
            }
           
            //echo"data correct?". $data_correct;
            if ($data_correct == 1){
                $cluster_name = test_input($_POST["cluster_name"]);
                //echo "$cluster_name".$cluster_name; 
                $query = "DELETE FROM `".__cluster_table_name."` WHERE ".__cluster_tl_cluster_name." LIKE '$cluster_name'";
                $is_cluster_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_cluster_exist, 0);
                if (! ($result == 0)){
                echo "<script type=\"text/javascript\"> alert(\"removed this cluster\"); </script>";
                } else {
                
                echo "<script type=\"text/javascript\"> alert(\"unable to remove this cluster\"); </script>";
                   
                    }       //close else case
            }               //close remove section
        }                   //close if $_SERVER["REQUEST_METHOD"] section
     }                      //close function RemoveCluster
     
    public function accoountCheck(&$account_name, &$data_correct){
        if (empty($_POST["account_name"])) {
        $data_correct = 0;
        $AccountErr = "account Name is required";
        return false;
        } else {
            $account_name = test_input($_POST["account_name"]);
            if (!preg_match("/^[a-zA-Z0-9_\-]*$/",$account_name)) {
                $AccountErr = "account name shouldn't contain special characters";
                $data_correct = 0;
                return false;
            }
        }
        return true;
    }
  
  public function clusterCheck(&$cluster_name, &$data_correct, $account_name){
        if (empty($_POST["cluster_name"])) {
            $data_correct = 0;
            return false;
        } else  {
                $cluster_name = test_input($_POST["cluster_name"]);
                $query = "SELECT count(*) From `".__cluster_table_name."` WHERE ".__cluster_tl_account_name." LIKE '$account_name' AND ".__cluster_tl_cluster_name." LIKE '$cluster_name'";
                $is_user_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_user_exist, 0) ;
                if (! ($result == 0)){
                    $data_correct = 0;
                    echo "<script type=\"text/javascript\"> alert(\"Account already exists in the system\"); </script>'";
                    return false;
                    }
            }
        return true;
    }
  
  public function mailing_listCheck(&$mailing_list, $data_correct){
        if (empty($_POST["mailing_list"])) {
            $data_correct = 0;
            return false;
        }
        $mailing_list = test_input($_POST["mailing_list"]);
        return true;
    }
    
    public function addAccountToCluster()
    {
    //echo $_POST["cluster_name"];
    //echo $_POST["account_name"];
    //add are you sure you want to remove this cluster?
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            $account_name= $cluster_name = $mailing_list="";
            $flag1 = $this->accoountCheck($account_name, $data_correct);
    
        if (false == $flag1){
            return;
            }
            $flag3 = $this->mailing_listCheck($mailing_list, $data_correct);
            $flag2 = $this->clusterCheck($cluster_name, $data_correct, $account_name);
            //echo "account_name, $account_name";
            //echo "flag2".$flag2;
            
            //echo"data correct?". $data_correct;
            if ($data_correct == 1){
            //echo "<script type=\"text/javascript\"> alert(\"behs\"); </script>";
            $date = date("Y-m-d");
             $colomns= __cluster_tl_cluster_name.",".__cluster_tl_account_name.",".__clusters_tl_mailing_list.",".__cluster_tl_date_modified.','.__cluster_tl_date_created.','.__cluster_tl_expired_date;
                mysql_query("INSERT INTO ".__cluster_table_name." ($colomns)
                VALUES('$cluster_name', '$account_name', '$mailing_list','$date', '$date', NULL)") or die(mysql_error());
                     echo "<script type=\"text/javascript\"> alert(\"Account was added successfully\"); </script>'";
                   
            }   //close insert section
        }       //close if ($_SERVER["REQUEST_METHOD"] == "POST")
     }          //close function addAccountToCluster
     
     public function removeAccountFromCluster()
    {
    //add are you sure you want to remove this cluster?
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            $account_name= $cluster_name ="";
            $flag1 = $this->accoountCheck($account_name, $data_correct);
    
        if (false == $flag1){
            return;
            }
            $flag2 = $this->clusterCheckForRemove($cluster_name, $data_correct, $account_name);
            
            //todo: check that the accountname doesn't allready exist in database
            // if (empty($_POST["account_name"])) {
                // $data_correct = 0;
                // $AccountErr = "account Name is required";
            // } else {
                // $account_name = test_input($_POST["account_name"]);
                // if (!preg_match("/^[a-zA-Z0-9_\- ]*$/",$account_name)) {
                    // $AccountErr = "account name shouldn't contain special characters";
                    // $data_correct = 0;
                // }
            // }
            // //echo "$data_correct".$data_correct."\n";
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
            //echo"data correct?". $data_correct;
            if ($data_correct == 1){
                mysql_query("INSERT INTO clusters (`cluster_name`, `account_name`)
                VALUES('$cluster_name', '$account_name')") or die(mysql_error());
                    //echo "add".$account_name."to cluster:".$cluster_name."\n";
                
            }
        }
     }
    
} //closing class 

