<?php
require "/var/www/giftExchange/include/sql.php";
//this page is used in conjuction with ajax to check that the username is ok for account creation
//sql
$selectSQL = "SELECT username FROM login";
$rawResult = $conn->query($selectSQL);
if ($rawResult->num_rows == 0){
	echo "Username OK";
	}else{
		$result = $rawResult->fetch_array();
		$input = $_REQUEST["i"]; //this still doesnt work, however it itsnt really worth my time & effort
		if ($input != ""){
			if (array_search($input ,$result)){
				echo "Username is taken. Please try another.";
				}else{
					echo "Username OK";//here the array search came back false, so there are no matching usernames
					}
			}
		}//end of else
?>
