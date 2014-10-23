<div class="bgtrang">	
	<div class="rows">
		<div class="lefts">
			
			<div class="chitietsp">
				<div class="chitietsp_header">
					<span><?=$title[0]['title'];?></span>
				</div>
			</div>
			
			<div class="phanhoi">
				<div class="phanhoi_header">
					&nbsp;&nbsp;&nbsp;Vui lòng nhập thông tin liên hệ và nội dung yêu cầu vào bên dưới.
				</div>
				<div class="phanhoi_form">
					<?=$msm;?>
					<? if($off==0) {?>
					<form action="" enctype="multipart/form-data" method="post">
					<table>
						<tr>
							<td>Họ tên</td>
							<td>
								<input type="text" name="fullname" id="fullname" class="phanhoi_input" value="<?=$_POST['fullname'];?>" />
							</td>
						</tr>
						<tr>
							<td>Điện thoại</td>
							<td>
								<input type="text" name="dienthoai" id="dienthoai" class="phanhoi_input" value="<?=$_POST['dienthoai'];?>" />
							</td>
						</tr>
						<tr>
							<td>Email</td>
							<td>
								<input type="text" name="email" id="email" value="<?=$_POST['email'];?>" class="phanhoi_input" />
							</td>
						</tr>
						<tr>
							<td>Nội dung</td>
							<td>
								<textarea name="noidung" id="noidung" class="phanhoi_input" style="width:350px; height:150px; padding:5px; line-height:18px;"><?=$_POST['noidung'];?></textarea>
							</td>
						</tr>
						<tr>
							<td>Ký tự ngẫu nhiên</td>
							<td>
								<input type="text" name="verification" id="verification" class="phanhoi_input" style=" float:left; width:99px;" value="<?=$_POST['verification'];?>" />
								<div style="width:99px; background:#fff; height:25px; float:left;margin:5px 0px 5px 10px;">
									<img src="<?=$config['url']?>security.php" width="90" height="24" />
								</div>
								<input type="submit" name="nutgui" id="nutgui" value=" Gửi " class="phanhoi_send" />
							</td>
						</tr>
					</table> 
					</form>
					<? }?>
				</div>
			</div>
			
			<div class="phanhoi">
				<div class="phanhoi_form">
					<?=$artlist[0]['contents'];?>
				</div>
			</div>
						
		</div>
		
		
		
		<!--CỘT PHẢI-->
		<?=sys_option('home','main','right');?>
		
	</div>
</div>