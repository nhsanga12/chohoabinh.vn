<?php

function users_list() {
	global $config;
	$sql = " SELECT fullname,usersname,usersid,email,memkey
			 FROM ".$config['db_prefix']."_users
			 WHERE deleted = 0 AND acti = '1'
			 ORDER BY usersid ";
	$userslist = sql_list($sql);
	return $userslist;
}

function users_where($select='u.fullname,u.id',$where='',$oder='') {
	global $id, $config;
	$sql = " SELECT ".$select."
			 FROM ".$config['db_prefix']."_users u
			 LEFT JOIN ".$config['db_prefix']."_users_detail dt ON dt.usersid = u.usersid
			 WHERE u.deleted = 0 AND u.acti = '1' ";
	if($where!='')
		$sql .= $where;
		
	if($oder!='')
		$sql .= " ORDER BY ".$oder." ";
	else
		$sql .= " ORDER BY u.usersid ";
		
	$userslist = sql_list($sql);
	return $userslist;
}

function users_more($moretb='detail',$select='') {	
}

function users_history_update($field='',$grp='') {
	global $id, $config;
	
	$sql = "INSERT INTO xalomuaban.".$config['db_prefix']."_users_history
			(`usersid`, `tablename`, `fieldname`, `old_str`, `new_str`, `old_text`, `new_text`, `bydate`, `deleted`)
	 VALUES ('1', 'bank', 'abc', 'abc', 'cde', NULL, NULL, '878787878', '0');";
	
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