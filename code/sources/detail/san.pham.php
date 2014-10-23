<?php
	global $id,$config,$pages;
	require 'include/option.php';
	$danhmuc = categories_detail($id['category']);
	$danhmuccon = categories_by_cat_group(1,$id['category']);
	$temp = $config['limit_news'];
	$config['limit_news'] = 6;
	$sanphamkhac =  search_pro($id['category'],'','','','',(int)time(),0,1);
	$config['limit_news'] = $temp;
	
	$sanpham = articles_detail($id['detail']);
	
	if($id['detail']!='')
		$sanpham = articles_detail($id['detail']);
	else
		$sanpham = articles_detail($sanphamkhac[0]['id']);
	
	$newamount = 1 + (int)$sanpham[0]['opt'];
	update_viewer($sanpham[0]['id'],$newamount);
	
	
	$catlist = explode(",",$config['grouphome']);
	$users = member_dt($sanpham[0]['usersid']);
	$dstaikhoan = bank_list($sanpham[0]['usersid']);
	
	
	if($_SESSION['user']['login'] != false)
	$yourdt = member_dt($_SESSION['user']['id']);
		
	if($_POST['verification']!=$_SESSION['security_code']){
		$msm =  "<span style=\"color:#f00;\"> Vui lòng nhập Ký tự ngẫu nhiên </span><br /><br />";
	}else if(isset($_POST['nutgui'])){
		$rw['usersid'] 	= $users[0]['usersid'];
		$rw['fromuser'] = $_SESSION['user']['id'];
		$rw['dienthoai']= $_POST['dienthoai'];
		$rw['email'] 	= $_POST['email'];
		$rw['article'] 	= $id['detail'];
		$rw['contents'] = $_POST['noidung'];
		$rw['bydate'] 	= time();
		$rw['lastdate'] = time();
		$rw['deleted'] 	= 0;
		sql_add('users_sms',$rw);
		
		$row['comments'] = (int)$sanpham[0]['comments'] + 1;
		$where['id'] = $id['detail'];
		sql_update('news_articles',$row,$where);
		
		$msm =  "<span style=\"color:#ee4;\"> Đã gửi phản hồi. </span><br /><br />";
	}
	
	$sms = users_comment($id['detail']);
	
	
	
?>