<div class="tcn">
	<div class="tcn_contents">
		<span style="color:#f00;"><?=$msg;?></span>
		<form action="" enctype="multipart/form-data" method="post">
		<table cellpadding="5" cellspacing="0">
			<? foreach($usesdata as $field =>$configuser){
					if($field!='tablename' && $configuser['display']=='1'){
					
					$value = $memberdt[0][$field];
			?>
				<tr>
					<td width="110" valign="top">
						<?=$configuser['vn'];?>
						<? if($configuser['require']=='1'){?>
							<span style="color:#f00;">*</span>
						<? }?>
					</td>
					<td valign="top" align="<?=$configuser['align'];?>">
						<? if($configuser['type']=='select'){?>
							<select name="<?=$field;?>" id="<?=$field;?>" class="tcnselect" rel="3">
								<option></option>
							</select>
						
						<? }else if($configuser['type']=='picture'){?>
							<? if($memberdt[0]['profile_image']!=''){?>
								<img src="<?=$memberdt[0]['profile_image'];?>" width="100" alt="anhdaidien" />
								<input type="hidden" name="<?=$field;?>" value="<?=$memberdt[0]['profile_image'];?>" />
							<? }?>
							<input type="file" name="<?=$field;?>_new" style="width:<?=$configuser['width'];?>px;" />
							
						
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
	</div>
</div>
