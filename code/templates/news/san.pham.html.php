<?php
	global $id,$config,$pages,$languages;
	
	// tìm sản phẩm
	$pricestr = explode("-",$_POST['gia']);
	$price_form = $pricestr[0];
	$price_to = $pricestr[1];
	$location = $_POST['khuvuc'];
	if($_POST['keysearch']=='Từ cần tìm' || $_POST['keysearch']==$languages['searchip'])
		$keys = '';
	else
		$keys = $_POST['keysearch'];
	
	$today  = (int)time();
	if($_POST['thoigiandang']!=''){
		
		$dwidth = (int)$_POST['thoigiandang'];
		$dwidth = $dwidth*86400;
		$fromdate = $today - $dwidth;
		
	}else
		$fromdate = 0;

	$temp = $config['limit_news'];
	$config['limit_news'] = 10;
	
	$sanpham = search_pro($id['category'],$price_form,$price_to,$location,$keys,$today,$fromdate,1);
	
	$config['limit_news'] = $temp;
	
	$catlist = explode(",",$config['grouphome']);
	$bannerlist = explode(",",$config['groupbanner']);
	
	$danhmuc = categories_detail($id['category']);
	$danhmuccon = categories_by_cat_group(1,$id['category']);
	
	require 'include/option.php';
	
	
		
?>


<div class="bgtrang">
	<div class="rows">
		<div class="lefts">
			<div class="otimkiem">
				<form id="proform" action="<?=sys_link('com=home&target=main&category='.$id['category']);?>" method="post" enctype="multipart/form-data" >
					<div class="search_div">
						<select name="khuvuc" id="khuvuc" class="slsearch">
							<? select_form_array($khuvuc,$_POST['khuvuc']);?>
						</select>
					</div>
					<div class="search_div">
						<select name="gia" id="giasearch" class="slsearch">
							<? select_form_array($giaca,$_POST['gia']);?>
						</select>
					</div>
					<div class="search_div">
						<select name="thoigiandang" id="thoigiandang" class="slsearch">
							<? select_form_array($thoigian,$_POST['thoigiandang']);?>
						</select>
					</div>
					<input type="hidden" name="keysearch" value="<?=$_POST['keysearch'];?>" />
					<input class="searchbutton" type="submit" value="Chọn" name="nutchon" />
				</form>
			</div>
			
			
			<div class="pro_list">
				<div class="pro_list_header">
					<div class="sptab">
						<span> <?=$danhmuc[0]['title'];?> </span>
					</div>
					<div class="spcolum">
						<span style="margin-left:300px;"> Thông tin </span>
						<span style="margin-left:280px;"> Xem </span>
					</div>
				</div>
				<div class="pro_list_cont">
                	<input name="danhmuc" id="danhmuc" type="hidden" value="<?=$id['category'];?>" />
                    <input name="trang" id="trang" type="hidden" value="5" />
                   	<input name="price_form" id="price_form" type="hidden" value="<?=$price_form;?>" />
                    <input name="price_to" id="price_to" type="hidden" value="<?=$price_to;?>" />
                    <input name="location" id="location" type="hidden" value="<?=$location;?>" />
                    <input name="keys" id="keys" type="hidden" value="<?=$keys;?>" />
                    <input name="fromdate" id="fromdate" type="hidden" value="<?=$fromdate;?>" />
                    
                    <input name="stop" id="stop" type="hidden" value="8" />
                
                
					<table cellpadding="0" cellspacing="0" width="100%" class="tb_pro">
						<? for($n=0;$n<count($sanpham);$n++){?>
							<tr>
								<td width="180" valign="top">
									<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><img src="<?=$config['url'];?>lib/articles/thums_<?=$sanpham[$n]['picture'];?>" alt="<?=$sanpham[$n]['title'];?>" class="listpro_img" border="0" /></a>
								</td>
								<td width="400" valign="top">
									<div class="noidungtomtat">
										<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><h2><?=$sanpham[$n]['title'];?></h2></a>
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
												<div class="sharelink likeshare" style="float: right;" rel="<?=$n;?>">Share</div>
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
												<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><div class="xemchitiet_bt" style="width:100px;">Xem chi tiết</div></a>
											</td>
										</tr>
									</table>
								</td>
							</tr>					
						<? } ?>
					</table>
				</div>
                <div id="loading"></div>
			</div>
						
		</div>
		
		
		<?=sys_option('home','main','right');?>
		
	</div>
</div>


<? for($n=0;$n<count($sanpham);$n++){?>
	<div class="bgxacnhan popuplink" id="chiaselink_<?=$n;?>">
		<div class="popupxacnhan">
			<div style="width:450px; height:auto;" class="regbox regbox_corner_top regbox_corner_bottom">
				<div class="regbox_header regbox_corner_top" style="width:450px; text-align:left;">
					<b>Chia sẽ link với các mạng xã hội</b>
				</div>
				<div class="regbox_cont" id="noidungxoa" style="height:250px; background:#fff;">
					<br />
					Bạn có thể link sản phẩm đến các trang sau :
					<div class="login">
						<div class="wrap-login">
							<div class="xalomuaban" style="margin-right:0px; margin-left:10px;">
								<a href="http://www.facebook.com/sharer/sharer.php?u=<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>" target="_blank" class="lg-face">Facebook</a>
							</div>
							<div class="xalomuaban">
								<a href="http://link.apps.zing.vn/share?url=<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>" target="_blank" class="lg-zing">Zing</a>
							</div>
							<div class="xalomuaban">
								<a href="https://plus.google.com/share?url=<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>&hl=vi" target="_blank" class="lg-google">Google</a>
							</div>
							<div class="xalomuaban">
								<a href="https://twitter.com/intent/tweet?url=<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>&text=<?=$sanpham[0]['title'];?>" target="_blank" class="lg-twitter">Twitter</a>
							</div>
							<div class="clear"></div>
						</div>
						<div class="clear"></div>
					</div>
					hoặc copy đường link sau đây  và dán vào các trang cá nhân của bạn: <br />
					<input class="tcninput copylink" value="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>" style="margin-top:10px; width:80%;" /><br /><br />
				
				</div>
				<div class="regbox_footer regbox_corner_bottom"><input type="button" name="nuthuyxoa" class="newuser_button donglaibt" value=" Đóng lại " style="display: inline;"  rel="<?=$n;?>" /></div>
			</div>
		</div>
	</div>
<? }?>