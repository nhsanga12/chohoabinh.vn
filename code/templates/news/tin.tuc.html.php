<?php
	global $id,$config,$pages;
	$temp = $config['limit_news'];
	$config['limit_news'] = 12;
	
	if($id['category']=='17')
		$cats = 14;
	else
		$cats = $id['category'];
		
	if($id['cate']==10){
		$sanpham = newnews($cats);
		$styhot = "color:#FF9900";
		$sty = "";
	}else{
		$sanpham = getnews($cats);
		$styhot = "";
		$sty = "color:#FF9900";
	}
	
	$config['limit_news'] = $temp;
		
	$catlist = explode(",",$config['grouphome']);
	$bannerlist = explode(",",$config['groupbanner']);
	
	$danhmuc = categories_detail($id['category']);
	$danhmuccon = categories_by_cat_group(1,$id['category']);
	
?>
<div class="bgtrang">
	<div class="rows" style="margin-top:0px;">
		<div class="lefts">
			<div class="pro_sublink" style="margin-top:0px;">
				<div class="pro_sublink_list">
					<div style="height:30px; float:left;">
						<a href="<?=sys_link('com=home&target=main&category='.$id['category']);?>" class="pro_mainlink" style="font-size:14px; font-weight:bold;<?=$sty;?>">
							Tin mới
						</a>|
					</div>
					<div style="height:30px; float:left;">
						<a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&cate=10');?>" class="pro_mainlink" style="font-size:14px; font-weight:bold;<?=$styhot;?>">
							Tin hot
						</a>
					</div>
				</div>
			</div>
			<div class="pro_list">
				
				<div class="pro_list_cont">
                	<input name="danhmuc" id="danhmuc" type="hidden" value="<?=$cats;?>" />
                    <input name="trang" id="trang" type="hidden" value="3" />
                    <input name="hot" id="hot" type="hidden" value="<?=$id['cate'];?>" />
                    <input name="stop" id="stop" type="hidden" value="0" />
                    
					<table cellpadding="0" cellspacing="0" width="100%" class="newslists">
						<? for($n=0;$n<count($sanpham);$n++){?>
							<tr>
								<td width="160" valign="top">
									<div class="imgnews">
									<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'].'&cate='.$id['cate']);?>">
										<? if($sanpham[$n]['picture']=='' || $sanpham[$n]['picture']== 'icon_view.png' || $sanpham[$n]['picture']=='icon_dongsukien_red.png' || $sanpham[$n]['picture']=='pix_news.jpg'){?>
											<img src="<?=$config['url'];?>themes/default/images/News-Icon24.jpg" alt="Xa lộ tin tức" class="news_img" border="0" />
										
										<? }else{?>
											<img src="<?=$config['url'];?>lib/articles/<?=$sanpham[$n]['picture'];?>" alt="<?=$sanpham[$n]['title'];?>" class="news_img" border="0" />
										<? }?>
									</a>
									</div>
								</td>
								<td width="480" valign="top">
									<div class="noidungtomtat" style="border:none;">
										<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id'].'&cate='.$id['cate']);?>"><h2 style="margin-bottom:3px;"><?=$sanpham[$n]['title'];?></h2></a>
										<p class="newsupdate">
											<font style="color:#993300;">
												<?=date("H:i",$sanpham[$n]['lastdate']);?>
											</font> | 
											<?=date("d/m/Y",$sanpham[$n]['lastdate']);?>
											 &nbsp;&nbsp; <?=$sanpham[$n]['local'];?>
										</p>
										<p class="sumnews">
											<?=sys_cut(html2text($sanpham[$n]['quick'].$sanpham[$n]['contents']),450);?>
										</p>
									</div>
								</td>
								<td valign="top" align="center">
									
									<?php
										if($sanpham[$n]['likes']=='' || $sanpham[$n]['likes']=='0')
											$lk = 1;
										else
											$lk = (int)$sanpham[$n]['likes'];
									?>
							
									<div class="likebt" onclick=" update_likes('<?=$sanpham[$n]['id'];?>','<?=$lk+1;?>');" style="cursor:pointer;">
										<div class="amount_like" style="margin-left:65px;">
											<table cellpadding="0" cellspacing="0" style="border:none;">
												<tr>
													<td style="border:none;"><div class="amount_like_left"></div></td>
													<td style="border:none;"><div class="amount_like_center" id="amount_like_<?=$sanpham[$n]['id'];?>"><?=$lk;?></div></td>
													<td style="border:none;"><div class="amount_like_right"></div></td>
												</tr>
											</table>
										</div>
									</div>
									<br />
									Lượt xem: <?=$sanpham[$n]['opt'];?><br /><br />
									<div class="sharebt sharelink" rel="<?=$n;?>" style="cursor:pointer;">&nbsp;</div>
								</td>
							</tr>					
						<? }?>
					</table>
					&nbsp;
				</div>
				
                <div id="loading"></div>
				
                <!--<div class="phantrang">
					<?if($pages['page']>1)
							divPageup(9);
					?>
				</div>-->
				
			</div>
						
		</div>
		
		
		<!--CỘT PHẢI-->
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