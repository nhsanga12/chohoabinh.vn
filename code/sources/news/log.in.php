<?php
	require 'include/option.php';
	global $id,$config,$languages;
	
	
	if ($_POST['xlmb_usersname'] !='' && $_POST['xlmb_password']!='') {
		if($_SESSION['user']['errolog']>4){
			$msg .= "Bạn đã nhập sai 5 lần, vui lòng đợi sau 20 phút để đăng nhập lại.";
	
		}else{
			$sql = " SELECT password,fullname,usersid FROM ".$config['db_prefix']."_users WHERE usersname='".addslashes($_POST['xlmb_usersname'])."' LIMIT 0,1 ";
			$authchk	= sql_detail($sql);
			
			if(count($authchk)==0){
				$_SESSION['user']['errolog']++;
				$msg .= "Tên đăng nhập không tồn tại.<br />Nếu nhập sai 5 lần tài khoản sẽ bị tạm khóa. Bạn đã nhập sai ".$_SESSION['user']['errolog']." lần.";
				
				
			}else if (md5(md5(md5($_POST['xlmb_password']))) != $authchk[0]['password']) {
				$_SESSION['user']['errolog']++;
				$msg .=	"Mật khẩu không chính xác.<br />Nếu nhập sai 5 lần tài khoản sẽ bị tạm khóa. Bạn đã nhập sai ".$_SESSION['user']['errolog']." lần.";
				
			} else {
				$_SESSION['user']['login'] 		= 	true;
				$_SESSION['user']['name'] 		= 	$authchk[0]['fullname'];
				$_SESSION['user']['id'] 		= 	$authchk[0]['usersid'];
				
				saveIPuser($authchk[0]['usersid']);
			
				echo "<script language=\"javascript\">window.location.replace(\"".sys_link('com=home&target=main&category=62')."\")</script>";
			}
		}
	}
	
	
	
	$banner_right = news_by_cat(16,1,20);
	$danhmuc = categories_detail($id['category']);
	
?>