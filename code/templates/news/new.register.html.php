<div class="bgtrang">	
	<div class="rows">
		<div class="lefts">
			<div class="pro_list">
				<div class="regbox regbox_corner_top regbox_corner_bottom">
					<div class="regbox_header regbox_corner_top">
						<?=$danhmuc[0]['title'];?>
					</div>
					<div class="regbox_cont">
						<div class="regbox_cont_note">
							Nếu bạn đã có tài khoản các mạng XH sau đây, không cần đăng ký vẫn có thể đăng nhập:
						</div>
						<div class="login">
							<div class="wrap-login">
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=37');?>" class="lg-xlmb_2">Xalomuaban</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=facebook" class="lg-face">Facebook</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=yahoo" class="lg-yahoo">Yahoo</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=google" class="lg-google">Google</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=twitter" class="lg-twitter">Twitter</a>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
					
						<div id="yarnball">
							<ul class="yarnball">
								<li id="yarnlet_1" class="yarnlet first yarnlet_now">
									<a style="z-index: 9;">
										<span class="left-yarn" style="background-position: 0 -48px;"></span>
										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tạo tài khoản &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									</a>
								</li>
								<li id="yarnlet_2" class="yarnlet">
									<a style="z-index: 8;" class="topic-link">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thông tin cá nhân&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
								</li>
								<li id="yarnlet_3" class="yarnlet">
									<a style="z-index: 7;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thông tin xác thực&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
								</li>
							</ul>
						</div>
						<div class="clear"></div>
					<? if($xacnhan==''){?>	
						<div id="newuser_1" class="formdangnhap" style="display:block">
								<table cellpadding="7" cellspacing="2" width="100%">
									<? 	foreach($newuser1 as $ks => $vs){
											if($ks =='usersname') $types = 'text'; else $types = 'password';
									?>
									<tr>
										<td valign="center" align="left" style="width:120px; font-weight:bold; color:#558896;"><?=$vs;?></td>
										<td valign="top" align="left">
											<input type="<?=$types;?>" name="<?=$ks;?>" id="<?=$ks;?>" class="inlog" autocomplete='off' />
										</td>
										<td valign="center" align="left" width="40%">
											&nbsp;
											<span id="kqcheck_<?=$ks;?>" style=" color:#444; font-size:11px; color:#336633;"></span>
										</td>
									</tr>
									<? } ?>
								</table>
						</div>
						
						<div id="newuser_2" class="formdangnhap" style="display:none">
								<table cellpadding="7" cellspacing="2" width="100%">
									<? 	foreach($newuser2 as $ks => $vs){?>
									<tr>
										<td valign="center" align="left" style="width:120px; font-weight:bold; color:#558896;"><?=$vs;?></td>
										<td valign="top" align="left">
											<input type="text" name="<?=$ks;?>" id="<?=$ks;?>" class="inlog" style="width:80%;" />
										</td>
										<td valign="center" align="left" width="10%">&nbsp;</td>
									</tr>
									<? } ?>
								</table>
						</div>
						
						<div id="newuser_3" class="formdangnhap" style="display:none;">
							<div style="margin:5px 15px 5px 15px;line-height:18px;">
								<p style="text-align:center; color:#CC6600; font-weight:bold;">Đăng ký thành công</p>
								<p style="text-align:center;">Chúc mừng thành viên Xalomuaban.com</p>
								<span>Để chắc chắn là bạn chứ không phải ai khác sử dụng email, điện thoại để đăng nhập vui lòng thực hiện các bước sau:</span>
								<ul style="list-style:decimal;">
									<li>Kiểm tra email để kích hoạt tài khoản
(Vui lòng kiểm tra trong bulk mail hoặc spam mail của bạn nếu bạn không nhận được email trong hộp thư đến).<br /></li><br />
									<li>Soạn tin theo cú pháp xxx &lt;tên đăng nhập&gt; gửi 8xxx để xác thực tài khoản.
									</li>
								</ul>
							</div>
						</div>
					<? }else{?>
						<div id="newuser_3" class="formdangnhap">
							<div style="margin:5px 15px 5px 15px;line-height:18px;">
								<p style="text-align:center; color:#CC6600; font-weight:bold;"><?=$xacnhan;?></p>
								<p style="text-align:center;">Chúc mừng thành viên Xalomuaban.com</p>
								<p style="text-align:center;">Bây giờ bạn có thể đăng sản phẩm và quản lý đầy đủ thông tin bán hàng của bạn.<br /><br /></p>
							</div>
						</div>
					<? }?>
						<div class="loading112">&nbsp;</div>
					</div>
					<div class="regbox_footer regbox_corner_bottom">
						<? if($xacnhan==''){?>
						<input type="button" name="nutquaylai" id="nutquaylai" class="newuser_button" value=" Quay lại " style="display:none; float:left;" />
						<input type="button" name="nuttieptuc" id="nuttieptuc" class="newuser_button" value=" Tiếp tục " style="display: inline; color:#777;" />
						<input type="button" name="nutluulai" id="nutluulai" class="newuser_button" value=" Lưu lại " style="display: none;" />
						<? }?>
					</div>
				</div>
			</div>
		</div>
		<div class="jquery_ms"></div>
		
		<?=sys_option('home','main','right');?>
		
	</div>
</div>