<?php
	if ($id['option'] == "main") {
		$sql = "SELECT ad.name , ad.lastdate, ad.id, gdt.title 
				FROM ".$config['db_prefix']."_admin ad  
				LEFT JOIN ".$config['db_prefix']."_news_groups_detail gdt ON gdt.groupid = ad.groupjobs ";
		$sql.= "WHERE ad.name LIKE '%".addslashes($id['search'])."%' AND gdt.language = '".$config['default_language']."' ";
		
		if($id['grpid']!=''){
			$sql.= " AND gdt.groupid = '".$id['grpid']."' ";
		}
		
		$sql.= " ORDER BY ad.bydate DESC ";
		
		
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_on_page']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page'];
		$rs_list = sql_list($sql);
	}
	if ($id['option'] == "add") {
		if (isset($_POST['submit'])) {
			if ($_POST['add_username'] == '') $msg = 'Tên đăng nhập cần được bổ sung !';
			if ($msg == '') {
				$rs['name']		=	$_POST['add_name'];
				$rs['username']	=	$_POST['add_username'];
				$rs['password']	=	md5(md5(md5($_POST['add_password'])));
				$rs['groupjobs'] =	$_POST['add_groupid'];
				$rs['email']	=	$_POST['add_email'];
				$rs['bydate']	=	time();
				$rs['lastdate']	=	time();
				$newid = sql_add('admin',$rs);
				group_plus('sumuser',$_POST['add_groupid']);
				
				$menum = $menu;
				while (list($keya,$valuea) = each($menum)) {
					while (list($keyb,$valueb) = each($valuea)) {
						if ($keyb != 'home' && $keyb != 'signin' && $keyb != 'signout' && $keyb != 'profiles') {
							$n = array ('main','add','edit','delete');
							while (list($key,$value)=each($n)) {
								$rs = false;
								$rs['admin'] 	= 	$newid;
								$rs['com']		=	$keyb;
								$rs['man']		=	$value;
								$rs['access']	=	intval($_POST[$keyb.'_'.$value]);
								sql_add('admin_detail',$rs);
							}
						}
					}
				} 
				$msg = 'Đã thêm thành công <strong>'.$_POST['add_name'].'</strong>';
			}
		}
	}
	if ($id['option'] == "edit") {
		if ($_POST['submit']) {
		$rsk['id']		=	$id['item'];
		$rs['name']		=	$_POST['add_name'];
		$rs['username']	=	$_POST['add_username'];
		if ($_POST['add_password'] != '') $rs['password']	=	md5(md5(md5($_POST['add_password'])));
		$rs['groupjobs'] =	$_POST['add_groupid'];
		$rs['email']	=	$_POST['add_email'];
		$rs['lastdate']	=	time();
		sql_update('admin',$rs,$rsk);
		
		group_plus('sumuser',$_POST['add_groupid']);
		group_minus('sumuser',$_POST['old_groupid']);
		
				$menum = $menu;
				while (list($keya,$valuea) = each($menum)) {
					while (list($keyb,$valueb) = each($valuea)) {
						if ($keyb != 'home' && $keyb != 'signin' && $keyb != 'signout' && $keyb != 'profiles') {
							$n = array ('main','add','edit','delete');
							while (list($key,$value)=each($n)) {
								$chk = sql_exit("SELECT * FROM ".$config['db_prefix']."_admin_detail WHERE admin='".$id['item']."' AND com='".$keyb."' AND man='".$value."'");
								if ($chk > 0) {
									$rs = false;
									$rsk = false;
									$rs['access']	=	intval($_POST[$keyb.'_'.$value]);
									$rsk['admin']	=	$id['item'];
									$rsk['com']		=	$keyb;
									$rsk['man']		=	$value;
									sql_update('admin_detail',$rs,$rsk); 
								} else {
									$rs = false;
									$rs['admin'] 	= 	$id['item'];
									$rs['com']		=	$keyb;
									$rs['man']		=	$value;
									$rs['access']	=	intval($_POST[$keyb.'_'.$value]);
									sql_add('admin_detail',$rs);
								}
							}
						}
					}
				} 
		$msg = 'Đã cập nhật thành công <strong>'.$_POST['add_name'].'</strong>';
		}
		$sql = "SELECT a.*, d.com, d.man, d.access FROM ".$config['db_prefix']."_admin a LEFT JOIN ".$config['db_prefix']."_admin_detail d ON a.id = d.admin ";
		$sql.= "WHERE a.id = '".$id['item']."' ORDER BY com,man ";
		$detail = sql_detail($sql);
		
		for($m=0;$m<count($detail);$m++) {
			$role[$detail[$m]['com']][$detail[$m]['man']] = $detail[$m]['access'];
		}
	}
	
	if ($id['option'] == 'delete') {
		$sql = "SELECT *, name AS title FROM ".$config['db_prefix']."_admin ";
		$sql.= "WHERE (";
		$item = explode(",",$id['item']);
		$i = 0;
		while (list($key,$value)=each($item)) {
			if ($i == 0) $sql.= " id= '".$value."' ";
			else $sql.= " OR id= '".$value."' ";
			$i++;
		}
		$sql.= ") ORDER BY  bydate DESC";
		$rs_list = sql_list($sql);
		
		if ($_POST['submit']) {
			for($m=0;$m<count($rs_list);$m++){
				group_minus('sumuser',$rs_list[$m]['groupjobs']);
				$rsk['id']			=	$rs_list[$m]['id'];
				sql_delete('admin',$rsk);
			}
			@header("location:?gnc=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:".$id['limi_on_page'].";page:".$id['page'].";search:".$id['search']."");
			
			echo "<script language=\"javascript\">window.location.replace(\"?gnc=com:system;target:admin\")</script>";
		}
		
		
	}
?>