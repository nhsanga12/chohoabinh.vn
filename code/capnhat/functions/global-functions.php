<?php
function str_arr($str=''){
	if($str!=''){
		$bam = explode(',',$str);
		for($i=0;$i<count($bam);$i++){
			$tach = explode(':',$bam[$i]);
			$chuoi[$tach[0]] = $tach[1];
		}
		return $chuoi;
	}
	return '';
}

function useronline(){
	global $config,$lgroups;
	$session_id = session_id(); // User's session id.
	$time = time();  // Current time.
	$expire_time = time()+100; // Current time plus five minutes.
	// Delete Expires records.
	mysql_query("DELETE FROM `".$config['db_prefix']."_users_online` WHERE `expire_time`<'{$time}'") or die(mysql_error());
	// Select the record with specific session id.
	$result = mysql_query("SELECT * FROM `".$config['db_prefix']."_users_online` WHERE `session_id`='{$session_id}'") or die(mysql_error());
	// if record does not exist.
	if(mysql_num_rows($result) == 0){
		// create the record of the user.
		mysql_query("INSERT INTO `".$config['db_prefix']."_users_online` (`session_id`, `expire_time`) VALUES('{$session_id}', '{$expire_time}')") or die(mysql_error());
	// Else, if the record exist.
	}else{
		// Update the expire time of the user.
		mysql_query("UPDATE `".$config['db_prefix']."_users_online` SET `expire_time`='{$expire_time}' WHERE `session_id`='{$session_id}'") or die(mysql_error());
	}
	// Count all the records within the table.
	$result = mysql_query("SELECT count(*) FROM `".$config['db_prefix']."_users_online`") or die(mysql_error());
	// Store the information into an array.
	$row = mysql_fetch_row($result);
	// Output the number of online users to the browser.
	 return $row[0];
}


