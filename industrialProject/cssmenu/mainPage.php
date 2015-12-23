<?php
    include_once "../common/base.php";
	
	// check user is logged in and is certified to add new user to the system
	if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1):
	
    $pageTitle = "Main Page";
    //include_once "../common/header.php";
    //include_once "../common/sidebar.php";
    //include_once "../common/section.php";
	
?>

<!doctype html>
<html lang="">
	<head>
	   <meta charset="utf-8">
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
	   <meta name="viewport" content="width=device-width, initial-scale=1">
	   <link rel="stylesheet" href="../cssmenu/styles.css">
	   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
	   <script src="../cssmenu/script.js"></script>
	   <title><?php echo $pageTitle ?></title>
	</head>
	<body>


	<!-- toolbar-->
		<header> 
			<div>	
				<ul>
					<li><img src="../cssmenu/images/Amdocs-logo.gif" type="image" alt="amdocs_icon" width="250"></li>
				</ul>
				<nav>
						<ul class="sf-menu dropdown">
							<li><a href="../user/logout.php">Logout</a></li>
							<li><a href="#">Report a problem</a></li>
						</ul>
					<div class="clear"></div>
				</nav>
			</div>

			<div class="clear"></div>

		</header>
        			<div id="body">
        		<div id="cssmenu" class="col-md-4">
			<ul>
			   <li class="active"><a href="../cssmenu/mainPage.php"><span>Home</span></a></li>
				<?php if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']=='SM'){ ?>
			   <li class="has-sub"><a href="#"><span>Cluster Functionality</span></a>
				  <ul>
             
<script>
function LoadFile(url) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (xhttp.readyState == 4 && xhttp.status == 200) {
      document.getElementById("content2").innerHTML = xhttp.responseText;
    }
  };
  xhttp.open("GET", url, true);
  xhttp.send();
}
</script>
					 <li><a href="../cluster/addnewCluster.php"><span>Add New Cluster</span></a></li>
					 <li><a href="../cluster/addnewAccount.php"><span>Add New Account</span></a></li>
					 <li><a href="../cluster/removeCluster.php"><span>Remove Existing Cluster</span></a></li>
					 <li class="last"><a href="../cluster/removeAccount_try.php"><span>Remove Account From Cluster</span></a></li>
				  
				  </ul>
			   </li>
			   <?php } ?>
			   <li class="has-sub"><a href="#"><span>Schedule</span></a>
				  <ul>
					 <li><a href="#"><span>Production Schedule</span></a></li>
					 <li class="last"><a href="#"><span>Run list schedule</span></a></li>
					 <?php if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']!='OPS'){ ?>
					 <li class="last"><a href="#"><span>Manager schedule</span></a></li>
					 <?php } ?>
				  </ul>
			   </li>   
			   <li class="has-sub"><a href="#"><span>Users</span></a>
				  <ul>
					 <?php if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']!='OPS'){ ?>
					 <li><a href="../user/addnewuser.php"><span>Add new user</span></a></li>
					 <li class="last"><a href="../user/removeuser.php"><span>Remove user</span></a></li>
					 <li class="last"><a href="#"><span>Update users info</span></a></li>
					 <?php } ?>
					 <li class="last"><a href="#"><span>Update my user info</span></a></li> 
				  </ul>
			   </li>
			   <?php if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']!='OPS'){ ?>
			   <li class="has-sub"><a href="#"><span>Tasks</span></a>
				  <ul>
					 <li><a href="../task/addnewTask_design.php"><span>add new Task</span></a></li>
					 <li class="last"><a href="../schedule/addnewSchedule.php"><span>add new Schedule</span></a></li>
				  </ul>
			   </li>
			   <?php } ?>
			   <li class="has-sub"><a href="#"><span>Reports</span></a>
				  <ul>
					 <li><a href="#"><span>Production Flow charts</span></a></li>
					 <li class="last"><a href="#"><span>Task list report</span></a></li>      
				  </ul>
			   </li>     
			   <li class="has-sub"><a href="#"><span>About</span></a>
				  <ul>
					 <li><a href="#"><span>Company</span></a></li>
					 <li class="last"><a href="#"><span>Contact</span></a></li>
				  </ul>
			   </li>
			   <li class="has-sub"><a href="#"><span>Administration</span></a>
				  <ul>
					 <li><a href="#"><span>User Admin</span></a></li>
					 <li class="last"><a href="#"><span>Task Wiper</span></a></li>      
				  </ul>
			   </li> 
			   <li class="last"><a href="#"><span>Log out</span></a></li>
			   <li class="last"><a href="#"><span>To be continue</span></a></li>
			</ul>
		</div>
		<section id="content2" class="col-md-8 three-column">
        <h5>Welcome!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:)</h5>
  		</section>

	</div> 
    <script src="../scripts/formDataValidation.js"></script>
    </body>
<html>
<?php
	//include_once "../common/close.php";
	else:
?>
	<meta http-equiv="refresh" content="0;../user/login.php">
<?php
	endif;
?>
