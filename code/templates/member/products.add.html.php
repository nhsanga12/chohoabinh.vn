<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<? if($ok==10){?>
			<div style="text-align:center; width:100%; font-size:14px; color:#0066CC; font-weight:bold;">
				Đăng sản phẩm thành công<br /><br /><br />
			</div>
			<div style="text-align:left; width:80%; margin:0 20%; font-size:12px;">
				Tự động đăng lại 15 lần (7500PIN) hoặc soạn tin XXX &lt;mã SP&gt; gửi 87XX (15000đ/SMS)
				<br /><br /><br />
				Bạn có thể link sản phẩm đến các trang sau để được hàng triệu người biết sp của bạn:
				<div class="login">
					<div class="wrap-login">
						<div class="xalomuaban">
							<a href="facebook/index.php" class="lg-face">Facebook</a>
						</div>
						<div class="xalomuaban">
							<a href="openid/server.php?provider=yahoo" class="lg-yahoo">Yahoo</a>
						</div>
						<div class="xalomuaban">
							<a href="openid/server.php?provider=google" class="lg-google">Google</a>
						</div>
						<div class="xalomuaban">
							<a href="http://siki.vn/twitter-oauth/" class="lg-twitter">Twitter</a>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				hoặc copy đường link sau đây  và dán vào các trang cá nhân của bạn: <br />
				<input id="linkshare" class="tcninput" value="<?=sys_link('com=home&target=main&category='.$cat.'&detail='.$newid);?>" style="margin-top:10px; width:80%;" />
			</div>	
		<? }else{?>
		<form action="" enctype="multipart/form-data" method="post">
		<table cellpadding="5" cellspacing="0">
			<tr>
				<td width="110">Tên sản phẩm</td>
				<td align="left"><input type="text" name="tensanpham" class="tcninput" style="width:350px;" value="<?=$_POST['tensanpham'];?>"  /> &nbsp;&nbsp;&nbsp;&lt;Nhập tiếng Việt có dấu&gt;</td>
			</tr>
			<tr>
				<td>Loại sản phẩm</td>
				<td align="left">
					<div class="tcnsediv" id="sploai01">
						<select name="loaisanpham1" id="loaisanpham1" class="tcnselect" rel="2">
							<option value="" label="-------">-------</option>
							<? $loai01 = categories_by_cat_group(1,2);?>
							<? for($m=0;$m<count($loai01);$m++){?>
								<option value="<?=$loai01[$m]['id'];?>" label="<?=$loai01[$m]['title'];?>"><?=$loai01[$m]['title'];?></option>
							<? }?>
						</select>
					</div>
					<div class="tcnsediv" id="sploai02">
						<select name="loaisanpham2" id="loaisanpham2" class="tcnselect" rel="3">
							<option></option>
						</select>
					</div>
					<div class="tcnsediv" id="sploai03">
						<select name="loaisanpham3" id="loaisanpham3" class="tcnselect" rel="3">
							<option></option>
						</select>
					</div>
				</td>
			</tr>
			<tr>
				<td>Giá sản phẩm</td>
				<td align="left">
					<div class="tcnsediv">
						<input type="text" name="giasp" class="tcninput" value="<?=$_POST['giasp'];?>" /> 
					</div>
					<div class="tcnsediv" style="width:190px; line-height:30px;">
						đồng<!--Giá trước khi giảm:&nbsp;&nbsp;-->
					</div>
					<div class="tcnsediv">
						<!--<input type="text" name="giatruockhigiam" class="tcninput" value="<?=$_POST['giatruockhigiam'];?>" /> đồng-->
					</div>
				</td>
			</tr>
			<tr>
				<td>Nơi rao</td>
				<td align="left">
					<div class="tcnsediv">
						<select name="noirao" id="noirao" class="tcnselect">
							<? select_form_array($khuvuc,$_POST['noirao']);?>
						</select>
					</div>
					<div class="tcnsediv" style="width:190px; text-align:right; line-height:30px;">
						Ảnh sản phẩm  &nbsp;&nbsp;
					</div>
					<div class="tcnsediv">
						<input type="file" name="hinhsp" style="width:200px;" />
					</div>
				</td>
			</tr>
			<tr>
				<td valign="top">Mô tả sản phẩm</td>
				<td align="left">
					<script type="text/javascript" src="<?=$config['url'];?>capnhat/ckeditor/ckeditor.js"></script>
					<script type="text/javascript" src="<?=$config['url'];?>capnhat/ckeditor/lang/_languages.js"></script>

					<textarea id="contents" name="contents" rows=4 cols=15><?=$_POST['contents']?></textarea>
					<script type="text/javascript">
						CKEDITOR.replace( 'contents',
							{	enterMode		: '2',
								extraPlugins : 'uicolor',
								height : 200,
								width : 600,
								toolbar :
								[
									['RemoveFormat','-','Font','FontSize','TextColor','BGColor','-','Undo','Redo','HorizontalRule','Blockquote','Maximize'],
									['Bold','Italic','Underline','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','Outdent','Indent','-','Link','Unlink','Anchor','Image','Table']
								],
								filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
								filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
								filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
								filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
								filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
								filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
							});
					</script>
				</td>
			</tr>
			<tr>
				<td valign="top">Điều kiện giao hàng</td>
				<td align="left">
					<textarea id="quick" name="quick" rows=4 cols=15><?=$_POST['quick']?></textarea>
					<script type="text/javascript">
						CKEDITOR.replace( 'quick',
							{	enterMode		: '2',
								extraPlugins : 'uicolor',
								height : 100,
								width : 600,
								toolbar :
								[
									['RemoveFormat','-','Font','FontSize','TextColor','BGColor','-','Undo','Redo','HorizontalRule','Blockquote','Maximize'],
									['Bold','Italic','Underline','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','Outdent','Indent','-','Link','Unlink','Anchor','Image','Table']
								],
								filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
								filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
								filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
								filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
								filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
								filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
							});
					</script>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td align="left">
					<input type="submit" name="luulai" id="luulai" value=" Đăng sản phẩm " />
				</td>
			</tr>
		</table>
		</form>
		<? }?>
	</div>
</div>
