<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 23.01.18
 * Time: 03:38
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

$username = $_SESSION['username'];
include('db-connection.php');

$sql1 = "SELECT Id FROM `user` WHERE Username = '$username';";
if ($result = $dbconnection->query($sql1)) {
	$row = $result->fetch_assoc();
	$userId = $row['Id'];
}

$date = date("Y-m-d");

$productId = $_GET['id'];
if (!$dbconnection->connect_errno) {
	$sql1 = "INSERT INTO `orderedproduct` (`ProductId`, `UserId`, `dateOfOrder`, `isPaid`) VALUES ('$productId', '$userId', '$date', '0');";
	$result = $dbconnection->query($sql1);
}

$sql = "SELECT Id FROM `orderedproduct` where ProductId = '$productId' AND UserId = '$userId'";
$result = $dbconnection->query($sql);
$row = $result->fetch_assoc();
$orderId = $row['Id'];
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<link href="imports/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/item.css" rel="stylesheet">
	<title>Kupiono produkt - UbijOkazje.pl</title>
	<script src="imports/jquery-3.1.1.slim.min.js"></script>
	<script src="imports/tether.min.js"></script>
	<script src="imports/bootstrap.min.js"></script>
</head>
<body>
<div id="searchHeader">
	<div style="float: left"><a href="index.php"><img src="img/logo.png" alt="logo" id="logoHeader"></a></div>
	<div id="userLinks" style="float: right; margin-left: 20px; margin-top: 35px;">
		<p><a href="user.php">Moje konto</a></p>
		<p><a href="logout.php">Wyloguj sie</a></p>
	</div>
	<div style="float: right; padding-top: 50px">
		<form method="get" action="search.php">
			<input name="query" id="searchBarHeader" type="text">
			<button id="searchButtonHeader">Szukaj</button>
		</form>
	</div>
	<div style="clear: both;"></div>
</div>
<div>
	<p style="text-align: center; margin-top: 50px;">Produkt kupiono. <a href="pay.php?id=<?php echo $orderId ?>">Zaplac za niego teraz</a>, badz przejdz do <a href="user.php">strony uzytkownika</a></p>
</div>
</body>
</html>