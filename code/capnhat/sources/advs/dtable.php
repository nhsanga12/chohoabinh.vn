<?php global $id, $config, $str; $msg ='';
if(isset($_POST['submit'])){
	
	// nhận giá trị biến
	$sourceid	=	$_POST['lbm_dest_id'];
	$destid		= 	$_POST['gnc_dest_id'];
	$db_prefix_s 	=	'lbm';
	$db_prefix_d 	=	'gnc';
	$config['default_language'] = 'vn';
	
	// load data cần chuyển
	if($sourceid!=0 && $sourceid!=''){
		
		$sql = "SELECT art.*, detail.*, grp.id AS news_groups FROM ".$db_prefix_s."_news_articles art RIGHT JOIN ".$db_prefix_s."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$db_prefix_s."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$db_prefix_s."_news_groups grp ON grp.id = cat.groupid ";
		$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( ";
		$sql.= " art.category= '".$sourceid."";
		$str = '';
		categories_child2($db_prefix_s,$sourceid,1);
		if ($str != '') {
			$str = str_replace(',',"' OR art.category = '",$str);
		}
		$str.= "'";
		$sql.= $str." ) ORDER BY art.id ASC ";
		
		$data =  sql_list($sql);
		$msg .= '<br /> Tổng cộng có '.count($data).' bài viết. <br />';
	}else $msg .= '<br /> Vui lòng chọn menu cần chuyển đi !! ';
	
	// chuyển data sang bảng chính
	if($destid!=0 && $destid!=''){
		for($i=0;$i<count($data);$i++){
			$rs['category']	=	$destid;
			$rs['picture']	=	$data[$i]['picture'];
			$rs['status']	= 	$data[$i]['status'];
			$rs['hot']		= 	$data[$i]['hot'];
			$rs['opt']		= 	$data[$i]['opt'];
			$rs['state_p']	= 	$data[$i]['state_p'];
			$rs['prices']	= 	$data[$i]['prices'];
			$rs['bydate']	=	$data[$i]['bydate'];
			$rs['lastdate']	=	$data[$i]['lastdate'];
			$newid = sql_add('news_articles',$rs);
			
			$rsa['newestarticles'] = $newid;
			$rska['id'] = $id['groups'];
			sql_update('news_groups',$rsa,$rska); 
			$rskna['id'] = $destid;
			sql_update('news_categories',$rsa,$rskna);
			
			$rsn['article']		=	$newid;
			$rsn['title']		= 	$data[$i]['title'];
			$rsn['seotit']		= 	$data[$i]['seotit'];
			$rsn['seodes']		= 	$data[$i]['seodes'];
			$rsn['quick']		= 	$data[$i]['quick'];
			$rsn['contents']	= 	$data[$i]['contents'];
			$rsn['language']	=	$data[$i]['language'];
			$rsn['ma']			= 	$data[$i]['ma'];
			$rsn['gia']			= 	$data[$i]['gia'];
			$rsn['loaitien']	= 	$data[$i]['loaitien'];
			$rsn['khuyenmai']	= 	$data[$i]['khuyenmai'];
			sql_add('news_articles_detail',$rsn);
					
			$driver = get_driver2('lbm',$data[$i]['id'],10);
			for($d=0;$d<count($driver);$d++){
				$rsp['title']	=	$driver[$d]['title'];
				$rsp['quick']	=	$driver[$d]['quick'];
				$rsp['file']	=	$driver[$d]['file'];
				$rsp['article']	=	$newid;
				$rsp['volum']	=	$driver[$d]['volum'];
				sql_add('driver',$rsp);
			}
			$manual = get_manual2('lbm',$data[$i]['id'],10);
			for($m=0;$m<count($manual);$m++){
				$rsm['title']	=	$manual[$m]['title'];
				$rsm['quick']	=	$manual[$m]['quick'];
				$rsm['file']	=	$manual[$m]['file'];
				$rsm['article']	=	$newid;
				$rsm['volum']	=	$manual[$m]['volum'];
				sql_add('manual',$rsm);
			}					
		}
		$msg .= '<br /> Đã chuyển thành công '.count($data).' bài viết. <br />';
	}else $msg .= '<br /> Vui lòng chọn menu cần chuyển đến !! ';
	
}
?>