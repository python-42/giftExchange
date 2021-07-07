<?php

//this script will be run by a cron daily cron job. It will remove any items that have meet or passed their expiration date, and that are marked as bought
require $_SERVER['DOCUMENT_ROOT'].'/include/sql.php';
$date = date('Y-d-m');
$select = "SELECT user, name FROM items WHERE date = '".$date."' AND bought = '1'";
$raw = $conn->query($select);
if ($raw->num_rows != 0) {

    while($result = $raw->fetch_assoc()){
        $deletePrep = $conn->prepare('DELETE FROM items WHERE user = ? AND name = ?');
        $deletePrep -> bind_param("ss", $result["user"], $result["name"]);
        $deletePrep -> execute();
        $deletePrep -> close();
    }
}
?>