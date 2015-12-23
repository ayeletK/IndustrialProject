<!DOCTYPE html>
<html lang="en">
<head>
  <link href='http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css' rel='stylesheet' type='text/css'>
  <link href='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/css/bootstrap-switch.css' rel='stylesheet' type='text/css'>
  <link href='http://davidstutz.github.io/bootstrap-multiselect/css/bootstrap-multiselect.css' rel='stylesheet' type='text/css'>
  <script src='//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.0/js/bootstrap.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js' type='text/javascript'></script>
  <script src='//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/1.8/js/bootstrap-switch.min.js' type='text/javascript'></script>
  <script src='http://davidstutz.github.io/bootstrap-multiselect/js/bootstrap-multiselect.js' type='text/javascript'></script>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  
    <!-- Load jQuery from Google's CDN -->
    <!-- Load jQuery UI CSS  -->
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    
    <!-- Load jQuery JS -->
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <!-- Load jQuery UI Main JS  -->
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    
    <!-- Load SCRIPT.JS which will create datepicker for input field  -->
    <script src="pick_date.js"></script>
    
    <!-- was in origin code:
        <link rel="stylesheet" href="runnable.css" />
        --------------------------------------------->
<?php
    
    include_once "../common/base.php";
	
	// define variables and set to empty values
	//global $clusterErr, $AccountErr ,$cluster_name ,$account_name;
    $clusterErr = $AccountErr = $cluster_name = $account_name = "";
 
 /*
    if(!empty($_POST['cluster_name']) && !empty($_POST['account_name'])) {
        include_once "../inc/class.task.inc.php";
            $cluster_group = new TasksTool(db);
            echo $cluster_group->addNewTask();
       } */
?> 
</head>
<body>
  <div class='container'>
    <div class='panel panel-primary dialog-panel'>
      <div class='panel-heading'>
        <h5>Add new Task</h5>
      </div>
                <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='task_name'>Task name</label>
            <div class='col-md-2' >
                <a href="#" data-placement="top" data-toggle="tooltip" title="Can include only Letters and digits">
                <input class="form-control" type="text" name="task_name" id="task_name" size="25" maxlength="30" width="7%" onblur="return validate_task_name(value);" required />
                </a>
            </div>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
            <td><span class="error"> *<?php echo $AccountErr;?></span></td>
          </div>
      <div class='panel-body'>
        <form class='form-horizontal' role='form' method="post" action="addNewtask.php">
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='Role'>Role</label>
            <div class='col-md-2'>
              <select class='form-control' id='Role'>
                <option>OPS</option>
                <option>SM</option>
                <option>AM</option>
              </select>
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
            <label class='control-label col-md-2 col-md-offset-2' for='task_id'>TaskID</label>
            <div class='col-md-3'>
              <div class='form-group'>
                <div class='col-md-11'>
                  <input class='form-control' id='task_id' placeholder='' type='text' maxlength='30'>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='id_start_date'>Start time</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' id="start_date" name="start_date" type="date">
                </div>
              </div>
              <label class='control-label col-md-2' for='id_finish_date'>End time</label>
              <div class='col-md-3'>
                <div class='form-group internal input-group'>
                  <input class='form-control datepicker' type="date" id="end_Date" name="end_Date">
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
          <input type="file" name="file" id="Upload File">
            <label class='control-label col-md-2 col-md-offset-2' for='id_equipment'>Equipment type</label>
            <div class='col-md-8'>
              <div class='col-md-3'>
                <div class='form-group internal'>
                  <select class='form-control' id='id_equipment'>
                    <option>Travel trailer</option>
                    <option>Fifth wheel</option>
                    <option>RV/Motorhome</option>
                    <option>Tent trailer</option>
                    <option>Pickup camper</option>
                    <option>Camper van</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='Task_Severity'>Task Severity</label>
            <div class='col-md-8'>
              <select class='multiselect' id='id_service' multiple='multiple'>
                <option value='Critical'>Critical</option>
                <option value='High'>High</option>
                <option value='Low'>Low</option>
              </select>
            </div>
          </div>
          <div class='form-group'>
            <label class='control-label col-md-2 col-md-offset-2' for='Repetition'>Repetitions</label>
            <div class='col-md-8'>
              <div class='make-switch' data-off-label='NO' data-on-label='YES' id='id_repetition_switch'>
                <input id='Repetition' type='checkbox' >
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
            <div class='col-md-offset-4 col-md-3'>
              <button class='btn-lg btn-primary' type='submit'>Request Reservation</button>
            </div>
          </div>
        </form>
                <div class='col-md-3'>
            <button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel">Cancel</button>
                <script>
                 $('#cancelButton').on('click', function (e) {
                    window.location.href ="/industrialProject/cssmenu/mainPage.php";
                    }
                 )
                 </script>
        </div>
      </div>
    </div>
  </div>

</body>

</html>