<?php session_start(); ?>
<!DOCTYPE=html>
<html lang="en">
<head>
<?php
if (file_exists("include/head-data.html")){
require "include/head-data.html";
}else{
	error_log("Eror Code 101: include/head_data.html is missing![create_account.php]");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}
?>
<title>Create Account</title>
</head>
<body>
<div class="container bg-dark text-primary p-3 border border-secondary mt-5" id="main">
	<h1 class="mb-3">Create An Account</h1>
	<form method="post" name="create">
		<div class="form-group">
			<label for="username-box">Username: </label>
			<input type="text" name="username-box" placeholder="Enter A Username" class="form-control" maxlength="20" required>
		</div>
		<div class="form-group">
			<label for="password-box">Password: </label>
		<input type="password" name="password-box" placeholder="Enter A Password" class="form-control" minlength="8" maxlength="20" required>
		</div>
		<div class="form-group">
		<label for="confirm-box">Confirm Password: </label>
		<input type="password" onkeyup="testPassword()" name="confirm-box" placeholder="Confirm Your Password" class="form-control" minlength="8" maxlength="20" required>
		</div>
		<p class="text-danger" id="errorTxt"></p>
		<button type="submit" class="btn btn-primary">Create Account</button>
	</form>
</div>
<style>
body{
	background-color:#007bff;
	}
	h1{
		text-decoration:underline;
		}
</style>
<?php
if (file_exists("include/sql.php")){
require "include/sql.php";
}else{
	error_log("Eror Code 101: include/sql.php is missing![create_account.php]");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}
//sql
$otherUsernames = true;
$selectSQL = "SELECT username FROM login";
$rawResult = $conn->query($selectSQL);
if ($rawResult->num_rows > 0){
	$result = $rawResult->fetch_assoc();
	}else{
		$otherUsernames = false;
		}
//no longer sql
//function
function createUser($user, $pass){
	global $conn;
	$prep = $conn->prepare("INSERT INTO login (username, password) VALUES (?,?)");
	$prep->bind_param("ss",$user,$pass);
	$prep->execute();
	$prep->close();
	//our values should have been inserted into the database. Now checks that insert was successful
	$checkSQL = "SELECT username FROM login WHERE username='".$user."'";
	$selected = $conn->query($checkSQL);
	if ($selected->num_rows == 1){
		echo "<script>location.replace('account.php')</script>";
		}else{
			error_log("Error Code 202: Expected data in table login, but data was absent. [create_account.php]");
			die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> Data is missing from database. Accout creation failed. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 202]</div>");
			}
	}
//ifs and things
if ($_SERVER["REQUEST_METHOD"]=="POST"){
$username = $_POST["username-box"];
$password = $_POST["password-box"];
$confirm = $_POST["confirm-box"];
$createOK = true;
$errorMsg = "";
//runs a few checks to verify all the things
if ($password === $confirm){
	//passwords match, password is now sanitized. confirm var will not be referenced again, so it is unset
	unset($confirm);
	$password = filter_var($password, FILTER_SANITIZE_STRING);
	}else{
		$createOK = false;
		$errorMsg = "Passwords do not match!";
		}
if ($createOK){
	if($otherUsernames){
		if(array_search($username,$result)){
			$createOK = false;
			$errorMsg = "Username already exists!";
			echo "<div class='alert alert-danger' style='text-align:center;'><b>".$errorMsg."</b> Please try again.</div>";
		}else{
			//final check, just like below
			if ($createOK){
		createUser($username, $password);
		}else{echo "<div class='alert alert-danger><b>Unknown Error...</b>Please try again.</div>'";}
			}
	}else{
		//one final check to make sure I havent slipped up, same as before
		if ($createOK){
		createUser($username, $password);
		}else{echo "<div class='alert alert-danger><b>Unknown Error...</b>Please try again.</div>'";}
	}
}else{
	echo "<div class='alert alert-danger' style='text-align:center;'><b>".$errorMsg."</b> Please try again.</div>";
}
}//closing for if $_SERVER[REQUEST_METHOD]
?>
<script>
//ajax which does a few checks for user convience. Futher checks are preformed using php once data is sent to the server. These checks are all about username
var ajax = new XMLHttpRequest();
//finish
//this checks that the passwords match
function testPassword() {
var password = document.forms["create"]["password-box"].value;
var confirm = document.forms["create"]["confirm-box"].value;
if (password != confirm){
	document.getElementById("errorTxt").innerHTML = "Passwords do not match!";
}else{
	document.getElementById("errorTxt").innerHTML = "";
	}
}
</script>
</body>
</html>
