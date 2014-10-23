<?php
	include('../../capnhat/config.php');
	$mysql = mysql_connect($config['db_servername'],$config['db_username'],$config['db_password']);
	$mysql = mysql_select_db($config['db_name'],$mysql) or die('Please set capnhat/config.php to connect a database !');
	mysql_query('SET CHARACTER SET utf8');
	require '../../capnhat/mysql/global-mysql.php';
	require '../../session.php'; 
	global $id, $config, $pages;
	# Thư viện các Hàm
	require '../../capnhat/functions/global-functions.php';
	require '../../capnhat/functions/auto-load.php';
	require '../../capnhat/functions/categories-functions.php';
	require '../../capnhat/functions/articles-functions.php';
	require '../../capnhat/functions/cal-functions.php';
	require '../../capnhat/functions/xml-functions.php';
	require '../../capnhat/functions/html-functions.php';
	require '../../capnhat/functions/image-functions.php';
	require '../../capnhat/functions/seo-functions.php';
	
	require '../../capnhat/functions/group-functions.php';
	require '../../capnhat/functions/member-functions.php';
	
	# Nội dung chính
	
	
	if($_POST['cat']!=''){
		$config['limit_news'] = 2;
		$id['page'] = (int)$_POST['trang']+1;
		$today  = (int)time();
		$fromdate = (int)$_POST['fromdate'];
		
		$sanpham = search_pro($_POST['cat'],$_POST['price_form'],$_POST['price_to'],$_POST['location'],$_POST['keys'],$today,$fromdate,1);
		
		$begin = ($id['page']-1)*$config['limit_news'];
		for($n=0;$n<count($sanpham);$n++){
?>
        <tr>
            <td width="180" valign="top">
                <a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'].'&page='.$id['page']);?>"><img src="<?=$config['url'];?>lib/articles/thums_<?=$sanpham[$n]['picture'];?>" alt="<?=$sanpham[$n]['title'];?>" class="listpro_img" border="0" /></a>
            </td>
            <td width="400" valign="top">
                <div class="noidungtomtat">
                    <a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'].'&page='.$id['page']);?>"><h2><?=$sanpham[$n]['title'];?></h2></a>
                    <table cellpadding="0" cellspacing="0" class="subpro" width="90%">
                        <tr>
                            <td width="70">Chủ shop:</td>
                            <td>
                                <a href="<?=sys_link('com=home&target=main&category=232&cate='.$sanpham[$n]['usersid']);?>"><?=$sanpham[$n]['fullname'];?></a>
                            </td>
                        </tr>
                        <tr><td>Điện thoại:</td><td><?=$sanpham[$n]['phone'];?></td></tr>
                        <tr><td valign="top">Địa chỉ:</td><td><?=$sanpham[$n]['address'];?></td></tr>
                        <tr><td>Tình trạng:</td><td><? if($sanpham[$n]['acti']=='') echo '<div class="xacthuc">Chưa xác thực thông tin</div>'; else echo 'Đã xác thực thông tin';?></td></tr>
                        <tr><td>Danh hiệu:</td><td><? if($sanpham[$n]['vip']==1) echo '<div class="vip">VIP</div>'; else echo '<div class="thanhvien">Thành viên</div>';?></td></tr>
                        
                        <tr><td></td>
                        
                        <?php
                             if($sanpham[$n]['likes']=='' || $sanpham[$n]['likes']=='0')
                                 $lk = 1;
                             else
                                 $lk = (int)$sanpham[$n]['likes'];
                        ?>
                        <td align="right">
                            <div class="amount_like" style="float: right; margin-top:0px;">
                                <table cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td><div class="amount_like_left"></div></td>
                                        <td><div class="amount_like_center" id="amount_like_<?=$sanpham[$n]['id'];?>"><?=$lk;?></div></td>
                                        <td><div class="amount_like_right"></div></td>
                                    </tr>
                                </table>
                            </div>	
                            <div class="likeshare" style="float: right;" onclick=" update_likes('<?=$sanpham[$n]['id'];?>','<?=$lk+1;?>');">Like</div>
                            <div class="sharelink likeshare" style="float: right;" rel="<?=$begin;?>">Share</div>
                        </td></tr>
                    </table>
                </div>
            </td>
            <td valign="top">
                <table cellpadding="0" cellspacing="0" class="subpro" style="margin:15px 1px 1px 25px;">
                    <tr><td width="70">Giá:</td>
                        <td>
                            <span class="pro_gia"><? $giatien =formatMoney($sanpham[$n]['gia'],0);
                            if($sanpham[$n]['loaitien']=='USD')
                                echo str_replace(".",",",$giatien);
                            else
                                echo $giatien;
                            ?></span>
                            <? if($sanpham[$n]['loaitien']=='USD') echo $sanpham[$n]['loaitien']; else echo 'đ';?>
                        </td>
                    </tr>
                    <tr><td>Lượt xem:</td><td><b><?=$sanpham[$n]['opt'];?></b></td></tr>
                    <tr><td>Phản hồi:</td><td><b><?=$sanpham[$n]['comments'];?></b></td></tr>
                    <tr>
                        <td colspan="2" align="center" valign="bottom" height="90">
                            <a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'].'&page='.$id['page']);?>"><div class="xemchitiet_bt" style="width:100px;">Xem chi tiết</div></a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
		
		<?php 
			$sharecont .= "<div class=\"bgxacnhan popuplink\" id=\"chiaselink_".$begin."\">
			
							<div class=\"popupxacnhan\">
							<div style=\"width:450px; height:auto;\" class=\"regbox regbox_corner_top regbox_corner_bottom\">
								<div class=\"regbox_header regbox_corner_top\" style=\"width:450px; text-align:left;\">
									<b>Chia sẽ link với các mạng xã hội</b>
								</div>
								<div class=\"regbox_cont\" id=\"noidungxoa\" style=\"height:250px; background:#fff;\">
									<br />
									Bạn có thể link sản phẩm đến các trang sau :
									<div class=\"login\">
										<div class=\"wrap-login\">
											<div class=\"xalomuaban\" style=\"margin-right:0px; margin-left:10px;\">
												<a href=\"http://www.facebook.com/sharer/sharer.php?u=".sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'])."\" target=\"_blank\" class=\"lg-face\">Facebook</a>
											</div>
											<div class=\"xalomuaban\">
												<a href=\"http://link.apps.zing.vn/share?url=".sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'])."\" target=\"_blank\" class=\"lg-zing\">Zing</a>
											</div>
											<div class=\"xalomuaban\">
												<a href=\"https://plus.google.com/share?url=".sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'])."&hl=vi\" target=\"_blank\" class=\"lg-google\">Google</a>
											</div> 
											<div class=\"xalomuaban\">
												<a href=\"https://twitter.com/intent/tweet?url=".sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'])."&text=".$sanpham[0]['title']."\" target=\"_blank\" class=\"lg-twitter\">Twitter</a>
											</div>
											<div class=\"clear\"></div>
										</div>
										<div class=\"clear\"></div>
									</div>
									hoặc copy đường link sau đây  và dán vào các trang cá nhân của bạn: <br />
									<input class=\"tcninput copylink\" value=\"".sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'])."\" style=\"margin-top:10px; width:80%;\" /><br /><br />
								
								</div>
								<div class=\"regbox_footer regbox_corner_bottom\"><input type=\"button\" name=\"nuthuyxoa\" class=\"newuser_button donglaibt\" value=\" Đóng lại \" style=\"display: inline;\"  rel=\"".$begin."\" /></div>
							</div>
						</div>
			
				</div>";
			
			
			
			$begin++;
		?>
							
<? 		}

		$_SESSION['user']['pages']++;
	}
	
	# Và xử lý menu
	@mysql_close($mysql);
	
	echo 'noidungketnoi'.$sharecont;

?>