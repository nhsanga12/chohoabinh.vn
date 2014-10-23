<?php
	include('../../capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	require '../../capnhat/mysql/global-mysql.php';
	require '../../session.php'; 
	
	# Thư viện các Hàm
	require '../../capnhat/functions/global-functions.php';
	require '../../capnhat/functions/auto-load.php';
	require '../../capnhat/functions/categories-functions.php';
	require '../../capnhat/functions/articles-functions.php';
	require '../../capnhat/functions/cal-functions.php';
	require '../../capnhat/functions/seo-functions.php';
	
	# Nội dung chính
	$_SESSION['user']['themes'] = false;
	global $config;
	if($_POST['username']=='')
		echo 'Tên truy cập không được để trống. ';
		
	else if(strlen($_POST['username'])<6)
		echo 'Tên truy cập phải lớn hơn 6 ký tự.';
		
	else if(preg_match('/[^a-zA-Z0-9_]/',$_POST['username']) == 0){
		$sql = " SELECT usersid FROM ".$config['db_prefix']."_users WHERE usersname = '".$_POST['username']."' ";
		//echo $sql;
		$counts = sql_exit($sql);
		if($counts>0)
			echo 'Đã tồn tại user này.';
		else{
			$_SESSION['user']['themes'] = 1;
			echo 'Tên truy cập hợp lệ.';
		}
	
	}else
		echo 'Tên truy cập không ghi kí tự đặc biệt.';
	
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
