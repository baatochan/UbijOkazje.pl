<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 23.01.18
 * Time: 02:39
 */

session_start();

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
	echo '
		<script type="text/javascript">
		   window.location = "index.php"
		</script>
	';
	die();
}


if (isset($_POST['payed'])) {
	$username = $_SESSION['username'];
	$orderId = $_GET['id'];
	include('db-connection.php');

	$sql1 = "SELECT Id FROM `user` WHERE Username = '$username';";
	if ($result = $dbconnection->query($sql1)) {
		$row = $result->fetch_assoc();
		$sellerId = $row['Id'];
	}

	$sql2 = "UPDATE `orderedProduct` SET `isPaid` = '1' WHERE `orderedProduct`.`Id` = '$orderId' AND `orderedProduct`.`UserId` = '$sellerId';";
	if ($result = $dbconnection->query($sql2)) {
		echo '
			<script type="text/javascript">
			   location.href = "user.php"
			</script>
		';
		die();
	}
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<link href="imports/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/register.css" rel="stylesheet">
	<title>Oplac zamowienie <?php echo $_GET['id'] ?> - UbijOkazje.pl</title>
	<script src="imports/jquery-3.1.1.slim.min.js"></script>
	<script src="imports/tether.min.js"></script>
	<script src="imports/bootstrap.min.js"></script>
</head>
<body>
<div id="searchHeader">
	<div style="float: left"><a href="index.php"><img src="img/logo.png" alt="logo" id="logoHeader"></a></div>
	<div style="float: right; padding-top: 50px">
		<form method="get" action="search.php">
			<input name="query" id="searchBarHeader" type="text" style="width: 500px;">
			<button id="searchButtonHeader">Szukaj</button>
		</form>
	</div>
	<div style="clear: both;"></div>
</div>
<div id="registerDiv">
	<form method="post" style="text-align: center; margin-top: 200px">
		<p><input name="payed" type="hidden" value="y"></p>
		<button id="registerButton" style="float: none;">Oplac zamowienie</button>
	</form>