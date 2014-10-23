<?php
	require 'include/option.php';
	global $id,$config,$languages;
	$banner_right = news_by_cat(16,1,20);
	
	$danhmuc = categories_detail($id['category']);
	$xacnhan = '';
	
	if(isset($_REQUEST['q'])){
		$data = explode("-",$_REQUEST['q']);
		$sql = " SELECT usersname,usersid,email,acti FROM ".$config['db_prefix']."_users WHERE bydate='".addslashes($data[1])."' ";
		$sumacti	= sql_detail($sql);
		for($p=0;$p<count($sumacti);$p++){
			if(md5($sumacti[$p]['email'])==$data[0] && $sumacti[$p]['acti']==''){
				$row['acti']=time();
				$where['usersid'] = $sumacti[$p]['usersid'];
				sql_update("users",$row,$where);
				$xacnhan = ' Xác nhận đăng ký thành công !';
			}
		}
	}
	
?>