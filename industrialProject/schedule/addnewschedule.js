// Validate schedule_name input
function validate_schedule_name(schedule_name){ 
  var re = /^[a-zA-Z0-9_\- ]+$/;
  if(re.test(document.getElementById('schedule_name').value)){
    
    document.getElementById('schedule_name').style.background ='#ccffcc';
    document.getElementById('schedule_err').style.display = "none";
    return true;
  }else{
    document.getElementById('schedule_name').style.background ='#e35152';
    return false;
  }
}
// Validate schedule_id input
function validate_schedule_id(schedule_id){ 
  var re = /^[0-9]+$/;
  if(re.test(document.getElementById('schedule_id').value)){
    
    document.getElementById('schedule_id').style.background ='#ccffcc';
    document.getElementById('schedule_id_err').style.display = "none";
    return true;
  }else{
    document.getElementById('schedule_id').style.background ='#e35152';
    return false;
  }
}

function validateClusterForm()
{
    document.getElementById('error1').innerText = 'Hila start working';
    return false;
}

