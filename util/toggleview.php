<?php
if (file_exists($_SERVER['DOCUMENT_ROOT']."/include/sql.php")){
			require $_SERVER['DOCUMENT_ROOT']."/include/sql.php";
			
			}else{
				error_log("Eror Code 101: include/sql.php is missing!");
			}

$item = $_REQUEST['item'];
$user = $_REQUEST['user'];

$selectSQL = "SELECT private FROM items WHERE name = '".$item."' AND user = '".$user."'";
$rawResult = $conn->query($selectSQL);
$result = $rawResult->fetch_assoc();

if($result['private'] == 0){
	$updateSQL = "UPDATE items SET private = '1' WHERE name = '".$item."' AND user = '".$user."'";
	$conn->query($updateSQL);
	$conn->close();
	}else{
		$updateSQL2 = "UPDATE items SET private = '0' WHERE name = '".$item."' AND user = '".$user."'";
		$conn->query($updateSQL2);
		$conn->close();
		}

?>
