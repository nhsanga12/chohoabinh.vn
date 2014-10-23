<div id="alert_box" style="background-color:#FFFFFF; margin-top:100px;">
	<div id="alert_header">&nbsp;&nbsp; <?=$langtext['sys_login']['title'];?> <b><?=$config['varurl'];?></b></div>
	<div id="alert_detail">
		<strong><?=$langtext['sys_login']['note'];?></strong>
		<form action="" method="post" enctype="multipart/form-data">
		<p>
			<span id="red"><?=$msg?><br /></span>
			<br />
			<table cellpadding="0" cellspacing="0" style=" margin: auto" border="0">
				<tr>
					<td width="50%"><?=$langtext['sys_login']['user'];?>:</td>
					<td><input type="text" name="username" /></td>
				</tr>
				<tr><td colspan="2" height="10">&nbsp;</td></tr>
				<tr>
					<td width="50%"><?=$langtext['sys_login']['pass'];?>:</td>
					<td><input type="password" name="password" /></td>
				</tr>
			</table>
			</p><br />
			<p>		
				<div id="login_left"></div>		
				<div id="login_right">
				<input style="margin-top:5px;" type="submit" name="submit" value="<?=$langtext['sys_login']['login'];?>" /></div>
			</p>
		</p>
		</form>
		<br /><br />
	</div>
</div>
<div class="fullwith">
	<div class="contarea" style="text-align:center;">
		<br /><?=$langtext['sys_basic']['version'];?> - &copy; 2012 by <a href="<?=$config['url'];?>" target="_blank"><strong><?=$config['varurl'];?></strong></a>.<br /><br />
	</div>
</div>