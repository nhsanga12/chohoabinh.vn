<?php

//return str.replace(/[a-zA-Z]/g, function(c){return String.fromCharCode((c<="Z"?90:122)>=(c=c.charCodeAt(0)+number)?c:c-26);});

function reproduce_email($stremail,$num=13)
{
	$chars = preg_split('//', $stremail, -1, PREG_SPLIT_NO_EMPTY);
	foreach($chars as $key => $value){
		if(preg_match("/[a-zA-Z]/",$value)){
			$numold = ord($value);
			if($numold<110)
				$newk = chr($numold+$num);
			else if($numold>=112)
				$newk = chr($numold-$num);
			else
				$newk = chr($numold-$num);
		}else{
			$newk = $value;
		}
		
		//echo $value.": ".$newk."<br />";
		$newdata .= $newk;
		
		
	}
	return $newdata;
}

function html2text2($html)
{
	$tags = array (
	0 => '~<h[123][^>]+>~si',
	1 => '~<h[456][^>]+>~si',
	2 => '~<table[^>]+>~si',
	3 => '~<tr[^>]+>~si',
	4 => '~<li[^>]+>~si',
	5 => '~<br[^>]+>~si',
	6 => '~<p[^>]+>~si',
	7 => '~<div[^>]+>~si',
	);
	$html = preg_replace($tags,"\n",$html);
	$html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html);
	$html = preg_replace('~<[^>]+>~s','',$html);
	$html = preg_replace('~ +~s',' ',$html);
	$html = preg_replace('~^\s+~m','',$html);
	$html = preg_replace('~\s+$~m','',$html);
	$html = preg_replace('~\n+~s',"\n",$html);
	return $html;
}
function html2text($html){    
	$tags = array (    
	0 => '~<h[123][^>]+>~si',    
	1 => '~<h[456][^>]+>~si',    
	2 => '~<table[^>]+>~si',    
	3 => '~<tr[^>]+>~si',    
	4 => '~<li[^>]+>~si',    
	5 => '~<br[^>]+>~si',    
	6 => '~<p[^>]+>~si',    
	7 => '~<div[^>]+>~si',
	8 => '~<dd[^>]+>~si',   
	);    
	$html = preg_replace($tags,"\n",$html);    
	$html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html);    
	$html = preg_replace('~<[^>]+>~s','',$html);    
	// reducing spaces    
	$html = preg_replace('~ +~s',' ',$html);    
	$html = preg_replace('~^\s+~m','',$html);    
	$html = preg_replace('~\s+$~m','',$html);    
	// reducing newlines    
	$html = preg_replace('~\n+~s',"\n",$html);    
	return $html;
}

function removediv($html){    
	$html = str_replace("div","span",$html);
	$html = str_replace("position","title",$html);
	$html = str_replace("background-color","alt",$html);
	$html = str_replace("xx-large","16px",$html);
	$html = str_replace("x-large","16px",$html);
	$html = str_replace("font-family:","font-family: Arial,",$html);
	$html = str_replace("Top</a></h2>","</h2>",$html);
	$html = str_replace("<table","<table width=\"95%\" ",$html);
	return $html;
}
function removediv2($html){    
	$tags = array (
	0 => '~<a[^>]+>~si', 
	1 => '~<div[^>]+>~si',
	2 => '~</a[^>]+>~si', 
	3 => '~</div[^>]+>~si',
	4 => '/top/i',
	  
	);    
	$html = preg_replace($tags,"<br />",$html);    
	return $html;
}

function pagination($tr) {
	
	$tr = str_replace("<hr />","</li><li>",$tr);
	//$tr = html2text_br($tr);
	return $tr;
}

