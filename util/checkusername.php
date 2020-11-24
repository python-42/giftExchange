<?php
require "include/sql.php";
//this page is used in conjuction with ajax to check that the username is ok for account creation
//sql
$selectSQL = "SELECT username FROM login";
$rawResult = $conn->query($selectSQL);
if ($rawResult->num_rows > 0){
	passBack(true);//true means that username is available. Username is obviously available becuase there are no usernames entered into db
	}else{
		$result = $rawResult->fetch_assoc();
		$input = $_GET["i"];
		if ($i !== ""){
			if (array_search($i,$result)){//all of this is still broken
				passBack(false);
				}else{
					passBack(true);//here the array search came back false, so there are no matching usernames
					}
			}
		}
	function passBack($cont){
		if ($cont){
			echo "Username Ok";
			}else{
				echo "This username is already taken. Please try another.";
				}
		}
?>
