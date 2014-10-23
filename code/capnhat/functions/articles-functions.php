<?php
function getnews($cat,$groupid=1,$limit=0) {
	global $id, $config, $pages, $str;
	
	$sql = " SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai,detail.thuonghieu,detail.local,grp.id AS news_groups, detail.quick, detail.contents, art.lastdate ,art.status,art.opt, art.likes
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' 
	         AND ( art.status = '3' OR art.status = '2') ";
	$sql.= " AND ( art.category= '".$cat."";
	$str = '';
			
	categories_child($cat,$groupid);
	
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}

function news_detail($dt,$bycat=0) {
	global $id,$config;
	$sql = " SELECT art.id, art.picture, art.likes,art.opt,art.usersid,art.comments,art.amountap,detail.title, detail.loaitien, detail.gia, detail.giacu, detail.local, detail.khuyenmai, detail.ma, detail.seotit, detail.seodes, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate 
			 FROM ".$config['db_prefix']."_news_crawler art 
			 RIGHT JOIN ".$config['db_prefix']."_news_crawler_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid  
			 WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR  art.status = '3') AND art.id = '".$dt."'";
	if($bycat!=0)	$sql.= " AND art.category = '".$bycat." '  ";
	$detail = sql_detail($sql);
	
	### KỸ THUẬT SEO CHO NỘI DUNG WEBSITE
	$azz = explode(",",$config['seokey']); 
	for($m=0;$m<count($azz);$m++){
		$cache = explode(":",$azz[$m]);
		$arr[$m] = $cache[0];
		$links[$m] = $cache[1];
	};
	
	$value = $detail[0]['contents'];
	$value1 = $detail[0]['quick'];
	
	for ( $z = 0; $z < count($arr); $z ++):
		$value = str_replace($arr[$z],'<a href="'.$config['url'].$links[$z].' target="_bank" class="seo" style="color:##3399FF">'.$arr[$z].'</a>',$value);
		$value1 = str_replace($arr[$z],'<a href="'.$config['url'].$links[$z].' target="_bank" class="seo" style="color:##3399FF">'.$arr[$z].'</a>',$value1);	
	endfor;
	$detail[0]['contents'] = $value;
	$detail[0]['quick'] = $value1;
	### KẾT THÚC
	
	return $detail;
}

function getvipro($keyvip='',$types ='',$sum=10) {
	global $id,$config;
	$sql = " SELECT b.*, d.gia,d.loaitien,a.category,a.id
			 FROM ".$config['db_prefix']."_banner b
			 LEFT JOIN ".$config['db_prefix']."_news_articles_detail d ON d.article = b.articles
			 LEFT JOIN ".$config['db_prefix']."_news_articles a ON a.id = b.articles
			 WHERE b.deleted = '0' AND b.status = '1' AND b.disto >= b.disfrom AND b.disfrom <= ".strtotime(date("Y")."-".date("m")."-".date("d"))." AND b.disto >= ".strtotime(date("Y")."-".date("m")."-".date("d"))." 
			 	   AND b.vitri LIKE '".$keyvip."%' ";
	if($types !='')
		$sql .= " AND b.types = '".$types."' ";
	
	$sql .= " ORDER BY b.lastdate DESC ";
	
	$rs = @mysql_query($sql);
	$i = 0;
	while ($temp = @mysql_fetch_array($rs)) {
		$vitri = str_replace($keyvip." ","",$temp['vitri']);
		while (list($key,$value) = each($temp)) {
			$records[$vitri][$key] = $value;
		}
		$i++;
	}
	return $records;
}

function count_msg($memberid='',$types ='') {
	global $id,$config;
	$sql = " SELECT s.id
			 FROM ".$config['db_prefix']."_users_sms s
			 LEFT JOIN ".$config['db_prefix']."_users u ON u.usersid = s.usersid
			 WHERE s.deleted = '0' AND u.deleted = '0' AND s.status = '0' ";
	if($types!=''){
		$sql .= " AND s.typesms = '".$types."' "; 
	}
	
	$sql.= " AND u.usersid= '".$memberid."' ";
	if($memberid!='')
		$count = sql_exit($sql);
	return $count;
}

function msg_detail($smgid=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT s.id,s.title,s.contents, s.fromuser, u.usersname as touser
			 FROM ".$config['db_prefix']."_users_sms s
			 LEFT JOIN ".$config['db_prefix']."_users u ON u.usersid = s.fromuser
			";
	$sql.= " WHERE s.deleted = '0' ";
	$sql.= " AND s.id = '".$smgid."' ";
	$sql.= " ORDER BY s.bydate DESC ";
	$news_articles = sql_list($sql);
	return $news_articles;
}


