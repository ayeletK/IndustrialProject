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
 * Handles task interactions within the app
 *
 *	wanted actions:
 *		Create new generic  task

 *
 */
class TasksTool
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
			include_once '../inc/constants.inc.php';
            $connection = mysql_connect(dbhost, dbuser, dbpass) ;
			mysql_select_db(db);
        }
    }
    

	/**
     * addNewTask 
     *
     * @return boolean    TRUE on success and FALSE on failure
     */
    public function AddGenericTask()
    {
    //echo "AddGenericTask1";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            
            //====================================================
            //	check validation of "cluster_name" input
            // if(!empty($_POST['task_name']) && !empty($_POST['task_id']) && !empty($_POST['instruction']) && !empty($_POST['frequency']) && !empty($_POST['attachment']) && !empty($_POST['role']) && !empty($_POST['account']) && !empty($_POST['task_description']) && !empty($_POST['duration']) && !!empty($_POST['days']) && !empty($_POST['schedule_id'])) {
   
            //====================================================
            if (empty($_POST["task_name"])) {
                $data_correct = 0;
                //echo "task_name\n";
            } else {
                $task_name = test_input($_POST["task_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\-]{4,30}$/",$task_name)) {
                    $data_correct = 0;
                }
            }//close the else
            
            
            //echo "before task_id\n";
            //====================================================
            //	check validation of "$task_id" input
            //====================================================            
            //todo: check that the task_id doesn't allready exist in database
            if (!($data_correct == 0) && empty($_POST["task_id"])) {
                //echo "task_id\n";
                $data_correct = 0;
                //$clusterErr = "account Name is required";
            } else {
                $task_id = test_input($_POST["task_id"]);
               // echo "gg";
                if (!preg_match("/^([a-zA-Z0-9_\-]){4,6}$/",$task_id)) {
                    echo "task_id::".$task_id;
                    $data_correct = 0;
                }
                $query = "SELECT count(*) From `general_tasks` WHERE ".__tasks_tl_task_id." LIKE '$task_id' ";
                $is_task_is_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_task_is_exist, 0) ;
                if (! ($result == 0)){
                    //echo "bhjb";
                    $data_correct = 0;
                }
            }
            echo "data_correct\n".$data_correct;
            //====================================================
            //	check validation of "$frequency" input
            //====================================================            
            if ($data_correct == 0 || empty($_POST["frequency"])) {
             echo "line108\n";
           
                $data_correct = 0;
            } else {
                $frequency = test_input($_POST["frequency"]);

            }
            
            
            //====================================================
            //	check validation of "$duration" input
            //====================================================            
            if ($data_correct == 0 || empty($_POST["duration"])) {
             echo "line103\n";
           
                $data_correct = 0;
            } else {
                $duration = test_input($_POST["duration"]);
                if (!preg_match("/^[0-9]{1,3}$/",$duration)) {
                 echo "line109\n";
                   $data_correct = 0;
                }
            }
            //echo "f line $data_correct";
            //====================================================
            //	check validation of "$role" input
            //====================================================   

            if (empty($_POST["role"])) {
                //echo "role\n";
                $data_correct = 0;
            } else {
                $role = test_input($_POST["role"]);
            }
            
                echo $_POST["severity"];
             //====================================================
            //	check validation of "$severity" input
            //====================================================            
            if (empty($_POST["severity"])) {
                echo "severity";
                $data_correct = 0;
            } else {
                $severity_val = test_input($_POST["severity"]);
            }
            //====================================================
            //	check validation of "$Days" input
            //====================================================            
            if (empty($_POST['Days'])) {
                echo "empty days ";
                $data_correct = 0;
            } else {
            echo "line145";
                    $days_value="";
                    foreach($_POST['Days'] as $selected){
                    $days_value= $days_value.$selected."_";
                    echo $selected."</br>";
                    }
                echo "days_value:".$days_value;
            }       
            
             //====================================================
            //	check validation of "$account_name" input
            //====================================================            
            if (empty($_POST["account_name"])) {
                $data_correct = 0;
            } else {
                $account_name = test_input($_POST["account_name"]);
            }            
            
             //====================================================
            //	check validation of "$account_name" input
            //====================================================            
            if (empty($_POST["id_instructions"])) {
                $data_correct = 0;
            } else {
                   $instructions = mysql_real_escape_string($_POST['id_instructions']);
            }            

             
