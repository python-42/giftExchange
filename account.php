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
<title>Account & Settings</title>
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
//this is just so we can get the amount of items in the items table
$selectItemSQL = "SELECT * FROM items WHERE user = '".$_SESSION['logged']."'";
$rawResult2 = $conn -> query($selectItemSQL);
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
	</div>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('nav.php')">Announcements</button>
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
		<!--toast-->
			<div class="toast">
				<div class="toast-header">
					Profile Picture is alreay at the default!
				</div>
				<div class="toast-body">
					Your profile picture is alreay the default image! Do not try to reset it when it is the default!
				</div>
			</div>
			<!---end-->
		</div>
		
		<div class="tab-pane container fade" id="profile">
		<h1>Profile</h1>
		<p class="text-dark">Change settings having to do with your profile here.</p>
		<h2>Interest</h2>
		<p class="text-dark">What are your hobbies or interests? 100 characters or less.</p>
		
		<form method="post" class="form-group" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
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
				<div class="card-body p-3">
					<h4 class="card-title">Current Profile Picture:</h4>
					<?php if($result["picture"] == "img/default.png"){
						echo "<p class='card-text text-dark mx-auto'>(Default) </p>";
						}?>
				</div>
				<img class="card-img-bottom img-fluid img-thumbnail mx-auto" src=<?php echo $result["picture"]?> alt="Profile image" style="max-width: 200px; max-height: 200px">
				<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#imgReset" title="Reset Profile Picture">Reset</button>
			</div>
			
			<!--start of modal-->
			<div class="modal" id="imgReset">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						
						<div class="modal-header">
							<h4 class="modal-title">Reset Profile Picture</h4>
						</div>
						
						<div class="modal-body">
							<p>Are you sure you would like to reset your profile picture? This will delete your current image, and set your profile picture back to the default. You can always upload a new profile picture after this.</p>
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-muted border border-dark" data-dismiss="modal">Cancel</button>
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
							<button type="submit" name="resetImg" id="resetImg" class="btn btn-danger">Reset Image</button>
							</form>
						</div>
						
					</div>
				</div>
			</div>
			<!--end of modal-->
			<?php
			if(isset($_POST['resetImg'])){
				if($result["picture"] == "img/default.png"){
					echo "<script>$('.toast').toast({delay: 7000});$('.toast').toast('show');</script>";
				}else{
				unlink($result["picture"]);//deletes file
				$prepare = $conn->prepare("UPDATE login SET picture = 'img/default.png' WHERE username = ?");
				$prepare->bind_param("s", $_SESSION["logged"]);
				$prepare->execute();
				$prepare->close();
				$conn->close();
				echo "<script>location.replace('/util/shortstop.php')</script>";
				}
			}
			?>
			
			<h3 class="mt-5">Upload</h3>
		<p class="text-dark">You may upload a new profile picture here. Make sure it is a square, and is less than 5 KB. It should also be a PNG format.</p>
		<form class="form-group" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
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
		
		<div class="tab-pane container fade" id="account">
		<h4>Account Settings</h4>
		<p class="text-dark">Change settings which have to do with your account here.</p>
		<h3>Password</h3>
		<p class="text-dark">Change your password here.</p>
		
		<form method="post" class="bg-dark text-primary p-3" autocomplete="off" name="update" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
			<div class="form-group">
				<label for="current-box">Current Password:</label>
				<input type="password" class="form-control" placeholder="Enter your current password for security" name="current-box" id="current-box" minlength="5" maxlength="20"  required>
			</div>
			<div class="form-group">
				<label for="new-box">New Password:</label>
				<input type="password" class="form-control" placeholder="Enter your new password" name="new-box" id="new-box" minlength="5" maxlength="20"  required>
			</div>
			<div class="form-group">
				<label for="confirm-box">Confirm Password:</label>
				<input type="password" onkeyup="testPassword()" class="form-control" placeholder="Confirm your new password" name="confirm-box" id="confirm-box" minlength="5" maxlength="20"  required>
			</div>
			<button type="submit" class="btn btn-primary" name="updatePassword">Submit</button>
			<p class="text-danger" id="errorTxt"></p>
		</form>
		<?php 
		function outputErrorMsg($errorMsg){
			echo "<div class='alert alert-danger' style='text-align:center;'><b>".$errorMsg."</b> Please try again.</div>";
		}
		?>
		<h3>Birthday</h3>
		<p class="text-dark">Add or change your birthday here.</p>
		
		<div class="card">
				<div class="card-body p-3">
					<h4 class="card-title">Current Birthday:</h4>
					<p class="text-dark">(Format is YYYY/MM/DD)</p>
					<?php if($result["birthday"] == NULL){
						echo "<p class='card-text text-dark mx-auto'>No birthday set</p>";
						}else{
							echo "<p class='card-text text-dark mx-auto'>".$result['birthday']."</p>";
							}
						?>
				</div>
			</div>
			
			<form class="bg-dark text-primary p-3 mt-3" method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
				<div class="form-group">
					<label for="date-box">Set Birthday: </label>
					<input type="date" name="date-box" class="form-control" required>
				</div>
				<button class="btn btn-primary" type="submit" name="updateBirthday">Submit</button>
			</form>	
		</div>
		
		<div class="tab-pane container fade bg-secondary" id="danger">
			<div class="pt-3 pb-3">
			<h4 class="text-danger">Danger!</h4>
			<p class="text-warning">Be careful when changing these settings!</p>
			<h3 class="text-danger">Delete Items</h3>
			<p class="text-warning">This will delete all items entered into the Gift Exchange database! This action is not reverseable!</p>
			<p class="text-info">You currently have <b><?php echo $rawResult2->num_rows;  ?></b> items.</p>
			<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteItems" title="Delete all items">Delete Items</button>
			<h3 class="text-danger mt-2">Delete Account</h3>
			<p class="text-warning">This will permanently delete your account and all of your items! This action is not reverseable!</p>
			<button class="btn btn-danger" type="button" data-toggle="modal" data-target="#deleteAccount" title="Delete your account">Delete Account</button>
			</div>
			<!--start of delete items modal-->
			<div class="modal" id="deleteItems">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						
						<div class="modal-header">
							<h4 class="modal-title">Delete Items</h4>
						</div>
						
						<div class="modal-body">
							<p>Are you sure you would like to delete all of your items? This action is completely irreverable and permanent. You will always be able to add new items.</p>
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-muted border border-dark" data-dismiss="modal">Cancel</button>
							<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
							<button type="submit" name="deleteItems" id="deleteItems" class="btn btn-danger">Delete Items</button>
							</form>
						</div>
						
					</div>
				</div>
			</div>
			<!--end of delete items modal-->
			
			<!--start of delete account modal-->
			<div class="modal" id="deleteAccount">
				<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						
						<div class="modal-header">
							<h4 class="modal-title">Delete Account</h4>
						</div>
						
						<div class="modal-body">
							<p>Are you sure you would like to delete your account? All of your items, as well as any other information (such as login information) will be deleted. This action is permenant and irreverable. </p>
							<p>If you are sure you would like to continue, enter your login information to confirm it is actually you.</p>
							<form method="post" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
								<div class="form-group">
									<label for="username-box">Username: </label>
									<input type="text" class="form-control" placeholder="Enter your username" name="username-box" id="username-box" maxlength="20" minlength="4" required>
								</div>
								
								<div class="form-group">
								<label for="password-box">Password: </label>
									<input type="password" class="form-control" placeholder="Enter your password" name="password-box" id="password-box" maxlength="20" required>
								</div>
								
								<button type="submit" name="deleteAccount" id="deleteAccount" class="btn btn-danger">Delete Account</button>
							</form>
						</div>
						
						<div class="modal-footer">
							<button type="button" class="btn btn-muted border border-dark" data-dismiss="modal">Cancel</button>
						</div>
						
					</div>
				</div>
			</div>
			<!--end of delete account modal-->
				
		</div>
		
		
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
			//image upload