function msg_list($memberid=0,$limit=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT s.id,s.title,s.contents,s.bydate,u.fullname,u.oauth_provider
			 FROM ".$config['db_prefix']."_users_sms s
			 LEFT JOIN ".$config['db_prefix']."_users u ON u.usersid = s.fromuser
			 
			  ";
	$sql.= " WHERE s.deleted = '0' AND u.deleted = '0' ";
	$sql.= " AND s.usersid= '".$memberid."' AND s.typesms = '2' ";
	$sql.= " ORDER BY s.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}


function comment_of_pro($memberid=0,$limit=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT s.id as idsmg,s.contents,s.bydate,s.dienthoai,s.email,s.fromuser,u.fullname,u.usersname,u.oauth_provider,
				art.picture,dt.title,art.id,art.category
			 FROM ".$config['db_prefix']."_users_sms s
			 LEFT JOIN ".$config['db_prefix']."_news_articles art ON art.id = s.article  
			 LEFT JOIN ".$config['db_prefix']."_news_articles_detail dt ON dt.article = s.article
			 LEFT JOIN ".$config['db_prefix']."_users u ON u.usersid = s.fromuser
			 
			  ";
	$sql.= " WHERE s.deleted = '0' AND art.deleted = '0' ";
	$sql.= " AND art.usersid= '".$memberid."' AND s.typesms = '1' ";
	$sql.= " ORDER BY s.article,s.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}



function order_of_mem($memberid=0,$limit=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT bs.users_buysellid,bs.description, bs.amount,
				u.fullname,u.email,ud.phone,ud.address,bs.bydate as ngaydat,
				art.picture,art.category,art.lastdate, art.status, art.bydate,
			 	dt.title,  dt.loaitien, dt.gia, dt.giacu, dt.quick, dt.contents 
			 FROM ".$config['db_prefix']."_users_buysell bs
			 LEFT JOIN ".$config['db_prefix']."_news_articles art ON art.id = bs.article  
			 LEFT JOIN ".$config['db_prefix']."_news_articles_detail dt ON dt.article = bs.article
			 LEFT JOIN ".$config['db_prefix']."_users u ON u.usersid = bs.userbuy
			 LEFT JOIN ".$config['db_prefix']."_users_detail ud ON ud.usersid = bs.userbuy
			 
			  ";
	$sql.= " WHERE bs.deleted = '0' AND art.deleted = '0' AND u.deleted ='0' ";
	$sql.= " AND bs.usersid= '".$memberid."' ";
	$sql.= " ORDER BY bs.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}

function banner_detail($banerid,$sta=0) {
	global $id,$config;
	$sql = " SELECT b.*
			 FROM ".$config['db_prefix']."_banner b
			 WHERE b.deleted = '0' AND b.bannerid = '".$banerid."' ";
	if($sta==1)
	$sql .= " AND b.status = '1' ";// chỉ tính tình trạng hoạt động
	
	$sql .= " ORDER BY b.lastdate DESC ";
	
	$news_articles = sql_list($sql);
	return $news_articles;
}



function banner_calender($local,$form=0,$to=0) {
	global $id, $config;
	
	$sql = " SELECT b.* FROM ".$config['db_prefix']."_banner b ";
	$sql.= " WHERE b.deleted = '0' AND b.status = '1' ";
	$sql.= " AND b.vitri like '%".trim($local)."' 
			 AND b.disto > b.disfrom AND b.disto <= ".$to." AND b.disfrom >= ".$form." ";
	$sql.= " ORDER BY b.bydate DESC ";
	$news_articles = sql_list($sql);
	$data = array();
	
	for($m=0;$m<count($news_articles);$m++){
		for($d=$form;$d<=$to;$d=$d+86400){
			if($d>=(int)$news_articles[$m]['disfrom'] && $d<=(int)$news_articles[$m]['disto'])
			array_push($data,$d);
			
		}
	}
	return $data;
}


function check_banner_local($bannerid){
	if($bannerid!=''){
		$data = banner_detail($bannerid);
		$sql = " SELECT bannerid
			 	 FROM ".$config['db_prefix']."_banner
			 	 WHERE deleted = '0' AND status = '1' AND bannerid <> '".$bannerid."'  
				   AND disto >= disfrom AND disfrom <= ".strtotime(date("Y")."-".date("m")."-".date("d"))." AND disto >= ".strtotime(date("Y")."-".date("m")."-".date("d"))." 	   AND vitri LIKE '".$data[0]['vitri']."'
			 	 ORDER BY vitri ";
		if(sql_exit($sql)>0)
			return false;
		else
			return true;
		
	}else
		return true;
}

function banner_of_mem($memberid=0,$limit=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT b.*, IF(b.disto< ".strtotime(date("Y")."-".date("m")."-".date("d")).",1,0) AS hanchay
			 FROM ".$config['db_prefix']."_banner b 
			 ";
	$sql.= " WHERE b.deleted = '0' ";
	$sql.= " AND b.usersid= '".$memberid."' ";
	$sql.= " ORDER BY hanchay,b.vitri ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}
function count_banner_of_mem($memberid=0) {
	global $id, $config;
	$sql = " SELECT b.* 
			 FROM ".$config['db_prefix']."_banner b 
			 ";
	$sql.= " WHERE b.deleted = '0' ";
	$sql.= " AND b.usersid= '".$memberid."' ";
	$sql.= " ORDER BY b.disfrom DESC ";
	
	$count = sql_exit($sql);
	return $count;
}


function pro_of_mem($memberid=0,$limit=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT art.id, art.picture,art.category,art.lastdate, art.status, art.bydate,
			 detail.title,  detail.loaitien, detail.gia, detail.giacu, detail.quick, detail.contents 
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' AND art.deleted = '0' ";
	$sql.= " AND art.usersid= '".$memberid."' ";
	$sql.= " ORDER BY art.state_p, art.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}
function pro_of_mem_full($memberid=0,$limit=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT art.id, art.picture,art.category,art.lastdate, art.status, art.bydate,
			 art.likes, art.comments,art.opt,
			 detail.title,  detail.loaitien, detail.gia, detail.giacu, detail.quick, detail.contents
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' AND art.deleted = '0' ";
	$sql.= " AND art.usersid= '".$memberid."' AND ( art.status = '2' OR  art.status = '3') ";
	$sql.= " ORDER BY art.state_p, art.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}

function count_pro_of_mem($memberid=0) {
	global $id, $config, $pages;
	
	$sql = " SELECT art.id
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' AND art.deleted = '0' ";
	$sql.= " AND art.usersid= '".$memberid."' ";
	$sql.= " ORDER BY art.state_p, art.bydate DESC ";
	
	$count = sql_exit($sql);
	return $count;
}


function update_viewer($ids,$amounts){
	global $id, $config;
	$sql = "  UPDATE ".$config['db_prefix']."_news_articles SET opt = '".$amounts."' WHERE id = '".$ids."' ";
	@mysql_query($sql);
	return true;
}

function search_pro($cat='',$giatu='',$dengia='',$location='',$key='',$today=0,$fromdate=0,$groupid=1,$limit=0) {
	global $id, $config, $pages, $news_articles, $str;
	$thu = 1+(int)date('N');
	$sql = " SELECT art.id, art.picture, art.opt,art.bydate, art.likes, art.comments, art.usersid,
				detail.title, art.category, detail.ma, detail.loaitien,
			 	detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate, us.fullname, us.acti, dt.phone,dt.address,dt.vip
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid 
			 
			 LEFT JOIN ".$config['db_prefix']."_users us ON us.usersid = art.usersid 
			 LEFT JOIN ".$config['db_prefix']."_users_detail dt ON dt.usersid = art.usersid ";
			 
	$sql.= " WHERE detail.language = '".$config['default_language']."' AND art.deleted = '0' AND ( art.status = '2' OR  art.status = '3') ";
	$sql.= " AND art.bydate > ".$fromdate." AND art.bydate <= ".$today." ";
	
	if($cat!=''){
		$sql.= " AND ( art.category= '".$cat."";
		$str = '';
		categories_child($cat,$groupid);
		if ($str != '') {
			$str = str_replace(',',"' OR art.category = '",$str);
		}
		$str.= "'";
		$sql.= $str." ) ";
	}
	
	if($key!=''){
		$sql.= " AND detail.title LIKE '%".$key."%' ";
	}
	
	if($location!=''){
		$sql.= " AND detail.local = '".$location."' ";
	}
	
	if($giatu!='')
	$sql.= " AND detail.gia >= '".$giatu."' ";
	
	if($dengia!= '' )
	$sql.= " AND detail.gia < '".$dengia."' ";
	
	$sql.= " ORDER BY art.bydate DESC ";
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	$news_articles = sql_list($sql);
	//echo $sql;
	return $news_articles;
}

function search_pro2($cat='',$giatu='',$dengia='',$location='',$key='',$groupid=1,$limit=0) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = " SELECT art.id, art.picture, art.opt,art.bydate, art.likes, art.comments, detail.title, art.category, detail.ma, detail.loaitien,
			 	detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate, us.fullname, us.acti, dt.phone,dt.address,dt.vip
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid 
			 
			 LEFT JOIN ".$config['db_prefix']."_users us ON us.usersid = art.usersid 
			 LEFT JOIN ".$config['db_prefix']."_users_detail dt ON dt.usersid = art.usersid ";
			 
	$sql.= " WHERE detail.language = '".$config['default_language']."' AND art.deleted = 0 AND ( art.status = '2' OR  art.status = '3') ";
	
	if($cat!=''){
		$sql.= " AND ( art.category= '".$cat."";
		$str = '';
		categories_child($cat,$groupid);
		if ($str != '') {
			$str = str_replace(',',"' OR art.category = '",$str);
		}
		$str.= "'";
		$sql.= $str." ) ";
	}
	
	if($key!=''){
		$sql.= " AND detail.title LIKE '%".$key."%' ";
	}
	
	if($location!=''){
		$sql.= " AND detail.local = '".$location."' ";
	}
	
	if($giatu!='')
	$sql.= " AND detail.gia >= '".$giatu."' ";
	
	if($dengia!= '' )
	$sql.= " AND detail.gia < '".$dengia."' ";
	
	$sql.= " ORDER BY art.state_p, art.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	$news_articles = sql_list($sql);
	//echo $sql;
	return $news_articles;
}

function articles_detail($dt,$bycat=0) {
	global $id,$config;
	$sql = " SELECT art.id, art.picture, art.likes,art.opt,art.usersid,art.comments,art.amountap,detail.title, detail.loaitien, detail.gia, detail.giacu, detail.local, detail.khuyenmai, detail.ma, detail.seotit, detail.seodes, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate 
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid  
			 WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR  art.status = '3') AND art.id = '".$dt."'";
	if($bycat!=0)	$sql.= " AND art.category = '".$bycat." '  ";
	$detail = sql_detail($sql);
	
	### KỸ THUẬT SEO CHO NỘI DUNG WEBSITE
	$azz = explode(",",$config['seokey']); 
	for($m=0;$m<count($azz);$m++){
		$cache = explode(":",$azz[$m]);
		$arr[$m] = $cache[0];
		$links[$m] = $cache[1];
	};
	
	$value = $detail[0]['contents'];
	$value1 = $detail[0]['quick'];
	
	for ( $z = 0; $z < count($arr); $z ++):
		$value = str_replace($arr[$z],'<a href="'.$config['url'].$links[$z].' target="_bank" class="seo" style="color:##3399FF">'.$arr[$z].'</a>',$value);
		$value1 = str_replace($arr[$z],'<a href="'.$config['url'].$links[$z].' target="_bank" class="seo" style="color:##3399FF">'.$arr[$z].'</a>',$value1);	
	endfor;
	$detail[0]['contents'] = $value;
	$detail[0]['quick'] = $value1;
	### KẾT THÚC
	
	return $detail;
}


function new_cat($cat,$groupid=1,$limit=0) {
	global $id, $config, $pages, $str;
	
	$sql = " SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai,detail.thuonghieu, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate, art.status
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' 
	         AND art.status = '3' ";
	$sql.= " AND ( art.category= '".$cat."";
	$str = '';
			
	categories_child($cat,$groupid);
	
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	$news_articles = sql_list($sql);
	return $news_articles;
}

function normal_cat($cat,$groupid=1,$limit=0) {
	global $id, $config, $pages, $str;
	
	$sql = " SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai, detail.thuonghieu, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate ,art.status
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' 
	         AND art.status = '2' ";
	$sql.= " AND ( art.category= '".$cat."";
	$str = '';
			
	categories_child($cat,$groupid);
	
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	$news_articles = sql_list($sql);
	return $news_articles;
}

function news_by_cat($cat,$groupid=1,$limit=0) {
	global $id, $config, $pages, $str;
	
	$sql = " SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai,detail.thuonghieu,detail.local,grp.id AS news_groups, detail.quick, detail.contents, art.lastdate ,art.status,art.opt, art.likes
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' 
	         AND ( art.status = '3' OR art.status = '2') ";
	$sql.= " AND ( art.category= '".$cat."";
	$str = '';
			
	categories_child($cat,$groupid);
	
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}

function newnews($cat,$groupid=1,$limit=0) { //hot news
	global $id, $config, $pages, $str;
	
	$sql = " SELECT art.id, art.picture, detail.title, art.category, art.likes, detail.loaitien, detail.gia, detail.khuyenmai,detail.thuonghieu,detail.local,grp.id AS news_groups, detail.quick, detail.contents, art.lastdate ,art.status,art.opt
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  
			 RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= " WHERE detail.language = '".$config['default_language']."' 
	         AND ( art.status = '3' OR art.status = '2') ";
	$sql.= " AND ( art.category= '".$cat."";
	$str = '';
			
	categories_child($cat,$groupid);
	
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.likes DESC,art.opt DESC, art.lastdate DESC ";
	
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$news_articles = sql_list($sql);
	return $news_articles;
}

function listarticle($artid,$limit=10){ // chi tiet cac bai viet chi dinh
	global $config;
	$arrayid = explode(',',$artid);
	$osql = ',';
	for($m=count($arrayid)-1;$m>=0;$m--){
		$osql .= " IF(art.id='".$arrayid[$m]."',".$m.",";
		$end .= ')';
	}
	
	$osql = $osql.count($artid).$end.' AS thutu ';
	
	$sql = " SELECT art.id, art.picture, art.opt,art.bydate, art.likes, art.usersid, detail.title, art.category, detail.ma, detail.loaitien, detail.gia, detail.quick, detail.contents, art.lastdate, us.fullname, us.acti, dt.phone,dt.address,dt.vip ".$osql."
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article
			 LEFT JOIN ".$config['db_prefix']."_users us ON us.usersid = art.usersid 
			 LEFT JOIN ".$config['db_prefix']."_users_detail dt ON dt.usersid = art.usersid 
			 
			 WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '3' )
			 AND art.id IN ('".str_replace(",","','",$artid)."') ORDER BY thutu DESC
			 ";
			 
	if($limit==0){
		$pages['rs']		=	sql_exit($sql);
		$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
		$pages['current']	=	$id['page'] ? $id['page'] : 1;
		$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
		$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	}else{
		$sql.= "LIMIT 0,".$limit;
	}
	
	//echo $sql;
	$listarticle = sql_list($sql);
	return $listarticle;
}


function listart_by_listcat($listcat,$limit=10){ // cac bai viet cua cac danh muc
	global $config;
	$sql = " SELECT art.id, art.groupid, art.picture, art.status, art.category, art.bydate,
					detail.title, detail.contents, detail.quick
			 FROM ".$config['db_prefix']."_news_articles art 
			 RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			 WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '3' )
			 AND art.category IN ('".str_replace(",","','",$listcat)."') ORDER BY art.status DESC, art.bydate DESC
			 LIMIT 0,".$limit."
			 ";
	$listarticle = sql_list($sql);
	return $listarticle;
}





//cập nhật ngày 08 tháng 06 2010
function hot_by_cat($cat) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, art.hot, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '0' ) AND ( art.hot = '1') AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.bydate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_p']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_p'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_p'];
	$news_articles = sql_list($sql);
	return $news_articles;
}


