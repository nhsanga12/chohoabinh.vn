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
	require 'templates/header.html.php';
	
	if(isset($_POST['luulai']) && $_POST['linkss']!='' && ($_POST['danhmuc']!='' || $_POST['loaisanpham2']!='')){
		$newscat = $_POST['danhmuc'];
		if($newscat=='')
			$newscat = $_POST['loaisanpham2'];
		
		$linknews = $_POST['linkss'];
	
		$setting = array(
			"data" => array(	
						"begin" 	=> "<!-- End View Filter -->",
						"end" 		=> '<div class="paper">',
						"begin2" 	=> "<ul>",
						"end2" 		=> "</ul>",
					),
			"block" => array(	
						"begin" 	=> 'class="product">',
						"end" 		=> "</li>",
					),
			"link" => array(	
						"begin" 	=> 'href="http://',
						"end" 		=> '"',
					),
			"pic" => array(	
						"begin" 	=> 'src="',
						"end" 		=> '"',
					),
			"ma" => array(	
						"begin" 	=> 'alt="',
						"end" 		=> '"',
					),
			"local" => array(	
						"begin" 	=> 'class="price">',
						"end" 		=> '<span',
					),
		);
		
		$setting_dt = array(
			"data" => array(	
						"begin" 	=> 'class="breadcrumb"',
						"end" 		=> 'sidebar-detail',
					),
			"title" => array(	
						"begin" 	=> 'itemprop="name">',
						"end" 		=> '</h1>',
					),
			"quick" => array(
						"begin" 	=> '<div id="tab3" class="ctn-detail-desc">',
						"end" 		=> '<div id',	
						"begin2" 	=> '<h2 class="summary-product">',
						"end2" 		=> '</h2>',
					),
			"contents" => array(	
						"begin" 	=> '<div id="tab2" class="ctn-detail-desc">',
						"end" 		=> '<div id',
						"begin2" 	=> '<div id="tab1" class="ctn-detail-desc">',
						"end2" 		=> '<div id',
					),
			"khuvuc" => array(	
						"begin" 	=> 'Phạm vi:</dt>',
						"end" 		=> '</dl>',
					),
			"codes" => array(	
						"begin" 	=> 'Mã SP:',
						"end" 		=> ')',
					),
			"img" => array(	
						"begin" 	=> "img_",
						"end" 		=> '"',
					),
			"savepic" => array(	
						"host" 		=> "lib/articles/",
						"domain" 	=> "http://123mua.vn",
					),
		);
		
		$setting_user = array(
			"data" => array(	
						"begin" 	=> 'Thông tin người bán',
						"end" 		=> 'Xem tất cả sản phẩm của shop',
					),
			"username" => array(	
						"begin" 	=> '<h3>',
						"end" 		=> '</h3>',
					),
			"address" => array(	
						"begin" 	=> 'text-addr">',
						"end" 		=> '</p>',
					),
			"phone" => array(	
						"begin" 	=> 'Điện thoại:',
						"end" 		=> "</p>",
					),
			"email" => array(	
						"begin" 	=> 'createFunc("',
						"end" 		=> '"',
					),
			"website" => array(	
						"begin" 	=> '<p class="website">',
						"end" 		=> '</p>',
					),
			"yahoo" => array(	
						"begin" 	=> "ymsgr:sendim?",
						"end" 		=> "'",
					),
		);
		
		$url = "123mua.vn";
		
		
		
		$links = html_datalist($linknews,$setting);
		/*echo count($links);
		echo "<pre>";
		print_r($links);
		echo "</pre>";*/
				
		if (is_array($links)){
			$n = 0;
			foreach($links as $key => $value){
				if(check_in_news($value['ma'])){
					$user[$n] = html_detail_user('http://'.$key,$setting_user);
					$datas[$n] = html_detail_products($url,'http://'.$key,$value,$setting_dt);
					//echo $n."=0k<br />";
					usleep(50000);
				}//else
					//echo $n.".........................<br />";
				if($n>9) break;
				$n++;
			}
			
			
			/*echo "<pre>";
			print_r($datas);
			echo "</pre>";*/
			
			//luu tin
			if(count($datas)>0){
				$userid = save_user($user);
				/*echo "<pre>";
				print_r($userid);
				echo "</pre>";*/
				save_products($newscat,$datas,$userid);
			}
			
		}
		$sms = " Đã lưu sản phẩm ";
	}else
		$sms = " Vui lòng nhập link và chọn danh mục cần lưu ";
?>
	<?=$sms;?><br />
	<table>
    <form action="" method="post" enctype="multipart/form-data">
        <tr>
            <td>Link:</td>
            <td><input name="linkss" type="text" style="width:500px;" value="<?=$_POST['linkss'];?>" /></td>
        </tr>
        <tr>
            <td>Loại sản phẩm</td>
            <td align="left">
                <div class="tcnsediv" id="sploai01">
						<select name="loaisanpham1" id="loaisanpham1" class="tcnselect" rel="2" style="width:200px;">
							<option value="" label="-------">-------</option>
							<?  if(isset($_POST['danhmuc'])){
								$cat_3	=	$_POST['danhmuc'];
								$cat_2	=	get_parentid_category($cat_3);
								$cat_1	=	get_parentid_category($cat_2);
							
								
								$loai02 = categories_by_cat_group(1,$cat_1);
								$loai03 = categories_by_cat_group(1,$cat_2);
								}
								$loai01 = categories_by_cat_group(1,2);
							?>
							<? for($m=0;$m<count($loai01);$m++){ 
							
							   if($loai01[$m]['id']==$cat_1) $selectxt = ' selected="selected"'; else $selectxt = '';
							?>
								<option value="<?=$loai01[$m]['id'];?>" label="<?=$loai01[$m]['title'];?>" <?=$selectxt;?>><?=$loai01[$m]['title'];?></option>
							<? }?>
						</select>
					</div>
					<div class="tcnsediv" id="sploai02">
						<select name="loaisanpham2" id="loaisanpham2" class="tcnselect" rel="3" style="width:200px;">
							<? for($m=0;$m<count($loai02);$m++){ 
							
							   if($loai02[$m]['id']==$cat_2) $selectxt = ' selected="selected"'; else $selectxt = '';
							?>
								<option value="<?=$loai02[$m]['id'];?>" label="<?=$loai02[$m]['title'];?>" <?=$selectxt;?>><?=$loai02[$m]['title'];?></option>
							<? }?>
						</select>
					</div>
					<div class="tcnsediv" id="sploai03">
						<select name="danhmuc" id="loaisanpham3" class="tcnselect" rel="3" style="width:200px;">
							<? for($m=0;$m<count($loai03);$m++){ 
							
							   if($loai03[$m]['id']==$cat_3) $selectxt = ' selected="selected"'; else $selectxt = '';
							?>
								<option value="<?=$loai03[$m]['id'];?>" label="<?=$loai03[$m]['title'];?>" <?=$selectxt;?>><?=$loai03[$m]['title'];?></option>
							<? }?>
						</select>
					</div>
            </td>
        </tr>
        <tr>
        	<td colspan="2">
        		<input type="submit" name="luulai" value=" Lưu lại " />
            </td>
        </tr>
	</form>
    </table>

<?
	require 'templates/footer.html.php';
	@mysql_close($mysql);
?>
