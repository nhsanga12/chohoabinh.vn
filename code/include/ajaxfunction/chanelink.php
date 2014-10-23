<?php
	include('../../capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	require '../../capnhat/mysql/global-mysql.php';
	require '../../session.php'; 
	# Thư viện các Hàm
	# Thư viện các Hàm
	require '../../capnhat/functions/global-functions.php';
	require '../../capnhat/functions/auto-load.php';
	require '../../capnhat/functions/categories-functions.php';
	require '../../capnhat/functions/articles-functions.php';
	require '../../capnhat/functions/cal-functions.php';
	require '../../capnhat/functions/seo-functions.php';
	# Bộ đếm
	
	echo sys_link('com=home&target=main&category='.$_POST['cat']);
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
