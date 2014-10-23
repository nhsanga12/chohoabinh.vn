<?php
$mysql_hostname = "localhost";
$mysql_user = "xalomuaban_web";
$mysql_password = "web654321";
$mysql_database = "xalomuaban_web";
$prefix = "gnc";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Could not connect database");
mysql_select_db($mysql_database, $bd) or die("Could not select database");

?>