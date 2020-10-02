<!DOCTYPE=html>
<html lang="en">
<head>
<?php
require "include/head-data.html"
?>
<title>About Gift Exchange</title>
</head>
<body>
<div class="container-fluid bg-dark pt-2">
	<nav class="navbar navbar-expand-sm bg-secondary border border-primary rounded-lg justify-content-center">
		<!--breadcrumbs-->
		<ul class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item active">About</li>
		</ul>
		<a class="navbar-brand" href="#">
		<img src="img/icon.png" alt="logo">
		</a>
		<!--quick links -->
		<ul class="navbar-nav">
		<li class="nav-link rounded-lg"><a href="index.php">Home</a></li>
		<li class="nav-link rounded-lg"><a href="login.php">Login</a></li>
		<li class="nav-link rounded-lg"><a href="account_create.php">Create Account</a></li>
		<li class="nav-link rounded-lg"><a href="help.php">Help</a></li>
	</ul>
	</nav>
	<div class="jumbotron border border-primary">
		<h1 class="jumbotron-heading text-danger">ABOUT</h1>
		</div>
	<div class="row">
	<div class="col-sm-2 bg-secondary"></div>
	<div class="col-sm-10 bg-info"></div>
	</div>
</div>
<style>
@media (min-width: 576px){
.jumbotron-heading{font-size:9rem; text-align:center;}
}
.nav-link{
	background-color:#e9ecef;
	padding-top: 0.75rem;
    padding-right: 1rem;
    padding-bottom: 0.75rem;
    padding-left: 1rem;
	}
.breadcrumb{
	margin-bottom:0;
	}
</style>
</body>
</html>
