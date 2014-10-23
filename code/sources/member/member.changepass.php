<?php
	global $id,$config,$pages;
	require 'include/option.php';
	
	if($_SESSION['user']['login'])
		$memberdt =  member_dt($_SESSION['user']['id']);
	else
		$memberdt = array();
	
	if(isset($_POST['luulai'])){
		$pasold = md5(md5(md5($_POST['password_old'])));
		$sql = " SELECT usersid FROM ".$config['db_prefix']."_users WHERE password ='".$pasold."' LIMIT 0,1 ";
		$authchk	= sql_detail($sql);
		
		if($_POST['password'] != $_POST['repassword']){
			$msg .= 'Mật khẩu nhập lại không giống mật khẩu mới.';
		
		}else if($memberdt[0]['password']=='' && $_POST['password']!='' && $_POST['repassword']!='' && $_POST['password'] == $_POST['repassword']){
			$msg .= 'Mật khẩu đã thay đổi thành công.';
			$ok = 1;
			
		
		}else if($_POST['password']!='' && $_POST['repassword']!='' && $_POST['password'] == $_POST['repassword'] && $_POST['password_old']!='' && count($authchk)>0){
			$msg .= 'Mật khẩu đã thay đổi thành công.';
			$ok = 1;
			
		}else if($memberdt[0]['password']!='' && $_POST['password_old']==''){
			$msg .= 'Vui lòng nhập mật khẩu cũ.';
		
		}else if($_POST['password_old']!='' && count($authchk)==0){
			$msg .= 'Mật khẩu cũ không chính xác.';
		
		}else if($_POST['password']=='' || $_POST['repassword']==''){
			$msg .= 'Vui lòng không để trống các ô dưới.';
		
		}else{
			$msg = '';
		}
		
		if($ok == 1){
			$row['password'] = md5(md5(md5($_POST['password'])));
			$where['usersid'] = $_SESSION['user']['id'];
			sql_update('users',$row,$where);
		}
	}
	
?>