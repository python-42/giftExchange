<?php session_start(); ?>
<!DOCTYPE=html>
<html lang="en">
<head></head>
<body>
<p>Welcome to shortstop. Please enjoy your brief stay. If you have seen this page longer than 10 seconds, please close this tab and try again.</p>
<?php
echo "<script>location.replace('/".$_SESSION['direct']."')</script>";
echo $_SESSION['direct'];
?>
</body>
</html>
