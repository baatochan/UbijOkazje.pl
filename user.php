<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 22.01.18
 * Time: 19:59
 */

session_start();

if (!isset($_SESSION['username'])) {
	echo '
		<script type="text/javascript">
		   window.location = "login.php"
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
	<link href="css/user.css" rel="stylesheet">
	<title>Twoje konto - UbijOkazje.pl</title>
	<script src="imports/jquery-3.1.1.slim.min.js"></script>
	<script src="imports/tether.min.js"></script>
	<script src="imports/bootstrap.min.js"></script>
</head>
<body>
<div id="searchHeader">
	<div style="float: left"><a href="index.php"><img src="img/logo.png" alt="logo" id="logoHeader"></a></div>
	<div id="userLinks" style="float: right; margin-left: 20px; margin-top: 50px;">
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
<h1>Zalogowany uzytkownik: <?php echo $_SESSION['username']?></h1>
<?php
include('db-connection.php');
$username = $_SESSION['username'];
if (!$dbconnection->connect_errno) {
	$sql1 = "SELECT * FROM user JOIN address on user.addressId=address.Id WHERE Username = '$username';";
	if ($result = $dbconnection->query($sql1)) {
		$result_row = $result->fetch_object();
		$firstName = $result_row->FirstName;
		$lastName = $result_row->LastName;
		$street = $result_row->Street;
		$number = $result_row->Number;
		$code = $result_row->Code;
		$city = $result_row->City;
		$country = $result_row->Country;
	}
}
//TODO: dodac opcje zmiany hasla i danych uzytkownika
//TODO: po dodaniu maila i numeru dodac wywietlanie tutaj
?>
<table>
	<tr><th colspan="4">Dane uzytkownika</th></tr>
	<tr><td class="tdLeft">Imie:</td><td><?php echo $firstName ?></td><td class="tdLeft">Adres:</td><td><?php echo $street.$number ?></td></tr>
	<tr><td class="tdLeft">Nazwisko:</td><td><?php echo $lastName ?></td><td class="tdLeft">Kod i miasto:</td><td><?php echo $code." ".$city ?></td></tr>
	<tr><td class="tdLeft"></td><td></td><td class="tdLeft">Kraj:</td><td><?php echo $country ?></td></tr>
</table>


</body>
</html>
