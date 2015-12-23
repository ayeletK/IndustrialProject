
<!DOCTYPE HTML> 
<html>
<head>
<style>
.error {color: #00FF00;}
</style>
</head>
<body> 


<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="/industrialProject/mysqltry/addTask.php"> 
   Name: <input type="text" maxlength="30" name="name">
   <span class="error">* </span>
   <br><br>
   Password: <input type="text" maxlength="16" name="password">
   <span class="error">*</span>
   <br><br>
   E-mail: <input type="text" maxlength="50" name="email">
   <span class="error">* </span>
   <br><br>
   <input type='reset' value='Reset'>
   <input type="submit" name="submit" value="Submit"> 
</form>


<!-- comment ?php
	include 'include/connection.php';

	$query = "SELECT * from users";
	
	$result = mysql_query($query);
	while ($user = mysql_fetch_array($result)){
		echo "<h3>" . $user['UserName'] . "</h3>";
	}
?> -->
</body>
</html>