<div class="tcn">
	<div class="tcn_contents">
		<span style="color:#f00;"><?=$msg;?></span>
		
		<?php if($id['cate']!=''){?>
		<form action="" enctype="multipart/form-data" method="post">
		<table cellpadding="5" cellspacing="0">
			<? foreach($usesbank as $field =>$configuser){
					if($field!='tablename' && $configuser['display']=='1'){
					
					$value = $bankdt[0][$field];
			?>
				<tr>
					<td width="110" valign="top">
						<?=$configuser['vn'];?>
						<? if($configuser['require']=='1'){?>
							<span style="color:#f00;">*</span>
						<? }?>
					</td>
					<td valign="top" align="<?=$configuser['align'];?>">
						<? if($field=='bankid'){?>
							<select name="<?=$field;?>" id="<?=$field;?>" class="tcnselect" rel="3">
								<?=select_banklist($banklist,$value);?>
								
							</select>
						
						<? }else if($configuser['type']=='textarea'){?>
							<script type="text/javascript" src="<?=$config['url'];?>capnhat/ckeditor/ckeditor.js"></script>
							<script type="text/javascript" src="<?=$config['url'];?>capnhat/ckeditor/lang/_languages.js"></script>
							<textarea id="<?=$field;?>" name="<?=$field;?>" rows=4 cols=15><?=$value;?></textarea><script type="text/javascript">
								CKEDITOR.replace( '<?=$field;?>',
									{	enterMode		: '2',
										extraPlugins : 'uicolor',
										height : <?=$configuser['height'];?>,
										width : <?=$configuser['width'];?>,
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
					
						<? }else{?>
								<input type="<?=$configuser['type'];?>" name="<?=$field;?>" id="<?=$field;?>" class="tcninput" style="width:<?=$configuser['width'];?>px;" value="<?=$value;?>"  />
						<? }?>
					</td>
				</tr>
			<? } } ?>
			
			<tr>
				<td>&nbsp;</td>
				<td align="left">
					<input type="submit" name="luulai" id="luulai" value=" Lưu lại " />
				</td>
			</tr>
		</table>
		</form>
		<? }else{ $catlist = categories_by_cat_group(1,460); ?>
		
			<div class="pin_list">
				<?=$config['smspin'];?>
			</div>
			<? for($m=0;$m<count($catlist);$m++){
				$logo = news_by_cat($catlist[$m]['id'],1,20);
			?>
				<div class="pin_list">
					<?=$catlist[$m]['contents'];?>
				</div>
				<div class="logolist">
					<? for($x=0;$x<count($logo);$x++){?>
					
						<a class="pinact" rel="<?=$logo[$x]['id'];?>" rev="<?=$catlist[$m]['id'];?>">
							<img src="<?=$config['url'];?>lib/articles/<?=$logo[$x]['picture'];?>" alt="" /></a>
							<input type="hidden" id="pinnames_<?=$logo[$x]['id'];?>" value="<?=$logo[$x]['title'];?>" />
					<? }?>
				</div>
				
				
					<div class="pin_data" id="pin_data_<?=$catlist[$m]['id'];?>" style="display:none;">
					<?  if($catlist[$m]['id']==461){?>
						<ul><li>Nạp Pin thông qua thẻ nạp <b id="tenmang_<?=$catlist[$m]['id'];?>">Mobifone</b></li></ul>
						<span class="pd_tit">Serial</span>
						<span class="pd_inp"><input type="text" name="serial" /></span><br />
						<span class="pd_tit">Mã thẻ</span>
						<span class="pd_inp">
							<input type="text" name="mathe" />
							<input type="button" name="naptien" value=" Nạp tiền" />
						</span><br />
						<span class="pd_tit">&nbsp;</span>
						<span class="pd_inp">
							<input type="radio" name="chuyensangpin" checked="checked" /> 
							Chuyển sang tiền PIN &nbsp;&nbsp;&nbsp;&nbsp;
							<input type="radio" name="chuyensangpin" /> 
							Lưu trong tài khoản Xalomuaban
						</span>
						
						<p style="padding-left:20px; line-height:20px;">
							Hệ thống sẽ nạp thông qua cổng Gamebank và sẽ chuyển sang tiền PIN trong vòng 60 giây.<br />
							1 PIN = 1.000 đ
						</p>
						
					
					<? }else if($catlist[$m]['id']==462){?>
							<ul><li>Nạp Pin thông ví điện tử <b id="tenmang_<?=$catlist[$m]['id'];?>">Ngân Lượng</b></li></ul>
							<span class="pd_tit" style="width:80px;">Số tiền (đ)</span>
							<span class="pd_inp">
								<input type="text" name="sotien" />
								<input type="button" name="naptien" value=" Nạp tiền" />
							</span><br />
							<span class="pd_tit">&nbsp;</span>
							<span class="pd_inp">
								<input type="radio" name="chuyensangpin2" checked="checked" /> 
								Chuyển sang tiền PIN &nbsp;&nbsp;&nbsp;&nbsp;
								<input type="radio" name="chuyensangpin2" /> 
								Lưu trong tài khoản Xalomuaban
							</span>
							
							<p style="padding-left:20px; line-height:20px;">
								Hệ thống sẽ nạp thông qua ví điện tử. Tùy vào quy định mỗi nhà cung cấp mà thời gian sẽ khác nhau.<br />
								1 PIN = 1.000 đ
							</p>
					
					
					<? }else{?>
							<ul><li>Nạp Pin thông Internet Banking  <b id="tenmang_<?=$catlist[$m]['id'];?>">Vietcombank</b></li></ul><br />
							<span class="pd_tit" style="width:100px; height:12px; line-height:12px;">Số tài khoản</span>
							<span class="pd_inp">
								<b>06899558854</b>
							</span><br />
							<span class="pd_tit" style="width:100px; height:12px; line-height:12px;">Người nhận</span>
							<span class="pd_inp">
								<b>Xalomuaban.com</b>
							</span><br />
							<span class="pd_tit" style="width:100px; height:12px; line-height:12px;">Chi nhánh</span>
							<span class="pd_inp">
								<b>Vietcombank - Chi nhánh Bến Thành</b>
							</span><br />
							<span class="pd_tit" style="width:100px; height:12px; line-height:12px;">&nbsp;</span>
							<span class="pd_inp">
								<input type="button" name="naptien" value=" Nạp tiền " />
							</span><br />
							
							<p style="padding-left:20px; line-height:20px;">
								Hệ thống sẽ nạp thông qua Ngân hàng. Tùy Ngân hàng mà thời gian sẽ khác nhau.<br />
								1 PIN = 1.000 đ
							</p>
					<? }?>
						
					</div>				
			<? }?>
		
		
		<? }?>
		
	</div>
</div>
