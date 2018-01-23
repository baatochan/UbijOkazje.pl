<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 23.01.18
 * Time: 02:03
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
$productId = $_GET['id'];

include('db-connection.php');

$sql1 = "SELECT Id FROM `user` WHERE Username = '$username';";
if ($result = $dbconnection->query($sql1)) {
	$row = $result->fetch_assoc();
	$sellerId = $row['Id'];
}

$sql2 = "UPDATE `desiredproduct` SET `isHidden` = '1' WHERE `desiredproduct`.`Id` = '$productId' AND `desiredProduct`.`UserId` = '$sellerId';";
if ($result = $dbconnection->query($sql2)) {
	echo '
			<script type="text/javascript">
			   location.href = "user.php"
			</script>
		';
	die();

}