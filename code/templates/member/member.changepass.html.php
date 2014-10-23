<div class="tcn">
	<div class="tcn_contents">
		<? if($ok==1) echo $msg; else{?>
		
		<? if($memberdt[0]['password']=='')
			echo 'Bạn đang đăng nhập bằng tài khoản mạng XH '.$memberdt[0]['oauth_provider'].'<br /> Username của bạn là : <b>'.$memberdt[0]['usersname'].'</b>, Bạn chỉ cần nhập mật khẩu mới và sử dụng như 1 tài khoản bình thường.<br /><br /> ';
		?>
		<font style="color:#f00;"><?=$msg;?></font><br /><br />
		
		<form action="" enctype="multipart/form-data" method="post">
		<table cellpadding="5" cellspacing="0">
			
			<? foreach($makhau as $field =>$configuser){
				if($field=='password_old' && $memberdt[0]['password']==''){
					echo '';
				}else{
			?>
				<tr>
					<td width="170" valign="top"><?=$configuser['vn'];?></td>
					<td valign="top" align="<?=$configuser['align'];?>">
						<input type="<?=$configuser['type'];?>" name="<?=$field;?>" id="<?=$field;?>" class="tcninput" style="width:<?=$configuser['width'];?>px;" value="<?=$_POST[$field];?>"  />
						
					</td>
				</tr>
			<? } } ?>
				<tr>
					<td>&nbsp;</td>
					<td align="left">
						<input type="submit" name="luulai" id="luulai" value=" Đổi mật khẩu " />
					</td>
				</tr>
		</table>
		</form>
		<? }?>
	</div>
</div>
