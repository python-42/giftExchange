<?php session_start();?>
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
<title>Login</title>
</head>
<body>
	<div class="container mt-5 p-3 bg-dark text-primary">
	<h1>Login</h1>
	<form method="post">
	<div class="form-group">
	<label for="username-box">Username: </label>
	<input type="text" name="username-box" id="username-box" class="form-control" minlength="5" maxlength="20" placeholder="Enter Your Username" required>
	</div>
	<div class="form-group">
	<label for="password-box">Password: </label>
	<input type="password" name="password-box" id="password-box" class="form-control" minlength="8" maxlength="20" placeholder="Enter Your Password" required>
	</div>
	<div class="form-group">
	<button type="submit" id="submitBtn" class="btn btn-primary">Login</button>
	</div>
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
<div class="modal" id="notifyNotLogged">
	<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
	<div class="modal-header">
	<h4 class="modal-title">Login Error!</h4>
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>
	<div class="modal-body">You were not logged in. Either your session expired, or you typed in or bookmarked a page which requires you to be logged in. Please avoid typing in the address bar to navigate, use the built-in navigation. <br>To continue using the site, simply log in normally</div>
	<div class="modal-footer">
	<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	</div>
	</div><!-- end for modal-content-->
	</div><!-- end for modal-dialog-->
</div>
<?php
//if user has been redirected here for lack or login, does a quick modal
if ($_GET["nl"]){
	echo "<script>\$(document).ready(function(){\$('#notifyNotLogged').modal();});</script>";
	}
//sql vars import
if (file_exists("include/sql.php")){
require "include/sql.php";
}else{
	error_log("Eror Code 101: include/sql.php is missing!");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}
//sql checks that accounts exist at all. Will be uselss almost %100 percent of the time
$selectSQLCheck = "SELECT username FROM login";
$rawResultCheck = $conn->query($selectSQLCheck);
if($rawResultCheck->num_rows  == 0){
	echo "<div style='text-align:center;' class='alert alert-danger'><strong>No Accounts Exist.</strong><a href='create_account.php'>Click Here</a> to create one.</div>'";
	}
//form has been submitted
if($_SERVER["REQUEST_METHOD"]=="POST"){
	$username = $_POST["username-box"];
	$password = $_POST["password-box"];
	$username = trim($username);
	$password = trim ($password);
	//sql & verification
	$selectSQL = "SELECT username, password FROM login WHERE username='".$username."'";
	$rawResult = $conn->query($selectSQL);
	if ($rawResult->num_rows ==0){
		echo "<div style='text-align:center;' class='alert alert-danger'>Username does not exist! Check your entries or create an account <a href=''>Here.</a></div>";
		}else{
			$result = $rawResult->fetch_assoc();
			if($result["password"]===$password){
				$_SESSION["logged"] = $username;
				echo "<script>location.replace('nav.php');</script>";
				}else{
					echo "<div style='text-align:center;' class='alert alert-danger'>Username or password is incorrect!</div>";
					}
			}
	}//end of $_SERVER if
?>
</body>
</html>
