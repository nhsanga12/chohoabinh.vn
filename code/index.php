<?php
	include('capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	require 'capnhat/mysql/global-mysql.php';
	require 'session.php'; 
	# Thư viện các Hàm
	require 'capnhat/functions/global-functions.php';
	require 'capnhat/functions/auto-load.php';
	require 'capnhat/functions/categories-functions.php';
	require 'capnhat/functions/articles-functions.php';
	require 'capnhat/functions/cal-functions.php';
	require 'capnhat/functions/xml-functions.php';
	require 'capnhat/functions/html-functions.php';
	require 'capnhat/functions/image-functions.php';
	require 'capnhat/functions/seo-functions.php';
	
	require 'capnhat/functions/group-functions.php';
	require 'capnhat/functions/member-functions.php';
	# Bộ đếm
	set_counter();
	global $id,$config; $id=array();
	# SET Themes
	define('themes',$config['themes'],true);
	# Lấy ID;
		# Nếu là SEO link thì nhập biến theo kiểu này
		if ($config['seo'] == 1) {
			$id['com']		= 	$config['com_default'];
			$id['target'] 	= 	'main';
			$chuoiurl	= $_SERVER['REQUEST_URI']; // nhận chuỗi từ address bar
			$timq	= explode("?q=",$chuoiurl);
			
			$atc	= $timq[0];
			$atc	= explode("/",$atc);  // cắt chuỗi và đổ vào $atc
			//echo $atc[$config['seopath']]."=====";
			$sum =count($atc);
			
			// truyền giá trị com,target,option vào $id
			for($i=$config['seopath'];$i<$sum;$i++){
				// nếu có &, chính là các com,target,option
				$ncom = strpos($atc[$i],"&");
				if($ncom){ 
					$stri	= explode("&",$atc[$i]);
					$id[$stri[0]]		= 	$stri[1];
				}
			}
			
			$p404 = 0;
			if($sum > $config['seopath']){	// nếu ko phải là trang chủ thì làm
					
					/*$array_end2 = strpos($atc[$sum-1],"@"); //TRƯỜNG HỢP DÙNG CÁC OPTION,TARGET KHÁC THÌ BẬT LÊN
					if($array_end) $kieu = ".html");		  //SAU ĐÓ KIỂM TRA $kieu ĐỂ THỰC HIỆN
					else if($array_end2) $kieu = "@";*/
					// Lấy detail,page,ok và cate
					
				if($atc[$sum-1]!=''){		// nếu mảng cuối khác rỗng thì có detail
					$array_end = strpos($atc[$sum-1],".html");
					if($array_end){
						$stri 	= str_replace(".html","",$atc[$sum-1]);
						$stri	= explode("_",$stri);
						$id['detail'] = $stri[1];
					}
						
					$stri	= explode("_",$atc[$sum-1]);									
					for($m=0;$m<count($stri);$m++){
						$ncom = substr($stri[$m],0,1); // lấy ký tự đầu
						switch ($ncom)
						{
							case 'P':
							  $id['page']	= (int)substr($stri[$m],1); $e404 = 0;
							  break;
							case 'O':
							 $id['ok'] 		= (int)substr($stri[$m],1); $e404 = 0;
							  break;
							case 'C':
							 $id['cate'] 	= (int)substr($stri[$m],1); $e404 = 0;
							  break;
							case 'L':
							 $id['lang'] 	=  substr($stri[$m],1); $e404 = 0;
							  break;
							default:
								$e404 = 1;
							  break;
						}
					}
					$detail = art_deta($id['detail']); // kiểm tra id detail có tồn tại không ?
					if(($id['detail']=='' || count($detail)==0) && $e404 == 1 )  $p404 = 1;
					
				}
				$atc = getIdbyKey($atc[$sum-2]);
				
				if($atc[0]['category']!='')
					$id['category'] = $atc[0]['category'];
				else
					$p404 = 1;
					
				
				
			}//end if
			//echo $id['page']."===".$id['detail'];
			$id['seotitle'] = seo_atc($id['category'],$id['detail']); 
		} else {
		# Ngược lại thì lấy kiểu truyền thống
			$gnc	= $_GET['global'];	
			$gnc 	= explode(',',$gnc);
			while (list($key,$value)=each($gnc)) {
				if ($value!='') {
				$value = explode(':',$value);
				$id[$value[0]]	= $value[1];
				}
			}
		}
		
if($p404 == 1)
	echo "<script>window.location='".$config['url']."404.shtml';</script>";
else{
			
  		# Nếu chưa tồn tại một com và target thì tự set
		if ($id['com'] == '' || $id['target'] == '') {
			$id['com']		= 	$config['com_default'];
			$id['target'] 	= 	'main';
			//header("location:".sys_link('com='.$id['com'].'&target='.$id['target']));
		}	
		# Nếu chưa tồn tại tiêu đề thì lấy tiêu đề mặc địch
		if($id['title'] == "") $id['title'] = $config['varurl'];	
	
	# Gọi ngôn ngữ khi có sự yêu cầu
	if ($id['lang'] != '' && ($id['lang'] == 'vn' || $id['lang'] == 'en')) $_SESSION['lang'] = $id['lang'];
	if ($_SESSION['lang'] != '') $config['default_language'] = $_SESSION['lang'];
	# Lấy ngôn ngữ đưa vào sử dụng
	$languages = languagedetail($config['default_language']); 
	
	# Kiểm tra trang thông tin
		if (is_file('sources/'.$id['com'].'/'.$id['target'].'.php')) {
			require 'sources/'.$id['com'].'/'.$id['target'].'.php';
		} else sys_file('sources/'.$id['com'].'/'.$id['target'].'.php');
		# Load các hàm auto
		require 'templates/header.html.php';
		if ($id['option'] != '') {
			if (is_file('sources/'.$id['com'].'/'.$id['target'].'.'.$id['option'].'.php')) {
				require('sources/'.$id['com'].'/'.$id['target'].'.'.$id['option'].'.php');
			} else sys_file('sources/'.$id['com'].'/'.$id['target'].'.'.$id['option'].'.php');
			if (is_file('templates/'.$id['com'].'/'.$id['target'].'.'.$id['option'].'.html.php')) {
				require('templates/'.$id['com'].'/'.$id['target'].'.'.$id['option'].'.html.php');
			} else {
				sys_file('templates/'.$id['com'].'/'.$id['target'].'.'.$id['option'].'.html.php');
				require 'templates/error.html.php';
			}	
		} else if ($id['target'] != '') {
			if (is_file('templates/'.$id['com'].'/'.$id['target'].'.html.php')) {
				require('templates/'.$id['com'].'/'.$id['target'].'.html.php');
			} else {
				sys_file('templates/'.$id['com'].'/'.$id['target'].'.html.php');
				require 'templates/error.html.php';
			}	
		} else {
				require 'templates/main.html.php';
		}
		# Load Template Footer & Env report
		//require 'templates/env.report.php';
		require 'templates/footer.html.php';
	# Và xử lý menu
	@mysql_close($mysql);
}
?>
