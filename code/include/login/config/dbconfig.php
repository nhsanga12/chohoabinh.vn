<?php

require '../../capnhat/config.php';
$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
mysql_query('SET CHARACTER SET utf8');
require '../../capnhat/mysql/global-mysql.php';
require '../../capnhat/functions/global-functions.php';
require '../../capnhat/functions/member-functions.php';
?>
