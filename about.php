<!DOCTYPE=html>
<html lang="en">
<head>
<?php
//error handling
//$root = $_SERVER["DOCUMENT_ROOT"];
if (file_exists("include/head-data.html")){
require "include/head-data.html";
}else{
	error_log("Eror Code 101: include/head_data.html is missing![create_account.php]");
	die ("<div style='text-align:center;' class='alert alert-danger'><b>Error:</b>File is missing. Error has been logged. Please <a target='_blank' href='https://forms.gle/A3aaKieUBzj4mG1C9' class='alert-link'>notify developer</a> if error persists.  [Error Code: 101]</div>");
	}
?>
<title>About Gift Exchange</title>
</head>
<body>
<div class="container-fluid bg-dark pt-2">
	<div class="jumbotron border border-primary" style="text-align:center;">
		<h1 class="jumbotron-heading text-danger">ABOUT</h1>
		</div>
	<div class="row">
	<div class="col-sm-2 bg-secondary">
	<h2 style="text-align:center;text-decoration:underline;">Navigation</h2>
		<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href=<?php if(isset($_REQUEST["ref"]) && isset($_REQUEST["ref-title"]) ){
			echo $_REQUEST["ref"];
			}else{
				echo "index.php";
				}?>
				>
				<?php
				if(isset($_REQUEST["ref"]) && isset($_REQUEST["ref-title"])){
					echo $_REQUEST["ref-title"];
					}else{
						echo "Home";
						}?>
						</a></li>
		<li class="breadcrumb-item active">About</li>
		</ul>
	</div>
	<div class="col-sm-10 bg-primary">
	<h1 style="text-align:center;text-decoration:underline;">About Gift Exchange</h1>
	<p>The following is a brief description of Gift Exchange. <br>Gift Exchange allows you to connect with friends and family in order to ask for a gift. This way everyone ends up with something that they actually want, and everyone is happy. You can also use Gift Exchange to define more general interests if you want to be surprised by what you recieve.</p>
	<p>I used <a target="_blank" class="text-dark" href="https://www.php.net">PHP</a> for server side scripting. I used the <a target="_blank" class="text-dark" href="https://getbootstrap.com/">Bootstrap 4</a> web library for a responsive website.</p>
	</div>
	</div>
<style>
@media (min-width: 576px){
.jumbotron-heading{font-size:9rem; text-align:center;}
}
	body{
		background: linear-gradient(to left,#007bff,#6c757d );
		}
</style>
</body>
</html>
