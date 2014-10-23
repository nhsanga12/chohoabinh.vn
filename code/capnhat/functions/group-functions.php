<?php

function group_list() {
	global $id, $config;
	
	$sql = " SELECT groupid,title,name
			 FROM ".$config['db_prefix']."_news_groups_detail 
			 WHERE language = '".$config['default_language']."' ORDER BY groupid ";
	$grouplist = sql_list($sql);
	return $grouplist;
}

function group_dt($grpid='') {
	global $id, $config;
	
	$sql = " SELECT groupid,title,name
			 FROM ".$config['db_prefix']."_news_groups_detail 
			 WHERE language = '".$config['default_language']."' ";
		
		if($grpid!='')
			 $sql .= " AND groupid = '".$grpid."' ";
			 
	$sql .= " ORDER BY groupid ";
	
	$grouplist = sql_list($sql);
	return $grouplist;
}

function group_plus($field='',$grp='') {
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

function group_minus($field='',$grp='') {
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

function group_select($select='') {
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

// ext: $test = chitietbangdon('subjects','tenmonhoc',2," AND mamon LIKE '%D%' ");
function chitietbangdon($tb,$select='id,bydate',$items='',$wherestr='') {
	global $id, $config;
	
	$sql = " SELECT ".$select."
			 FROM ".$config['db_prefix']."_".$tb." 
			 WHERE deleted = '0' ";
	if($items!=''){
		$sql .= " AND ".$tb."id = '".$items."' ";
	}
	
	if($wherestr!=''){
		$sql .= " ".$wherestr." ";
	}
	
	$sql .= " ORDER BY ".$tb."id ";
	
	$data = sql_list($sql);
	return $data;
}

function auto_setting($dt=''){
	global $id, $config;
	$sql = " SELECT au.autoid,au.actidate, au.bydate, tim.fromtime, tim.totime,tim.amount, tim.lastdate,tim.autotime
			 FROM ".$config['db_prefix']."_news_articles_auto au
			 LEFT JOIN  ".$config['db_prefix']."_news_articles_autotime tim ON au.autoid = tim.autoid 
			 WHERE au.deleted = '0' AND au.autotype = '1' AND au.article = '".$dt."'
			 ORDER BY tim.autotime
			";
	//echo $sql;
	$datas = sql_list($sql);
	return $datas;
}

function check_auto($dt=''){
	global $id, $config;
	$sql = " SELECT autoid
			 FROM ".$config['db_prefix']."_news_articles_auto
			 WHERE deleted = '0' AND autotype = '1' AND article = '".$dt."'
			";
	$sum = sql_exit($sql);
	if($sum>0) return true;
	else return false;
}
function getdateval($val,$str=''){ // 05:00 hoac 32989
	if($str==''){
		$kq = $val;
	}else{
		$gt0 = (int)strtotime(date("d-m-Y 00:00:00"));
		if($str=='H:i')
			$gt1 = (int)strtotime(date("d-m-Y ".$val.":00"));
		else
			$gt1 = (int)strtotime(date("d-m-Y ".$val));
		
		$kq = $gt1 - $gt0;
	}
	
	return $kq;
}
function taocackhoanthoigian($amount,$begini,$endi,$str=''){
	if($str==''){
		$minus = $endi - $begini;
		$kq = $begini;
	}else{
		$minus = getdateval($endi,$str) - getdateval($begini,$str);
		$kq = getdateval($begini,$str);
	}
		if($amount>0)
			$step = $minus/$amount;
		else
			$step = 0;
		$step = floor($step);
		 
		for($i=0;$i<$amount;$i++){
			$kq +=$step;
			if($i==0) $dau = ""; else $dau =",";
			$strkq .= $dau.(string)$kq; 
		}
	
	return $strkq;
}
function timsoganbang($numtr,$val){
	$numarr = explode(",",$numtr);
	//asort($numarr); không cần sort vì cấu trúc đã sort sẳn
	for($i=0;$i<count($numarr);$i++){
		$numup = (int)$numarr[$i];
		if($numup >= $val)
		return (int)$numarr[$i-1];
	}
}

function timhaisoganbang($numtr,$val){
	$numarr = explode(",",$numtr);
	//asort($numarr); không cần sort vì cấu trúc đã sort sẳn
	for($i=0;$i<count($numarr);$i++){
		$numup = (int)$numarr[$i];
		if($numup >= $val){
			$giatri[0] = (int)$numarr[$i-1];
			$giatri[1] = $numup;
			return $giatri;
		}
	}
}


?>