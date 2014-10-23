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
	if($_POST['func']=='xoa'){
		$sql = " UPDATE  ".$config['db_prefix']."_banner SET lastdate = '".time()."', status =  '0', deleted =  '1' 
				 WHERE  bannerid = '".$_POST['ids']."' ";
		@mysql_query($sql);
	}else if($_POST['func']=='ngung'){
		$sql = " UPDATE  ".$config['db_prefix']."_banner SET  lastdate = '".time()."', status =  '0' 
				 WHERE  bannerid = '".$_POST['ids']."' ";
		@mysql_query($sql);
	
	}else if($_POST['func']=='bat'){ 
		// kiem tra xem co ai da dang ky chua
		if(check_banner_local($_POST['ids'])){
			$sql = " UPDATE  ".$config['db_prefix']."_banner SET  lastdate = '".time()."', status =  '1' 
					 WHERE  bannerid = '".$_POST['ids']."' ";
			@mysql_query($sql);
		}else
			echo 'khongthebat';
	}
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
