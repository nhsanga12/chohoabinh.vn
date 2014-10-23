<?php
	require 'include/option.php';
	global $id,$config,$languages;
	$banner_right = news_by_cat(16,1,20);
	
	$danhmuc = categories_detail($id['category']);
	
?>
<div class="bgtrang">
	<div class="rows">
		<div class="lefts">
			<div class="pro_list">
				<div class="regbox regbox_corner_top regbox_corner_bottom">
					<div class="regbox_header regbox_corner_top">
						Đang kết bằng tài khoản mạng xã hội <font style=" font-weight:bold; text-transform:capitalize;"><? echo $_GET['q'];?></font> 
					</div>
					<div class="regbox_cont">
						<div id="dangnhap" class="formdangnhap" style="display:block">
							<form action="" enctype="multipart/form-data" method="post">
								<table cellpadding="7" cellspacing="2" width="100%">
									<? 	foreach($newuser1 as $ks => $vs){
										if($ks !='repassword'){
											if($ks =='usersname') $types = 'text'; else $types = 'password';
									?>
									<tr>
										<td valign="center" align="left" style="width:120px; font-weight:bold; color:#558896;"><?=$vs;?></td>
										<td valign="top" align="left">
											<input type="<?=$types;?>" name="xlmb_<?=$ks;?>"  class="inlog" />
										</td>
										<td valign="center" align="left" width="20%">&nbsp;</td>
									</tr>
									<? } } ?>
									
									<tr>
										<td valign="center" align="left" style="width:120px; font-weight:bold; color:#558896;"></td>
										<td valign="top" align="left">
											<input type="checkbox" name="nhomatkhau" id="nhomatkhau" />
											Nhớ mật khẩu<br /><br />
											<div style=" display:table; clear:both;">
												<input type="submit" name="nutdangnhap" id="nutdangnhap" class="newuser_button" value=" Đăng nhập " style="float:left;" />
												<input type="button" name="nutdangky" id="nutdangky" class="newuser_button" value=" Đăng ký " style=" float:left; margin-left:25px;" onclick="newLocation('<?=sys_link('com=home&target=main&category=39');?>');" />
											</div>
						
											<br /><br /><a href="#" style="text-decoration:underline;">Quên mật khẩu ?</a>
										</td>
										<td valign="center" align="left" width="20%">
											
										</td>
									</tr>
								</table>
							</form>
						</div>
						<div class="regbox_cont_note">
							Nếu bạn không đăng ký có thể đăng nhập thông qua tài khoản mạng XH sau:
						</div>
						<div class="login">
							<div class="wrap-login">
								<div class="xalomuaban">
									<a href="#" class="lg-zing">ZingMe</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=facebook" title="Đăng nhập bằng tài khoản Facebook." class="lg-face">Facebook</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=yahoo" title="Đăng nhập bằng tài khoản Yahoo." class="lg-yahoo">Yahoo</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=google" title="Đăng nhập bằng tài khoản Google." class="lg-google">Google</a>
								</div>
								<div class="xalomuaban">
									<a href="<?=sys_link('com=home&target=main&category=80');?>?q=twitter" class="lg-twitter">Twitter</a>
								</div>
								<div class="clear"></div>
							</div>
							<div class="clear"></div>
						</div>
						
					</div>
					<div class="regbox_footer regbox_corner_bottom">&nbsp;</div>
				</div>
			</div>
		</div>
		<div class="jquery_ms"></div>
		
		<?=sys_option('home','main','right');?>
	</div>
</div>