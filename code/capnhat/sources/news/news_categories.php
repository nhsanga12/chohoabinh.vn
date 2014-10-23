<?php global $config, $id, $pages;

	// phan quyen nhom
	if($_SESSION['auth']['group']== '' || $_SESSION['auth']['group']=== false)
		$grpid = 0;
	else if($_SESSION['auth']['group']== 1){
		if($id['grpid']=='')
			$grpid = 1;
		else
			$grpid = $id['grpid'];
	}else
		$grpid = $_SESSION['auth']['group'];
		
	$title = group_dt($grpid);
		
	
	if ($id['option'] == "main") {
		if($id['search']=='Tên menu cần tìm') $id['search'] = '';
		$sql = " SELECT cat.id, cat.parentid, detail.title, cat.lastdate, cat.oderid, cat.status, cat.groupid
				 FROM ".$config['db_prefix']."_news_categories cat 
				 RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
		$sql.= " WHERE detail.title LIKE '%".addslashes($id['search'])."%' AND detail.language = 'vn' AND cat.status <> '0' ";
		
		if($grpid !='')
		$sql.= " AND cat.groupid = '".$grpid."' ";
		
		$sql.= " ORDER BY cat.status DESC , cat.parentid , cat.oderid, detail.title, cat.bydate DESC ";
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_on_page']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page'];
		$rs_list = sql_list($sql);
		
		if($id['search']!='')
			$searchval = $id['search'];
		else
			$searchval = "Tên menu cần tìm";
		
		// Nếu có thay đổi thông tin thì lưu lại
		if (isset($_POST['save'])) {
			//echo 'Thông tin đã được lưu';
			for($i=0;$i<count($rs_list);$i++){
				$dex['id'] = $rs_list[$i]['id'];
				$nd['oderid'] = $_POST['oderid'.$rs_list[$i]['id']];
				$nd['lastdate'] = time();
				sql_update('news_categories',$nd,$dex);
			}
			$rs_list = sql_list($sql);
		};
	}
	
	
	if ($id['option'] == "add") {
		if($_SESSION['auth']['group']== 1 && $_POST['groupid']!=''){
			$grpid = $_POST['groupid'];
			$title = group_dt($grpid);
		}
		
		if (isset($_POST['submit'])) {
			if ($_POST['add_title_vn'] == '') $msg = 'Tiêu đề của loại bài viết cần được bổ sung !';
			if ($msg == '') {
				$rs['oderid']	=	$_POST['add_oder'];
				$rs['groupid']	=	$_POST['groupid'];
				$rs['parentid']	=	$_POST['add_parentid'];
				$rs['picture']	=	sys_uploads('../lib/banner/','add_picture','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV',5);
				$rs['picture_ov']	=	sys_uploads('../lib/banner/','add_picture_ov','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV',2);
				$rs['textcolor']	=	$_POST['add_textcolor'];
				$rs['status']	=	$_POST['status'];
				$rs['bydate']	=	time();
				$rs['lastdate']	=	time();
				$newid = sql_add('news_categories',$rs);
				
				$temlang = $config['default_language'];
				
				for ($i=0; $i < count($lgroups); $i++) {
					$rsn['category']	=	$newid;
					$rsn['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsn['titkey']		= 	sys_sign($rsn['title']);
					
					// sitemap general
					$oldtk = sys_sign($_POST['add_title_'.$lgroups[0]['key']]);
					if( $i>0 && $rsn['titkey']== $oldtk){
						$msg1 = ' .Tiêu đề vn và en giống nhau nên chỉ lưu 1 link vào sitemap !';
					}else{
						$config['default_language'] = $lgroups[$i]['key'];
						$newlink = CmsBreadcrumbLink('',$rs['parentid'],'',$rsn['titkey']);
						$rsn['sitemappoint'] = AddSitemap('../sitemap.xml',$config['url'].$newlink,'weekly','0.8');
					}
					// END sitemap general
					
					if($_POST['add_seotit_cat_'.$lgroups[$i]['key']]!='')
						$rsn['seotit_cat']	= 	$_POST['add_seotit_cat_'.$lgroups[$i]['key']];
					else
						$rsn['seotit_cat']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
						
					$rsn['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsn['language']	=	$lgroups[$i]['key'];
					
					sql_add('news_categories_detail',$rsn);
				}
				
				$config['default_language']= $temlang ;
				
				$msg = 'Đã thêm thành công <strong>'.$_POST['add_title_vn'].'</strong>';
			}
		}
	}
	if ($id['option'] == "edit") {
		if($_SESSION['auth']['group']== 1 && $_POST['groupid']!=''){
			$grpid = $_POST['groupid'];
			$title = group_dt($grpid);
		}
		
		if ($_POST['submit']) {
		// xử lý hình kèm theo
		$npic				=	sys_uploads('../lib/banner/','add_picture','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV',5);
		if ($npic != '') {
			$rsn['picture'] = $npic;
		}
		if ($_POST['xoahinh']== 'xoahinh') {
			@unlink('../lib/banner/'.$_POST['old_picture']);
			$rsn['picture'] = '';
		}
		
		$npic_ov  =	sys_uploads('../lib/banner/','add_picture_ov','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV',2);
		if ($npic_ov != '') {
			$rsn['picture_ov'] = $npic_ov;
		}
		if ($_POST['xoahinh_ov']== 'xoahinh_ov') {
			@unlink('../lib/banner/'.$_POST['old_picture_ov']);
			$rsn['picture_ov'] = '';
		}	
				
		$rsn['textcolor']	=	$_POST['add_textcolor'];		
		$rsn['oderid']		=	$_POST['add_oder'];
		$rsn['parentid']	=	$_POST['add_parentid'];
		$rsn['groupid']		=	$_POST['groupid'];
		$rsn['status']		=	$_POST['status'];
		$rsk['id']			=	$id['item'];
		sql_update('news_categories',$rsn,$rsk); 
		$temlang = $config['default_language'];
		for ($i=0; $i < count($lgroups); $i++) {
			$chk = sql_exit("SELECT * FROM ".$config['db_prefix']."_news_categories_detail WHERE category='".$id['item']."' AND language='".$lgroups[$i]['key']."'");
			if ($chk > 0) {
					$rsi['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsi['titkey']		= 	sys_sign($rsi['title']);
					// sitemap general
					$oldtk = sys_sign($_POST['add_title_'.$lgroups[0]['key']]);
					if( ($i>0 && $rsi['titkey']== $oldtk) || $_POST['sitemappoint_'.$lgroups[$i]['key']] == 0 || $_POST['sitemappoint_'.$lgroups[$i]['key']] == '' ){
						$msg1 = ' .Tiêu đề vn và en giống nhau nên chỉ lưu 1 link vào sitemap !';
					}else{
						$config['default_language'] = $lgroups[$i]['key'];
						$newlink = CmsBreadcrumbLink('',$rsn['parentid'],'',$rsi['titkey']);
						$rsi['sitemappoint'] = UpdateSitemap('../sitemap.xml',$config['url'].$newlink,'weekly','0.8',$_POST['sitemappoint_'.$lgroups[$i]['key']]);
					}
					// END sitemap general
					if($_POST['add_seotit_cat_'.$lgroups[$i]['key']]!='')
						$rsi['seotit_cat']	= 	$_POST['add_seotit_cat_'.$lgroups[$i]['key']];
					else
						$rsi['seotit_cat']	= 	$_POST['add_title_'.$lgroups[$i]['key']];
					
					$rsi['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsko['language']	=	$lgroups[$i]['key'];
					$rsko['category']	=	$id['item'];
					sql_update('news_categories_detail',$rsi,$rsko); 
			} else {
					$rsu['category']	=	$id['item'];
					$rsu['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsu['titkey']		= 	sys_sign($rsu['title']);
					// sitemap general
					$oldtk = sys_sign($_POST['add_title_'.$lgroups[0]['key']]);
					if( $i>0 && $rsu['titkey']== $oldtk){
						$msg1 = ' .Tiêu đề vn và en giống nhau nên chỉ lưu 1 link vào sitemap !';
					}else{
						$config['default_language'] = $lgroups[$i]['key'];
						$newlink = CmsBreadcrumbLink($startlink ='',$rsn['parentid'],'',$rsu['titkey']);
						$rsu['sitemappoint'] = AddSitemap('../sitemap.xml',$config['url'].$newlink,'weekly','0.8');
					}
					// END sitemap general
					$rsu['seotit_cat']	= 	$_POST['add_seotit_cat_'.$lgroups[$i]['key']];
					$rsu['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsu['language']	=	$lgroups[$i]['key'];
					sql_add('news_categories_detail',$rsu);
			}
		}
		$config['default_language']= $temlang ;
		$msg = 'Đã cập nhật thành công <strong>'.$_POST['add_title_vn'].'</strong>'.$msg1;
		}
		$sql = "SELECT cat.id, cat.parentid, cat.groupid, cat.status, detail.title,detail.seotit_cat, detail.sitemappoint, cat.picture, cat.picture_ov, cat.textcolor, cat.lastdate, detail.language, cat.oderid, detail.contents FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
		$sql.= "WHERE cat.id = '".$id['item']."' ORDER BY cat.id AND cat.status <> '0' ";
		$detail = sql_detail($sql);
	}
	
	
	
	
	
	
	if ($id['option'] == 'delete') {
		
		$sql = "SELECT cat.id, detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
		$sql.= "WHERE detail.language = 'vn' AND cat.status <> '0' ";
		$item = str_replace(" ","",$id['item']);
		$item = str_replace(",","','",$item);
		
		if ($_POST['submit']) {
			cate_del($grpid,$id['item']);
			if($_POST['delete_sub']==1){ // xoa danh muc con
				subcate_del($grpid,$id['item']);
			}
			@header("location:?gnc=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:".$id['limi_on_page'].";page:".$id['page'].";search:".$id['search'].";grpid:".$grpid);
			echo "<script language=\"javascript\">window.location.replace(\"?gnc=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:".$id['limi_on_page'].";page:".$id['page'].";search:".$id['search'].";grpid:".$grpid."\")</script>";
		}
		
		$sql.= " AND cat.id IN ('".$item."-1') ";
		$sql.= " ORDER BY cat.bydate DESC ";
		$rs_list = sql_list($sql);
	}
?>