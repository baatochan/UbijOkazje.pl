<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 21.01.18
 * Time: 23:57
 */


session_start();

if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
	echo '
		<script type="text/javascript">
		   window.location = "user.php"
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
	<title>Zarejestruj sie - UbijOkazje.pl</title>
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
	<h1>Rejestracja</h1>
	<?php
	$username = "";
	$password = "";
	$password2 = "";
	$mail = "";
	$firstName = "";
	$lastName = "";
	$street = "";
	$number = "";
	$code = "";
	$city = "";
	$country = "";

	if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['firstName']) && isset($_POST['lastName']) &&
		isset($_POST['street']) && isset($_POST['number']) && isset($_POST['code']) && isset($_POST['city']) && isset($_POST['country'])) {
		include('db-connection.php');
		if (!$dbconnection->connect_errno) {
			// TODO: Dodac zbieranie maila i numeru
			// TODO: dodac potwierdzenie rejestracji mailem
			$username = $dbconnection->real_escape_string($_POST['username']);
			$password = $dbconnection->real_escape_string($_POST['password']);
			$password2 = $dbconnection->real_escape_string($_POST['password2']);
			$mail = $dbconnection->real_escape_string($_POST['email']);
			$firstName = $dbconnection->real_escape_string($_POST['firstName']);
			$lastName = $dbconnection->real_escape_string($_POST['lastName']);
			$street = $dbconnection->real_escape_string($_POST['street']);
			$number = $dbconnection->real_escape_string($_POST['number']);
			$code = $dbconnection->real_escape_string($_POST['code']);
			$city = $dbconnection->real_escape_string($_POST['city']);
			$country = $dbconnection->real_escape_string($_POST['country']);

			$sql1 = "SELECT Id FROM user WHERE Username = '$username';";
			if ($result_of_user_check = $dbconnection->query($sql1)) {
				if ($result_of_user_check->num_rows == 0) {
					if ($password == $password2) {
						$sql2 = "SELECT Id FROM address WHERE Street = '$street' AND Number = '$number' AND Code = '$code' AND City = '$city' AND Country = '$country';";
						if ($result_of_address_check = $dbconnection->query($sql2)) {
							if ($result_of_address_check->num_rows == 0) {
								$sql3 = "INSERT INTO `address` (`Street`, `Number`, `Code`, `City`, `Country`) VALUES ('$street', '$number', '$code', '$city', '$country');";
								$result_of_address_check = $dbconnection->query($sql3);
								$result_of_address_check = $dbconnection->query($sql2);
							}
							if ($result_of_address_check->num_rows == 0) {
								echo '
								<p id="error">Blad polaczenia z baza!</p>
							';
								die();
							}
							$result_row = $result_of_address_check->fetch_object();
							$addressID = $result_row->Id;
							$salt = substr(md5(microtime()),rand(0,26),6);

							$passWithSalt = $password . $salt;

							$hashedPass = md5($passWithSalt);

							$sql4 = "INSERT INTO `user` (`AddressId`, `FirstName`, `LastName`, `Username`, `Email`, `SaltyPassword`, `Salt`) VALUES ('$addressID', '$firstName', '$lastName', '$username', '$mail', '$hashedPass', '$salt');";

							$result = $dbconnection->query($sql4);

							echo '
								<script type="text/javascript">
								   window.location = "index.php?registered"
								</script>
							';
						} else {
							echo '<p class="error">Blad polaczenia z baza!</p>';
							/*echo "Query: " . $sql . "\n";
							echo "Errno: " . $dbconnection->errno . "\n";
							echo "Error: " . $dbconnection->error . "\n";*/
						}
					} else {
						echo '<p id="error">Podano rozne hasla!</p>';
					}
				} else {
					echo '<p id="error">Uzytkownik o takiej nazwie juz istnieje!</p>';
				}
			} else {
				echo '<p id="error">Blad polaczenia z baza!</p>';
				/*echo "Query: " . $sql . "\n";
				echo "Errno: " . $dbconnection->errno . "\n";
				echo "Error: " . $dbconnection->error . "\n";*/
			}
		} else {
			echo '<p id="error">Blad polaczenia z baza!</p>';
			/*echo "Query: " . $sql . "\n";
			echo "Errno: " . $dbconnection->errno . "\n";
			echo "Error: " . $dbconnection->error . "\n";*/
		}
	}
	?>
	<form method="post">
		<p><label for="loginInput">Login: </label><input name="username" id="loginInput" type="text" value="<?php echo $username ?>"></p>
		<p><label for="passwordInput">Haslo: </label><input name="password" id="passwordInput" type="password"></p>
		<p><label for="password2Input">Powtorz haslo: </label><input name="password2" id="password2Input" type="password"></p>
        <p><label for="emailInput">Email: </label><input name="email" id="emailInput" type="text" value="<?php echo $mail ?>"></p>
        <p><label for="firstNameInput">Imie: </label><input name="firstName" id="firstNameInput" type="text" value="<?php echo $firstName ?>"></p>
		<p><label for="lastNameInput">Nazwisko: </label><input name="lastName" id="lastNameInput" type="text" value="<?php echo $lastName ?>"></p>
		<p><label for="streetInput">Ulica: </label><input name="street" id="streetInput" type="text" value="<?php echo $street ?>"></p>
		<p><label for="numberInput">Numer: </label><input name="number" id="numberInput" type="text" value="<?php echo $number ?>"></p>
		<p><label for="codeInput">Kod pocztowy: </label><input name="code" id="codeInput" type="text" value="<?php echo $code ?>"></p>
		<p><label for="cityInput">Miejscowosc: </label><input name="city" id="cityInput" type="text" value="<?php echo $city ?>"></p>
		<p><label for="countryInput">Panstwo: </label><input name="country" id="countryInput" type="text" value="<?php echo $country ?>"></p>
		<button id="registerButton">Zaloz konto</button>
		<div style="clear: both;"></div>
	</form>
	<p style="text-align: center; margin-top: 15px">Masz juz konto? <a href="login.php">Zaloguj sie.</a></p>
</div>
</body>
</html>
