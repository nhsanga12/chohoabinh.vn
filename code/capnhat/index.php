<?php 
	// Ben CMS v11.0 update Oct 9th 2012
	require 'config.php';
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql);
	mysql_query('SET CHARACTER SET utf8');
	require 'mysql/global-mysql.php';
	require 'session.php'; 
	
	# Thư viện các Hàm
	require 'functions/global-functions.php';
	require 'functions/auto-load.php';
	require 'functions/categories-functions.php';
	require 'functions/articles-functions.php';
	require 'functions/cal-functions.php';
	require 'functions/xml-functions.php';
	require 'functions/html-functions.php';
	require 'functions/image-functions.php';
	require 'functions/seo-functions.php';
	
	require 'functions/group-functions.php';
	
	//require 'functions/excel-functions.php';
	//require 'functions/security.php';
	
	# Hết thư viện hàm
	require 'language/menu_'.$config['default_language'].'.php';
	
	# Lấy ID;
	$gnc	= $_GET['gnc'];	
	$gnc 	= explode(';',$gnc);
	while (list($key,$value)=each($gnc)) {
		$value = explode(':',$value);
		$id[$value[0]]	= $value[1];
	}
	if (count($id) > 1) {
		if ($menu[$id['com']] == '') $id['com']	= 'system';
		if ($menu[$id['com']][$id['target']] == '') $id['target'] = 'error';
	}
	else {
		$id['com']	= 'system';
		$id['target'] = 'home';
	}
	if ($id['option'] == "") $id['option'] = 'main';
	if ($id['limit_on_page'] > 1) $config['limit_on_page'] = $id['limit_on_page'];
	
	# Gọi ngôn ngữ khi có sự yêu cầu
	if ($id['lang'] != '' && ($id['lang'] == 'vn' || $id['lang'] == 'en')) $_SESSION['lang'] = $id['lang'];
	if ($_SESSION['lang'] != '') $config['default_language'] = $_SESSION['lang'];
	
	
	require 'language/themes_'.$config['default_language'].'.php';
	
	require 'templates/header.html.php';
	
		# Kiểm tra quyền
		if ($_SESSION['auth']['login']	== false){
			require 'sources/system/signin.php';
			require 'templates/system/signin.html.php';
				
		} else {
			if (is_file('sources/system/main.php'))
				require 'sources/system/main.php';
			if (is_file('templates/system/main.html.php'))
				require 'templates/system/main.html.php';
		}
	
	require 'templates/footer.html.php';
	
	@mysql_close($mysql);
?>