<?php session_start(); ?>
<html lang="en">
	<head>
		<title>Lists</title>
		<?php
			if (file_exists("include/head-data.html")){
				require "include/head-data.html";
				}else{
					error_log("Eror Code 101: include/head_data.html is missing![create_account.php]");
					die ("<b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9'>notify developer</a> if error persists.  [Error Code: 101]</div>");
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
			
		$selectSQL = "SELECT * FROM items WHERE NOT user= '".$_SESSION['logged']."' AND  private = 0";
		$resultRaw = $conn->query($selectSQL);
		if($resultRaw ->num_rows == 0){
			$outputLackOfContent = "No one else has inputted any items!";
			}
		?>
		<div class="container-fluid">
			<div class="jumbotron text-center m-2"><h1 class="jumbotron-heading" style="font-family: 'Courier New','Courier','monospace';">Lists</h1></div>
			<div class="row">
	<div class="col-sm-2 pb-3 bg-secondary">
	<h2>Navigation</h2>
	<div class="btn-group-vertical btn-block">
		<button type="button" class="btn btn-primary btn-block active border border-body">Lists</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('manage.php')">Your List</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('nav.php')" title="Announcements and more">Announcements</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('account.php')" title="Account Settings">Settings</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('about.php?ref=nav.php&ref-title=Navigation')">About</button>
		</div>
	</div><!--end of nav-->
	<div class="col-sm-10 bg-primary">
		
		<ul class="nav nav-tabs bg-white border border-dark">
		<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home">Home</a></li>
		<?php
		$outputLinkSQL = "SELECT username FROM login WHERE NOT username ='".$_SESSION['logged']."'";
		$outputLinkRaw = $conn->query($outputLinkSQL);
		if($outputLinkRaw-> num_rows > 0){
		while($outputLinks = $outputLinkRaw->fetch_assoc()){
			echo "<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#".$outputLinks['username']."'>".$outputLinks['username']."</a></li> ";
			}
		}else{
			$outputLackOfContent = "No other users exist!";
			}
		?>
		</ul>
		
		<div class="tab-content">
			<div class="tab-pane container active" id="home">
				<h2>View Others List</h2>
				<p>Click the name of the person whom you would like to view to see their list. Click the button by the item to mark the item as bought. <strong>Only mark an item as bought after you have purchased them!</strong></p>
				<?php
				echo "<p class='text-danger' id='lackOfContent' >".$outputLackOfContent."</p>";
				?>
				</div><!--end of home div-->
		<?php
		$outputTabSQL = "SELECT username, interest, picture FROM login WHERE NOT username ='".$_SESSION['logged']."'";
		$outputTabRaw = $conn->query($outputTabSQL);
		if($outputTabRaw-> num_rows > 0){
		while($outputTabs = $outputTabRaw->fetch_assoc()){
			echo "<div class='tab-pane container fade' id='".$outputTabs['username']."'>";
			//media object to intergrate profile pictures
			echo "<div class='media mt-3'><img src=".$outputTabs['picture']." alt='Profile Picture' class='mr-3 rounded-lg bg bg-light align-self-start' style='width:60px'> <div class='media-body'>";
			echo "<h1>".$outputTabs['username']."</h1></div></div>";
			echo "<p>Interest: ".$outputTabs['interest']."<p>";
			$outputItemSQL = "SELECT * FROM items WHERE user = '".$outputTabs['username']."' AND NOT private=1";
			$outputItemRaw = $conn->query($outputItemSQL);
			if($outputItemRaw->num_rows == 0){
				echo "<p class='text-danger'>This person hasn't added any items to their list!</p>";
				}else{
					echo "<div class='card-columns'>";
					while($outputItem = $outputItemRaw -> fetch_assoc()){
						echo "<div class='card'><div class='card-header'><h4 class='card-title'>".$outputItem['name']."</h4></div><div class='card-body'><a target='_blank' href='".$outputItem['url']."' class='card-link'>".$outputItem['urlTitle']."</a><p class='card-text'>Comment: ".$outputItem['comment']."</p>";
						if( $outputItem['bought'] == null ){
							echo "<p class='card-text' id=".str_replace(" ", "+",$outputItem['name']).">This item has not been bought</p>";
							echo "<button class='btn btn-primary' id=".str_replace(" ", "+",$outputItem['name'])."|".$outputItem['user']." onclick='markBought(this.id)' >Mark Item As Bought</button>";
						}else{
							echo "<p class='card-text text-danger'>This item has been bought</p> ";
							}
						echo "</div></div>";
					}//closes loop
					echo "</div>";
			}//closes else
			echo "</div>";
		}//closes other loop
	}//closes if
		?>
		

		</div><!--end of tabs-->
	</div><!--end of main content area-->
	</div><!--end of .row-->
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
var user = "<?php echo $_SESSION["logged"]; ?>";
console.log(user);
function markBought(temp) {
	console.log(temp);
	formatted = temp.replace("+", " ");
	console.log(formatted);
	var data = formatted.split("|");
	console.log(data);
	var ajax = new XMLHttpRequest();
	ajax.open("GET", "util/markbought.php?item="+encodeURI(data[0])+"&owner="+encodeURI(data[1])+"&user="+encodeURI(user), true);
	ajax.send();
	//AJAX request has been sent. The item in question shoud've been marked as bought
	console.log("Item marked as bought");
	data[0] = data[0].replace(" ","+");
	document.getElementById(data[0]).innerHTML = "You just marked this item as bought!";
	document.getElementById(data[0]).className = "card-text text-danger";
	var toBeRm = document.getElementById(temp);
	toBeRm.remove();
}
</script>

	</body>
</html>
