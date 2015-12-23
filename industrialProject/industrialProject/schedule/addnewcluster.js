// Validate Cluster input
function validate_cluster_name(cluster_name){ 
  var re = /^[a-zA-Z0-9_\- ]+$/;
  if(re.test(document.getElementById('cluster_name').value)){
    
    document.getElementById('cluster_name').style.background ='#ccffcc';
    document.getElementById('cluster_err').style.display = "none";
    return true;
  }else{
    document.getElementById('cluster_name').style.background ='#e35152';
    return false;
  }
}
// Validate Cluster input
function validate_account_name(account_name){ 
  var re = /^[a-zA-Z0-9_\- ]+$/;
  if(re.test(document.getElementById('account_name').value)){
    
    document.getElementById('account_name').style.background ='#ccffcc';
    document.getElementById('account_err').style.display = "none";
    return true;
  }else{
    document.getElementById('account_name').style.background ='#e35152';
    return false;
  }
}

function validateClusterForm()
{
    document.getElementById('error1').innerText = 'Hila start working';
    return false;
}

