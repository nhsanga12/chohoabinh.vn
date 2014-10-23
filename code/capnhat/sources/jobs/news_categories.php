<?php global $config, $id, $pages;
	if ($id['option'] == "main") {
		$sql = "SELECT cat.id, cat.parentid, detail.title, cat.lastdate, cat.oderid FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
		$sql.= "WHERE detail.title LIKE '%".addslashes($id['search'])."%' AND detail.language = 'vn' AND cat.groupid= '".$id['groups']."' ORDER BY cat.parentid, cat.oderid, detail.title, cat.bydate DESC ";
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_on_page']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page'];
		$rs_list = sql_list($sql);
		
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
		if (isset($_POST['submit'])) {
			if ($_POST['add_title_vn'] == '') $msg = 'Tiêu đề của loại bài viết cần được bổ sung !';
			if ($msg == '') {
				$rs['oderid']	=	$_POST['add_oder'];
				$rs['groupid']	=	$id['groups'];
				$rs['parentid']	=	$_POST['add_parentid'];
				$rs['picture']	=	sys_uploads('../lib/banner/','add_picture','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV',2);
				$rs['picture_ov']	=	sys_uploads('../lib/banner/','add_picture_ov','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV',2);
				$rs['textcolor']	=	$_POST['add_textcolor'];
				$rs['bydate']	=	time();
				$rs['lastdate']	=	time();
				$newid = sql_add('news_categories',$rs);
				for ($i=0; $i < count($lgroups); $i++) {
					$rsn['category']	=	$newid;
					$rsn['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsn['titkey']		= 	sys_sign($rsn['title']);
					
					if($_POST['add_seotit_cat_'.$lgroups[$i]['key']]!='')
						$rsn['seotit_cat']	= 	$_POST['add_seotit_cat_'.$lgroups[$i]['key']];
					else
						$rsn['seotit_cat']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
						
					$rsn['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsn['language']	=	$lgroups[$i]['key'];
					sql_add('news_categories_detail',$rsn);
				}	
				$msg = 'Đã thêm thành công <strong>'.$_POST['add_title_vn'].'</strong>';
			}
		}
	}
	if ($id['option'] == "edit") {
		if ($_POST['submit']) {
		// xử lý hình kèm theo
		$npic				=	sys_uploads('../lib/banner/','add_picture','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV',2);
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
		$rsk['id']			=	$id['item'];
		sql_update('news_categories',$rsn,$rsk); 
		for ($i=0; $i < count($lgroups); $i++) {
			$chk = sql_exit("SELECT * FROM ".$config['db_prefix']."_news_categories_detail WHERE category='".$id['item']."' AND language='".$lgroups[$i]['key']."'");
			if ($chk > 0) {
					$rsi['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsi['titkey']		= 	sys_sign($rsi['title']);
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
					$rsu['seotit_cat']	= 	$_POST['add_seotit_cat_'.$lgroups[$i]['key']];
					$rsu['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsu['language']	=	$lgroups[$i]['key'];
					sql_add('news_categories_detail',$rsu);
			}
		}	
		$msg = 'Đã cập nhật thành công <strong>'.$_POST['add_title_vn'].'</strong>';
		}
		$sql = "SELECT cat.id, cat.parentid, detail.title,detail.seotit_cat, cat.picture, cat.picture_ov, cat.textcolor, cat.lastdate, detail.language, cat.oderid, detail.contents FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
		$sql.= "WHERE cat.id = '".$id['item']."' ORDER BY cat.id ";
		$detail = sql_detail($sql);
	}
	if ($id['option'] == 'delete') {
		$sql = "SELECT cat.id, detail.title, cat.lastdate FROM ".$config['db_prefix']."_news_categories cat RIGHT JOIN ".$config['db_prefix']."_news_categories_detail detail ON cat.id = detail.category ";
		$sql.= "WHERE detail.language = 'vn' AND (";
		$item = explode(",",$id['item']);
		$i = 0;
		if ($_POST['submit']) {
			while (list($key,$value)=each($item)) {
				$rsk['id']			=	$value;
				sql_delete('news_categories',$rsk);
				$rskn['category']	=	$value;
				sql_delete('news_categories_detail',$rskn);
			}
			@header("location:?lbm=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:".$id['limi_on_page'].";page:".$id['page'].";search:".$id['search'].";groups:".$id['groups']."");
		}
		while (list($key,$value)=each($item)) {
			if ($i == 0) $sql.= " cat.id= '".$value."' ";
			else $sql.= " OR cat.id= '".$value."' ";
			$i++;
		}
		$sql.= ") ORDER BY cat.bydate DESC";
		$rs_list = sql_list($sql);
	}
?>