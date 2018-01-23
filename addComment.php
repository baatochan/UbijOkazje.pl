<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 23.01.18
 * Time: 11:10
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
$userId = $_GET['id'];

include('db-connection.php');

$sql1 = "SELECT Id FROM `user` WHERE Username = '$username';";
if ($result = $dbconnection->query($sql1)) {
	$row = $result->fetch_assoc();
	$authorId = $row['Id'];
}

$sql1 = "SELECT Id FROM `comment` WHERE UserId = '$userId' AND AuthorId = '$authorId';";
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<link href="imports/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/register.css" rel="stylesheet">
	<link href="css/sell.css" rel="stylesheet">
	<title>Wystaw komentarz - UbijOkazje.pl</title>
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

<?php
if ($result = $dbconnection->query($sql1)) {
	if ($result->num_rows > 0) {
		echo "<p class='error'>Wystawiles juz komentarz temu uzytkownikowi. <a href='user.php'>Wroc do swojego konta.</a></p>";
	} elseif (isset($_POST['commentBody'])) {
		$commentBody = $_POST['commentBody'];
		$date = date("Y-m-d");
		$sql2 = "INSERT INTO `comment` (`UserId`, `Text`, `Date`, `authorId`) VALUES ('$userId', '$commentBody', '$date', '$authorId');";
		if ($result = $dbconnection->query($sql2)) {
			echo "<p>Komentarz dodano. <a href='user.php'>Wroc do swojego konta.</a></p>";
		}
	} else {
		echo '
			<form method="post">
				<p><label for="commentInput">Tresc: </label><textarea name="commentBody" id="commentInput" style="height: 100px;"></textarea></p>
				<button id="registerButton">Wystaw komentarz</button>
			</form>
		';
	}
}

?>

</div>
</body>
</html>
