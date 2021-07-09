<?php

require $_SERVER['DOCUMENT_ROOT'].'/include/sql.php';
//this page is used in conjuction with ajax to check that the item name is ok for item input
//sql
$user = 
$selectSQL = "SELECT name FROM items WHERE user = '".$_GET['user']."'";
$rawResult = $conn->query($selectSQL);
if ($rawResult->num_rows == 0) {
    echo 'Name OK';
} else {
    $result = $rawResult->fetch_assoc();
    if(in_array($_GET["name"], $result)){
        echo "Name taken. Please choose another.";
    }else{
        echo "Name OK";
    }

}//end of else
