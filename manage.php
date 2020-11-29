<?php session_start(); ?>
<!DOCTYPE=html>
<html lang="en">
	<head>
		<title>Manage Your List</title>
			<?php
			if (file_exists("include/head-data.html")){
				require "include/head-data.html";
				}else{
					error_log("Eror Code 101: include/head_data.html is missing![create_account.php]");
					die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
					}
				?>
	</head>
	<body>
		<?php
		//checks to make sure user is logged in
					if(!isset($_SESSION["logged"])){
						echo "<script>location.replace('login.php?nl=true')</script>";
						}
			$_SESSION["direct"] = "manage.php";
			
		if (file_exists("include/sql.php")){
			require "include/sql.php";
			}else{
				error_log("Eror Code 101: include/sql.php is missing!");
				die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
			}
		?>
		<div class="container-fluid">
			<div class="jumbotron text-center m-2"><h1 class="jumbotron-heading" style="font-family: 'Courier New','Courier','monospace';">Your List</h1></div>
			<div class="row">
	<div class="col-sm-2 pb-3 bg-secondary">
	<h2>Navigation</h2>
	<div class="btn-group-vertical btn-block">
		<button type="button" class="btn btn-primary btn-block active border border-body">Your List</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('lists.php')" title="Others Lists">Lists</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('nav.php')" title="Announcements and more">Announcements</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('account.php')" title="Account Settings">Settings</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('help.php')">Help</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('about.php?ref=nav.php&ref-title=Navigation')">About</button>
		</div>
	</div><!--end of nav-->
	<div class="col-sm-10 bg-primary">
		
		<ul class="nav nav-tabs bg-white border border-dark">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Home</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#add">Add Items</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#edit">Edit Items</a></li>
		<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#remove">Remove Items</a></li>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane container active" id="home">
				<h2>Manage Your List</h2>
				<p class="text-dark">Edit your list here. Click the corresponding tabs to either add, edit, or delete items from your list.</p>
				<h2>Your Current List</h2>
			</div><!--end of Home tab-->
			
			<div class="tab-pane container fade" id="add">
				<h2>Add Items</h2>
				<p class="text-dark">Add items to your list here.</p>
				
				<form method="post" class="bg-dark text-primary p-3 rounded-lg" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"><!-- this should break any attempted injections-->
					<div class="form-group">
						<label for="item-box">Item: </label>
						<input type="text" class="form-control" maxlength="50" name="item-box"  id="item-box" placeholder="The name of the item you would like" required>
					</div>
					
					<div class="form-group">
						<label for="holiday-box">Holiday: </label>
						<input type="text" class="form-control" maxlength="20"  name="holiday-box" id="holiday-box" placeholder="Which holiday would you like to get this item for?" required>
					</div>
					
					<div class="form-group">
						<label for="url-box">URL: </label>
						<input type="text" class="form-control"  maxlength="250" name="url-box" id="url-box" placeholder="The link to the item you would like" required>
					</div>
					
					<div class="form-group">
						<label for="title-box">Title: </label>
						<input type="text"  class="form-control" maxlength="20" name="title-box" id="title-box" placeholder="How the URL will appear when outputted" required>
					</div>
					
					<div class="form-group">
						<label for="comment-box">Comment: </label>
						<input type="text"  class="form-control" maxlength="250" name="comment-box" id="comment-box" placeholder="Any comment about the item" required>
					</div>
					<button class="btn btn-primary" type="submit" name="addBtn" id="addBtn">Add Item</button>
				</form>
				
			</div><!--end of Add tab-->
			
			<div class="tab-pane container fade" id="edit">
				<h2>Edit Items</h2>
				<p class="text-dark">Edit items which are already on your list here.</p>
				<form method="post" class="bg-dark text-primary p-3 rounded-lg" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"><!-- this should break any attempted injections-->
				<div class="form-group">
					<label for="which-box">Select which item you would like to edit:</label>
					<select name="which-box" class="custom-select form-control">
						<?php
					$editOptionSelect = "SELECT name FROM items WHERE user = '".$_SESSION["logged"]."'";
					$editOptionResultRaw = $conn->query($editOptionSelect);
					if($editOptionResultRaw->num_rows > 0){
						while($editOptionResult = $editOptionResultRaw->fetch_assoc()){
							echo "<option>".$editOptionResult['name']."</option>";
							}
					}else{
						echo "<option selected value='none'>There aren't any items on your list! And items in the tab labeled 'Add Items'!</option>";
						}
					?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary" name="editSelectBtn" id="editSelectBtn">Next</button>
				</form>
				<?php
				if($_SERVER["REQUEST_METHOD"] == "POST"){
			//checks which form was submitted
			if(isset($_POST["addBtn"])){
				//gets inputs
				$create["item"] = $_POST["item-box"];
				$create["holiday"] = $_POST["holiday-box"];
				$create["url"] = $_POST["url-box"];
				$create["title"] = $_POST["title-box"];
				$create["comment"] = $_POST["comment-box"];
				//validates input
				if (in_array("", $create)){
					error_log("Input was blank for a required form. Page = manage.php Form = add item form. User = ".$_SERVER["REMOTE_HOST"]." , ".$_SERVER["REMOTE_ADDR"]);
					}else{
						$createPrep = $conn->prepare("INSERT INTO items (user, name, url, holiday, comment, urlTitle) VALUES (?, ?, ?, ?, ?, ? )");
						$createPrep -> bind_param("ssssss", $_SESSION["logged"], $create["item"], $create["url"], $create["holiday"], $create["comment"], $create["title"]);
						$createPrep ->execute();
						$createPrep->close();
						
						echo "<script>location.replace('util/shortstop.php')</script>";
						}
					
				}elseif(isset($_POST["editBtn"])){
					//gets inputs
				$edit["item"] = $_POST["item-edit-box"];
				$edit["holiday"] = $_POST["holiday-edit-box"];
				$edit["url"] = $_POST["url-edit-box"];
				$edit["title"] = $_POST["title-edit-box"];
				$edit["comment"] = $_POST["comment-edit-box"];
				//validates input
				if (in_array("", $edit)){
					error_log("Input was blank for a required form. Page = manage.php Form = edit item form. User = ".$_SERVER["REMOTE_HOST"]." , ".$_SERVER["REMOTE_ADDR"]);
					}else{
						$editPrep = $conn->prepare("UPDATE items SET name = ? , url = ? , holiday = ? , comment =? , urlTitle = ? WHERE user = ? AND name = ?");
						$editPrep -> bind_param("sssssss",  $edit["item"], $edit["url"], $edit["holiday"], $edit["comment"], $edit["title"], $_SESSION["logged"], $_SESSION["old-item"]);
						$editPrep ->execute();
						$editPrep->close();
						echo "<script>location.replace('util/shortstop.php')</script>";
						}
					
					}elseif(isset($_POST["rmBtn"])){
						$rmItem = $_POST["rm-box"];
						if($rmItem == ""){
							error_log("Input was blank for a required form. Page = manage.php Form= remove item form. User = ".$_SERVER["REMOTE_HOST"]." , ".$_SERVER["REMOTE_ADDR"]);
							}else{
								$rmPrep = $conn->prepare("DELETE FROM items WHERE name = ? AND user = ?");
								$rmPrep -> bind_param("ss", $rmItem, $_SESSION["logged"]);
								$rmPrep -> execute();
								$rmPrep -> close();
								
								echo "<script>location.replace('util/shortstop.php')</script>";
								}
						}elseif(isset($_POST["editSelectBtn"])){
							$which = $_POST["which-box"];
							if ($which != "" && $which != "none"){
								$editSelect = "SELECT * FROM items WHERE name='".$which."' AND user='".$_SESSION["logged"]."'";
								$editRawResult = $conn->query($editSelect);
								if($editRawResult -> num_rows == 0){
									error_log("Error Code 202: Expected data in table items, but data was absent. [manage.php]");
									die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b> Data is missing from database.  Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 202]</div>");
								}else{
									$_SESSION["tab"] = "#edit";
									$_SESSION["old-item"] = $which;
									$editResult = $editRawResult->fetch_assoc();
									echo "<form method='post' class='bg-dark text-primary p-3 rounded-lg' autocomplete='off' action='".htmlspecialchars($_SERVER['PHP_SELF']) ."'><div class='form-group'><label for='item-edit-box'>Item: </label><input type='text' class='form-control' maxlength='50' name='item-edit-box'  id='item-edit-box' value='".$editResult['name']."' required></div><div class='form-group'><label for='holiday-edit-box'>Holiday: </label><input type='text' class='form-control' maxlength='20'  name='holiday-edit-box' id='holiday-edit-box' value='".$editResult['holiday']."' required></div><div class='form-group'><label for='url-edit-box'>URL: </label><input type='text' class='form-control'  maxlength='250' name='url-edit-box' id='url-edit-box' value='".$editResult['url']."' required></div><div class='form-group'><label for='title-edit-box'>Title: </label><input type='text'  class='form-control' maxlength='20' name='title-edit-box' id='title-edit-box' value='".$editResult['urlTitle']."' required></div><div class='form-group'><label for='comment-edit-box'>Comment: </label><input type='text'  class='form-control' maxlength='250' name='comment-edit-box' id='comment-edit-box' value='".$editResult['comment']."' required></div><button class='btn btn-primary' type='submit' name='editBtn' id='editBtn'>Edit Item</button></form>";
									}
								}
							}//end of elseif's
			}//end of $_SERVER if
			
				if (isset($_SESSION['tab'])){
				echo "<script>var tab =\"".$_SESSION['tab']."\"</script>";
				$_SESSION["tab"] = "#home";
			}
		?>	
			</div><!--end of Edit tab-->
			
			<div class="tab-pane container fade" id="remove">
				<h2>Remove Items</h2>
				<p class="text-dark">Remove items from your list here.</p>
				<form method="post" class="bg-dark text-primary p-3 rounded-lg" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>"><!-- this should break any attempted injections-->
			<div class="form-group">
				<label for="rm-box">Select the item you would like to remove: </label>
				<select name="rm-box" class="custom-select form-control">
					<?php
					$rmSelect = "SELECT name FROM items WHERE user = '".$_SESSION["logged"]."'";
					$rmResultRaw = $conn->query($rmSelect);
					if($rmResultRaw->num_rows > 0){
						while($rmResult = $rmResultRaw->fetch_assoc()){
							echo "<option>".$rmResult['name']."</option>";
							}
					}else{
						echo "<option selected>There aren't any items on your list! And items in the tab labeled 'Add Items'!</option>";
						}
					?>
				</select>
			</div>
			<button type="submit" class="btn btn-primary" name="rmBtn" id="rmBtn">Remove Item</button>
			</form>
			</div><!--end of Remove tab-->
		</div>
		
	</div><!--end of large content section-->
	</div><!--end of row-->
		</div><!--end of .container-fluid-->
<style>
	body{
		background: linear-gradient(to left,#007bff,#6c757d );
		}
	@media (min-width: 576px){
		.jumbotron-heading{font-size:9rem;}
	}
</style>
<script>
	$(document).ready(function () { 
	if (typeof(tab) == "string"){
$(".nav-tabs a[href='"+tab+"'] ").tab("show");
console.log("Tab shown");
}else{
	console.log("tab is not a string (likely not defined)");
	}
});
</script>
</body>
</html>
