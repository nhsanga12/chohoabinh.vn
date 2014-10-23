<?php

function SaveHistory($iduser,$table,$field,$str_old,$str_new) {
	$row['usersid'] = $iduser;
	$row['tablename'] = $table;
	$row['fieldname'] = $field;
	if($field=='description' || $field=='contents'){
		$row['old_text'] = $str_old;
		$row['new_text'] = $str_new;
	}else{
		$row['old_str'] = $str_old;
		$row['new_str'] = $str_new;
	}
	$row['bydate'] = time();
	sql_add('users_history',$row);
}

function saveIPuser($iduser) {
	global $id, $config;
	
	$dt = member_dt($iduser);
	$row['loginip'] = getRealIpAdd();
	SaveHistory($iduser,'users_detail','loginip',$dt[0]['loginip'],$row['loginip']);
	
	$where['usersid'] = $iduser;
	
	if(check_user_dt($iduser))
		sql_update('users_detail',$row,$where);
	else{
		$row['usersid'] = $iduser;
		sql_add('users_detail',$row);
	}
}

function bank_list($iduser) {
	global $id, $config;
	
	$sql = " SELECT *
			 FROM ".$config['db_prefix']."_users_bank 
			 WHERE deleted = '0' AND usersid = '".$iduser."' ORDER BY bankid ";
	$banklist = sql_list($sql);
	return $banklist;
}

function member_list() {
	global $id, $config;
	
	$sql = " SELECT fullname,id,name
			 FROM ".$config['db_prefix']."_news_groups_detail 
			 WHERE language = '".$config['default_language']."' ORDER BY groupid ";
	$grouplist = sql_list($sql);
	return $grouplist;
}

function users_comment($ids) {
	global $id, $config;
	$sql = " SELECT sms.contents,sms.dienthoai,sms.email,sms.bydate,
					u.fullname,u.profile_image,u.oauth_provider
			 FROM ".$config['db_prefix']."_users_sms sms
			 LEFT JOIN ".$config['db_prefix']."_users u ON u.usersid = sms.fromuser
			 WHERE sms.deleted <> '1' AND sms.article = '".$ids."' ORDER BY sms.bydate ";
	$sms = sql_list($sql);
	return $sms;
}

function member_dt($memid='1') {
	global $id, $config;
	
	$sql = " SELECT us.*,dt.*
			 FROM ".$config['db_prefix']."_users us
			 LEFT JOIN ".$config['db_prefix']."_users_detail dt ON dt.usersid = us.usersid
			 WHERE us.usersid = '".$memid."' LIMIT 0,1 ";
	$users = sql_list($sql);
	return $users;
}
function check_user_dt($memid='1') {
	global $id, $config;
	$sql = " SELECT * FROM ".$config['db_prefix']."_users_detail
			 WHERE usersid = '".$memid."' LIMIT 0,1 ";
	$users = sql_exit($sql);
	if($users>0)
	 	return true;
	else
		return false;
}

function member_plus($field='',$grp='') {
	global $id, $config;
	
	if($field!='' && $grp!=''){
		$sqlf = " SELECT ".$field." FROM ".$config['db_prefix']."_news_groups WHERE id ='".$grp."' LIMIT 0,1 "; 
		$rs = @mysql_query($sqlf);
		$temp = @mysql_fetch_array($rs);
		
		$newdata = (int)$temp[$field] + 1;
		
		$sqlu = " UPDATE ".$config['db_prefix']."_news_groups SET ".$field."='".$newdata."' WHERE id ='".$grp."' "; 
		$rs = @mysql_query($sqlu);
		//return true;
	}//else return false;
	
}

function member_minus($field='',$grp='') {
	global $id, $config;
	
	if($field!='' && $grp!=''){
		$sqlf = " SELECT ".$field." FROM ".$config['db_prefix']."_news_groups WHERE id ='".$grp."' LIMIT 0,1 "; 
		$rs = @mysql_query($sqlf);
		$temp = @mysql_fetch_array($rs);
		
		$newdata = (int)$temp[$field] - 1;
		
		$sqlu = " UPDATE ".$config['db_prefix']."_news_groups SET ".$field."='".$newdata."' WHERE id ='".$grp."' "; 
		$rs = @mysql_query($sqlu);
		return true;
	}else return false;
}

function member_select($select='') {
	global $id, $config; $str = '';
	$sql = " SELECT groupid,title
			 FROM ".$config['db_prefix']."_news_groups_detail 
			 WHERE language = '".$config['default_language']."' ";
			
			 if($_SESSION['auth']['group']!= 1){
			 	$sql .=" AND groupid = '".$_SESSION['auth']['group']."' ";
			 }
			 
	$sql .=" ORDER BY groupid ";
	
	$grouplist = sql_list($sql);
	
	for($i=0;$i<count($grouplist);$i++){
		if($grouplist[$i]['groupid']==$select) $sltr = ' selected="selected"'; else $sltr ='';
		$str .= "<option value=\"".$grouplist[$i]['groupid']."\" label=\"".$grouplist[$i]['title']."\"".$sltr.">".$grouplist[$i]['title']."</option>";
	}
	
	echo $str;
}

?>