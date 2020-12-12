<?php
require "/var/www/giftExchange/include/sql.php";

$item = $_REQUEST["item"];
$owner = $_REQUEST["owner"];
$user = $_REQUEST["user"];
//to be clear, 'owner' is the user who asked for the item, and user is the person who marked it as bought

$prep = $conn->prepare("UPDATE items SET bought = 1, boughtBy = ? WHERE user = ? AND name = ?");
$prep -> bind_param("sss", $user, $owner, $item);
$prep->execute();
$prep->close();
$conn->close();
?>
