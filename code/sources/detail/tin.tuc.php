<?php global $id,$config,$pages;
		
	$temp = $config['limit_news'];
	$config['limit_news'] = 4;
	if($id['cate']==10)
		$sanpham = newnews($id['category']);
	else
		$sanpham = getnews($id['category']);
	$config['limit_news'] = $temp;
	
	if($id['detail']!='')
		$chitiet = articles_detail($id['detail']);
	else
		$chitiet = articles_detail($sanpham[0]['id']);
	
	$newamount = 1 + (int)$chitiet[0]['opt'];
	update_viewer($chitiet[0]['id'],$newamount);
	
	$catlist = explode(",",$config['grouphome']);
	$bannerlist = explode(",",$config['groupbanner']);
	
	$danhmuc = categories_detail($id['category']);
	$danhmuccon = categories_by_cat_group(1,$id['category']);
	
	
	
	// binh luan
	if($_SESSION['user']['login'] != false)
	$yourdt = member_dt($_SESSION['user']['id']);
	
	if(isset($_POST['nutgui']) && $_POST['verification']!=$_SESSION['security_code']){
		$msm =  "<span style=\"color:#f00;\"> Vui lòng nhập Ký tự ngẫu nhiên </span><br /><br />";
	}else if(isset($_POST['nutgui']) && strlen($_POST['noidung'])<10){
		$msm =  "<span style=\"color:#f00;\"> Vui lòng nhập nội dung hơn 10 kí tự </span><br /><br />";
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