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
	//checks to make sure user is logged in
	if(!isset($_SESSION["logged"])){
		echo "<script>location.replace('login.php?nl=true')</script>";
		}
	?>
<title>Navigation</title>
</head>
<body>
<div class="container-fluid">
	<div class="jumbotron text-center mt-2"><h1 class="jumbotron-heading" style="font-family: 'Courier New','Courier','monospace';"><strong>WELCOME!</strong></h1></div>
	<div class="row">
	<div class="col-sm-2 pb-3 bg-secondary">
	<h2>Navigation</h2>
	<div class="btn-group-vertical btn-block">
		<button type="button" class="btn btn-primary btn-block active border border-body">Announcements</button>
		<button type="button" class="btn dropdown-toggle bg-white btn-block border border-body" data-toggle="dropdown">Lists</button>
	<div class="dropdown-menu bg-dark text-white">
		<a class="dropdown-item bg-dark text-white" href="lists.php">Lists</a>
		<a class="dropdown-item bg-dark text-white" href="manage.php">Your List</a>
	</div>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('account.php')" title="Account Settings">Settings</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('help.php')">Help</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="location.assign('about.php?ref=nav.php&ref-title=Navigation')">About</button>
		</div>
	</div><!--end of nav-->
	<div class="col-sm-10 bg-primary">
	<h1>Now that your logged in, you can:</h1>
	<dl>
		<dt>Browse Lists</dt>
		<dd>This is the point of Gift Exchange. Click "Lists" in the sidebar to begin.</dd>
		<dt>Manage Your Account</dt>
		<dd>Your can change your account settings, such as your password. You can also add a profile picture, and an interest. It is recommended that you add an interest right away.</dd>
		<dt>Browse Help</dt>
		<dd>If you are confused or have a question, you can browse the help page to see an answer to your question. </dd>
	</dl>
	<h1>Announcements</h1>
	<p class="text-dark">Read about recent announcements having to do with Gift Exchange here. </p>
	<dl>
	<dt>Gift Exchange has launched!</dt>
	<dd>The remodeled version of gift Exchange has launched. Please be sure to report bugs in order to improve gift exchange. </dd>
	<dt>More information</dt>
	<dd>If you desire more information, view the <a href="about.php" class="text-dark">About page.</a></dd>
	</dl>
	<h1>Current Develpment</h1>
	<p class="text-dark">Here's what I am working on right now...</p>
	<div id="collapser">
		<div class="card">
			<div class="card-header"><a class="card-link" data-toggle="collapse" href="#issueOne">Settings / Account Management</a></div>
			<div id="issueOne" class="collapse show" data-parent="#collapser">
				<div class="card-body">I need to make a settings page so the users can change things, such as their password, profile picture, interest, etc. I should also make a "Delete account" button. This bit will basically be a status page, then a long bunch of forms. Maybe look at some AJAX?</div>
			</div>
		</div><!--end of issue one-->
		<div class="card">
			<div class="card-header"><a class="card-link" data-toggle="collapse" href="#issueTwo">User Input Page</a></div>
			<div id="issueTwo" class="collapse show" data-parent="#collapser">
				<div class="card-body">A page which allows users to report bugs, suggest features, or provide other feedback. Basically 3 forms, which are made accessible via a little JavaScript toggle. The data is then sent to a database? or maybe my email? Perhaps I could create a 'Admin Page' with access to data such as the form results? Anyway this page will be linked in several spots.</div>
			</div>
		</div><!--end of issue two-->
		<div class="card">
			<div class="card-header"><a class="card-link" data-toggle="collapse" href="#issueThree">Lists</a></div>
			<div id="issueThree" class="collapse show" data-parent="#collapser">
				<div class="card-body">Create the two list pages. These pages will be divided into tabs for different people (lists) or functions (editing, deleting, adding, etc)</div>
			</div>
		</div><!--end of issue three-->	
	</div><!--end of collapser-->
	</div>
</div><!--end of .row-->
</div><!-- end of .container-fluid-->
<script>
//hides collapsable right away
$(".collapse").collapse("hide");
</script>
<style>
	body{
		background: linear-gradient(to left,#007bff,#6c757d );
		}
	@media (min-width: 576px){
		.jumbotron-heading{font-size:9rem;}
	}
</style>
</body>
</html>
