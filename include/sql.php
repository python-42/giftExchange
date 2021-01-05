<?php
$SQLservername = "localhost";
$SQLusername = "php";
$SQLpasswd = "ayXz9cP1*4cp";
$SQLdb = "giftdb";
$conn = new mysqli($SQLservername, $SQLusername, $SQLpasswd, $SQLdb);
if ($conn->connect_error){
	die("Database connection failed: ".$conn->connect_error.". If error persists please report it to the developers");
	}
?>
