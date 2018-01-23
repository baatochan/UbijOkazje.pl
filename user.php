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
<h1>Zalogowany uzytkownik: <?php echo $_SESSION['username'] ?></h1>
<?php
include('db-connection.php');
$username = $_SESSION['username'];
if (!$dbconnection->connect_errno) {
	$sql1 = "SELECT * FROM user JOIN address on user.addressId=address.Id WHERE Username = '$username';";
	if ($result = $dbconnection->query($sql1)) {
		$result_row = $result->fetch_object();
		$firstName = $result_row->FirstName;
		$mail = $result_row->Email;
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
	<tr>
		<th colspan="4">Dane uzytkownika</th>
	</tr>
	<tr>
		<td class="tdLeft">Imie:</td>
		<td><?php echo $firstName ?></td>
		<td class="tdLeft">Adres:</td>
		<td><?php echo $street . $number ?></td>
	</tr>
	<tr>
		<td class="tdLeft">Nazwisko:</td>
		<td><?php echo $lastName ?></td>
		<td class="tdLeft">Kod i miasto:</td>
		<td><?php echo $code . " " . $city ?></td>
	</tr>
	<tr>
		<td class="tdLeft">Email:</td>
		<td><?php echo $mail ?></td>
		<td class="tdLeft">Kraj:</td>
		<td><?php echo $country ?></td>
	</tr>
</table>
<table>
	<tr>
		<th colspan="4">Kupione przedmioty</th>
	</tr>
<?php
if (!$dbconnection->connect_errno) {
	$sql1 = "SELECT op.Id AS OrderId, op.dateOfOrder AS dateOfOrder, op.isPaid AS isPaid, s.Id as SellerId, s.username AS sellerUsername, s.Email as Email, p.Value as Value, p.Name as Name, p.Id AS ProductId, p.Photo AS Photo FROM `orderedproduct` op JOIN `user` u on op.UserId=u.Id JOIN `product` p on p.Id=op.ProductId JOIN `user` s on p.SellerId=s.Id WHERE u.username = '$username';";
	if ($result = $dbconnection->query($sql1)) {
		if ($result->num_rows == 0) {
			echo "<tr><td colspan='4'>Nie kupies jeszcze zadnego produktu.</td></tr>";
		}
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			if ($row['Photo'] != null) {
				$photo = $row['Photo'];
			} else {
				$photo = "img/defaultProductImg.png";
			}
			echo "<td><a href='item.php?id=" . $row['ProductId'] . "'><img class='boughtProductPhoto' src='" . $photo . "'></a></td>";
			echo "<td class='boughtProductName'><a href='item.php?id=" . $row['ProductId'] . "'>" . $row['Name'] . "</a></td>";
			echo "<td class='boughtProductPrice'>" . $row['Value'] . "zl</td>";
			echo "<td class='boughtProductSellerDetails'>";// . $row['Value'] . "zl
				echo "<p>Sprzedawca: " . $row['sellerUsername'] . "</p>";
				echo "<p>Zakupiono dnia: " . $row['dateOfOrder'] . "</p>";
				echo "<p>Oplacono: ";
				if ($row['isPaid'] == true) {
					echo 'tak</p>';
				} else {
					echo 'nie</p>';
					echo "<p><a href='pay.php?id=".$row['OrderId']."'>Oplac teraz.</a></p>";
				}
			echo "<p>Mail sprzedajacego: <a href='mailto:" . $row['Email'] . "'>" . $row['Email'] . "</a></p>";
			echo "<p><a href='addComment.php?id=" . $row['SellerId'] . "'>Wystaw komentarz</a></p>";
			echo "</td>";
			echo "</tr>";
		}
	}
}
?>
</table>
<table>
	<tr>
		<th colspan="4">Obserwowane przedmioty</th>
	</tr>
<?php
if (!$dbconnection->connect_errno) {
    $sql1 = "SELECT Id FROM `user` WHERE Username = '$username';";
    if ($result = $dbconnection->query($sql1)) {
		$row = $result->fetch_assoc();
		$sellerId = $row['Id'];
	}
	$sql1 = "SELECT dp.Id AS DesiredId, p.Id AS Id, p.Name as Name, p.Photo as Photo, p.Value as Value, op.Id as OrderId FROM `desiredproduct` dp JOIN `product` p on dp.productId=p.Id LEFT JOIN `orderedproduct` op on op.productId=p.Id WHERE dp.UserId = '$sellerId' AND dp.isHidden = false;";
	if ($result = $dbconnection->query($sql1)) {
		if ($result->num_rows == 0) {
			echo "<tr><td colspan='4'>Nie obserwujesz zadnego przedmiotu.</td></tr>";
		}
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";

			if ($row['Photo'] != null) {
				$photo = $row['Photo'];
			} else {
				$photo = "img/defaultProductImg.png";
			}
			echo "<td><a href='item.php?id=" . $row['Id'] . "'><img class='boughtProductPhoto' src='" . $photo . "'></a></td>";
			echo "<td class='boughtProductName'><a href='item.php?id=" . $row['Id'] . "'>" . $row['Name'] . "</a></td>";
			echo "<td class='boughtProductPrice'>" . $row['Value'] . "zl</td>";
			echo "<td class='boughtProductSellerDetails'>";
			if ($row['OrderId'] == null) {
				echo "<p>Sprzedany: nie</p>";
			} else {
				echo "<p>Sprzedany: tak</p>";
			}
			echo "<p><a href='hideFromDesired.php?id=".$row['DesiredId']."'>Usun z obserwowanych</a></p>";
			echo "</td>";
			echo "</tr>";
		}
	}
}
?>
</table>
<table>
	<tr>
		<th colspan="5">Przedmioty wystawione na sprzedaz</th>
	</tr>
	<tr>
        <td colspan="5" style="text-align: center; padding: 10px;"><a href="sell.php">Wystaw nowy</a></td>
	</tr>
