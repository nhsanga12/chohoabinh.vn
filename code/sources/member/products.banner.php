<?php
	global $id,$config,$pages,$languages;
	require 'include/option.php';
	if($_SESSION['user']['id']!= false)
	$dssanpham = pro_of_mem($_SESSION['user']['id']);
 	
	$bannerdt = banner_detail($id['detail']);
	if($id['detail']==0 || $id['cate']==21)
		$detail = array();
	else if(count($bannerdt)>0)
		$detail = articles_detail($bannerdt[0]['articles']);
	else
		$detail = articles_detail($id['detail']);
	if(isset($_POST['luulailich'])){
		if(isset($_POST['calen_tungay']) && $_POST['calen_tungay']!='')
			$rsn['disfrom']	=	strtotime($_POST['calen_tungay']);
		else
			$rsn['disfrom']	=	time();
			
		if(isset($_POST['calen_denngay']) && $_POST['calen_denngay']!='')	
			$rsn['disto']	=	strtotime($_POST['calen_denngay']);
		else
			$rsn['disto']	=	time();
			
		if(isset($_POST['vitribanner']))
			$rsn['vitri'] = trim($_POST['vitribanner']);
		else
			$rsn['vitri'] = "VIP 0";
				
		if($_POST['hinhthucs']=='1'){
			$detail = articles_detail($_POST['tieudesp']);
			$rsn['types'] = '1';
			$rsn['title'] = $detail[0]['title'];
			$rsn['picture'] = $detail[0]['picture'];
			$rsn['articles'] = $detail[0]['id'];
			$rsn['usersid'] = $detail[0]['usersid'];
			$rsn['links'] = $detail[0]['category'];
			
		}else{
			$rsn['types'] = '2';	
			$rsn['title'] = 'Banner '.$rsn['vitri'];
			$rsn['picture'] = sys_uploads('lib/articles/','filebanner','gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG');
			if($_SESSION['user']['id']!= false)
			$rsn['usersid'] = $_SESSION['user']['id'];
			$rsn['links'] = $_POST['linkbanner'];
		
		}
		
		
		if(count($bannerdt)>0){
			$where['bannerid'] =  $bannerdt[0]['bannerid'];
			$rsn['lastdate'] = time();
			if($_POST['oldpic']!='' && $rsn['picture'] =='')
			$rsn['picture'] = $_POST['oldpic'];
			sql_update('banner',$rsn,$where);
		
		}else{
			$rsn['bydate'] = $rsn['lastdate'] = time();
			sql_add('banner',$rsn);
		
		}
		$msg = "Đã lưu lịch !!";
	}
	
?>