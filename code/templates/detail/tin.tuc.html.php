
<div class="bgtrang">
	<div class="rows">
		<div class="lefts">
			<div class="pro_list">
				<div class="pro_list_cont">
					<div class="chitiettin">
						<?=$msm;?>
						<h1><?=$chitiet[0]['title'];?></h1>
						<p class="newsupdate">
							
							<font style="color:#993300;">
								<?=date("H:i",$chitiet[0]['lastdate']);?>
							</font> | 
							<?=date("d/m/Y",$chitiet[0]['lastdate']);?>
							&nbsp;&nbsp; <?=$chitiet[0]['local'];?>
						</p>
						<p class="newsquick"><?=$chitiet[0]['quick'];?></p>
						<? if($chitiet[0]['picture']=='1212'){?>
							<div class="chitiethinh">
								<img src="<?=$config['url'];?>lib/articles/<?=$chitiet[0]['picture'];?>" alt="<?=$chitiet[0]['title'];?>" border="0" width="350" />
							</div>
						<? }?>
						<?=remove_link_tag($chitiet[0]['contents']);?>
					</div>
				</div>
			</div>
			
			
			<? if(count($sms)>0){?>
			<div class="phanhoi">
				<div class="phanhoi_header">
					&nbsp;&nbsp;&nbsp;Phản hồi
				</div>
				<div class="phanhoi_form">
					<table width="100%" cellspacing="2">
						<? for($i=0;$i<count($sms);$i++){?>
							<tr>
								<td valign="top" width="60">
									<? 	if($sms[$i]['profile_image']){?>
										<img src="<?=$sms[$i]['profile_image'];?>" alt="hinhdaidien" width="50" style=" margin:0 5px;" />
									<? }else{?>
										<div style="border:1px solid #ddd; width:50px; height:50px; display:table; text-align:center; vertical-align:middle; color:#ddd;">Không hình</div>
									<? }?>
								</td>
								<td valign="top">
									<font style="color:#3B5998; font-weight:bold; font-size:12px; line-height:15px;">
									<? 	if($sms[$i]['fullname'])
											echo $sms[$i]['fullname'];
										else
											echo $sms[$i]['dienthoai'];
									?>
									</font><br />
									<?=$sms[$i]['contents'];?>
								</td>
								<td width="120" align="right" style="color:#666; font-size:11px;">
									<?=date("H:i \N\g\à\y d-m-Y",$sms[$i]['bydate']);?>
								</td>
							</tr>
							<tr><td height="10" align="right" colspan="3" style="border-top:1px solid #eef;">&nbsp;</td></tr>
						<? }?>
					</table>
				</div>
			</div>
			<? }?>
			<div class="phanhoi">
				<div class="phanhoi_header">
					&nbsp;&nbsp;&nbsp;Gửi phản hồi
				</div>
				<div class="phanhoi_form">
					<form action="" enctype="multipart/form-data" method="post">
					<table>
						<tr>
							<td>Điện thoại</td>
							<td>
								<input type="text" name="dienthoai" id="dienthoai" value="<?=$yourdt[0]['phone'];?>" class="phanhoi_input" />
							</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>
								<input type="text" name="email" id="email" value="<?=$yourdt[0]['email'];?>" class="phanhoi_input" />
							</td>
						</tr>
						<tr>
							<td>Nội dung</td>
							<td>
								<textarea name="noidung" id="noidung" class="phanhoi_input" style="width:350px; height:150px; padding:5px; line-height:18px;"></textarea>
							</td>
						</tr>
						<tr>
							<td>Ký tự ngẫu nhiên</td>
							<td>
								<input type="text" name="verification" id="verification" class="phanhoi_input" style=" float:left; width:99px;" />
								<div style="width:99px; background:#fff; height:25px; float:left;margin:5px 0px 5px 10px;">
									<img src="<?=$config['url']?>security.php" width="90" height="24" />
								</div>
								<input type="submit" name="nutgui" id="nutgui" value=" Gửi " class="phanhoi_send" />
							</td>
						</tr>
					</table> 
					</form>
				</div>
			</div>
			
			<div class="phanhoi">
				<div class="phanhoi_header">
					&nbsp;&nbsp;&nbsp;Các bài viết khác cùng chủ đề
				</div>
				<div class="phanhoi_form">
					<div class="pro_list_cont">
						<input name="danhmuc" id="danhmuc" type="hidden" value="<?=$id['category'];?>" />
                    	<input name="trang" id="trang" type="hidden" value="<?=$id['page'];?>" />
                   		<input name="hot" id="hot" type="hidden" value="<?=$id['cate'];?>" />
                    	<input name="stop" id="stop" type="hidden" value="0" />
                    
                        <table cellpadding="0" cellspacing="0" width="100%" class="newslists">
                            <? for($n=0;$n<count($sanpham);$n++){ if($sanpham[$n]['id']!=$id['detail']){?>
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
                            <? } } ?>
                         </table>
						&nbsp;
					</div>
                    <div id="loading"></div>
				</div>
			</div>
			
		</div>
		
		
		<!--CỘT PHẢI-->
		<?=sys_option('home','main','right');?>
		
	</div>
</div>