function other_by_cat($cat,$deta=0) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '0' OR art.status = '2') AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) AND detail.id <> '".$deta."' ORDER BY art.state_p, art.bydate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	$news_articles = sql_list($sql);
	return $news_articles;
}

function new_by_cat($cat) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '0') AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
	$pages =array();
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	$news_articles = sql_list($sql);
	return $news_articles;
}

function thuonghieu_by_cat($cat=0,$thuonghieu=0) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND detail.thuonghieu = '".$thuonghieu."' AND ( art.status = '0' OR art.status = '2') AND ( ";
		$sql.= " art.category = '".$cat."";
		$str = '';
		categories_child($cat,1);
		if ($str != '') {
			$str = str_replace(',',"' OR art.category = '",$str);
		}
		$str.= "'";
	
	$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	$news_articles = sql_list($sql);
	return $news_articles;
}

function list_by_thuonghieu($thuonghieu) {
	global $id, $config, $pages, $news_articles;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, detail.loaitien, detail.gia, detail.khuyenmai, detail.thuonghieu, catdt.title,
					detail.quick, detail.contents, art.lastdate 
			FROM ".$config['db_prefix']."_news_articles art 
			RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article 
			RIGHT JOIN ".$config['db_prefix']."_news_categories_detail catdt ON catdt.category = art.category  
			WHERE detail.language = '".$config['default_language']."' AND catdt.language = '".$config['default_language']."' AND ( art.status = '0' OR art.status = '2') AND detail.thuonghieu = '".$thuonghieu."' ";
	
	$sql.= " ORDER BY art.state_p, art.bydate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_news']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_news'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_news'];
	$news_articles = sql_list($sql);
	return $news_articles;
}