$allowedExts = array("png");
$extension = pathinfo($_FILES['file-box']['name'], PATHINFO_EXTENSION);
$target = "img/uploaded/".basename($_FILES["file-box"]["name"]);
$continue = 1;

if ((($_FILES["file-box"]["type"] == "image/png")&& ($_FILES["file-box"]["size"] < 20000000)&& in_array($extension, $allowedExts))){
  if ($_FILES["file-box"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file-box"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file-box"]["name"] . "<br />";
    echo "Type: " . $_FILES["file-box"]["type"] . "<br />";

    if (file_exists("img/uploaded/" . $_FILES["file-box"]["name"])){
      echo $_FILES["file-box"]["name"] . " already exists. ";
      $continue = 0;
      }
    else{
      move_uploaded_file($_FILES["file-box"]["tmp_name"], $target );
      echo "Stored in: " . "img/uploaded/" . $_FILES["file-box"]["name"];
      $path = "img/uploaded/". $_FILES["file-box"]["name"];
      }
    }
  }
else
  {
  echo "Invalid file";
  $continue = 0;
 }
 
 if ($continue){
	 $prep = $conn->prepare("UPDATE login SET picture = ? WHERE username = ?");
	 $prep->bind_param("ss",$path, $_SESSION["logged"]);
	 $prep->execute();
	 $prep->close();
	 $conn->close();
	echo "<script>location.replace('/util/shortstop.php')</script>";
	 }
	 }elseif(isset($_POST["updatePassword"])){
		 $currentPassword = $_POST["current-box"];
		 $newPassword = $_POST["new-box"];
		 $confirmPassword = $_POST["confirm-box"];
		 $currentPassword = trim($currentPassword);
		 $newPassword = trim($newPassword);
		 $confirmPassword = trim($confirmPassword);
		 $updateOk = true;
		 $errorMsg = "";
		 //checks
		 if ($currentPassword == "" || $newPassword ==""|| $confirmPassword == ""){
			 $updateOk = false;
			 $errorMsg = "Input may not be blank!";
			 }
		if ($currentPassword != $result["password"]){
			$updateOk = false;
			$errorMsg = "Current password is incorrect!";
			}
		if($newPassword != $confirmPassword){
			$updateOk = false;
			$errorMsg = "Passwords do not match!";
			}
		 
		 if($updateOk){
			 //SQL query
			 $updatePrep = $conn->prepare("UPDATE login SET password = ? WHERE username = ?");
			 $updatePrep -> bind_param("ss",$newPassword, $_SESSION["logged"]);
			 $updatePrep -> execute();
			 $updatePrep -> close();
			 $conn -> close();
			 echo "<script>location.replace('util/shortstop.php');</script>";
			 }else{
				 outputErrorMsg($errorMsg);
				 }
		 }elseif(isset($_POST["updateBirthday"])){
			 $birthday = $_POST["date-box"];
			 $updateOK = true;
			 $errMsg = "";
			 //checks
			 if ($birthday == ""){
				 $updateOK = false;
				 }
			if($updateOK ){
				//SQL query
				$datePrep = $conn ->prepare("UPDATE login SET birthday = ? where username = ?");
				$datePrep -> bind_param("ss",$birthday, $_SESSION["logged"]);
				$datePrep -> execute();
				$datePrep -> close();
				$conn->close();
				 echo "<script>location.replace('util/shortstop.php');</script>";
				}//the only way that $updateOK is false is if the user tampers with the DevTools, so I will reward this tampering with absolutely nothing. If the input type is changed, the input will be rejected from the database anyway
	 
	}elseif(isset($_POST["deleteItems"])){
		$deletePrep = $conn->prepare("DELETE FROM items WHERE user = ?");
		$deletePrep -> bind_param("s", $_SESSION["logged"]);
		$deletePrep -> execute();
		$deletePrep -> close();
		echo "<script>location.replace('util/shortstop.php')</script>";
		}elseif(isset($_POST["deleteAccount"])){
			$deleteUsername = $_POST["username-box"];
			$deletePswd = $_POST["password-box"];
			if($deleteUsername == $result["username"] && $deletePswd == $result["password"]){
				$deletePrep2 = $conn->prepare("DELETE FROM items WHERE user = ?");
				$deletePrep2 -> bind_param("s", $_SESSION["logged"]);
				$deletePrep2 -> execute();
				$deletePrep2 -> close();
				$destroyPrep = $conn->prepare("DELETE FROM login WHERE username = ?");
				$destroyPrep->bind_param("s", $_SESSION["logged"]);
				$destroyPrep -> execute();
				$destroyPrep->close();
				$conn->close();
				echo "<script>location.replace('util/shortstop.php')</script>";
				}else{
					echo "<p class='text-danger'>Username or password incorrect. Account deletion failed.</p>";
					}
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
	//makes sure that the name of the file to be uploaded shows up in the form
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

//this checks that the passwords match
function testPassword() {
var password = document.forms["update"]["new-box"].value;
var confirm = document.forms["update"]["confirm-box"].value;
if (password != confirm){
	document.getElementById("errorTxt").innerHTML = "Passwords do not match!";
}else{
	document.getElementById("errorTxt").innerHTML = "";
	}
}
</script>
</body>
</html>
