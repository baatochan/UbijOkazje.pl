<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 22.01.18
 * Time: 21:29
 */

session_start();

if (!isset($_GET['query'])) {
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
	<link href="css/search.css" rel="stylesheet">
	<title>Wyniki wyszukiwania dla <?php echo $_GET['query'] ?> - UbijOkazje.pl</title>
	<script src="imports/jquery-3.1.1.slim.min.js"></script>
	<script src="imports/tether.min.js"></script>
	<script src="imports/bootstrap.min.js"></script>
</head>
<body>
<div id="searchHeader">
	<div style="float: left"><a href="index.php"><img src="img/logo.png" alt="logo" id="logoHeader"></a></div>
    <?php
        if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
        echo '
        <div id="userLinks" style="float: right; margin-left: 20px; margin-top: 35px;">
            <p><a href="user.php">Moje konto</a></p>
            <p><a href="logout.php">Wyloguj sie</a></p>
        </div>
        ';
        } else {
        echo '
        <div id="logLink" style="float: right; margin-left: 20px; margin-top: 35px;">
            <p><a href="login.php">Zaloguj sie</a></p>
            <p><a href="register.php">Zarejestruj sie</a></p>
        </div>
        ';
        }
    ?>
	<div style="float: right; padding-top: 50px">
		<form method="get" action="search.php">
			<input name="query" id="searchBarHeader" type="text" value="<?php echo $_GET['query'] ?>">
			<button id="searchButtonHeader">Szukaj</button>
		</form>
	</div>
	<div style="clear: both;"></div>
</div>
<table>
<?php
include('db-connection.php');
if (!$dbconnection->connect_errno) {
	$sql1 = "SELECT * FROM `product` WHERE Id not in (SELECT ProductId from orderedproduct) AND Name Like '%".$_GET['query']."%';";
	if ($result = $dbconnection->query($sql1)) {
	    if ($result->num_rows == 0) {
	        echo "<p class='error'>Brak wynikow dla podanych kryteriow.</p>";
        }
		while($row = $result->fetch_assoc()) {
			echo "<tr>";
			if ($row['Photo'] != null) {
				$photo = $row['Photo'];
			} else {
				$photo = "img/defaultProductImg.png";
			}
			echo "<td><a href='item.php?id=".$row['Id']."'><img class='productPhoto' src='".$photo."'></a></td>";
			echo "<td class='productName'><p><a href='item.php?id=".$row['Id']."'>".$row['Name']."</a></p><p style='font-size: 10px'><a href='addToDesired.php?id=".$row['Id']."&query=".$_GET['query']."'>Dodaj do obserowanych</a></p></td>";
			echo "<td class='productPrice'>".$row['Value']."zl</td>";
			echo "</tr>";
		}
	}
}
?>
</table>
</body>
</html>
