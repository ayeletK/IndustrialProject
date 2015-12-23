		<div id="cssmenu">
			<ul>
			   <li class="active"><a href="../cssmenu/mainPage.php"><span>Home</span></a></li>
				<?php if(isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn']==1 && $_SESSION['Role']=='SM'){ ?>
			   <li class="has-sub"><a href="#"><span>function</span></a>
				  <ul>
					 <li><a href="../cluster/addnewcluster.php"><span>add new cluster</span></a></li>
					 <li><a href="../cluster/addnewAccount.php"><span>add new account</span></a></li>
					 <li><a href="../cluster/removeCluster.php"><span>remove existing cluster</span></a></li>
					 <li class="last"><a href="#"><span>remove account from Cluster</span></a></li>
				  
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
		