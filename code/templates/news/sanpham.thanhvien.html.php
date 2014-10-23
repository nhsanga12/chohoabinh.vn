<div class="bgtrang">
	<div class="rows">
		<div class="lefts">			
			<div class="pro_list">
				<div class="pro_list_header">
					<div class="sptab">
						<span><? if($users[0]['tengianhang']) echo $users[0]['tengianhang']; else echo $users[0]['fullname'];?> </span>
					</div>
					<div class="spcolum">
						<span style="margin-left:300px;"> Thông tin </span>
						<span style="margin-left:280px;"> Xem </span>
					</div>
				</div>
				<div class="pro_list_cont">
					<table cellpadding="0" cellspacing="0" width="100%" class="tb_pro">
						<? for($n=0;$n<count($sanpham);$n++){ ?>
							<tr>
								<td width="180" valign="top">
									<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><img src="<?=$config['url'];?>lib/articles/thums_<?=$sanpham[$n]['picture'];?>" alt="<?=$sanpham[$n]['title'];?>" class="listpro_img" border="0" /></a>
								</td>
								<td width="400" valign="top">
									<div class="noidungtomtat">
										<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><h2><?=$sanpham[$n]['title'];?></h2></a>
										<table cellpadding="0" cellspacing="0" class="subpro" width="90%">
											<tr>
												<td colspan="2" height="80" valign="top">
													<?=sys_cut(html2text($sanpham[$n]['contents']),300);?>
												</td>
											</tr>
											<tr><td height="20" valign="bottom" width="70">Danh hiệu:</td><td  valign="bottom"><? if($users[0]['vip']==1) echo '<div class="vip">VIP</div>'; else echo '<div class="thanhvien">Thành viên</div>';?></td></tr>
											
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