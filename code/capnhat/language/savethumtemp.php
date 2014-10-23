<?php global $config, $id;
	
	require '../config.php';
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql);
	mysql_query('SET CHARACTER SET utf8');
	require '../mysql/global-mysql.php';
	require '../session.php'; 
	
	
	$typefile = explode(".",$_POST['namefile']);
	$_SESSION['auth']['temp'] = end($typefile);
	 
?>