function html2text_br($html){    
	$tags = array (    
	0 => '~<h[123][^>]+>~si',    
	1 => '~<h[456][^>]+>~si',    
	2 => '~<table[^>]+>~si',    
	3 => '~<tr[^>]+>~si',    
	4 => '~<li[^>]+>~si',    
	5 => '~<p[^>]+>~si',    
	6 => '~<div[^>]+>~si',    
	);    
	$html = preg_replace($tags,". ",$html);    
	$html = preg_replace('~</t(d|h)>\s*<t(d|h)[^>]+>~si',' - ',$html);    
	$html = preg_replace('~<[^>]+>~s','',$html);    
	// reducing spaces    
	$html = preg_replace('~ +~s',' ',$html);    
	$html = preg_replace('~^\s+~m','',$html);    
	$html = preg_replace('~\s+$~m','',$html);    
	// reducing newlines    
	$html = preg_replace('~\n+~s'," ",$html);
	return $html;
}

function select_form_array($arr,$select='') {
	$str = '';
	foreach($arr as $key=>$value){
		if($select==$key) $selectr = " selected=\"selected\" "; else $selectr ="";
		$str .= '<option value="'.$key.'" label="'.$value.'"'.$selectr.'>'.$value.'</option>';
	}
	echo $str;
}
function select_banklist($arr,$select='') {
	$str = '';
	foreach($arr as $key=>$value){
		if($select==$key) $selectr = " selected=\"selected\" "; else $selectr ="";
		$str .= '<option value="'.$key.'" label="'.$value['name'].'"'.$selectr.'>'.$value['name'].'</option>';
	}
	echo $str;
}

function html_select_config($name,$select='') {
	global $config;
	if($config[$name]!=''){
		$datagr = explode("-",$config[$name]);
		if($config['default_language']=='en')
			$index = 1;
		else
			$index = 0;
		$data = explode(",",$datagr[$index]);
		for($n=0;$n<count($data);$n++){
			if($select==$data[$n]) $selectr = " selected=\"selected\" "; else $selectr ="";
			$str .= '<option value="'.$data[$n].'" label="'.$data[$n].'"'.$selectr.'>'.$data[$n].'</option>';
		}
		return $str;
	}else{
		$ndata = dsdangtuyen();
		for($m=0;$m<count($ndata);$m++){
			if($select==$ndata[$m]['id']) $selectr = " selected=\"selected\" "; else $selectr ="";
			$str .= '<option value="'.$ndata[$m]['id'].'" label="'.$ndata[$m]['vitri'].'"'.$selectr.'>'.$ndata[$m]['vitri'].'</option>';
		}
		return $str;
	}
}

function html_select_table($table,$where=array(),$select='') {
	global $config;
	$sql = " SELECT * FROM ".$config['db_prefix']."_".$table." ";
	
	if(count($where)>0){
		$sql .= " WHERE deleted = 0 ";
		foreach($$where as $key=>$value){
			$sql .= " AND ".$key." = ".$value;
		}
	}
	$rs_list = sql_list($sql);
	for($m=0;$m<count($rs_list);$m++){
		if($select==$rs_list[$m]['id']) $selectr = " selected=\"selected\" "; else $selectr ="";
			$str .= '<option value="'.$rs_list[$m]['id'].'" label="'.$rs_list[$m]['title'].'"'.$selectr.'>'.$rs_list[$m]['title'].'</option>';
	}
	
}


//===========================================================
// Lấy tin tự động | Hàm cơ bản
//===========================================================

function html_getin_only($contents,$begin,$end){
	$newdata = explode($begin,$contents,2); // tách khối text đầu
	$newdata = explode($end,$newdata[1]);// tách khối text cuối, và lấy khối text giữa
	return $newdata[0];
}

function unset_dupple($arr,$sort=1)
{
	if(is_array($arr)){
		foreach($arr as $k => $v){
			foreach($arr as $key => $value){
				if($v==$value && $key>$k){
					unset($arr[$key]);
				}
			}
		}
		if($sort==1)
			return array_reverse($arr);
		else
			return $arr;
	}
	
}

function html_getin($contents,$begin,$end,$sort=1){
	$newdata = explode($begin,$contents); // tách khối text đầu
	for($m=1;$m<count($newdata);$m++){
		$temp = explode($end,$newdata[$m]);// tách khối text cuối, và lấy khối text giữa
		$data[$m] = $temp[0];
	}
	$data = unset_dupple($data,$sort); // lọc trùng
	return $data;
}

