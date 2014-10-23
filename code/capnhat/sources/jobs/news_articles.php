<?php global $config, $str,$pages;
	$numcol = 5;
	$content = array('Tên vật tư','Đời máy','Đơn vị','Định mức','Giá');
	$skin_edit = 'kama';
	if($config['skin_editor']==1) $skin_edit = 'office2003';
	if($config['skin_editor']==2) $skin_edit = 'v2';
	
	if ($id['option'] == "main") {
		$sql = "SELECT art.id, art.category, detail.title, detail.ma, detail.gia, detail.khuyenmai,detail.thuonghieu, detail.quick, detail.contents, art.lastdate, art.state_p, art.status, art.hot, art.bydate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
		$sql.= "WHERE title LIKE '%".addslashes($id['search'])."%' AND detail.language = 'vn' AND ( ";
		
		$sql.= " art.category= '".$id['category'];
		$str = '';
		categories_child($id['category'],1);
		if ($str != '') {
			$str = str_replace(',',"' OR art.category = '",$str);
		}
		$str.= "'";
		$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
		
		if($config['limit_on_page']=='' || $config['limit_on_page']==0)
		$config['limit_on_page'] = 10;
		$pages = array();
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
				$nd['state_p'] = $_POST['s'.$rs_list[$i]['id']];
				$nd['lastdate'] = time();
				sql_update('news_articles',$nd,$dex);
				
				$dedex['article'] = $rs_list[$i]['id'];
				$dend['gia'] = $_POST['gia'.$rs_list[$i]['id']];
				sql_update('news_articles_detail',$dend,$dedex);
			}
		$rs_list = sql_list($sql);
		};
	}
	if ($id['option'] == "add") {
		if (isset($_POST['submit'])) {
			if ($_POST['add_title_vn'] == '') $msg = 'Tiêu đề của bài viết cần được bổ sung !';
			if ($msg == '') {
				$rs['category']	=	$id['category'];
				$rs['picture']	=	sys_uploads('../lib/articles/','add_picture','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV');
				
				$sisefile = $_FILES['add_picture']['size'];
				if($sisefile > $config['max_upload_file_size'])
					$msg .= "File không được tải lên vì vượt quá kích thước quy định (".($config['max_upload_file_size']/1000)."KB)!! <br /><br />";
				
				//BEGIN add excel file .Thêm file excel đính kèm
				if ($_POST['checksave'] == 1){	
					$rs['excel']		=	sys_uploads('../lib/files/','add_excel','xls|xlsx|xml|XLS|XLSX|XML');
					$temp = preg_split('/[\/\\\\]+/', $_FILES['add_excel']["name"]);
					$filename = $temp[count($temp)-1];
					$filename = str_replace("%20","",$filename);
				}
				// END add excel file
				$rs['status']	= 	$_POST['add_status'];
				$rs['hot']	= 	$_POST['add_hot'];
				$rs['opt']		= 	$_POST['add_opt'];
				$rs['bydate']	=	time();
				$rs['lastdate']	=	time();
				if($_POST['add_picture_text_0'] != '') 
					$rs['state_p'] = 1;
				if($_POST['add_video_text_0'] != '') 
					$rs['state_v'] = 1;
				$newid = sql_add('news_articles',$rs);
				$rsa['newestarticles'] = $newid;
				$rska['id'] = $id['groups'];
				sql_update('news_groups',$rsa,$rska); 
				$rskna['id'] = $id['category'];
				sql_update('news_categories',$rsa,$rskna); 
				for ($i=0; $i < count($lgroups); $i++) {
					$rsn['article']		=	$newid;
					$rsn['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					
					// Xử lý SEO ================== Chức năng tự động cắt xén nội dung đưa vào text SEO
						$cut_tit=68; $cut_des=250;
						$seotit = $_POST['add_seotit_'.$lgroups[$i]['key']];
						if($seotit=='' || strlen($seotit)<10)// nếu trống
							$seotit = sys_cut($_POST['add_title_'.$lgroups[$i]['key']],$cut_tit);
						else // nếu ghi
							$seotit = sys_cut($_POST['add_seotit_'.$lgroups[$i]['key']],$cut_tit);
							
						$seodes = $_POST['add_seodes_'.$lgroups[$i]['key']];
						if($seodes=='' || strlen($seodes)<10){ // nếu trống
							$nd = sys_cut($_POST['add_quick_'.$lgroups[$i]['key']].'. '.$_POST['add_contents_'.$lgroups[$i]['key']],$cut_des);
							$seodes = html2text($nd);
						}else // nếu ghi
							$seodes = sys_cut( $_POST['add_seodes_'.$lgroups[$i]['key']],$cut_des);
						$rsn['seotit']		= 	$seotit;
						$rsn['seodes']		= 	$seodes;
					// End SEO=====================		
					
					$rsn['ma']			= 	$_POST['add_ma_'.$lgroups[$i]['key']];
					$rsn['gia']			= 	$_POST['add_gia_'.$lgroups[$i]['key']];
					$rsn['loaitien']	= 	$_POST['cbbloaitien_'.$lgroups[$i]['key']];
					$rsn['khuyenmai']	= 	$_POST['add_khuyenmai_'.$lgroups[$i]['key']];
					$rsn['thuonghieu']	= 	$_POST['add_thuonghieu_'.$lgroups[$i]['key']];
					$rsn['quick']		= 	$_POST['add_quick_'.$lgroups[$i]['key']];
					$rsn['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsn['language']	=	$lgroups[$i]['key'];
					
					sql_add('news_articles_detail',$rsn);					
				}
				
				
				
				for ($j=0;$j<$config['max_file'];$j++) {
					//Thêm các FILE ẢNH
					$title1	=	'add_file_tit_'.$j;
					
					if ($_POST[$title1] != ''){
						$quick1	=	'add_file_text_'.$j;
						$file1	=	'add_file_'.$j;
						$nhom	=	'../lib/'.$_POST['nhomfile'].'/';
						$thumnail1	=	'add_thumnail_'.$j;
					
						$rsp['title']	=	$_POST[$title1];
						$rsp['quick']	=	$_POST[$quick1];
						$rsp['file']	=	sys_uploads($nhom,$file1,'gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV|txt|TXT',0,false);
						$rsp['article']	=	$newid;
						$rsp['type']	=	$_POST['nhomfile'];
						$rsp['volum']	=	$_FILES[$file1]["size"];
						$rsp['thum']	=	sys_uploads($nhom,$thumnail1,'gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV|txt|TXT',1);
						if($rsp['thum']=='')
						$rsp['thum']	=	'thums_'.$rsp['file'];
						if($rsp['file']!='') $picid = sql_add('file',$rsp);
					}	
				}// end for
				$msg .= 'Đã thêm thành công <strong>'.$_POST['add_title_vn'].'</strong>';
			}
		}
	}
	if ($id['option'] == "edit") {
		if ($_POST['submit']) {
		$rsk['id']			=	$id['item'];
		$rsn['status']		= 	$_POST['add_status'];
		$rsn['hot']		= 	$_POST['add_hot'];
		$rsn['opt']			= 	$_POST['add_opt'];
		$npic				=	sys_uploads('../lib/articles/','add_picture','gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV');
		if ($npic != '') {
			$rsn['picture'] = $npic;
		}
		if ($_POST['xoahinh']== 'xoahinh') {
			@unlink('../lib/articles/'.$_POST['old_picture']);
			$rsn['picture'] = '';
		}				
		sql_update('news_articles',$rsn,$rsk); 
		for ($i=0; $i < count($lgroups); $i++) {
			$chk = sql_exit("SELECT * FROM ".$config['db_prefix']."_news_articles_detail WHERE article='".$id['item']."' AND language='".$lgroups[$i]['key']."'");				
			if ($chk > 0) {
					$rsi['seotit']		= 	$_POST['add_seotit_'.$lgroups[$i]['key']];// Xử lý SEO ==================					
					$rsi['seodes']		= 	$_POST['add_seodes_'.$lgroups[$i]['key']];// Xử lý SEO ==================
					$rsi['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsi['ma']			= 	$_POST['add_ma_'.$lgroups[$i]['key']];
					$rsi['gia']			= 	$_POST['add_gia_'.$lgroups[$i]['key']];
					$rsi['loaitien']	= 	$_POST['cbbloaitien_'.$lgroups[$i]['key']];
					$rsi['khuyenmai']	= 	$_POST['add_khuyenmai_'.$lgroups[$i]['key']];
					$rsi['thuonghieu']	= 	$_POST['add_thuonghieu_'.$lgroups[$i]['key']];
					$rsi['quick']		= 	$_POST['add_quick_'.$lgroups[$i]['key']];
					$rsi['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsnk['language']	=	$lgroups[$i]['key'];
					$rsnk['article']	=	$id['item'];
					sql_update('news_articles_detail',$rsi,$rsnk); 
			} else {
					$rsi['seotit']		= 	$_POST['add_seotit_'.$lgroups[$i]['key']];// Xử lý SEO ==================
					$rsi['seodes']		= 	$_POST['add_seodes_'.$lgroups[$i]['key']];// Xử lý SEO ==================
					$rsu['article']		=	$id['item'];
					$rsu['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsu['ma']			= 	$_POST['add_ma_'.$lgroups[$i]['key']];
					$rsu['gia']			= 	$_POST['add_gia_'.$lgroups[$i]['key']];
					$rsu['loaitien']	= 	$_POST['cbbloaitien_'.$lgroups[$i]['key']];
					$rsu['khuyenmai']	= 	$_POST['add_khuyenmai_'.$lgroups[$i]['key']];
					$rsu['quick']		= 	$_POST['add_quick_'.$lgroups[$i]['key']];
					$rsu['contents']	= 	$_POST['add_contents_'.$lgroups[$i]['key']];
					$rsu['language']	=	$lgroups[$i]['key'];
					sql_add('news_articles_detail',$rsu);
			}
		}
		
		
		for ($j=0;$j<$config['max_file'];$j++) {
				//Thêm các FILE ẢNH
				$title1	=	'add_file_tit_'.$j;
				
				if ($_POST[$title1] != ''){
					$quick1	=	'add_file_text_'.$j;
					$file1	=	'add_file_'.$j;
					$nhom	=	'../lib/'.$_POST['nhomfile'].'/';
					$thumnail1	=	'add_thumnail_'.$j;
					
					$rsp['title']	=	$_POST[$title1];
					$rsp['quick']	=	$_POST[$quick1];					 
					$rsp['file']	=	sys_uploads($nhom,$file1,'gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV|txt|TXT',0,false);
					$rsp['article']	=	$id['item'];
					$rsp['type']	=	$_POST['nhomfile'];
					$rsp['volum']	=	$_FILES[$file1]["size"];
					$rsp['thum']	=	sys_uploads($nhom,$thumnail1,'gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV|txt|TXT',1,false);
					if($rsp['thum']=='')
					$rsp['thum']	=	'thums_'.$rsp['file'];
					if($rsp['file']!='') $picid = sql_add('file',$rsp);
				}
			}// end for
		
		
		//XỬ LÝ FILE CŨ
		$sqlsum = "SELECT * FROM ".$config['db_prefix']."_file WHERE article = ".$id['item']." AND type = 'images' ORDER BY id " ;
		$gr_imgsum = sql_detail($sqlsum);
		
		$old_file_sum = count($gr_imgsum);
		for ($e=0;$e<$old_file_sum;$e++) {
			$driverpcs1	=  'dr_checkdel_'.$e;			
			$new_file 	  =  'new_file_'.$e;
			$old_file 	  =  'old_file_'.$e;
			$old_file_tit =  'old_file_tit_'.$e;
			$file_id 	  =  'file_id_'.$e;
			$new_thum 	  =  'new_thum_'.$e;
			$old_thum 	  =  'old_thum_'.$e;
			
			// Xóa hình
			if ($_POST[$driverpcs1] == '1') {
				$rsp1['id'] = $_POST[$file_id];
				sql_delete('file',$rsp1);
			}else{
			
				//sửa hình
				if($_POST[$old_file_tit] != '') {
					$rsold['title']		=	$_POST[$old_file_tit];
					$rsold['volum']		=	$_FILES[$new_file]["size"];
					$newfile[$e] 		=	sys_uploads($nhom,$new_file,'gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV|txt|TXT',0,true);
					if($newfile[$e]!='') 
						$rsold['file']	= 	$newfile[$e];
					else
						$rsold['file']	= 	$_POST[$old_file];
						
					$rsold['article']	=	$id['item'];
					
					//sửa thumnail
					$newthumnail[$e] = sys_uploads($nhom,$new_thum,'gif|jpg|png|GIF|JPG|PNG|PDF|DOC|XLS|RAR|ZIP|PPT|swf|SWF|flv|FLV|txt|TXT',2,true);
					if($newthumnail[$e] != '') {
						$rsold['thum'] = $newthumnail[$e];
						
					}else
						$rsold['thum'] = $_POST[$old_thum];
					
					$rsold_index['id']	= 	$_POST[$file_id];
					sql_update('file',$rsold,$rsold_index);
				}
				
				
			}
			
		}// end for
		
		$msg = 'Đã cập nhật thành công <strong>'.$old_file_sum.'</strong>';
		
		}
		$sql = "SELECT art.id, art.picture, art.lastdate, art.status, art.state_p, art.hot, art.opt, detail.language, detail.title, detail.ma,detail.loaitien, detail.gia,detail.khuyenmai,detail.thuonghieu, detail.quick,detail.seotit,detail.seodes,detail.contents FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
		$sql.= "WHERE art.id = '".$id['item']."' ";
		$detail = sql_detail($sql);
		$sqlp = "SELECT * FROM ".$config['db_prefix']."_file WHERE article = ".$id['item']." AND type = 'images' ORDER BY title " ;
		$gr_img = sql_detail($sqlp);
		$sqlv = "SELECT * FROM ".$config['db_prefix']."_file WHERE article = ".$id['item'];
		$gr_file = sql_detail($sqlv);
	}
	if ($id['option'] == 'delete' && $id['dupple'] == 0) {
		$sql = "SELECT art.id, detail.title, detail.ma,detail.loaitien,detail.gia,detail.khuyenmai,detail.seotit,detail.seodes, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
		$sql.= "WHERE detail.language = 'vn' AND (";
		$item = explode(",",$id['item']);
		$i = 0;
		if ($_POST['submit']) {
			while (list($key,$value)=each($item)) {
				$rsk['id']	=	$value;
				
				// lưu hình xóa
				$sqlhinh	=	'SELECT * FROM '.$config['db_prefix'].'_news_articles WHERE id = '.$value;
				$hinh = sql_detail($sqlhinh);
				@unlink('../lib/articles/'.$hinh[0]['picture']);
				// end lưu hình xóa
				
				// xóa XML
					if($id['category']>10 && $id['category']<20){ // chỉ dùng cho mục có id 10 banner
						$sqlxml	=	'SELECT * FROM '.$config['db_prefix'].'_news_articles_detail WHERE article = '.$value;
						$chimuc = sql_detail($sqlxml);
						$empty	= "\n";
						if($chimuc[0]['gia']!=0)
							writeoverXmlItem('../lib/xmldata/cong'.$id['category'].'.xml',$chimuc[0]['gia'],$chimuc[0]['gia']+7,$empty);
					}
				//end XML
				
				sql_delete('news_articles',$rsk);
				$rskn['articles']	=	$value;
				sql_delete('news_articles_detail',$rskn);
				$rsp['article']	=	$value;
				//Xóa tất cả hình ảnh trong picture
				$sqlp	=	'SELECT * FROM '.$config['db_prefix'].'_file WHERE article = '.$value;
				$cpic	=	count(sql_list($sqlp));
				for ($i=0;$i<$cpic;$i++)
					sql_delete('file',$rsp);
			}
			@header("location:?gnc=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:".$id['limi_on_page'].";page:".$id['page'].";search:".$id['search'].";groups:".$id['groups'].";category:".$id['category']."");
		}
		while (list($key,$value)=each($item)) {
			if ($i == 0) $sql.= " art.id= '".$value."' ";
			else $sql.= " OR art.id= '".$value."' ";
			$i++;
		}
		$sql.= ") ORDER BY art.bydate DESC";
		$rs_list = sql_list($sql);
	}
// Sao chép bài viết	
	if ($id['option'] == 'delete' && $id['dupple'] == 1) {
			$sql = "SELECT art.id, detail.title, detail.ma,detail.loaitien,detail.gia,detail.khuyenmai,detail.seotit,detail.seodes, art.lastdate, detail.language FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
			$sql.= "WHERE detail.title != '' AND (";
			$item = explode(",",$id['item']);
			$i = 0; $_SESSION['dup']+=	1;
			if ($_POST['submit']) { // XỬ LÝ KHI NHẤN NÚT
				while (list($key,$value)=each($item)) {
					$rsk			=	$value;
					sql_dupple('news_articles',$rsk);
				}
			};
			while (list($key,$value)=each($item)) {
				if ($i == 0) $sql.= " art.id= '".$value."' ";
				else $sql.= " OR art.id= '".$value."' ";
				$i++;
			}
			$sql.= ") ORDER BY art.bydate DESC ";
			$rs_list = sql_list($sql);
	}else {
			$_SESSION['dup']=false;
	}
	
	// Di chuyển bài viết	
	if ($id['option'] == 'delete' && $id['dupple'] == 9) {
		$bi = 0; $j = 0;
		$item = explode(",",$id['item']);
		if ($_POST['submit']) { // XỬ LÝ KHI NHẤN NÚT
			$sql = "SELECT * FROM ".$config['db_prefix']."_news_articles art WHERE art.category != '' AND ( ";
			while (list($key,$value)=each($item)) {
				if ($bi == 0) $sql.= " art.id= '".$value."' ";
				else $sql.= " OR art.id= '".$value."' ";
				$bi++;
			}
			$sql.= ") ORDER BY art.bydate DESC ";
			$cat_list = sql_list($sql);
			for($k=0;$k<count($cat_list);$k++){
				$rsi['category']	=	$_POST['dest_id'];
				$rsnk['id']	=	$cat_list[$k]['id'];
				sql_update('news_articles',$rsi,$rsnk);
			}
		}else{ // XỬ LÝ HIỂN THỊ
			$sql2 = "SELECT art.id, detail.title, detail.ma,detail.loaitien,detail.gia,detail.khuyenmai,detail.seotit,detail.seodes, art.lastdate, detail.language FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
			$sql2.= "WHERE detail.title != '' AND (";
			while (list($key,$value)=each($item)) {
				if ($j == 0) $sql2.= " art.id= '".$value."' ";
				else $sql2.= " OR art.id= '".$value."' ";
				$j++;
			}
			$sql2.= ") ORDER BY art.bydate DESC ";
			$rs_list = sql_list($sql2);
		}
		if($_POST['dest_id']!='') $j=$_POST['dest_id']; else $j=$id['category'];
	};
		
?>