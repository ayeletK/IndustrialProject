<?php

session_start();

include_once "../inc/constants.inc.php";
include_once "../inc/class.users.inc.php";
$ClusterObj = new ToolUsers();

if(!empty($_POST['action'])
&& isset($_SESSION['LoggedIn'])
&& $_SESSION['LoggedIn']==1)
{
    switch($_POST['action'])
    {
        case 'changeClusterName':
            $status = $ClusterObj->updateClusterName() ? "changed" : "failed";
            header("Location: /account.php?email=$status");
            break;
        case 'changeAccountName':
            $status = $ClusterObj->updatechangeAccountName() ? "changed" : "nomatch";
            header("Location: /account.php?password=$status");
            break;
        case 'deleteAccount':
            $ClusterObj->deleteAccount();
            break;
        default:
            header("Location: /");
            break;
    }
}
else
{
    header("Location: /");
    exit;
}

?>