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
	$term = trim(strip_tags($_GET['term']));//retrieve the search term that autocomplete sends

	$qstring = " SELECT u.usersname,u.oauth_provider,u.usersid, dt.tengianhang
				 FROM gnc_users u
				 LEFT JOIN gnc_users_detail dt ON dt.usersid = u.usersid
				 WHERE u.usersname LIKE '".$term."%' ";
	$result = @mysql_query($qstring);//query the database for entries containing the term

	while ($row = @mysql_fetch_array($result,MYSQL_ASSOC))//loop through the retrieved values
	{
			$row2['value']=htmlentities(stripslashes($row['usersname']));
			
			if($row['tengianhang']!='')
			$row2['value'] .= " (".$row['tengianhang'].") ";
			
			if($row['oauth_provider']!='')
			$row2['value'] .= " (".$row['oauth_provider'].")";
			
			$row2['id']=(int)$row['usersid'];
			$row_set[] = $row2;//build an array
	}
	echo json_encode($row_set);//format the array into json data
	
		
	# Và xử lý menu
	@mysql_close($mysql);

?>
