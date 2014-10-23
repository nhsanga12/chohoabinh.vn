<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'xalomuaban_web');
define('DB_PASSWORD', 'web654321');
define('DB_DATABASE', 'xalomuaban_web');

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die('Oops connection error -> ' . mysql_error());
mysql_select_db(DB_DATABASE, $connection) or die('Database error -> ' . mysql_error());
?>