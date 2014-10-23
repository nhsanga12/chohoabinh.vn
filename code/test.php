<?php
	include('capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	require 'capnhat/mysql/global-mysql.php';
	require 'session.php'; 
	# Thư viện các Hàm
	require 'capnhat/functions/global-functions.php';
	require 'capnhat/functions/auto-load.php';
	require 'capnhat/functions/categories-functions.php';
	require 'capnhat/functions/articles-functions.php';
	require 'capnhat/functions/cal-functions.php';
	require 'capnhat/functions/xml-functions.php';
	require 'capnhat/functions/html-functions.php';
	require 'capnhat/functions/image-functions.php';
	require 'capnhat/functions/seo-functions.php';
	
	require 'capnhat/functions/group-functions.php';
	require 'capnhat/functions/member-functions.php';
	require 'templates/header.html.php';
	
	//$newscat = 464;
//	$linknews = "http://xalo.vn/news/tl/news.mobi?c=1003&cn=R2nDoW8gZOG7pWM.&tab=new";
//	
//	$setting = array(
//		"data" => array(	
//					"begin" 	=> " START:Tab Content ",
//					"end" 		=> " END:Tab Content ",
//					"begin2" 	=> "<ul>",
//					"end2" 		=> "</ul>",
//				),
//		"block" => array(	
//					"begin" 	=> "class=\"clearfix\">",
//					"end" 		=> "<p",
//				),
//		"link" => array(	
//					"begin" 	=> 'href="',
//					"end" 		=> '"',
//				),
//		"pic" => array(	
//					"begin" 	=> 'src="',
//					"end" 		=> '"',
//				),
//		"ma" => array(	
//					"begin" 	=> 'alt="',
//					"end" 		=> '"',
//				),
//		"local" => array(	
//					"begin" 	=> 'class="src_list-news">',
//					"end" 		=> '</span>',
//				),
//	);
//	
//	$setting_dt = array(
//		"data" => array(	
//					"begin" 	=> '<div class="top-news">',
//					"end" 		=> '<div class="link-bot">',
//				),
//		"title" => array(	
//					"begin" 	=> "<h1>",
//					"end" 		=> "</h1>",
//				),
//		"quick" => array(	
//					"begin" 	=> '<h2 class="bd" style="margin-top:5px;">',
//					"end" 		=> '</h2>',
//				),
//		"contents" => array(	
//					"begin" 	=> '</h2>',
//					"end" 		=> '<ends>',
//				),
//		"img" => array(	
//					"begin" 	=> "?url=",
//					"end" 		=> "&type=",
//				),
//		"savepic" => array(	
//					"host" 		=> "lib/articles/",
//					"domain" 	=> "",
//				),
//	);
//	$url = "xalo.vn";
//	
//	
//	
//	$links = html_datalist($linknews,$setting);
//	echo "<pre>";
//	print_r($links);
//	echo "</pre>";
//	
//	foreach($links as $key => $value){
//		check_in_news($value['ma']);
//		
//		$n++; if($n==7) break;
//	}
//		
//	if (is_array($links)){
//		$n = 0;
//		foreach($links as $key => $value){
//			if(check_in_news($value['ma'])){
//				$datas[$n] = html_detail_by_link($url,$key,$value,$setting_dt);
//				echo $n."=0k<br />";
//				usleep(5000000);
//			}else
//				echo $n.".........................<br />";
//			if($n>2) break;
//			$n++;
//		}
//		luu tin
//		if(count($datas)>0)
//		save_news($newscat,$datas);
//	}
	
	
	echo create_guid();
	require 'templates/footer.html.php';
	@mysql_close($mysql);
?>