function check_in_news($alt){
	global $config;
	//echo $alt."<br />";
	$sql = " SELECT id FROM ".$config['db_prefix']."_news_articles_detail WHERE ma = '".$alt."' ";
	//echo $sql."<br />";
	$rs = @mysql_query($sql);
	$chk = @mysql_num_rows($rs);
	if($chk>0)
		return false;
	else
		return true;
}

function save_news($cat,$news,$status=2) {
	global $config;
	$maxql = "SELECT MAX(id) FROM ".$config['db_prefix']."_news_articles ";
	$rs = @mysql_query($maxql);
	$temp = @mysql_fetch_array($rs);
	$max = (int)$temp[0] + 1 ;
	
	$sql1 = " INSERT INTO  ".$config['db_prefix']."_news_articles
				( id, category, picture, status, state_p, bydate, lastdate, groupid, deleted )
			VALUES ";
	$sql2 = " INSERT INTO  ".$config['db_prefix']."_news_articles_detail
				( article, title, quick, contents, seotit, seodes, ma, local, language )
			VALUES ";
	$m = 0; $sum = count($news)-1;
	
	if (is_array($news)){
		foreach($news as $k => $v){
			$sql1 .= " ( '".($max+$m)."','".$cat."',";
			$sql2 .= " ( '".($max+$m)."',";
			if (is_array($v)){
				foreach($v as $key => $value){
					if($key=='picture')
						$sql1 .= "'".mysql_real_escape_string($value)."',";
					else
						$sql2 .= "'".mysql_real_escape_string($value)."',";
				}
			}
			
			$sql1 .= "'".$status."','0','".time()."','".time()."','1','0')";
			$sql2 .= "'vn')";
			
			if($m!=$sum){
				$sql1 .= ",";
				$sql2 .= ",";
			}
			$m++;
		}
	}	
	@mysql_query($sql1);
	@mysql_query($sql2);
}

//===========================================================
// lấy tin tự động | Hàm cục bộ
//===========================================================
function html_getlink($url,$setting=array()) { // lấy link
	$contents	=	file_get_contents($url);
    if(!$contents)
		return 'Không truy cập linnk được !';
	else{
		$contents = html_getin_only($contents,$setting[0]['data_begin'],$setting[0]['data_end']);
		$contents = html_getin_only($contents,$setting[1]['data_begin'],$setting[1]['data_end']);
		$contents = html_getin($contents,$setting[0]['link_begin'],$setting[0]['link_end']);	
	}
	return $contents;
}

function html_datalist($url,$setting=array()) { // lấy link, hình, nguồn tin,... từ trang listview
	$contents	=	file_get_contents($url);
    /*if(!$contents){
		$fp = fsockopen($url, 80, $errn, $errs);
		$out  = "GET ".$url." HTTP/1.1\r\n";
		$out .= "Host: xalo.vn\r\n";
		$out .= "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0\r\n";
		$out .= "Connection: close\r\n";
		$out .= "\r\n";
		fwrite($fp, $out);
		$contents = "";
		while ($line = fread($fp, 4096)) {
			$contents .= $line;
		} 
		fclose($fp);
	}*/
	
	if(!$contents){
		return 'Không truy cập được link';
	}else{
		$extrastr = array("\t","\r","\n");
		$contents = html_getin_only($contents,$setting['data']['begin'],$setting['data']['end']);
		$contents = html_getin_only($contents,$setting['data']['begin2'],$setting['data']['end2']);
		$block = html_getin($contents,$setting['block']['begin'],$setting['block']['end'],0);
		
		if (is_array($block)){
			foreach($block as $key => $value){
				$links = html_getin_only($value,$setting['link']['begin'],$setting['link']['end']);			
				$data[$links]['picture'] = html_getin_only($value,$setting['pic']['begin'],$setting['pic']['end']);
				$data[$links]['ma'] = sys_sign(html_getin_only($value,$setting['ma']['begin'],$setting['ma']['end']));
				$local[$links] = html_getin_only($value,$setting['local']['begin'],$setting['local']['end']);	
				$local[$links] = str_replace($extrastr,"",$local[$links]);
				$local[$links] = explode("-",$local[$links]);
				$data[$links]['local'] =trim($local[$links][0]);
			}
		}
		
	}
	return $data;
}

