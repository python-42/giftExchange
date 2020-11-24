<?php session_start(); 
$_SESSION["direct"] = "account.php";
?>
<!DOCTYPE=html>
<html lang="en">
<head>
<?php
if (file_exists("include/head-data.html")){
require "include/head-data.html";
}else{
	error_log("Eror Code 101: include/head_data.html is missing!");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}
?>
<title>Account</title>
</head>
<body>
<?php 
//sql vars import
if (file_exists("include/sql.php")){
require "include/sql.php";
}else{
	error_log("Eror Code 101: include/sql.php is missing!");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}
//checks to make sure user is logged in
	if(!isset($_SESSION["logged"])){
		echo "<script>location.replace('login.php?nl=true')</script>";
		}
//gets data from db about user, i.e. interest, profile picture, password, etc
$selectSQL = "SELECT * FROM login WHERE username = '".$_SESSION['logged']."'";
$rawResult =  $conn->query($selectSQL);
if ($rawResult -> num_rows == 0){
	echo "<script>location.replace('login.php')</script>";
	}else{
		$result = $rawResult -> fetch_assoc();
		}
?>
<div class="container-fluid">
	<div class="jumbotron text-center mt-2"><h1 class="jumbotron-heading" style="font-family: 'Courier New','Courier','monospace';"><strong>SETTINGS</strong></h1></div>
	<div class="row">
		<div class="col-sm-2 pb-3 bg-secondary">
	<h2>Navigation</h2>
	<div class="btn-group-vertical btn-block">
		<button type="button" class="btn btn-primary btn-block active border border-body">Settings</button>
		<button type="button" class="btn dropdown-toggle bg-white btn-block border border-body" data-toggle="dropdown">Lists</button>
	<div class="dropdown-menu bg-dark text-white">
		<a class="dropdown-item bg-dark text-white" href="lists.php">Lists</a>
		<a class="dropdown-item bg-dark text-white" href="manage.php">Your List</a>
		<a class="dropdown-item bg-dark text-white" href="circles.php">Circles</a>
	</div>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('nav.php')">Announcements</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('help.php')">Help</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('about.php')">About</button>
		</div>
	</div><!--end of nav-->
	
	<div class="col-sm-10 bg-primary pt-3">
		<ul class="nav nav-tabs bg-white border border-dark">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#words">Start</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile">Profile</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#account">Account</a></li>
		<li class="nav-item"><a class="nav-link text-danger" data-toggle="tab" href="#danger">Danger</a></li>
		</ul>
		
		<div class="tab-content">
		<div class="tab-pane container active" id="words">
		<h1 style="text-decoration:underline;">Settings</h1>
		<p>Using this menu, you can access and change different settings. Click on the group of settings you would like to change above.</p>
		<dl>
		<dt>Profile</dt>
		<dd>Social settings, such as your profile picture or interests.</dd>
		<dt>Account</dt>
		<dd>Settings having to do with your account, such as your password. You can also add a birthday here.</dd>
		<dt>Danger</dt>
		<dd>These settings can have potentially frusterating or disaterous effects, such as deleting your account, or clearing all of your items. These are irreversible!</dd>
		</dl>
		</div>
		
		<div class="tab-pane container fade" id="profile">
		<h1>Profile</h1>
		<p class="text-dark">Change settings having to do with your profile here.</p>
		<h2>Interest</h2>
		<p class="text-dark">What are your hobbies or interests? 100 characters or less.</p>
		
		<form method="post" class="form-group">
		<div class="input-group">
			<div class="input-group-prepend">
		<span class="input-group-text">Interest:</span>
		</div>
		<input type="text" class="form-control" placeholder="What are your interests?" name="interest-box" id="interest-box" maxlength="100" required>
			<div class="input-group-append">
				<button type="submit" class="btn btn-success border border-dark" name="interest_submit">Save</button>
			</div>
		</div>
		</form>
		
		<div class="card">
			<div class="card-body  p-3">
				<h4 class="card-title">Current Interest: </h4>
				<p class="card-text"><?php echo $result["interest"];?></p>
			</div>
		</div>
		
		<h2>Profile Picture</h2>
			<div class="card">
				<div class="card-body">
					<h4 class="card-title">Current Profile Picture</h4>
					<?php if($result["picture"] == "img/default.png"){
						echo "<p class='card-text text-dark'>(Default) </p>";
						}?>
				</div>
				<img class="card-img-bottom img-fluid img-thumbnail" src=<?php echo $result["picture"]?> alt="Profile image" style="max-width: 200px; max-height: 200px">
			</div>
			<h3>Upload</h3>
		<p class="text-dark">You may upload a new profile picture here. Make sure it is a square, and is less than 5 KB. It should also be a PNG format.</p>
		<form class="form-group" method="post" enctype="multipart/form-data">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text">Upload File: </span>
				</div>
				<div class="custom-file">
				<input type="file" class="custom-file-input" name="file-box" id="file-box" required>
				<label class="custom-file-label" for="customFile">Choose file</label>
				</div>
				<div class="input-group-append">
					<button type="submit" class="btn btn-success border border-dark" name="upload_submit">Upload</button>
				</div>
			</div>
		</form>
		
		</div>
		
		<div class="tab-pane container fade" id="account"></div>
		
		<div class="tab-pane container fade" id="danger"></div>
		
		</div>
		</div><!--end of main content section-->
	</div><!--end of .row-->
</div><!--end of .container-fluid-->
<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){
	//checks which form was submitted
	if(isset($_POST["interest_submit"])){
		$interest = $_POST["interest-box"];
		$interest = filter_var($interest, FILTER_SANITIZE_STRING);
		$prepInterest = $conn->prepare("UPDATE login SET interest = ? WHERE username = ?");
		$prepInterest->bind_param("ss",$interest, $_SESSION["logged"]);
		$prepInterest->execute();
		$prepInterest->close();
		echo "<script>location.replace('util/shortstop.php')</script>";
		}elseif(isset($_POST["upload_submit"])){
			//handle file upload
			
			}
	}//end of $_SERVER if
?>
<style>
	body{
		background: linear-gradient(to left,#007bff,#6c757d);
		}
	@media (min-width: 576px){
		.jumbotron-heading{font-size:9rem;}
	}
</style>
<script>
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
</script>
</body>
</html>
