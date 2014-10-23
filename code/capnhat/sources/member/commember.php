<?php
	if ($id['option'] == "main") {
		$sql = "SELECT * FROM ".$config['db_prefix']."_commember WHERE ";
		$sql.= "firstname LIKE '%".addslashes($id['search'])."%' ";
		$sql.= " OR lastname LIKE '%".addslashes($id['search'])."%' ";
		$sql.= " OR title LIKE '%".addslashes($id['search'])."%' ";
		$sql.= " OR room LIKE '%".addslashes($id['search'])."%' ";
		$sql.= " OR email LIKE '%".addslashes($id['search'])."%' ";
		$sql.= " OR telephone LIKE '%".addslashes($id['search'])."%' ";
		$sql.= " OR handphone LIKE '%".addslashes($id['search'])."%' ";
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
			if ($_POST['lastname'] == '') $msg = 'Vui lòng nhập tên của bạn !';
			if ($_POST['password'] == '' || $_POST['password']!=$_POST['repassword']) $msg = 'Mật khẩu chưa có hoặc chưa giống nhau!';
			if ($msg == '') {
				$rs['firstname']		=	$_POST['firstname'];
				$rs['lastname']			=	$_POST['lastname'];
				$rs['gender']			=	$_POST['gender'];
				$rs['picture']	=	sys_uploads('../lib/files/','picture','gif|jpg|png|bmp|dib|jpeg|jpe|jfifi|tif|tiff|GIF|JPG|PNG|BMP|DIB|JPEG|JPE|JFIFI|TIF|TIFF');
				$rs['title']			=	$_POST['title'];
				$rs['room']				=	$_POST['room'];
				$rs['email']			=	$_POST['email'];
				$rs['telephone']		=	$_POST['telephone'];
				$rs['handphone']		=	$_POST['handphone'];
				if ($_POST['password'] != '') $rs['password']	=	md5(md5(md5($_POST['password'])));
				$rs['address']			=	$_POST['address'];
				$rs['district']			=	$_POST['district'];
				$rs['city']				=	$_POST['city'];
				$rs['thuongtru']		=	$_POST['thuongtru'];
				$rs['tinhthanh']		=	$_POST['tinhthanh'];
				$rs['bday']				=	$_POST['bday'];
				$rs['bmonth']			=	$_POST['bmonth'];
				$rs['byear']			=	$_POST['byear'];
				$rs['adday']			=	$_POST['adday'];
				$rs['admonth']			=	$_POST['admonth'];
				$rs['adyear']			=	$_POST['adyear'];
				$rs['cmnd']				=	$_POST['cmnd'];
				$rs['status']			=	$_POST['status'];
				$rs['membergroup']		=	$_POST['membergroup'];
				$rs['detail']			=	$_POST['detail'];
				$rs['sothich']			=	$_POST['sothich'];
				$rs['lastdate']			=	time();		
				$rs['bydate']			=	time();
				$rs['status']			=	'2';	
				$newid = sql_add('commember',$rs);
				$msg = 'Đã thêm thành công <strong>'.$_POST['firstname'].' '.$_POST['lastname'].'</strong>';
			}
		}
	}
	if ($id['option'] == "edit") {
		if ($_POST['submit']) {
		$rsk['id']		=	$id['item'];
				$rs['firstname']		=	$_POST['firstname'];
				$rs['lastname']			=	$_POST['lastname'];
				$rs['gender']			=	$_POST['gender'];
				$npic					=	sys_uploads('../lib/files/','picture','gif|jpg|png|bmp|dib|jpeg|jpe|jfifi|tif|tiff|GIF|JPG|PNG|BMP|DIB|JPEG|JPE|JFIFI|TIF|TIFF');
				if ($npic != '') {
					$rs['picture'] = $npic;
					@unlink('../lib/files/'.$_POST['old_picture']);
				}
				$rs['title']			=	$_POST['title'];
				$rs['room']				=	$_POST['room'];
				$rs['email']			=	$_POST['email'];
				$rs['telephone']		=	$_POST['telephone'];
				$rs['handphone']		=	$_POST['handphone'];
				
				if ($_POST['password'] != '') 
				$rs['password']	=	md5(md5(md5($_POST['password'])));
				
				$rs['address']			=	$_POST['address'];
				$rs['district']			=	$_POST['district'];
				$rs['city']				=	$_POST['city'];
				$rs['thuongtru']		=	$_POST['thuongtru'];
				$rs['tinhthanh']		=	$_POST['tinhthanh'];
				$rs['bday']				=	$_POST['bday'];
				$rs['bmonth']			=	$_POST['bmonth'];
				$rs['byear']			=	$_POST['byear'];
				$rs['adday']			=	$_POST['adday'];
				$rs['admonth']			=	$_POST['admonth'];
				$rs['adyear']			=	$_POST['adyear'];
				$rs['cmnd']				=	$_POST['cmnd'];
				$rs['status']			=	$_POST['status'];
				$rs['membergroup']		=	$_POST['membergroup'];
				$rs['detail']			=	$_POST['detail'];
				$rs['sothich']			=	$_POST['sothich'];
				$rs['lastdate']			=	time();		
		sql_update('commember',$rs,$rsk); 
		$msg = 'Đã cập nhật thành công <strong>'.$_POST['firstname'].' '.$_POST['lastname'].'</strong>';
		}
		$sql = "SELECT a.* FROM ".$config['db_prefix']."_commember a ";
		$sql.= "WHERE a.id = '".$id['item']."' ";
		$detail = sql_detail($sql);
	}
	if ($id['option'] == 'delete') {
		$sql = "SELECT * FROM ".$config['db_prefix']."_commember ";
		$sql.= "WHERE (";
		$item = explode(",",$id['item']);
		$i = 0;
		if ($_POST['submit']) {
			while (list($key,$value)=each($item)) {
				$rsk['id']			=	$value;
				sql_delete('commember',$rsk);
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