function html_detail_by_link($url,$link,$mores,$setting=array()){ // lấy thông tin chi tiết tin
	$fp = fsockopen($url, 80, $errn, $errs);
	$out  = "GET ".$link." HTTP/1.1\r\n";
	$out .= "Host: ".$url."\r\n";
	$out .= "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0\r\n";
	$out .= "Connection: close\r\n";
	$out .= "\r\n";
	fwrite($fp, $out);
	$contents = "";
	while ($line = fread($fp, 4096)) {
		$contents .= $line;
	} 
	fclose($fp);
	
    if(!$contents)
		return 'Không truy cập linnk được !';
	else{
		$contents = html_getin_only($contents,$setting['data']['begin'],$setting['data']['end']);
		$data_title = html_getin_only($contents,$setting['title']['begin'],$setting['title']['end']);
		$data['title'] = str_replace("'","",$data_title);
		
		$data['quick'] = html_getin_only($contents,$setting['quick']['begin'],$setting['quick']['end']);
		$data['quick'] = remove_link_tag($data['quick']);
		
		$data['contents'] = "<div><div><div>".html_getin_only($contents,$setting['contents']['begin'],$setting['contents']['end']);
		$data['contents'] = remove_link_tag($data['contents']);
		$data['seotit'] = $data['title'];
		$data['seodes'] = $data['quick'];
		$data['ma'] 	= $mores['ma'];
		$data['local'] 	= $mores['local'];
		
		$pics = explode("?url=",$mores['picture']); echo count($pics);
		if(count($pics)>1)
			$pic2 =  urldecode(html_getin_only($mores['picture'],$setting['img']['begin'],$setting['img']['end']));
		else
			$pic2 = $mores['picture'];
		$data['picture'] = save_form_url_to_host($pic2,$setting['savepic']['host'],$setting['savepic']['domain']);
		//$data['picture'] =$pic2;
	}
	return $data;
}

function save_form_url_to_host($url,$host,$domain,$ww=150,$hh=150){ // upload hình lên host
	$filename = explode("/",$url);//lib/articles/google_com.jpg;
	$filename = end($filename);  //google_com.jpg
	$urlarr = explode(":",$url);
	if($urlarr[0]=='http' || $urlarr[0]=='https')
		$fullurl = $url;
	else
		$fullurl = $domain.$url;
	
	
	$contenst = file_get_contents($fullurl);
	if(file_put_contents($host.$filename,$contenst)){
		$image = new SimpleImage();
		$image->load($host.$filename);
		$image->save($host.$filename);
		$image->resizecropH($ww,$hh);
		$image->save($host."thums_".$filename);
		return $filename;
	}else
		return '';
		
}

function remove_link_tag($cont){
	$tags = array (    
		0 => '~<a[^>]+>~si',
	);    
	$html = preg_replace($tags,"",$cont);
	return $html;
}


