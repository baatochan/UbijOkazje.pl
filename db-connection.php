<?php
/**
 * Created by PhpStorm.
 * User: barto
 * Date: 21.01.18
 * Time: 21:32
 */

const dbhost = 'localhost';
const dbname = 'auctionsite';
const dbusername = 'root';
const dbpass = 'toor';

$dbconnection = new mysqli(dbhost, dbusername, dbpass, dbname);

if (!$dbconnection->set_charset("utf8")) {
	echo '<p>'.$dbconnection->error.'</p>';
}
