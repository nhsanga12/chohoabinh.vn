<?php
	global $config;
	include('../../capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	
	# Thư viện các Hàm
	require '../../capnhat/mysql/global-mysql.php';
	require '../../capnhat/functions/global-functions.php';
	require '../../capnhat/functions/auto-load.php';
	require '../../capnhat/functions/categories-functions.php';
	require '../../capnhat/functions/articles-functions.php';
	require '../../capnhat/functions/cal-functions.php';
	require '../../capnhat/functions/group-functions.php';
	
	# Nội dung chính
	$thuhientai = 1 + (int)date('N');
	$giohientai = getdateval(date("H:i"),"H:i");
	$chuoingay = strtotime(date("d-m-Y")." 00:00:00");
	
	$sql = " SELECT ati.bydatestore,au.article
			 FROM ".$config['db_prefix']."_news_articles_autotime ati
			 LEFT JOIN ".$config['db_prefix']."_news_articles_auto au ON au.autoid = ati.autoid
			 LEFT JOIN ".$config['db_prefix']."_news_articles art ON  art.id = au.article
			 WHERE au.deleted = '0' AND au.actidate LIKE '%".$thuhientai."%'
			 	AND ati.fromtime <= ".$giohientai." AND ati.totime >= ".$giohientai."
			
			ORDER BY ati.lastdate LIMIT 0,300
			";
	echo 'Begin: '.date("H:i:s d-m-Y")."<br />";		
	$artlist = sql_list($sql);
	for($m=0;$m<count($artlist);$m++){
		$now = timhaisoganbang($artlist[$m]['bydatestore'],$giohientai);
		$next = $chuoingay + $now[1]; // thoi gian se up tu dong ke tiep
		$now = $chuoingay + $now[0]; // thoi gian up tu dong hien tai
		
		$sqlup = " UPDATE ".$config['db_prefix']."_news_articles 
				 SET bydate = '".$now."',
				 	 bydatenext = '".$next."',
					 lastdate = '".time()."',
					 amountap = amountap+1,
					 listpost = CONCAT( listpost,',".$now."')
				 WHERE id = '".$artlist[$m]['article']."' ";
		
		if($artlist[$m]['bydate']!=$now)
			@mysql_query($sqlup);
	}
	
	
	echo 'End: '.date("H:i:s d-m-Y");
	
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