// dành cho sản phẩm trang 123mua.vn
function html_detail_products($url,$link,$mores,$setting=array()){ // lấy thông tin chi tiết tin
	$contents	=	file_get_contents($link);
    //$data['contsum'] = strlen($contents);
	$makhuvuc = array(
		'Toàn quốc' => '0',
		'TP. Hồ Chí Minh' => '1',
		'Đà Nẵng' => '11',
		'Hà Nội' => '15',
		'Cần Thơ' => '10',
		'Bình Dương' => '7',
		'Đồng Nai' => '12',
		'Khánh Hòa' => '16',
		'An Giang' => '2',
		'Bà Rịa - Vũng Tàu' => '27',
		'Bình Thuận' => '44',
		'Bình Định' => '6',
		'Lai Châu' => '81',
		'Long An' => '50',
	);
	if(!$contents)
		$data['error'] = "Nội dung trống ! ";
	else{
		$contents = html_getin_only($contents,$setting['data']['begin'],$setting['data']['end']);
		
		$titles = html_getin_only($contents,$setting['title']['begin'],$setting['title']['end']);
		$titles = explode("<span>",$titles);
		$data['title'] = $titles[0];
		$data['quick'] = "<div>".html_getin_only($contents,$setting['quick']['begin'],$setting['quick']['end']);
		$data['quick'] = remove_link_tag($data['quick']);
		if(strlen($data['quick'])<10){
			$data['quick'] = "<div>".html_getin_only($contents,$setting['quick']['begin2'],$setting['quick']['end2']);
			$data['quick'] = remove_link_tag($data['quick']);
		}
		
		$data['contents'] = "<div>".html_getin_only($contents,$setting['contents']['begin'],$setting['contents']['end']);
		$data['contents'] = remove_link_tag($data['contents']);
		if(strlen($data['contents'])<10){
			$data['contents'] = "<div>".html_getin_only($contents,$setting['contents']['begin2'],$setting['contents']['end2']);
			$data['contents'] = remove_link_tag($data['contents']);
		}
		$locals 		= html2text(html_getin_only($contents,$setting['khuvuc']['begin'],$setting['khuvuc']['end']));
		$locals 		= trim($locals);
		$data['local'] 	= $makhuvuc[$locals];
		$data['ma'] 	= html2text(html_getin_only($contents,$setting['codes']['begin'],$setting['codes']['end']));
		$data['seotit'] = $data['title'];
		$data['seodes'] = $data['title'];
		if($data['ma']=='')
			$data['ma'] 	= $mores['ma'];
		
		$data['gia'] 	= str_replace(".","",$mores['local']);
		
		
		$data['picture'] = save_form_url_to_host(str_replace("_200x200","",$mores['picture']),$setting['savepic']['host'],$setting['savepic']['domain']);
		//$data['picture'] =$pic2;
	}
	return $data;
}

function html_detail_user($link,$setting=array()){ // lấy thông tin chi tiết tin
	$contents	=	file_get_contents($link);
	if(!$contents)
		$data['error'] = "Nội dung trống ! ";
	else{
		$contents = html_getin_only($contents,$setting['data']['begin'],$setting['data']['end']);
		//$data['noidung'] 	= html2text($contents);
		$data['username'] 	=  html2text(html_getin_only($contents,$setting['username']['begin'],$setting['username']['end']));
		$data['user'] 		=  str_replace("-","",sys_sign($data['username']));
		$data['address'] 	= html_getin_only($contents,$setting['address']['begin'],$setting['address']['end']);
		$data['website'] 	= html2text(html_getin_only($contents,$setting['website']['begin'],$setting['website']['end']));
		$data['phone'] 		= html_getin_only($contents,$setting['phone']['begin'],$setting['phone']['end']);
		$data['yahoo'] 		= html_getin_only($contents,$setting['yahoo']['begin'],$setting['yahoo']['end']);
		$data['email']		= reproduce_email(html_getin_only($contents,$setting['email']['begin'],$setting['email']['end']));
	
	}
	return $data;
}

