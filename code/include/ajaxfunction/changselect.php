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
	if($_POST['cat']!=''){
		$loai01 = categories_by_cat_group(1,$_POST['cat']);
		//<select name="loaisanpham'.$_POST['ids'].'" id="loaisanpham'.$_POST['ids'].'" class="tcnselect">
		$str = '<option value="" label="-------">-------</option>';
		
		for($m=0;$m<count($loai01);$m++){
			$str .= ' <option value="'.$loai01[$m]['id'].'" label="'.$loai01[$m]['title'].'">'.$loai01[$m]['title'].'</option> ';
			//$str .= " <option value=\"".$loai01[$m]['id']."\">Menu 0011</option> ";
		}
		
		echo $str;
	}
	
	# Và xử lý menu
	@mysql_close($mysql);

?>
