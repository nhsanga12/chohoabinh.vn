<?php global $config, $id;
	
	require '../config.php';
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql);
	mysql_query('SET CHARACTER SET utf8');
	require '../mysql/global-mysql.php';
	require '../session.php'; 
	
	# Thư viện các Hàm
	require '../functions/global-functions.php';
	require '../functions/auto-load.php';
	require '../functions/categories-functions.php';
	
	$rsn[$_POST['cfield']]		=	$_POST['values'];
	$rsk['id']					=	$_POST['cid'];
	if($rsn['parentid']!=$rsk['id']){
		sql_update('news_categories',$rsn,$rsk);
	}
		
?>