<?php
if (!$dbconnection->connect_errno) {
	$sql1 = "SELECT p.Date as Date, p.Value as Value, p.Name as Name, p.Id AS ProductId, p.Photo AS Photo, op.Id as OrderId FROM `product` p LEFT JOIN `orderedproduct` op on op.ProductId = p.Id JOIN `user` u on p.sellerId=u.Id where u.username='$username';";
	if ($result = $dbconnection->query($sql1)) {
		if ($result->num_rows == 0) {
			echo "<tr><td colspan='4'>Nie wystawiles jeszcze zadnego produktu.</td></tr>";
		}
		while ($row = $result->fetch_assoc()) {
			echo "<tr>";
			if ($row['Photo'] != null) {
				$photo = $row['Photo'];
			} else {
				$photo = "img/defaultProductImg.png";
			}
			echo "<td><a href='item.php?id=" . $row['ProductId'] . "'><img class='boughtProductPhoto' src='" . $photo . "'></a></td>";
			echo "<td class='boughtProductName'><a href='item.php?id=" . $row['ProductId'] . "'>" . $row['Name'] . "</a></td>";
			echo "<td class='boughtProductPrice'>" . $row['Value'] . "zl</td>";
			if ($row['OrderId'] == null) {
				echo "<td class='boughtProductSellerDetails' colspan='2'>";
			} else {
				echo "<td class='boughtProductSellerDetails'>";
            }
			    echo "<p>Wystawiono dnia: ".$row['Date']."</p>";
				if ($row['OrderId'] == null) {
					echo "<p>Sprzedany: nie</p>";
					echo "</td>";
				} else {
					$sql2 = "SELECT  op.dateOfOrder as dateOfOrder, op.isPaid as isPaid, u.username as username, u.FirstName as FirstName, u.Email as Email, u.LastName as LastName, u.AddressId as AddressId from `orderedproduct` op JOIN `user` u on u.Id = op.userId where op.Id = '".$row['OrderId']."';";
					if ($result2 = $dbconnection->query($sql2)) {
						$row2 = $result2->fetch_assoc();
						echo "<p>Sprzedany: tak</p>";
						echo "<p>Kupujacy: ".$row2['username']."</p>";
						echo "<p>Sprzedany dnia: ".$row2['dateOfOrder']."</p>";
						echo "<p>Oplacono: ";
						if ($row2['isPaid'] == true) {
							echo 'tak</p>';
						} else {
							echo 'nie</p>';
						}
						echo "</td><td class='buyerInfo'>";
						echo "<p style='font-weight: bold'>Dane kupujacego:</p>";
						echo "<p>Imie i nazwisko: ".$row2['FirstName']." ".$row2['LastName']."</p>";
						echo "<p>Mail: <a href='mailto:" . $row2['Email'] . "'>" . $row2['Email'] . "</a></p>";
						echo "<p style='font-weight: bold'>Adres: </p>";
						$sql3 = "SELECT * from `address` where Id = '".$row2['AddressId']."';";
						if ($result3 = $dbconnection->query($sql3)) {
							$row3 = $result3->fetch_assoc();
							echo "<p>".$row3['Street']." ".$row3['Number']."</p>";
							echo "<p>".$row3['Code']." ".$row3['City']."</p>";
							echo "<p>".$row3['Country']."</p>";
						}
						echo "</td>";
					}
				}
			echo "</tr>";
		}
	}
}
?>
</table>

<table>
    <tr><th>Otrzymane komentarze</th></tr>
	<?php
	if (!$dbconnection->connect_errno) {
		$sql4 = "SELECT * FROM `comment` c JOIN `user` u on u.Id=c.AuthorId WHERE c.UserId = '$sellerId';";
		if ($result = $dbconnection->query($sql4)) {
			if ($result->num_rows == 0) {
				echo "<tr><td class='comment'><p>Nie otrzymales jeszcze zadnych komentarzy.</p></td></tr>";
			}
			while($row = $result->fetch_assoc()) {
				echo "<tr><td class='comment'>";
				echo "<p>".$row['Text']."</p>";
				echo "<p style='font-size: 14px;'>Wystawiono przez ".$row['Username'].", dnia ".$row['Date']."</p>";
				echo "</td></tr>";
			}
		}
	}
	?>
</table>


</body>
</html>
