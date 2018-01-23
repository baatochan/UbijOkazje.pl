<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 23.01.18
 * Time: 01:47
 */

session_start();

if (!isset($_SESSION['username']) || !isset($_GET['id']) || !isset($_GET['query'])) {
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
$sql1 = "SELECT Id FROM `desiredProduct` WHERE UserId = '$sellerId' AND ProductId = '$productId';";
if ($result = $dbconnection->query($sql1)) {
	if ($result->num_rows == 0) {
		$sql2 = "INSERT INTO `desiredproduct` (`ProductId`, `UserId`, `isHidden`) VALUES ('$productId', '$sellerId', '0');";
	} else {
		$row = $result->fetch_assoc();
		$dpId = $row['Id'];
		$sql2 = "UPDATE `desiredproduct` SET `isHidden` = '0' WHERE `desiredproduct`.`Id` = '$dpId';";
	}
	$result = $dbconnection->query($sql2);
}
echo '
	<script type="text/javascript">
	   window.location = "search.php?query='.$_GET['query'].'"
	</script>
';
die();