function getRealIpAdd(){ // lay ip user
	
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
     	$ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function uservisitor(){
	global $config;
	$date = date('Ymd');
	$time = time();
	$user_ip = getRealIpAdd();
	$link = $_SERVER['REQUEST_URI'];
	
	$result = mysql_query("SELECT * FROM `".$config['db_prefix']."_users_visitor` WHERE `bydate`='{$date}' AND `ip`='{$user_ip}' AND `local`='".$link."' ") or die(mysql_error());
	
	if(mysql_num_rows($result) == 0){
		mysql_query("INSERT INTO `".$config['db_prefix']."_users_visitor` (`bydate`,`time`,`ip`,`local`) VALUES('{$date}','{$time}', '{$user_ip}','".$link."') ") or die(mysql_error());
	}
	
	// Count all the records within the table.
	$result = mysql_query("SELECT ip FROM `".$config['db_prefix']."_users_visitor` WHERE `bydate`='{$date}' GROUP BY ip ") or die(mysql_error());
	// Store the information into an array.
	$row = mysql_fetch_row($result);
	// Output the number of online users to the browser.
	 return count($result);
}

function countryCityFromIP($ipAddr)
{
  ip2long($ipAddr)== -1 || ip2long($ipAddr) === false ? trigger_error("Invalid IP", E_USER_ERROR) : "";
  $ipDetail=array(); //initialize a blank array
  $xml = file_get_contents("http://api.hostip.info/?ip=".$ipAddr);
 
  preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si",$xml,$match);
  $ipDetail['city']=$match[2]; 
  
  preg_match("@<countryName>(.*?)</countryName>@si",$xml,$matches);
  $ipDetail['country']=$matches[1];
  
  preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si",$xml,$cc_match);
  $ipDetail['country_code']=$cc_match[1]; //assing the country code to array
 
  return $ipDetail;
}


function get_size_picture($path,$w,$h) {
	$size = getimagesize($path);
	list($width, $height) = $size;
	for ($j = 1; $j < 100; $j++) {
		$nheight	=	($height*$j)/100 + 5;
		$nwidth 	=	($width*$j)/100 + 5;	
		if ($nheight >= $h || $nwidth >= $w) {											
			break;
		}
	}
	$img = array($width,$height,$nwidth,$nheight);
	return $img;
}

function config() {
	global $config,$lgroups;
	$sql = "SELECT * FROM ".$config['db_prefix']."_configs";
	$sql = @mysql_query($sql);
	while ($temp = @mysql_fetch_array($sql)) {
		$config[$temp['key_id']]				= $temp['key_value'];
	}
	$sql = "SELECT * FROM ".$config['db_prefix']."_languagesgroups";
	$sql = @mysql_query($sql);
	$i = 0;
	while ($temp = @mysql_fetch_array($sql)) {
		$lgroups[$i]['key']				= $temp['language'];
		$lgroups[$i]['title']			= $temp['title'];
		$i++;
	}
}
function sys_uploads($folder,$file,$type='gif|jpg|jpeg|png|swf|doc|xls|GIF|JPG|JPEG|PNG|SWF|DOC|XLS|PPT',$thum=0,$crop=false,$ww=200,$hh=200)
{	// thum = 0: tao 1 pic+ 1thum;
	// thum = 1: tao 1 thum;
	// thum = 2: tao 1 pic; 
	global $config;
	$upload_file = "";
	if ( $_SERVER["REQUEST_METHOD"] != "POST" ) {
		return $upload_file;
	}
				
	if ( !isset($_FILES[$file]["error"]) || $_FILES[$file]["error"] != 0 ) {
		return $upload_file;
	}
	if ( $_FILES[$file]["size"] > $config['max_upload_file_size'] ) {	
		return $upload_file;
	}
	$temp = preg_split('/[\/\\\\]+/', $_FILES[$file]["name"]);
	$filename = $temp[count($temp)-1];
	if ( !preg_match('/\.('.$type.')$/i', $filename )) {
		return $upload_file;
	} 
	$filename = str_replace("%20","",$filename);
	$filename = str_replace(" ","",$filename);
	if($thum==1)
		$upload_file = "thums_muaban_".date('is')."_".$filename;
	else
		$upload_file = "muaban_".date('is')."_".$filename;
		
	move_uploaded_file($_FILES[$file]["tmp_name"],$folder.$upload_file);
	
	
		// save images thums
		$imgtype = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
		if (preg_match('/\.('.$imgtype.')$/i', $filename )) {
			$image = new SimpleImage();
			if($thum==0){
				$img_thums = 'thums_'.$upload_file;
				$image->load($folder.$upload_file);
				$image->resizefull($ww,$hh);
				$image->save($folder.$img_thums);
			}/*else if($thum==5){ //blur
				$img_thums = 'blur_'.$upload_file;
				$image->load($folder.$upload_file);
				$image->blurimg(400,268);
				$image->resizeToWidth($ww);
				$image->save($folder.$img_thums);
			}*/
			if($crop){
				$imgcrop = $upload_file;
				$image->load($folder.$upload_file);
				$image->resizecrop($ww,$hh);
				$image->save($folder.$imgcrop);
			}
		}
	return $upload_file;
}

function sys_cut($str,$var)
{        
		$result=""; 
		$co = false ; 
		$c_str=strlen($str);
		if ($c_str>$var)
		{
			for ($i=$var;$i>0;$i--)
			{
					if($str[$i]==" ")
					{
					$dung=$i;
					$co = true;
					break;
					}
			}
				if ($co==true)
					$result=substr($str,0,$i)." ...";
				else
					$result=substr($str,0,$var)." ...";
		}
		else
		$result=$str;
		return $result;		
} 

function languagedetail($lgkey) {
	global $config;
	$sql = "SELECT keylang,contents
			FROM ".$config['db_prefix']."_languages_detail
			WHERE language='".$lgkey."' ";
	$sql = @mysql_query($sql);
	while ($temp = @mysql_fetch_array($sql)) {
		$lgroups[$temp['keylang']]	= $temp['contents'];
	}
	return $lgroups;
}

function access() {
	global $id, $config;
	$sql = "SELECT * FROM ".$config['db_prefix']."_admin_detail ";
	$sql.= "WHERE admin = '".$_SESSION['auth']['id']."' AND com = '".$id['target']."' AND man= '".$id['option']."'";
	$detail = sql_detail($sql);
	if ($id['target'] == 'home' || $id['target'] == 'signin' || $id['target'] == 'signout')
	$detail[0]['access'] = 1;
	return $detail[0]['access'];
}


function sys_mail($info)
{
		   $from = "MIME-Versin: 1.0\r\n" .
		   "Content-type: text/html ; charset=utf-8; format=flowed\r\n" .
		   "Content-Transfer-Encoding: 8bit\r\n" .
		   "From: ".$info['from_name']."<".$info['from_email'].">\r\n" .
		   "Reply-To: ".$info['from_name']."<".$info['from_email'].">\r\n" .
		   "X-Mailer: PHP" . phpversion();
			@mail($info['to_email'],$info['subject'],$info['detail'],$from);	
}

function sys_link($options) {
	global $config;
	$cong	=	array('com','target','option','category','detail','page','ok','cate','lang');
	
	// Nhận Data từ chuỗi link
	$optionsTemp = explode("&",$options);// cắt chuỗi url bằng dấu @
	$options = array();
	while (list($key,$value)=each($optionsTemp)) {
		$value = explode("=",$value);
		$options[$value[0]] = $value[1]; // lưu các biến(tên+giá trị) vào trong mảng Options
	}
	
	$options['file'] = sys_sign($options['file']); // chuyển từ tiếng Việt sang không dấu
	
	// Bắt đầu mã hóa
	if ($config['seo'] == 1) {
		$str 			= '';
		if($options['com']!="home")  		$str .= 'com@'.$options['com'].'/';
		if($options['target']!="main")  	$str .= 'target@'.$options['target'].'/';
		if($options['option']!="")  		$str .= 'option@'.$options['option'].'/';
		
		$str = BreadcrumbLink($str,$options['category'],$options['detail'],$options['page'],$options['ok'],$options['cate'],$options['lang']);
		
		// kết thúc mã hóa	
			
	} else {
		$str = '?global=';
		$n = count($options);
		while (list($key,$value)=each($options)) {
			if ($i < ($n-1)) {
				$str.= $key.':'.$value.',';
			} else {
				$str.= $key.':'.$value.'';
			}
			$i++;
		}
	}
	$str = $config['url'].$str;
	return $str;
}
function sys_sign($str){
	$unicode 		= array(
						"à","á","ạ","ả","ã","â","ầ","ấ","ậ","ẩ","ẫ","ă",
						"ằ","ắ","ặ","ẳ","ẵ",
						"è","é","ẹ","ẻ","ẽ","ê","ề" ,"ế","ệ","ể","ễ",
						"ì","í","ị","ỉ","ĩ",
						"ò","ó","ọ","ỏ","õ","ô","ồ","ố","ộ","ổ","ỗ","ơ"
						,"ờ","ớ","ợ","ở","ỡ",
						"ù","ú","ụ","ủ","ũ","ư","ừ","ứ","ự","ử","ữ",
						"ỳ","ý","ỵ","ỷ","ỹ",
						"đ","ê","ù","à",
						"À","Á","Ạ","Ả","Ã","Â","Ầ","Ấ","Ậ","Ẩ","Ẫ","Ă",
						"Ằ","Ắ","Ặ","Ẳ","Ẵ",
						"È","É","Ẹ","Ẻ","Ẽ","Ê","Ề" ,"Ế","Ệ","Ể","Ễ",
						"Ì","Í","Ị","Ỉ","Ĩ",
						"Ò","Ó","Ọ","Ỏ","Õ","Ô","Ồ","Ố","Ộ","Ổ","Ỗ","Ơ"
						,"Ờ","Ớ","Ợ","Ở","Ỡ",
						"Ù","Ú","Ụ","Ủ","Ũ","Ư","Ừ","Ứ","Ự","Ử","Ữ",
						"Ỳ","Ý","Ỵ","Ỷ","Ỹ",
						"Đ","Ê","Ù","À",
						" ",",","\"",".","/","_","(",")","'","&#039;","%","&#034;",":","!","?"
					);
	$none_unicode	= array(
						"a","a","a","a","a","a","a","a","a","a","a"
						,"a","a","a","a","a","a",
						"e","e","e","e","e","e","e","e","e","e","e",
						"i","i","i","i","i",
						"o","o","o","o","o","o","o","o","o","o","o","o"
						,"o","o","o","o","o",
						"u","u","u","u","u","u","u","u","u","u","u",
						"y","y","y","y","y",
						"d","e","u","a",
						"a","a","a","a","a","a","a","a","a","a","a"
						,"a","a","a","a","a","a",
						"e","e","e","e","e","e","e","e","e","e","e",
						"i","i","i","i","i",
						"o","o","o","o","o","o","o","o","o","o","o","o"
						,"o","o","o","o","o",
						"u","u","u","u","u","u","u","u","u","u","u",
						"y","y","y","y","y",
						"d","e","u","a",
						"-","","","","","","","","","","","","","",""
					);
	return strtolower(str_replace($unicode,$none_unicode,$str));
}

function sys_option($com,$target,$option) {
	$gncs	=   $_SERVER["SCRIPT_NAME"];
	$gncs	=	explode("/",$gncs);
	if ($gncs[count($gncs)-1] == 'index.php') {
		if (is_file('sources/'.$com.'/'.$target.'.'.$option.'.php')) include('sources/'.$com.'/'.$target.'.'.$option.'.php');
		else sys_file('sources/'.$com.'/'.$target.'.'.$option.'.php');
		if (is_file('templates/'.$com.'/'.$target.'.'.$option.'.html.php')) include('templates/'.$com.'/'.$target.'.'.$option.'.html.php');
		else sys_file('templates/'.$com.'/'.$target.'.'.$option.'.html.php');
	} else {
		if (is_file('temp_dev/'.themes.'/'.$com.'/'.$target.'.'.$option.'.html.php')) include('temp_dev/'.themes.'/'.$com.'/'.$target.'.'.$option.'.html.php');
		else sys_file('temp_dev/'.themes.'/'.$com.'/'.$target.'.'.$option.'.html.php');
	}
}
function sys_file($file) {
	echo '<div id="alertnofile">Bạn cần bổ sung file sau: <strong>'.$file.'</strong></div>';
}
function dateDisplay($lang){
$mkendtimep=mktime(date("H")+0, date("i"), date("s"), date("m"), date("d"), date("Y"));
$todaydate1=date("d", $mkendtimep);
$todaydate2=date("m", $mkendtimep);
$todaydate3=date("Y", $mkendtimep);
$todaydate4=date("M", $mkendtimep);
	if (date("l")=="Monday") { $mday=Monday; $mdayvn= 'Thứ Hai'; } else
    if (date("l")=="Tuesday") { $mday=Tuesday; $mdayvn= 'Thứ Ba'; } else
    if (date("l")=="Wednesday") { $mday=Wednesday; $mdayvn= 'Thứ Tư';  } else
    if (date("l")=="Thursday") { $mday=Thursday; $mdayvn= 'Thứ Năm'; } else
    if (date("l")=="Friday") { $mday=Friday; $mdayvn= 'Thứ Sáu'; } else
    if (date("l")=="Saturday") { $mday=Saturday; $mdayvn= 'Thứ Bảy'; } else
    if (date("l")=="Sunday"){  $mday=Sunday; $mdayvn= 'Chủ Nhật'; }
	

if($lang=='vn') $realtime="$mdayvn, $todaydate1-$todaydate2-$todaydate3";
	else 	$realtime="$mday, $todaydate2 $todaydate4 $todaydate3";

return $realtime;
}
function dateDisplayfull($lang){
$mkendtimep=mktime(date("H")+0, date("i"), date("s"), date("m"), date("d"), date("Y"));
$todaydate1=date("d", $mkendtimep);
$todaydate2=date("m", $mkendtimep);
$todaydate3=date("Y", $mkendtimep);
$todaydate4=date("M", $mkendtimep);
	if (date("l")=="Monday") { $mday=Monday; $mdayvn= 'Thứ Hai'; } else
    if (date("l")=="Tuesday") { $mday=Tuesday; $mdayvn= 'Thứ Ba'; } else
    if (date("l")=="Wednesday") { $mday=Wednesday; $mdayvn= 'Thứ Tư';  } else
    if (date("l")=="Thursday") { $mday=Thursday; $mdayvn= 'Thứ Năm'; } else
    if (date("l")=="Friday") { $mday=Friday; $mdayvn= 'Thứ Sáu'; } else
    if (date("l")=="Saturday") { $mday=Saturday; $mdayvn= 'Thứ Bảy'; } else
    if (date("l")=="Sunday"){  $mday=Sunday; $mdayvn= 'Chủ Nhật'; }
	

if($lang=='vn') $realtime="$todaydate1 / $todaydate2 / $todaydate3 ";
	else 	$realtime="$todaydate1 / $todaydate2 / $todaydate3";

return $realtime;
}
function datechange($day){
$mkendtimep=mktime(date("H")+0, date("i"), date("s"), date("m"), date("d"), date("Y"));
$todaydate1=date("d", $mkendtimep);
$todaydate2=date("m", $mkendtimep);
$todaydate3=date("Y", $mkendtimep);
$todaydate4=date("M", $mkendtimep);
	if (date("l")=="Monday") { $mday=Monday; $mdayvn= 'Thứ Hai'; } else
    if (date("l")=="Tuesday") { $mday=Tuesday; $mdayvn= 'Thứ Ba'; } else
    if (date("l")=="Wednesday") { $mday=Wednesday; $mdayvn= 'Thứ Tư';  } else
    if (date("l")=="Thursday") { $mday=Thursday; $mdayvn= 'Thứ Năm'; } else
    if (date("l")=="Friday") { $mday=Friday; $mdayvn= 'Thứ Sáu'; } else
    if (date("l")=="Saturday") { $mday=Saturday; $mdayvn= 'Thứ Bảy'; } else
    if (date("l")=="Sunday"){  $mday=Sunday; $mdayvn= 'Chủ Nhật'; }
	

if($lang=='vn') $realtime="$todaydate1 / $todaydate2 / $todaydate3 ";
	else 	$realtime="$todaydate1 / $todaydate2 / $todaydate3";

return $realtime;
}
function divPage($div = 5){
	global $pages,$id;
	/*
	$pages['page']		tổng số trang;
	$pages['current'] 	trang hiện tại;
	$div				phân đoạn trang; ví dụ phân đoạn là 3:  <<   <  5  6   7   >   >>; 
	
	*/
	if($pages['page']!=''){
		if($pages['current']<3)
			for($p = 0; $p<$div;$p++){
				$number = $p+1; if($number==$pages['current']) $cl='tron01'; else $cl='tron02';
				if($number<=$pages['page'])
					echo '<div class="'.$cl.'"><a class="hong"  href="'.sys_link('com=home&target=main&category='.$id['category'].'&cate='.$id['cate'].'&detail='.$id['detail'].'&page='.$number).'">'.$number.'</a></div>';
			}
		else if($pages['current']>$pages['page']-3)
			for($p = 0; $p<$div;$p++){
				$number = $pages['page']+$p-4; if($number==$pages['current']) $cl='tron01'; else $cl='tron02';
				if($number>0)
					echo '<div class="'.$cl.'"><a class="hong" href="'.sys_link('com=home&target=main&category='.$id['category'].'&cate='.$id['cate'].'&detail='.$id['detail'].'&page='.$number).'">'.$number.'</a></div>';
			}
		else
			for($p = 0; $p<$div;$p++){
				$number = $pages['current']+$p-2; if($number==$pages['current']) $cl='tron01'; else $cl='tron02';
				if($number>0 && $number<=$pages['page'])
					echo '<div class="'.$cl.'"><a class="hong" href="'.sys_link('com=home&target=main&category='.$id['category'].'&cate='.$id['cate'].'&detail='.$id['detail'].'&page='.$number).'">'.$number.'</a></div>';
			}
	}
}
function divPageup($div = 5){
	global $pages,$id;
	/*
	$pages['page']		tổng số trang;
	$pages['current'] 	trang hiện tại;
	$div				phân đoạn trang; ví dụ phân đoạn là 3:  <<   <  5  6   7   >   >>; 
	*/
	if($pages['page']!=''){
		if($pages['current']<3){
			for($p = $div-1; $p>=0;$p--){
				$number = $p+1; if($number==$pages['current']) $cl='tron01'; else $cl='tron02';
				if($number<=$pages['page'])
					echo '<div class="'.$cl.'"><a class="hong"  href="'.sys_link('com=home&target=main&category='.$id['category'].'&cate='.$id['cate'].'&detail='.$id['detail'].'&page='.$number).'">'.$number.'</a></div>';
					
					
			}		
		}else if($pages['current']>$pages['page']-3)
			for($p = $div-1; $p>=0;$p--){
				$number = $pages['page']+$p-4; if($number==$pages['current']) $cl='tron01'; else $cl='tron02';
				if($number>0)
					echo '<div class="'.$cl.'"><a class="hong" href="'.sys_link('com=home&target=main&category='.$id['category'].'&cate='.$id['cate'].'&detail='.$id['detail'].'&page='.$number).'">'.$number.'</a></div>';
			}
		else{
			
			for($p = $div-1; $p>=0;$p--){
				$number = $pages['current']+$p-2; if($number==$pages['current']) $cl='tron01'; else $cl='tron02';
				if($number>0 && $number<=$pages['page'])
					echo '<div class="'.$cl.'"><a class="hong" href="'.sys_link('com=home&target=main&category='.$id['category'].'&cate='.$id['cate'].'&detail='.$id['detail'].'&page='.$number).'">'.$number.'</a></div>';
			}			
		}
	}
}
?>