/*            // //echo $_POST['attachment'];
            // echo $_FILES['attachment'];
            // echo $_FILES['attachment']['size'];
            // if ($_FILES['attachment']['size'] > 0){
            // echo "i'm big enough!";
            // }
            // if(isset($_POST['attachment'])){
            // echo "i'm set :(";
            // }*/
            if((!isset($_FILES['attachment'])) || !($_FILES['attachment']['size'] > 0))
            {
                echo "file not found";
                $data_correct = 0;
            }
            else
           {
            echo "inside isset";
            echo $_FILES['attachment']['name'];
            //echo "mytry";
            $fileName = $_FILES['attachment']['name'];
            $tmpName  = $_FILES['attachment']['tmp_name'];
            $fileSize = $_FILES['attachment']['size'];
            $fileType = $_FILES['attachment']['type'];
            
            $fp= fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            $content = addslashes($content);
            fclose($fp);

            //$content = file_get_contents($_FILES['attachment']['tmp_name']);
            $query = "INSERT INTO `attachments` (name, size, type, data) VALUES('$fileName', '$fileSize', '$fileType', '$content')";

            mysql_query($query) or die('Error, query failed'); 
            
            echo "<br>File $fileName uploaded<br>";
            } 

            //echo "data_correct $data_correct"; 
            //====================================================
            //when all inputs are correct-
            //  insert new cluster with account to dbt_name" input
            //====================================================             
            if ($data_correct == 1){
                //echo "data_correct: $data_correct";
                //echo "start insert to db";
                //$account_col = __cluster_tl_account_name;
                $query = "SELECT count(*) From `general_tasks` WHERE ".__tasks_tl_task_name." LIKE '$task_name' OR ".__tasks_tl_task_id." LIKE '$task_id'";
                $is_account_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_account_exist, 0) ;
                if (! ($result == 0)){
                    echo '<script language="javascript">';
                    echo 'alert("Account or cluster already exist in this cluster")';
                    echo '</script>';
                   
                 } else {
                echo "severity_val".$severity_val;
                    $colomns= __tasks_tl_task_name.','.__tasks_tl_task_id.','.__tasks_tl_role.','.__tasks_tl_account.','.__tasks_tl_severity.','.__tasks_tl_days.','.__tasks_tl_instruction;
                    $insertQuery = "INSERT INTO general_tasks ($colomns) VALUES('$task_name', '$task_id','$role', '$account_name', '$severity_val', '$days_value','$instructions')";
                    $insertResult = mysql_query($insertQuery) or die(mysql_error());
					
					if(mysql_errno()){
						echo "MySQL error ".mysql_errno().": "
						.mysql_error()."\n<br>When executing <br>\n$insertQuery\n<br>";
					}
					else {
						// if insert succeeded
						echo "<script type=\"text/javascript\"> alert(\"Task was added successfully!\"); </script>";
						header('Location: ../cssmenu/mainPage.php');
					}
                    echo "task added successfully";
                    include_once "addnewTask.php";
                }
                
            }
        }
     }// closing function addGenerictask
    public function AddGenericTask()
    {
    //echo "AddGenericTask1";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $data_correct = 1;
            
            //====================================================
            //	check validation of "cluster_name" input
            // if(!empty($_POST['task_name']) && !empty($_POST['task_id']) && !empty($_POST['instruction']) && !empty($_POST['frequency']) && !empty($_POST['attachment']) && !empty($_POST['role']) && !empty($_POST['account']) && !empty($_POST['task_description']) && !empty($_POST['duration']) && !!empty($_POST['days']) && !empty($_POST['schedule_id'])) {
   
            //====================================================
            if (empty($_POST["task_name"])) {
                $data_correct = 0;
                //echo "task_name\n";
            } else {
                $task_name = test_input($_POST["task_name"]);
                if (!preg_match("/^[a-zA-Z0-9_\-]{4,30}$/",$task_name)) {
                    $data_correct = 0;
                }
            }//close the else
            
            
            //echo "before task_id\n";
            //====================================================
            //	check validation of "$task_id" input
            //====================================================            
            //todo: check that the task_id doesn't allready exist in database
            if (!($data_correct == 0) && empty($_POST["task_id"])) {
                //echo "task_id\n";
                $data_correct = 0;
                //$clusterErr = "account Name is required";
            } else {
                $task_id = test_input($_POST["task_id"]);
               // echo "gg";
                if (!preg_match("/^([a-zA-Z0-9_\-]){4,6}$/",$task_id)) {
                    echo "task_id::".$task_id;
                    $data_correct = 0;
                }
                $query = "SELECT count(*) From `general_tasks` WHERE ".__tasks_tl_task_id." LIKE '$task_id' ";
                $is_task_is_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_task_is_exist, 0) ;
                if (! ($result == 0)){
                    //echo "bhjb";
                    $data_correct = 0;
                }
            }
            echo "data_correct\n".$data_correct;
            //====================================================
            //	check validation of "$frequency" input
            //====================================================            
            if ($data_correct == 0 || empty($_POST["frequency"])) {
             echo "line108\n";
           
                $data_correct = 0;
            } else {
                $frequency = test_input($_POST["frequency"]);

            }
            
            
            //====================================================
            //	check validation of "$duration" input
            //====================================================            
            if ($data_correct == 0 || empty($_POST["duration"])) {
             echo "line103\n";
           
                $data_correct = 0;
            } else {
                $duration = test_input($_POST["duration"]);
                if (!preg_match("/^[0-9]{1,3}$/",$duration)) {
                 echo "line109\n";
                   $data_correct = 0;
                }
            }
            //echo "f line $data_correct";
            //====================================================
            //	check validation of "$role" input
            //====================================================   

            if (empty($_POST["role"])) {
                //echo "role\n";
                $data_correct = 0;
            } else {
                $role = test_input($_POST["role"]);
            }
            
                echo $_POST["severity"];
             //====================================================
            //	check validation of "$severity" input
            //====================================================            
            if (empty($_POST["severity"])) {
                echo "severity";
                $data_correct = 0;
            } else {
                $severity_val = test_input($_POST["severity"]);
            }
            //====================================================
            //	check validation of "$Days" input
            //====================================================            
            if (empty($_POST['Days'])) {
                echo "empty days ";
                $data_correct = 0;
            } else {
            echo "line145";
                    $days_value="";
                    foreach($_POST['Days'] as $selected){
                    $days_value= $days_value.$selected."_";
                    echo $selected."</br>";
                    }
                echo "days_value:".$days_value;
            }       
            
             //====================================================
            //	check validation of "$account_name" input
            //====================================================            
            if (empty($_POST["account_name"])) {
                $data_correct = 0;
            } else {
                $account_name = test_input($_POST["account_name"]);
            }            
            
             //====================================================
            //	check validation of "$account_name" input
            //====================================================            
            if (empty($_POST["id_instructions"])) {
                $data_correct = 0;
            } else {
                   $instructions = mysql_real_escape_string($_POST['id_instructions']);
            }            

             
