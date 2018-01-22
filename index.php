<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <link href="imports/bootstrap.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/index.css" rel="stylesheet">
    <title>UbijOkazje.pl - najlepsze okazje w sieci!</title>
    <script src="imports/jquery-3.1.1.slim.min.js"></script>
    <script src="imports/tether.min.js"></script>
    <script src="imports/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
</head>
<body>


<?php

if (isset($_GET['login'])) {
    echo '<p id="infoP">Zalogowano.</p>';
} elseif (isset($_GET['logout'])) {
    echo '<p id="infoP">Wylogowano.</p>';
} elseif (isset($_GET['registered'])) {
    echo '<p id="infoP">Zarejestrowano. Mozesz sie juz zalogowac.</p>';
}

if (isset($_SESSION['user_login_status']) && $_SESSION['user_login_status'] == 1) {
    echo '
        <div id="userLinks">
            <p><a href="user.php">Moje konto</a></p>
            <p><a href="logout.php">Wyloguj sie</a></p>
        </div>
    ';
} else {
    echo '
        <div id="logLink">
            <p><a href="login.php">Zaloguj sie</a></p>
            <p><a href="register.php">Zarejestruj sie</a></p>
        </div>
    ';
}

?>
<div id="searchDiv">
    <a href="index.php"><img src="img/logo.png" alt="logo" id="logoBig"></a>
    <form method="get" action="search.php">
        <input name="query" id="searchBar" type="text">
        <button id="searchButton">Szukaj</button>
    </form>
</div>
</body>
</html>
