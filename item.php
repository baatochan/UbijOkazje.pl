<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 23.01.18
 * Time: 03:03
 */

session_start();

if (!isset($_GET['id'])) {
	echo '
		<script type="text/javascript">
		   window.location = "index.php"
		</script>
	';
	die();
}

include('db-connection.php');
$productId = $_GET['id'];
if (!$dbconnection->connect_errno) {
	$sql1 = "SELECT p.Date as Date, p.Value as Value, p.Name as Name, p.Id AS ProductId, p.Rating as Rating, p.Description as Description, p.Photo AS Photo, op.Id as OrderId, u.Username AS Username FROM `product` p LEFT JOIN `orderedproduct` op on op.ProductId = p.Id JOIN `user` u on p.sellerId=u.Id  WHERE p.Id = '$productId';";
	if ($result = $dbconnection->query($sql1)) {
		$row = $result->fetch_assoc();
		if ($row['Photo'] != null) {
			$photo = $row['Photo'];
		} else {
			$photo = "img/defaultProductImg.png";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="UTF-8">
	<link href="imports/bootstrap.min.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/item.css" rel="stylesheet">
	<title><?php echo $row['Name'] ?> - UbijOkazje.pl</title>
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
			<input name="query" id="searchBarHeader" type="text">
			<button id="searchButtonHeader">Szukaj</button>
		</form>
	</div>
	<div style="clear: both;"></div>
</div>
<table>
	<tr><th colspan="3"><?php echo $row['Name'] ?></th></tr>
    <tr>
        <td id="productPhoto" rowspan="2"><img src="<?php echo $photo ?>"></td>
        <td id="productDescription" rowspan="2"><?php echo $row['Description'] ?></td>
        <td id="buyLink">
            <?php
            if ($row['OrderId'] == null) {
                echo '<p>Stan: '.$row['Rating'].'</p>';
                echo '<p>Cena: '.$row['Value'].'zl</p>';
                echo '<p><a href="buy.php?id='.$row['ProductId'].'">Kup teraz</a></p>';
                echo '<p><a href="addToDesired.php?id='.$row['ProductId'].'">Dodaj do obserwowanych</a></p>';
            } else {
				$sql2 = "SELECT  op.dateOfOrder as dateOfOrder, op.isPaid as isPaid, u.username as username from `orderedproduct` op JOIN `user` u on u.Id = op.userId where op.Id = '".$row['OrderId']."';";
				if ($result2 = $dbconnection->query($sql2)) {
					$row2 = $result2->fetch_assoc();
					echo "<p style='font-weight: bold'>Sprzedany: tak</p>";
					echo "<p>Kupujacy: ".$row2['username']."</p>";
					echo "<p>Sprzedany dnia: ".$row2['dateOfOrder']."</p>";
				}
            }
            ?>
        </td>
    </tr>
    <tr>
        <td id="sellerInfo">
            <p>Sprzedajacy: <?php echo $row['Username'] ?></p>
            <p>Data wystawienia: <?php echo $row['Date'] ?></p>
        </td>
    </tr>
</table>