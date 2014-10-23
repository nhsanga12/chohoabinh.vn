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
		$sql = " UPDATE  ".$config['db_prefix']."_news_articles SET lastdate = '".time()."', status =  '1', deleted =  '1' 
				 WHERE  id = '".$_POST['ids']."' ";
		@mysql_query($sql);
		
		// xóa tin nhắn của bài này
		$sql = " UPDATE  ".$config['db_prefix']."_users_sms SET lastdate = '".time()."', deleted =  '1' 
				 WHERE  article = '".$_POST['ids']."' ";
		@mysql_query($sql);
		// xóa banner của bài này
		$sql = " UPDATE  ".$config['db_prefix']."_banner SET lastdate = '".time()."', deleted =  '1' 
				 WHERE  articles = '".$_POST['ids']."' ";
		@mysql_query($sql);
		
		
	}else if($_POST['func']=='xoasmg'){
		$sql = " UPDATE  ".$config['db_prefix']."_users_sms SET  lastdate = '".time()."', deleted =  '1' 
				 WHERE  id = '".$_POST['ids']."' ";
		@mysql_query($sql);
	}
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
