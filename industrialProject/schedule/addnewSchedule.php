<?php
    
        include '../common/base.php';
    
        // define variables and set to empty values
        //global $clusterErr, $AccountErr ,$cluster_name ,$account_name;
        $clusterErr = $schedule_id_err = $schedule_name_err = "";
    
        if(!empty($_POST['schedule_name']) && !empty($_POST['schedule_name']) && !empty($_POST['start_date']) && !empty($_POST['end_date'])) {
            include_once "../inc/class.schedules.inc.php";
            $cluster_group = new SchedulesTool(db);
            echo $cluster_group->AddNewSchedule();
}
?>
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
</head>
<body>
<!--    -          Schedule Name
    
    -          Schedule ID
    
    -          Start date and time
    
    -          End date and time
    
    -          Expiration date

    -          Account
    
    -          Task status
    -->
<div class='container'>
    <div class='panel panel-primary dialog-panel'>
        <div class='panel-heading'>
            <h5>Adding new Schedule to system</h5>
        </div>
        <div class='panel-body'>
            <form class='form-horizontal' role='form' method="post" type="submit" action="addnewSchedule.php">
                <!--TODO: check if the script should be in other section or file-->
                <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
                <div class='form-group'>
                    <label class='control-label col-md-2 col-md-offset-2' for='schedule_name'>Schedule Name:</label>
                    <div class='col-md-2'>
                            <input class="form-control" type="text" name="schedule_name" id="schedule_name" size="25" maxlength="30" width="7%" onblur="return validate_schedule_name(value);" required/>
                        </div>
                                <div class='col-md-2' >       
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Can include only Letters or digits">        
            </div>
                    </div>
                <div class='form-group'>
                    <label class='control-label col-md-2 col-md-offset-2' for='schedule_id:'>Schedule ID:</label>
                    <div class='col-md-2'>
                            <input class="form-control" type="text" name="schedule_id" id="schedule_id" size="25" maxlength="30" width="7%" onblur="return validate_schedule_id(value);" required/>
                        </div>
            <div class='col-md-2' >       
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="Can include only Letters or digits">        
            </div>                
                </div>
                <div class='form-group'>
                    <label class='control-label col-md-2 col-md-offset-2' for='id_start_date'>Start date</label>
                    <div class='col-md-8'>
                        <div class='col-md-3'>
                            <div class='form-group internal input-group'>
                                <input id="start_date" name="start_date" type="date" required>
                            </div>
                        </div>
                        <label class='control-label col-md-2' for='id_finish_date'>End date</label>
                        <div class='col-md-3'>
                            <div class='form-group internal input-group'>
                                <input type="date" id="end_Date" name="end_Date" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-md-2 col-md-offset-2' for="account">Account: </label>
                    <div class='col-md-2' >
                        <?php
            include_once '../helpers/getDropDownListFromTableData.php';
            echo dataDropdown('clusters',__cluster_tl_account_name);
			?>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='control-label col-md-2 col-md-offset-2' for="account">manager: (optional) </label>
                    <div class='col-md-2' >
                            <?php
            include_once '../helpers/getDropDownListFromTableData.php';
            $pred = " WHERE ".__users_tl_role." in ('AM', 'SM') ";
            echo dataDropdown('users',__users_tl_user_name, $pred);
			?>

                    </div>
                                <div class='col-md-2' >       
            <img src="../common/question_mark.jpg" alt="?" height="20" width="20" data-placement="right" data-toggle="tooltip" title="the schedule belongs only to a specific user with his own tasks">        
            </div>
                </div>
                <div class='form-group'>
                    <button class='btn-lg btn-primary' type="submit" name="new_schedule" id="new_schedule">Add new Schedule</button>
                    <div class='col-md-offset-4 col-md-3'>
                    </div>
                </div>

            </form>
            <div class='col-md-3'>
                <button class='btn-lg btn-danger' id='cancelButton' style='float:right' name="Cancel">Cancel</button>
                <script>
                     $('#cancelButton').on('click', function (e) {
                        window.location.href ="../cssmenu/mainPage.php";
                        }
                     )
                     </script>
            </div>
        </div>
    </div>
</div>
</body>
<script src="addnewschedule.js"></script>