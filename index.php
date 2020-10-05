<!DOCTYPE=html>
<html lang="en">
<head>
<?php
//require statements for data that belongs in head
require "include/head-data.html";
?>
<title>Gift Exchange</title>
</head>
<body>
<div class="container-fluid bg-dark pt-2">
	<div class="jumbotron text-danger border border-primary"><h1 class="jumbotron-heading">GIFT EXCHANGE</h1></div>
	<div class="row">
	<div class="col-sm-2 pb-3 bg-secondary">
	<h2><abbr>Navigation</abbr></h2>
	<div class="btn-group-vertical btn-block">
		<button type="button" class="btn btn-primary btn-block active border border-body">Home</button>
	<button type="button" class="btn dropdown-toggle bg-white btn-block border border-body" data-toggle="dropdown">Account</button>
	<div class="dropdown-menu bg-dark text-white">
	<a class="dropdown-item bg-dark text-white" href="login.php">Login</a>
	<a class="dropdown-item bg-dark text-white" href="create_account.php">Create Account</a>
	</div>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="document.location('help.php')">Help</button>
		<button type="button" class="btn bg-white btn-block border border-body" onclick="document.location('about.php')">About</button>
	</div>
	</div>
	<div class="col-sm-10 bg-primary text-body">
	<h1>Welcome to Gift Exchange!</h1>
	<p>Gift Exchange is a website which allows you to connect with your friends and family. You can ask for a gift, and give others gifts. Gift exchange takes the guesswork out of giving, making sure that at the end of the day, everyone is happy.</p>
	<h3>How Does Gift Exchange work?</h3>
	<p>Gift Exchange is designed to be simple to use.</p>
	<ol>
	<li>Create an account by clicking on the 'Account' tab in the navigation and filling out the forms.</li>
	<li>CONTINUE UPDATING THIS IN CONJUNCTION WITH SITE DEVELOPMENT</li>
	</ol>
	<h3>A Few Notes...</h3>
	<p>Please, please remeber to use the breadcrumbs! These will show your path throught the site, with links so that you can return to previous pages. <strong>Pressing your browsers back button can result in your entries being deleted!</strong> Use the breadcrumbs in the lower right hand corner to navigate the site!</p>
	</div>
	</div>
</div>
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
