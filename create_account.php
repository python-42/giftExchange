<?php session_start(); ?>
<!DOCTYPE=html>
<html lang="en">
<head>
<?php
if (file_exists("include/head_data.html")){
require "include/head_data.html";
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
	<form method="post">
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
		<input type="password" name="confirm-box" placeholder="Confirm Your Password" class="form-control" minlength="8" maxlength="20" required>
		</div>
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
		$errorMsg = "Passwords do not match!";//finish this part
		}
if($otherUsernames){
if(array_search($username,$result)){
	}else{
		
		}
}else{
	}
?>
</body>
</html>
