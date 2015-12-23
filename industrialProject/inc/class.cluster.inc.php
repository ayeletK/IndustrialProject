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
                if (!preg_match("/^[a-zA-Z0-9_\-][a-zA-Z0-9_\- ]+$/",$cluster)) {
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
                    $columns= __cluster_tl_cluster_name.",".__cluster_tl_account_name.",".__clusters_tl_mailing_list.",".__cluster_tl_date_modified.','.__cluster_tl_date_created.','.__cluster_tl_expired_date;
             
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
            $mailing_list= $account_name ="";
            $cluster_name = "";
            //====================================================
            //	validate cluster input is not empty
            //====================================================             
            $cluster_flag = $this->clusterCheck($cluster_name, $data_correct);
            //echo "cluster_flag:-$cluster_flag-";
            //====================================================
            //	validate account name input is correct
            //====================================================             
             $account_flag = $this->accoountCheck($account_name, $data_correct);
             $mailing_flag = $this->mailing_listCheck($mailing_list, $data_correct);
             
             if ($cluster_flag && $account_flag && $mailing_flag){ 
                echo "enter ";
             //echo "mailing_list".$mailing_list."data_correct".$data_correct;
             $exist_acc_flag = $this->accountExist($account_name, $data_correct);
             $exist_clu_flag = $this->clusterExist($cluster_name, $data_correct);
             }
             echo "data_correct- before last:=".$data_correct."=";
            if ($data_correct == 1){
                    $date = date("Y-m-d"); 
                    $columns= __cluster_tl_cluster_name.','.__cluster_tl_account_name.','.__clusters_tl_mailing_list.','.__cluster_tl_date_modified.','.__cluster_tl_date_created;
                    $insertQuery ="INSERT INTO ".__cluster_table_name."($columns) VALUES('$cluster_name', '$account_name', '$mailing_list',' $date', '$date')";
                    echo $insertQuery;
                    $insertResult= mysql_query($insertQuery) or die(mysql_error());
    				
                    if(mysql_errno()){
						echo "MySQL error ".mysql_errno().": "
						.mysql_error()."\n<br>When executing <br>\n$insertQuery\n<br>";
					}
					else {
						// if insert succeeded
                    echo '<script language="javascript">';
                    echo 'alert("cluster added successfully")';
                    echo '</script>';
                    header('Location: ../cssmenu/mainPage.php');
					}

                                        
                }// insert section
        }// close ($_SERVER["REQUEST_METHOD"] == "POST")
     }// close function
	
    /**
     * RemoveCluster
     * function update all account under this cluster to expired
     * 
     */
    public function RemoveCluster()
    {
        //echo "RemoveCluster";
        
        //add are you sure you want to remove this cluster?
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;

            //====================================================
            //	validate cluster was chose and not empty
            //====================================================             
            if (empty($_POST['cluster_name'])) {
                $data_correct = 0;
                echo "<script type=\"text/javascript\"> alert(\"cluster to remove wasn't selected\"); </script>";
            }
           
            //====================================================
            //	if all the input are correct- turn a cluster and all
            //its related account to expired in db
            //==================================================== 
           
           if ($data_correct == 1){
                $cluster_name = test_input($_POST['cluster_name']);
                $date = date("Y-m-d");
                $removeQuery = "UPDATE clusters SET ".__cluster_tl_expired_date ."='$date',".__cluster_tl_date_modified." = '$date' WHERE ".__cluster_tl_cluster_name." LIKE '$cluster_name'";
                $removeQuery = mysql_query($removeQuery) or die(mysql_error());
                
            if (! (mysql_errno())){
                    echo '<script language="javascript">';
                    echo 'alert("removed cluster Successfully!")';
                    echo '</script>';                   
            } else {
                    echo '<script language="javascript">';
                    echo 'alert("unable to remove this cluster")';
                    echo '</script>';                
                    }      //close else case
            }               //close remove section
        }                   //close if $_SERVER["REQUEST_METHOD"] section
     }                      //close function RemoveCluster
     
     
     
    /*
    * function accoountCheck:
    * this function should be static, validate account_name was inserted 
    * with legal value
    * @param: $account_name- given by reference should be update in this function with new legal input
    * @param: $data_correct - reference to indicator if input stand all the rules it should
    * @returns true in case input is valid and update 
    *    $account_name given by reference with new legal value, $data_correct stay correct
    * else- in case input is not valid, return false update $data_correct with 0 value.
    */    
    public function accoountCheck(&$account_name, &$data_correct){
        if (empty($_POST["account_name"])) {
        $data_correct = 0;
        $AccountErr = "account Name is required";
        return false;
        } else {
            $account_name = test_input($_POST["account_name"]);
            if (!preg_match("/^[a-zA-Z0-9][a-zA-Z0-9_\- ]*$/",$account_name)) {
                $AccountErr = "account name shouldn't contain special characters";
                $data_correct = 0;
                return false;
            }
        }
        return true;
    }
  
      /*
    * function clusterCheck:
    * this function should be static, validate cluster name was inserted 
    * contains legal value 
    * @param: $cluster_name- given by reference should be update in this function with new legal input 
    * @param: $data_correct - reference to indicator if input stand all the rules it should
    * @returns true in case input is valid and update 
    *    $cluster_name given by reference with new legal value, $data_correct stay correct
    * else- in case input is not valid, return false update $data_correct with 0 value.
    */   
  public function clusterCheck(&$cluster_name, &$data_correct){
        if (empty($_POST["cluster_name"])) {
            $data_correct = 0;
            return false;
        } 
        else {
        $cluster_name = test_input($_POST["cluster_name"]);
        if (! preg_match("/^[a-zA-Z0-9][a-zA-Z0-9_\- ]*$/",$cluster_name)) {
            $data_correct = 0;
            return false; 
         }
        }
        return true;
    }
     
    /*
    * function accountDoesntExistUnderCluster:
    * this function should be static, validate that account and cluster name  
    * doesn't already exist in DB
    * @param: $cluster_name- new cluster_name
    * @param: $account_name- new account_name 
    * @param: $data_correct - reference to indicator if input stand all the rules it should
    * @returns true in case input is valid and update 
    *    $data_correct stay correct
    * else- in case input is not valid, return false update $data_correct with 0 value.
    */ 
    public function accountDoesntExistUnderCluster(&$cluster_name, &$data_correct, $account_name){
        
        $query = "SELECT count(*) From `".__cluster_table_name."` WHERE ".__cluster_tl_account_name." LIKE '$account_name' AND ".__cluster_tl_cluster_name." LIKE '$cluster_name'";
        $is_user_exist = mysql_query($query) or die(mysql_error());
        $result =  mysql_result($is_user_exist, 0) ;
        if (! ($result == 0)){
            $data_correct = 0;
            echo "<script type=\"text/javascript\"> alert(\"Account already exists in the system\"); </script>'";
            return false;
            }
         return true;
     }   

     /*
    * function clusterExist:
    * this function should be static, validate that cluster doesn't already exist in DB
    * @param: $cluster_name- new cluster_name
    * @param: $data_correct - reference to indicator if input stand all the rules it should
    * @returns true in case given $cluster_name already exist in db
    *    $data_correct turn to 0
    * else-$cluster_name is unique return true $data_correct stay correct.
    */ 
    public function clusterExist($cluster_name, &$data_correct){
        echo "cluster_name".$cluster_name;
        
        $query = "SELECT count(*) From `".__cluster_table_name."` WHERE ".__cluster_tl_cluster_name." LIKE '$cluster_name'";
        echo "\n\r\t";
        echo $query;
        $is_user_exist = mysql_query($query) or die(mysql_error());
        
        $result =  mysql_result($is_user_exist, 0) ;
        if (! ($result == 0)){
            $data_correct = 0;
            echo "cluster exist";
            echo "<script type=\"text/javascript\"> alert(\"cluster already exists in the system\"); </script>'";
            return false;
            }
             echo "cluster correct";
         return true;
     }
     
     /*
    * function accountExist:
    * this function should be static, validate that cluster doesn't already exist in DB
    * @param: $account_name- new account_name
    * @param: $data_correct - reference to indicator if input stand all the rules it should
    * @returns true in case given $account_name already exist in db
    *    $data_correct turn to 0
    * else-$account_name is unique return true $data_correct stay correct.
    */ 
    public function accountExist($account_name, &$data_correct){
        echo "account_name".$account_name;
        $query = "SELECT count(*) From `".__cluster_table_name."` WHERE ".__cluster_tl_account_name." LIKE '$account_name'";
        echo "\n\r\t";
        echo $query;
        $is_user_exist = mysql_query($query) or die(mysql_error());
        $result =  mysql_result($is_user_exist, 0) ;
        if (! ($result == 0)){
            echo "account exist";
            $data_correct = 0;
            echo "<script type=\"text/javascript\"> alert(\"account already exists in the system\"); </script>'";
            return false;
            }
          echo "new account";
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
            $flag2 = $this->clusterCheck($cluster_name, $data_correct);
            
            if ($flag2 and $flag3 ){
            $flag4 = $this->accountDoesntExistUnderCluster($cluster_name, $data_correct, $account_name);
            }
            
            //echo"data correct?". $data_correct;
            if ($data_correct == 1){
            
            $date = date("Y-m-d");
             $columns= __cluster_tl_cluster_name.','.__cluster_tl_account_name.','.__clusters_tl_mailing_list.','.__cluster_tl_date_modified.','.__cluster_tl_date_created.','.__cluster_tl_expired_date;
                mysql_query("INSERT INTO ".__cluster_table_name." ($columns)
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