function art_deta($dt,$bycat=0) {
	global $id,$config;
	$sql = "SELECT art.id, art.picture, detail.title, detail.loaitien, detail.gia, detail.khuyenmai, detail.ma, detail.seotit, detail.seodes, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid  WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR  art.status = '0') AND art.id = '".$dt."'";
	if($bycat!=0)	$sql.= "AND art.category = '".$bycat." '  ";
	$detail = sql_detail($sql);	
	return $detail;
}


function articles_by_cat_d($cat,$item,$k) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, detail.loaitien,  detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND art.status = '2' AND art.id ".$k." ".$item." AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	if ($k=='<') $temp='DESC'; else $temp='ASC';
	$sql.= $str." ) ORDER BY art.bydate ".$temp." ";
	$sql.= "LIMIT 1";
	$news_articles = sql_list($sql);
	return $news_articles;
}
function articles_by_cat($cat) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, art.state_p, detail.ma,detail.loaitien, detail.gia, detail.khuyenmai, art.bydate, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '0' ) AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_p']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_p'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_p'];
	$news_articles = sql_list($sql);
	return $news_articles;
}
function articles_by_cat_opt($cat=3,$opt=0) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, detail.loaitien,  detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND art.status = '2' AND art.opt = '".$opt."' AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.bydate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_4p']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_4p'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_4p'];
	$news_articles = sql_list($sql);
	return $news_articles;
}
function articles_by_cat_rand($idn,$count) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, detail.loaitien,  detail.gia, detail.khuyenmai, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND art.status = '2' AND ( ";
	$sql.= " art.category= '".$idn."";
	$str = '';
	categories_child($idn,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY RAND() ";	
	$sql.= "LIMIT ".$count;
	$news_articles = sql_list($sql);
	return $news_articles;
}
function new_articles_by_cat($cat,$limit=5,$sid=0,$byopt=0,$bystatus=2) {
	global $id, $config, $str;
	$sql = "SELECT art.id, art.picture, art.opt, art.lastdate, detail.title,detail.seotit, detail.loaitien, detail.gia, detail.quick, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."'";
	if ($sid > 0) $sql.= " AND art.id <> '".$sid."'";
	$sql.= " AND art.status = '".$bystatus."' AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	if($byopt!=0)
		$sql.= $str." ) ORDER BY art.opt DESC ";
	else 
		$sql.= $str." ) ORDER BY art.state_p, art.lastdate DESC ";
	$sql.= "LIMIT ".$limit;	
	return sql_list($sql);
}
function new_articles_by_cat2($cat,$limit=5,$sid=0) {
	global $id, $config, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."'";
	if ($sid > 0) $sql.= " AND art.id <> '".$sid."'";
	$sql.= " AND art.status = '2' AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.lastdate DESC ";
	$sql.= "LIMIT ".$limit;	
	return sql_list($sql);
}
function get_video($ida='',$count=8) {
	global $config;
	$sql = "SELECT v.* FROM ".$config['db_prefix']."_video v";
	if ($ida != '')
		$sql .= " WHERE v.article = ".$ida;
	$sql.= " ORDER BY v.id DESC LIMIT ".$count;
	return sql_list($sql);	
}
function vp_detail($idv,$cat) {
	global $config;
	$sql = "SELECT v.* FROM ".$config['db_prefix']."_".$cat." v WHERE v.id = ".$idv;
	return sql_detail($sql);
}
function get_picture($ida='',$count=20) {
	global $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_file ";
	if ($ida != '')
		$sql .= " WHERE article = ".$ida." AND type = 'images' ";
	$sql.= " ORDER BY id DESC LIMIT ".$count;
	return sql_list($sql);	
}
function get_note($ida='',$count=20) {
	global $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_file ";
	if ($ida != '')
		$sql .= " WHERE article = ".$ida." AND type = 'articles' ";
	$sql.= " ORDER BY id DESC LIMIT ".$count;
	return sql_list($sql);	
}
function news_search($cat,$dist,$key) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND  art.status = '2' AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." )";
	if ($dist != '')
		$sql.= " AND detail.dist = ".$dist;
	if ($key == 'Search' || $key == 'Tìm kiếm')
		$key = '';
	$key = explode(' ',$key);
	$count  = count($key);
	$andrey = '';
	for($i=0;$i<$count;$i++) {
		$andrey .= "detail.title LIKE '%".$key[$i]."%' OR detail.quick LIKE '%".$key[$i]."%' OR "; 
	}
	for($i=0;$i<$count;$i++) {
		$andrey .= "detail.contents LIKE '%".$key[$i]."%' OR detail.ma LIKE '%".$key[$i]."%'";
		if($i<$count-1) $andrey .= " OR "; 
	}
	$sql.= " AND (".$andrey.")";
	$sql.= " ORDER BY art.lastdate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_s']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_s'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_s'];
	$news_articles = sql_list($sql);
	//echo $sql;
	return $news_articles;
}
function search_p($cat,$key,$min=0,$max=0) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, detail.loaitien, detail.gia, detail.ma, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '0' ) AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." )";
	if ($key == 'Nhập từ khóa' || $key == 'Từ khoá')
		$key = '';
	$key = explode(' ',$key);
	$count  = count($key);
	$andrey = '';
	for($i=0;$i<$count;$i++) {
		$andrey .= "detail.title LIKE '%".$key[$i]."%' OR detail.quick LIKE '%".$key[$i]."%' OR "; 
	}
	for($i=0;$i<$count;$i++) {
		$andrey .= "detail.contents LIKE '%".$key[$i]."%' OR detail.ma LIKE '%".$key[$i]."%'";
		if($i<$count-1) $andrey .= " OR "; 
	}
	$sql.= " AND (".$andrey.")";
	if($max!=0)
	$sql.= " AND ( detail.gia > ".$min. " AND detail.gia < ".$max. " ) ";
	$sql.= " ORDER BY detail.gia ASC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_s']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_s'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_s'];
	$news_articles = sql_list($sql);
	//echo $sql;
	return $news_articles;
}
function detail_mem($userid){
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT * FROM ".$config['db_prefix']."_member "."WHERE id = '".$userid."'";
	$member = sql_list($sql);
	return $member;
}
function commember($userid){
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT * FROM ".$config['db_prefix']."_commember "."WHERE id = '".$userid."'";
	$member = sql_list($sql);
	return $member;
}
// cập nhật ngày 30 07 2010
function get_new_member($cat,$memberid) {
	global $id, $config, $pages, $news_articles, $str;
	$sql = "SELECT art.id, art.picture, detail.title, art.category, art.state_p, detail.ma, art.hot,detail.loaitien, detail.gia, detail.khuyenmai, art.bydate, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND detail.ma = '".$memberid. "' AND ( art.status = '2' OR art.status = '0' ) AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';
	categories_child($cat,1);
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_p']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_p'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_p'];
	$news_articles = sql_list($sql);
	return $news_articles;
}
function get_detail_member($dt,$memberid,$bycat=0){
	global $id,$config;
	$sql = "SELECT art.id, art.picture, detail.title, detail.loaitien, detail.gia, detail.khuyenmai, detail.ma, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid  WHERE detail.language = '".$config['default_language']."' AND detail.ma = '".$memberid."' AND ( art.status = '2' OR  art.status = '0') AND art.id = '".$dt."'";
	if($bycat!=0)	$sql.= "AND art.category = '".$bycat." '  ";
	$detail = sql_detail($sql);
	//echo $detail;
	return $detail;
}
function get_all($ida='',$db_name='driver',$count=20) {
	global $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_".$db_name." ";
	if ($ida != '')
		$sql .= " WHERE article = ".$ida;
	$sql.= " ORDER BY id DESC LIMIT ".$count;
	return sql_list($sql);
}
function check_data($ida='',$db_name='driver') {
	global $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_".$db_name." ";
	if ($ida != '')
		$sql .= " WHERE article = ".$ida." ";
	$sqlcall = sql_list($sql);
	if(count($sqlcall)>0) return 'x';
	else return '';
}
function get_driver($ida='',$count=8) {
	global $config;
	$sql = "SELECT d.* FROM ".$config['db_prefix']."_driver d";
	if ($ida != '')
		$sql .= " WHERE d.article = ".$ida;
	$sql.= " ORDER BY d.id DESC LIMIT ".$count;
	return sql_list($sql);	
}
function get_manual($ida='',$count=8) {
	global $config;
	$sql = "SELECT m.* FROM ".$config['db_prefix']."_manual m";
	if ($ida != '')
		$sql .= " WHERE m.article = ".$ida;
	$sql.= " ORDER BY m.id DESC LIMIT ".$count;
	return sql_list($sql);	
}
function get_driver2($db_prefix,$ida='',$count=8) {
	global $config;
	$sql = "SELECT d.* FROM ".$db_prefix."_driver d";
	if ($ida != '')
		$sql .= " WHERE d.article = ".$ida;
	$sql.= " ORDER BY d.id DESC LIMIT ".$count;
	return sql_list($sql);	
}
function get_manual2($db_prefix,$ida='',$count=8) {
	global $config;
	$sql = "SELECT m.* FROM ".$db_prefix."_manual m";
	if ($ida != '')
		$sql .= " WHERE m.article = ".$ida;
	$sql.= " ORDER BY m.id DESC LIMIT ".$count;
	return sql_list($sql);	
}
function search($cat,$key,$prefix='') {
	global $id, $config, $pages, $news_articles, $str;
	if($prefix!='') $db_prefix = $prefix; else $db_prefix = $config['db_prefix'];
	$sql = "SELECT art.id, art.picture, detail.title, detail.gia, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$db_prefix."_news_articles art RIGHT JOIN ".$db_prefix."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$db_prefix."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$db_prefix."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '0' ) AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';	
	if($prefix!='') categories_child($cat,1,$prefix);
	else categories_child($cat,1);
	
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." )";
	$key = addslashes($key);
	$andrey = '';
	$andrey .= "detail.title LIKE '%".$key."%' "; 	
	$sql.= " AND (".$andrey.")";
	$sql.= " ORDER BY art.lastdate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_s']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_s'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_s'];
	$news_articles = sql_list($sql);
	//echo 'ok';//$sql;
	return $news_articles;
}
function search_cont($cat,$key,$prefix='') {
	global $id, $config, $pages, $news_articles, $str;
	if($prefix!='') $db_prefix = $prefix; else $db_prefix = $config['db_prefix'];
	$sql = "SELECT art.id, art.picture, detail.title, detail.gia, art.category, grp.id AS news_groups, detail.quick, detail.contents, art.lastdate FROM ".$db_prefix."_news_articles art RIGHT JOIN ".$db_prefix."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$db_prefix."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$db_prefix."_news_groups grp ON grp.id = cat.groupid ";
	$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '0' ) AND ( ";
	$sql.= " art.category= '".$cat."";
	$str = '';	
	if($prefix!='') categories_child($cat,1,$prefix);
	else categories_child($cat,1);
	
	if ($str != '') {
		$str = str_replace(',',"' OR art.category = '",$str);
	}
	$str.= "'";
	$sql.= $str." )";
	$key = addslashes($key);
	$andrey = '';
	$andrey .= "detail.contents LIKE '%".$key."%' "; 	
	$sql.= " AND (".$andrey.")";
	$sql.= " ORDER BY art.lastdate DESC ";
	$pages['rs']		=	sql_exit($sql);
	$pages['page']		=	ceil($pages['rs']/$config['limit_on_page_s']);
	$pages['current']	=	$id['page'] ? $id['page'] : 1;
	$pages['begin']		= 	($pages['current'] - 1) * $config['limit_on_page_s'];
	$sql.= "LIMIT ".$pages['begin'].",".$config['limit_on_page_s'];
	$news_articles = sql_list($sql);
	//echo 'ok';//$sql;
	return $news_articles;
}

	function GetThumnail($thumid=0){
		global $config;
		$sqlthum = " SELECT file FROM ".$config['db_prefix']."_file WHERE article = '".$thumid."' AND type = 'thumnail' ORDER BY id " ;
		$gr_thum = sql_detail($sqlthum);
		return $gr_thum[0]['file'];
	}
	
	function GetThumnailId($thumid=0){
		global $config;
		$sqlthum = " SELECT id FROM ".$config['db_prefix']."_file WHERE article = '".$thumid."' AND type = 'thumnail' ORDER BY id " ;
		$gr_thum = sql_detail($sqlthum);
		return $gr_thum[0]['id'];
	}
	
	function GetThumnailIndex($thumid=0){
		global $config;
		$sqlthum = " SELECT quick FROM ".$config['db_prefix']."_file WHERE article = '".$thumid."' AND type = 'thumnail' ORDER BY id " ;
		$gr_thum = sql_detail($sqlthum);
		return $gr_thum[0]['quick'];
	}
	
	function GetThumnailList($deta=3){
		global $config;
		$sqlalbum = " SELECT * FROM ".$config['db_prefix']."_file WHERE article = '".$deta."' AND type = 'images' ORDER BY title " ;
		$gr_album = sql_detail($sqlalbum);
		for($m=0;$m<count($gr_album);$m++){
			$thum_img[$m] = GetThumnail($gr_album[$m]['id']);
		}
		return $thum_img;
	}
	
	function GetAlbum($deta=3){
		global $config;
		$sqlalbum = " SELECT * FROM ".$config['db_prefix']."_file WHERE article = '".$deta."' AND type = 'images' ORDER BY title " ;
		$gr_album = sql_detail($sqlalbum);
		return $gr_album;
	}
	
	function SumArticle($cat) {
		global $id, $config, $str;
		$sql = "SELECT COUNT(art.id) AS counter FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article RIGHT JOIN ".$config['db_prefix']."_news_categories cat ON cat.id = art.category  RIGHT JOIN ".$config['db_prefix']."_news_groups grp ON grp.id = cat.groupid ";
		$sql.= "WHERE detail.language = '".$config['default_language']."' AND ( art.status = '2' OR art.status = '0' ) AND ( ";
		$sql.= " art.category= '".$cat."";
		$str = '';
		categories_child($cat,1);
		if ($str != '') {
			$str = str_replace(",","' OR art.category = '",$str);
		}
		$str.= "'";
		$sql.= $str." ) ORDER BY art.state_p, art.bydate DESC ";
		$sql.= "LIMIT 0,500 ";
		$news_articles = sql_list($sql);
		return $news_articles[0]['counter'];
	}


?>