function save_products($cat,$news,$uidlist,$status=2){
	global $config;
	// lấy giá trị id kế tiếp
	$maxql = "SELECT MAX(id) FROM ".$config['db_prefix']."_news_articles ";
	$rs = @mysql_query($maxql);
	$temp = @mysql_fetch_array($rs);
	$max = (int)$temp[0] + 1 ;
	
	//lưu data
	$sql1 = " INSERT INTO  ".$config['db_prefix']."_news_articles
				( id, category, picture, status, state_p, bydate, lastdate, groupid, deleted, usersid )
			VALUES ";
	$sql2 = " INSERT INTO  ".$config['db_prefix']."_news_articles_detail
				( article, title, quick, contents, local, ma, seotit, seodes, gia, language )
			VALUES ";
	$m = 0; $sum = count($news)-1;
	
	if (is_array($news)){
		foreach($news as $k => $v){
			if($uidlist[$k]!=''){
				$sql1 .= " ( '".($max+$m)."','".$cat."',";
				$sql2 .= " ( '".($max+$m)."',";
				if (is_array($v)){
					foreach($v as $key => $value){
						if($key=='picture')
							$sql1 .= "'".mysql_real_escape_string($value)."',";
						else
							$sql2 .= "'".mysql_real_escape_string($value)."',";
					}
				}
				
				$sql1 .= "'".$status."','0','".time()."','".time()."','1','0','".$uidlist[$k]."')";
				$sql2 .= "'vn')";
				
				if($m!=$sum){
					$sql1 .= ",";
					$sql2 .= ",";
				}
				$m++;
			}
		}
	}
	@mysql_query($sql1);
	@mysql_query($sql2);
		
}
function save_user($user){
	global $config;
	$n=0; $hadlist =array();
	// lấy chuỗi user để truy vấn
	foreach($user as $ku => $vu){
		if(!in_array($vu['user'],$hadlist)){
			$listuser .= ",'".$vu['user']."'";
			$hadlist[$n] = $vu['user'];
		}
		$n++;
	}
	// tìm xem user có tồn tại chưa	
	$sqlsum = " SELECT usersid,usersname FROM ".$config['db_prefix']."_users  WHERE usersname IN ('nulluser'".$listuser.") ";
	$rs = @mysql_query($sqlsum);
	
	// lưu user và iduser tồn tại
	$i = 0; $tontai_name = $tontai_id = array();
	while ($temp = @mysql_fetch_array($rs)) {
		$tontai_id[$temp['usersname']] = $temp['usersid'];
		$tontai_name[$i] = $temp['usersname'];
		$i++;
	}
	
	// tìm userid kế tiếp
	$maxql = " SELECT MAX(usersid) FROM ".$config['db_prefix']."_users ";
	$rss = @mysql_query($maxql);
	$temp = @mysql_fetch_array($rss);
	$max = (int)$temp[0] + 1 ;
	
	// lưu các user mới
	$sql = " INSERT INTO  ".$config['db_prefix']."_users
				( usersid, fullname, usersname, email, password, bydate, lastdate, deleted, acti )
			VALUES ";
	$sql_dt = " INSERT INTO  ".$config['db_prefix']."_users_detail
				( usersid, tengianhang, vip, address, phone, description )
			VALUES ";
	$m = $demsave = 0; $sum = count($user)-1;
	if (is_array($user)){
		$hadadd = array();
		foreach($user as $ke => $ve){
			if(in_array($ve['user'],$hadadd))
				$data[$ke] = $valuehad[$ve['user']];
			else if(in_array($ve['user'],$tontai_name)){
				$data[$ke] = $tontai_id[$ve['user']];
			}else{
				if($m!=0){
					$sql .= ",";
					$sql_dt .= ",";
				}
				$sql .= " ('".($max+$m)."','".mysql_real_escape_string($ve['username'])."','".mysql_real_escape_string($ve['user'])."','".mysql_real_escape_string($ve['email'])."','7363a0d0604902af7b70b271a0b96480','".time()."','".time()."','1','".time()."')";
				$sql_dt .= " ('".($max+$m)."','".mysql_real_escape_string($ve['username'])."','0','".mysql_real_escape_string($ve['address'])."','".mysql_real_escape_string($ve['phone'])."','YM: ".mysql_real_escape_string($ve['yahoo'])."<br />".mysql_real_escape_string($ve['website'])."')";				
				
				
				$hadadd[$ke] = $ve['user'];
				$valuehad[$ve['user']] = $max+$m;
				$data[$ke] = $max+$m;
				$m++;
				$demsave++;
			}
		}
	}
	
	
	
	if($demsave>0){
		//echo $sql."<br />";
		//echo $sql_dt;
		@mysql_query($sql);
		@mysql_query($sql_dt);
	}
	
	return $data;
	
}


function checknick($nick,$type='yahoo'){
	if($type=='skype'){
		echo 'skype_on.png';
	
	}else if($type=='yahoo'){
		$url = "http://opi.yahoo.com/online?u=".$nick."&m=t&t=1"; 
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
		curl_setopt($ch, CURLOPT_HEADER , 0); 
		curl_setopt($ch, CURLOPT_URL, $url); 
		$result = curl_exec ($ch); 
		curl_close ($ch); 
		unset($ch); 
		if ($result == 1)
			echo 'yahoo_on.png';
		else
			echo 'yahoo_off.png';		
	}
}


?>