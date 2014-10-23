<?php
	if ($id['option'] == "main") {
		$sql = "SELECT *, fullname AS title FROM ".$config['db_prefix']."_member ";
		//$sql.= "WHERE username LIKE '%".addslashes($id['search'])."%' ORDER BY bydate DESC ";
		$sql.= " ORDER BY bydate DESC ";
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_on_page']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page'];
		$rs_list = sql_list($sql);
	}
	if ($id['option'] == "add") {
		if (isset($_POST['submit'])) {
			if ($_POST['fullname'] == '') $msg = 'Tên đăng nhập cần được bổ sung !';
			if ($msg == '') {
				$rs['fullname']	=	$_POST['fullname'];
				$rs['company']	=	$_POST['company'];
				$rs['gender']		=	$_POST['gender'];
				$rs['birthday']		=	$_POST['birthday'];
				$rs['email']		=	$_POST['email'];
				if ($_POST['password'] != '') $rs['password']	=	md5(md5(md5($_POST['password'])));
				$rs['address']		=	$_POST['address'];
				$rs['numbertel']	=	$_POST['numbertel'];
				$rs['city']			=	$_POST['city'];
				$rs['products']		=	$_POST['products'];
				$rs['country']		=	$_POST['country'];
				$rs['securityquestion']	=	$_POST['securityquestion'];
				$rs['securityanswer']	=	$_POST['securityanswer'];
				$rs['measure']		=	$_POST['measure'];
				$rs['lastdate']		=	time();		
				$rs['bydate']	=	time();
				$newid = sql_add('member',$rs);
				$msg = 'Đã thêm thành công <strong>'.$_POST['add_name'].'</strong>';
			}
		}
	}
	if ($id['option'] == "edit") {
		if ($_POST['submit']) {
		$rsk['id']		=	$id['item'];
		$rs['fullname']	=	$_POST['fullname'];
				$rs['company']		=	$_POST['company'];
				$rs['gender']		=	$_POST['gender'];
				$rs['birthday']		=	$_POST['birthday'];
				$rs['email']		=	$_POST['email'];
				if ($_POST['password'] != '') $rs['password']	=	md5(md5(md5($_POST['password'])));
				$rs['address']		=	$_POST['address'];
				$rs['numbertel']	=	$_POST['numbertel'];
				$rs['city']			=	$_POST['city'];
				$rs['products']		=	$_POST['products'];
				$rs['country']		=	$_POST['country'];
				$rs['securityquestion']	=	$_POST['securityquestion'];
				$rs['securityanswer']	=	$_POST['securityanswer'];
				$rs['measure']		=	$_POST['measure'];
				$rs['lastdate']		=	time();		
		sql_update('member',$rs,$rsk); 
		$msg = 'Đã cập nhật thành công <strong>'.$_POST['add_name'].'</strong>';
		}
		$sql = "SELECT a.* FROM ".$config['db_prefix']."_member a ";
		$sql.= "WHERE a.id = '".$id['item']."' ";
		$detail = sql_detail($sql);
	}
	if ($id['option'] == 'delete') {
		$sql = "SELECT *, fullname AS title FROM ".$config['db_prefix']."_member ";
		$sql.= "WHERE (";
		$item = explode(",",$id['item']);
		$i = 0;
		if ($_POST['submit']) {
			while (list($key,$value)=each($item)) {
				$rsk['id']			=	$value;
				sql_delete('member',$rsk);
			}
			@header("location:?lbm=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:".$id['limi_on_page'].";page:".$id['page'].";search:".$id['search']."");
		}
		while (list($key,$value)=each($item)) {
			if ($i == 0) $sql.= " id= '".$value."' ";
			else $sql.= " OR id= '".$value."' ";
			$i++;
		}
		$sql.= ") ORDER BY  bydate DESC";
		$rs_list = sql_list($sql);
	}
?>