/*            // //echo $_POST['attachment'];
            // echo $_FILES['attachment'];
            // echo $_FILES['attachment']['size'];
            // if ($_FILES['attachment']['size'] > 0){
            // echo "i'm big enough!";
            // }
            // if(isset($_POST['attachment'])){
            // echo "i'm set :(";
            // }*/
            if((!isset($_FILES['attachment'])) || !($_FILES['attachment']['size'] > 0))
            {
                echo "file not found";
                $data_correct = 0;
            }
            else
           {
            echo "inside isset";
            echo $_FILES['attachment']['name'];
            //echo "mytry";
            $fileName = $_FILES['attachment']['name'];
            $tmpName  = $_FILES['attachment']['tmp_name'];
            $fileSize = $_FILES['attachment']['size'];
            $fileType = $_FILES['attachment']['type'];
            
            $fp= fopen($tmpName, 'r');
            $content = fread($fp, filesize($tmpName));
            $content = addslashes($content);
            fclose($fp);

            //$content = file_get_contents($_FILES['attachment']['tmp_name']);
            $query = "INSERT INTO `attachments` (name, size, type, data) VALUES('$fileName', '$fileSize', '$fileType', '$content')";

            mysql_query($query) or die('Error, query failed'); 
            
            echo "<br>File $fileName uploaded<br>";
            } 

            //echo "data_correct $data_correct"; 
            //====================================================
            //when all inputs are correct-
            //  insert new cluster with account to dbt_name" input
            //====================================================             
            if ($data_correct == 1){
                //echo "data_correct: $data_correct";
                //echo "start insert to db";
                //$account_col = __cluster_tl_account_name;
                $query = "SELECT count(*) From `general_tasks` WHERE ".__tasks_tl_task_name." LIKE '$task_name' OR ".__tasks_tl_task_id." LIKE '$task_id'";
                $is_account_exist = mysql_query($query) or die(mysql_error());
                $result =  mysql_result($is_account_exist, 0) ;
                if (! ($result == 0)){
                    echo '<script language="javascript">';
                    echo 'alert("Account or cluster already exist in this cluster")';
                    echo '</script>';
                   
                 } else {
                echo "severity_val".$severity_val;
                    $colomns= __tasks_tl_task_name.','.__tasks_tl_task_id.','.__tasks_tl_role.','.__tasks_tl_account.','.__tasks_tl_severity.','.__tasks_tl_days.','.__tasks_tl_instruction;
                    $insertQuery = "INSERT INTO general_tasks ($colomns) VALUES('$task_name', '$task_id','$role', '$account_name', '$severity_val', '$days_value','$instructions')";
                    $insertResult = mysql_query($insertQuery) or die(mysql_error());
					
					if(mysql_errno()){
						echo "MySQL error ".mysql_errno().": "
						.mysql_error()."\n<br>When executing <br>\n$insertQuery\n<br>";
					}
					else {
						// if insert succeeded
						echo "<script type=\"text/javascript\"> alert(\"Task was added successfully!\"); </script>";
						header('Location: ../cssmenu/mainPage.php');
					}
                    echo "task added successfully";
                    include_once "addnewTask.php";
                }
                
            }
        }
     }// closing function addGenerictask
    
} //closing class 

