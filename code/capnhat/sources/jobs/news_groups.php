<?php
	if ($id['option'] == "main") {
		$sql = "SELECT grp.id, detail.title, grp.lastdate FROM ".$config['db_prefix']."_news_groups grp RIGHT JOIN ".$config['db_prefix']."_news_groups_detail detail ON grp.id = detail.groupid ";
		$sql.= "WHERE title LIKE '%".addslashes($id['search'])."%' AND detail.language = '".$config['default_language']."' ORDER BY grp.bydate DESC ";
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_on_page']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page'];
		$rs_list = sql_list($sql);
	}
	if ($id['option'] == "add") {
		if (isset($_POST['submit'])) {
			if ($_POST['add_title_vn'] == '') $msg = 'Tiêu đề của nhóm bài viết cần được bổ sung !';
			if ($msg == '') {
				$rs['oderid']	=	$_POST['add_oder'];
				$rs['bydate']	=	time();
				$rs['lastdate']	=	time();
				$newid = sql_add('news_groups',$rs);
				for ($i=0; $i < count($lgroups); $i++) {
					$rsn['groupid']		=	$newid;
					$rsn['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsn['language']	=	$lgroups[$i]['key'];
					sql_add('news_groups_detail',$rsn);
				}	
				$msg = 'Đã thêm thành công <strong>'.$_POST['add_title_vn'].'</strong>';
			}
		}
	}
	if ($id['option'] == "edit") {
		if ($_POST['submit']) {
		$rsn['oderid']		=	$_POST['add_oder'];
		$rsk['id']			=	$id['item'];
		sql_update('news_groups',$rsn,$rsk); 
		for ($i=0; $i < count($lgroups); $i++) {
			$chk = sql_exit("SELECT * FROM ".$config['db_prefix']."_news_groups_detail WHERE groupid='".$id['item']."' AND language='".$lgroups[$i]['key']."'");
			if ($chk > 0) {
					$rsi['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsko['language']	=	$lgroups[$i]['key'];
					$rsko['groupid']		=	$id['item'];
					sql_update('news_groups_detail',$rsi,$rsko); 
			} else {
					$rsu['groupid']		=	$id['item'];
					$rsu['title']		= 	$_POST['add_title_'.$lgroups[$i]['key']];
					$rsu['language']	=	$lgroups[$i]['key'];
					sql_add('news_groups_detail',$rsu);
			}
		}	
		$msg = 'Đã cập nhật thành công <strong>'.$_POST['add_title_vn'].'</strong>';
		}
		$sql = "SELECT grp.id, detail.title, grp.lastdate, detail.language, grp.oderid FROM ".$config['db_prefix']."_news_groups grp RIGHT JOIN ".$config['db_prefix']."_news_groups_detail detail ON grp.id = detail.groupid ";
		$sql.= "WHERE grp.id = '".$id['item']."' ";
		$detail = sql_detail($sql);
	}
	if ($id['option'] == 'delete') {
		$sql = "SELECT grp.id, detail.title, grp.lastdate FROM ".$config['db_prefix']."_news_groups grp RIGHT JOIN ".$config['db_prefix']."_news_groups_detail detail ON grp.id = detail.groupid ";
		$sql.= "WHERE detail.language = 'vn' AND (";
		$item = explode(",",$id['item']);
		$i = 0;
		if ($_POST['submit']) {
			while (list($key,$value)=each($item)) {
				$rsk['id']			=	$value;
				sql_delete('news_groups',$rsk);
				$rskn['groupid']	=	$value;
				sql_delete('news_groups_detail',$rskn);
			}
			@header("location:?lbm=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:".$id['limi_on_page'].";page:".$id['page'].";search:".$id['search']."");
		}
		while (list($key,$value)=each($item)) {
			if ($i == 0) $sql.= " grp.id= '".$value."' ";
			else $sql.= " OR grp.id= '".$value."' ";
			$i++;
		}
		$sql.= ") ORDER BY grp.bydate DESC";
		$rs_list = sql_list($sql);
	}
?>