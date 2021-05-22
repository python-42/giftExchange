<!DOCTYPE=html>
<html lang="en">
<head>
<?php
//error handling script
if (file_exists("include/head-data.html")){
require "include/head-data.html";
}else{
	error_log("Eror Code 101: include/head_data.html is missing![index.php]");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}

if (file_exists("util/nav-block.php")){
require "util/nav-block.php";
}else{
	error_log("Eror Code 101: util/nav-block.php is missing![index.php]");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}
?>
<title>Gift Exchange</title>
</head>
<body>
<div class="container-fluid bg-dark pt-2">
	<div class="jumbotron text-danger border border-primary"><h1 class="jumbotron-heading">GIFT EXCHANGE</h1></div>
	<div class="row">
	<!--nav start-->
		<?php 
		nav(0, "shown+create", "active+index", 0, "shown+login", 0, 0, 0);
		?>
	<!--nav end-->
	<div class="col-sm-10 bg-primary text-body">
	<h1>Welcome to Gift Exchange!</h1>
	<p>Gift Exchange is a website which allows you to connect with your friends and family. You can ask for a gift, and give others gifts. Gift exchange takes the guesswork out of giving, making sure that at the end of the day, everyone is happy.</p>
	<h3>How Does Gift Exchange work?</h3>
	<p>Gift Exchange is designed to be simple to use.</p>
	<ol>
	<li>Create an account by clicking 'Account' then 'Create Account'  in the navigation area and filling out the form.</li>
	<li>Once you are logged in, go to the 'Settings' page and add an interest, as well as any other information you would like to add.</li>
	<li>Go to the page labeled 'Your List' to manage your list. You can add, edit, and remove items from your list.</li>
	<li>Visit the page labeled 'Lists' to view other people's lists and interests.</li>
	<li>Visit the 'About' page for a few important notes, some random fun facts, and a link to my GitHub repo to see the source code.</li>
	<li>Contact me if you run into any bugs or have a question, comment or concern.</li>
	</ol>
	<h3>A Few Notes...</h3>
	<p>Please, please remeber to use the breadcrumbs! These will show your path throught the site, with links so that you can return to previous pages. <strong>Pressing your browsers back button can result in your entries being deleted!</strong> Use the navigation section present on every page to navigate!</p>
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
