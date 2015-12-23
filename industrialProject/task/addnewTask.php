<!DOCTYPE html>
<?php
    
    include_once "../common/base.php";
	
// echo "hi";
    if(!empty($_POST['task_name']) && !empty($_POST['task_id']) && isset($_FILES['attachment']) && !empty($_POST['role']) && !empty($_POST['account_name']) && !empty($_POST['duration']) && !empty($_POST['severity'])){  //!empty($_POST['instruction']) && !empty($_POST['frequency']) && !empty($_POST['attachment']) && !empty($_POST['role']) && !empty($_POST['account']) && !empty($_POST['task_description']) && !empty($_POST['duration']) && !!empty($_POST['days']) && !empty($_POST['schedule_id'])) {
  //      echo "1";
        include_once "../inc/class.tasks.inc.php";
            $task_group = new TasksTool(db);
            //echo "oooo";
            echo $task_group->AddGenericTask();
       }
?> 
<head>
  <link href='http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
  <link href='http://davidstutz.github.io/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

	<style>
		.error {
			color: #FF0033; 
			font-style: italic; 
			font-size: 12px; 
			font-weight: bold; 
			vertical-align:-17px;
			text-decoration: underline;
		}
	</style>
</head>
<body>
  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h5>Adding new Task</h5>
      </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" enctype="multipart/form-data" action="addnewTask.php">
          <div class='form-group'>
            <label class='col-md-2 ' for='task_name'>Task name:</label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="task_name" id="task_name" size="25" maxlength="30" width="7%" required />
            </div>					
            <div class='col-md-1' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Task name include only Letters or digits">        
            </div>
            <div class="error" id="taskNameErr"></div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
            <label class='control-label col-md-2' for='task_id'>Task id:</label>
            <div class='col-md-2' >
                <input class="form-control" type="text" name="task_id" id="task_id" size="25" maxlength="30" width="7%" required />
            </div>
            <div class='col-md-1' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Task id include only Letters or digits">        
            </div>
            <div class="error" id="taskIdErr"></div>
          </div>          
          <div class='form-group'>
            <label class='control-label col-md-1' for='role'>Role</label>
            <div class='col-md-2'>
              <select class='form-control' id='role' name="role">
                <option value="OPS">OPS</option>
                <option value="SM">SM</option>
                <option value="AM">AM</option>
              </select>
            </div>
            <div class='col-md-1' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Who should deal this task">        
            </div>
            <label class='control-label col-md-1' for='duration'>Duration</label>
            <div class='col-md-3'>
              <div class='form-group'>
                
                <div class='col-md-3'>
                  <input class='form-control' name='duration' id='duration' placeholder='' type='text' maxlength='30'>
                </div>
              <div class='col-md-1' >
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="In minutes- time the task should be completed">        
            </div>
            <div class="error" id="durationErr"></div>
            </div>
          </div>   
          </div>   

          <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2' for='account_name'>Account:</label>
              <div class='col-md-8'>
                <div class='col-md-2'>
                    <div class='form-group internal'>                
                    <?php
                    $query = mysql_query("SELECT account_name FROM `clusters`"); // Run your query

                    echo '<select class="form-control" name="account_name">'; // Open your drop down box

                    // Loop through the query results, outputing the options one by one
                    while ($row = mysql_fetch_array($query)) {
                       echo '<option value="'.$row['account_name'].'">'.$row['account_name'].'</option>';
                    }

                    echo '</select>';
                    ?> 
                    </div>
                </div>
              </div>          
          </div> 
              <div class='form-group'>
                <label class='control-label col-md-2 col-md-offset-2' for='id_instructions'>Instructions</label>
                <div class='col-md-6'>
                  <textarea class='form-control' id='id_instructions' placeholder='Type here' rows='3'></textarea>
                </div>
              </div> 
                        <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='task_id'>attachment:</label>
            <div class='col-md-2' >
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <input name="attachment" type="file" id="attachment"> 
            </div>
            </div> 
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='severity'>Task Severity</label>
            <div class='col-md-8'>
              <select class='multiselect' id='severity' name='severity' multiple='multiple'>
                <option value='Critical'>Critical</option>
                <option value='High'>High</option>
                <option value='Low'>Low</option>
              </select>
            </div>
          </div>  
       
          <div class='form-group'>
              <label class='control-label col-md-2 col-md-offset-2' for='task_id'>Under Cluster:</label>
              <div class='col-md-2'>
                <div class='form-group internal'>                
                <?php
                $query = mysql_query("SELECT DISTINCT cluster_name FROM clusters ORDER BY cluster_name ASC "); // Run your query

                echo '<select class="form-control" name="cluster_name" required>'; // Open your drop down box

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
              <button class='btn-lg btn-primary' type="submit" name="submit" id="submit">Add Task</button>
            </div>
          </div>
        </form>
        <div class='col-md-3'>
            <button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel">Cancel</button>
                <script>
                 $('#cancelButton').on('click', function (e) {
                    window.location.href ="../cssmenu/index.html";
                    }
                 )
                 </script>
        </div>
          
      </div>
    </div>
  </div>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='http://davidstutz.github.io/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  </body>
<!--<script src="addnewcluster.js"></script>-->
