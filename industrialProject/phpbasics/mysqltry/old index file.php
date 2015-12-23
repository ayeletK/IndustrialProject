
<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<?php
	include 'include/connection.php';

	// define variables and set to empty values
	$name = $password = $email ="";

	$nameErr = $emailErr = $genderErr = $websiteErr = "";
	$name = $email = $gender = $comment = $website = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  if (empty($_POST["inputName"])) {
		$nameErr = "Name is required";
	  } else {
		$inputName = test_input($_POST["inputName"]);
	  }

	  if (empty($_POST["inputMail"])) {
		$emailErr = "Email is required";
	  } else {
		$inputMail = test_input($_POST["inputMail"]);
	  } 
	  if (empty($_POST["inputPass"])) {
		$inputPass = "";
	  } else {
		$inputPass = test_input($_POST["inputPass"]);
	  }
	  echo "<h2>succeed adding new user !:</h2>";
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
   Name: <input type="text" name="name">
   <span class="error">* <?php echo $nameErr;?></span>
   <br><br>
   E-mail: <input type="text" name="email">
   <span class="error">* <?php echo $emailErr;?></span>
   <br><br>
   Website: <input type="text" name="website">
   <span class="error"><?php echo $websiteErr;?></span>
   <br><br>
   Comment: <textarea name="comment" rows="5" cols="40"></textarea>
   <br><br>
   Gender:
   <input type="radio" name="gender" value="female">Female
   <input type="radio" name="gender" value="male">Male
   <span class="error">* <?php echo $genderErr;?></span>
   <br><br>
   <input type="submit" name="submit" value="Submit"> 
</form>

