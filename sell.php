<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 23.01.18
 * Time: 00:37
 */

session_start();

if (!isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] != 1) {
	echo '
		<script type="text/javascript">
		   window.location = "index.php"
		</script>
	';
	die();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<link href="imports/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/register.css" rel="stylesheet">
	<link href="css/sell.css" rel="stylesheet">
	<title>Wystaw nowy przedmiot - UbijOkazje.pl</title>
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
	<h1>Wystaw nowy produkt</h1>
	<?php
	$name = "";
	$description = "";
	$photo = "";
	$value = "";
	$rating = "";
	$username = $_SESSION['username'];

	if (isset($_POST['name']) && isset($_POST['description']) && isset($_POST['photo']) && isset($_POST['value']) && isset($_POST['rating'])) {
		include('db-connection.php');
		if (!$dbconnection->connect_errno) {
			$name = $dbconnection->real_escape_string($_POST['name']);
			$description = $dbconnection->real_escape_string($_POST['description']);
			$photo = $_POST['photo'];
			$value = $dbconnection->real_escape_string($_POST['value']);
			$rating = $dbconnection->real_escape_string($_POST['rating']);

			if ($name != "" && $value != "" && $rating != "") {
                $sql1 = "SELECT Id FROM `user` WHERE Username = '$username';";
                if ($result = $dbconnection->query($sql1)) {
                    $row = $result->fetch_assoc();
                    $sellerId = $row['Id'];
                    $date = date("Y-m-d");

                    $sql2 = "INSERT INTO `product` (`Name`, `Description`, `Photo`, `Value`, `Rating`, `SellerId`, `Date`) VALUES ('$name', '$description', '$photo', '$value', '$rating', '$sellerId', '$date');";
					//echo $sql2;

                    if($result = $dbconnection->query($sql2)) {
						echo '
                            <script type="text/javascript">
                               window.location = "user.php?listed"
                            </script>
                        ';
                        die();
                    } else {
						echo '<p id="error">Podano bledne dane. Sprawdz czy wypelniles wysztkie pola poprawnie.</p>';
                    }
                }
			} else {
				echo '<p id="error">Podano bledne dane. Sprawdz czy wypelniles wysztkie pola.</p>';
            }
		}
	}


	?>

	<form method="post">
		<p><label for="nameInput">Nazwa produktu: </label><input name="name" id="nameInput" type="text" value="<?php echo $name ?>"></p>
		<p><label for="descriptionInput">Opis: </label><textarea name="description" id="descriptionInput"><?php echo $description ?></textarea></p>
		<p><label for="photoInput">Link do zdjecia: </label><input name="photo" id="photoInput" type="text" value="<?php echo $photo ?>"></p>
		<p><label for="valueInput">Cena (PLN): </label><input name="value" id="valueInput" type="text" value="<?php echo $value ?>"></p>
		<p><label for="ratingInput">Stan produktu (1-5): </label><input name="rating" id="ratingInput" type="text" value="<?php echo $rating ?>"></p>
		<button id="registerButton">Wystaw produkt na sprzedaz</button>
		<div style="clear: both;"></div>
	</form>
</div>
</body>
</html>