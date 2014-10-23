<? if($id['cate']==''){?>
<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<div style="display:table; width:100%;">
		<a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&cate=22')?>"><input type="button" name="nutthemmoi" id="nutthemmoi" class="newuser_button" value=" Gửi tin mới " style="display:inline; float:right; margin:10px 0px;" /></a>
		</div>
		<table cellpadding="5" cellspacing="0" width="100%" style="border: 1px solid #ddd;">
			<? if(count($dstinnhan)==0){?>
				<tr>
					<td> <p> &nbsp;&nbsp;Bạn chưa có tin nhắn nào.</p></td>
				</tr>
			<? }else{?>
                <tr>
                    <td align="center" valign="middle" class="tieudebang"> Ngày gửi</td>
                    <td align="left" valign="middle" class="tieudebang"> Người gửi</td>
                    <td align="left" valign="middle" class="tieudebang">Nội dung </td>
                    <td align="center" valign="middle" class="tieudebang">&nbsp; </td>
                </tr>
                <? for($i=0;$i<count($dstinnhan);$i++){?>
                <tr id="dongsp_<?=$dstinnhan[$i]['id'];?>">
                    <td width="130" valign="top" align="center" class="noidungbang">
                        <?=date("H\hi",$dstinnhan[$i]['bydate']);?><br />
						<font style="color:#aaa; font-size:11px; line-height:18px;">
							<?=date("d-m-Y",$dstinnhan[$i]['bydate']);?>
						</font>
                    </td>
                    <td align="left" valign="top" class="noidungbang" style="min-width:100px;">
                        <a href="#"><?=$dstinnhan[$i]['fullname'];?></a><br />
						<font style="color:#aaa; font-size:11px; line-height:18px;">
							<?  if($dstinnhan[$i]['oauth_provider']=='')
									echo 'xalomuaban';
								else
									echo $dstinnhan[$i]['oauth_provider'];
							?> 
						</font>
                    </td>
                    <td align="left" valign="top" class="noidungbang">
                        <a style="margin-top:0px; cursor:pointer;" id="tieudesp_<?=$dstinnhan[$i]['id'];?>" class="title_sms" rel="<?=$dstinnhan[$i]['id'];?>"><b><?=$dstinnhan[$i]['title'];?></b></a><br />
                        <?=sys_cut(html2text($dstinnhan[$i]['contents']),100);?>
						<div id="smscont_<?=$dstinnhan[$i]['id'];?>" style="display:none;">
							<?=$dstinnhan[$i]['contents'];?>
						</div>
                    </td>
                    <td width="80" align="right" valign="top" class="noidungbang">
                        <a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&detail='.$dstinnhan[$i]['id'].'&cate=22');?>" style="cursor:pointer" id="linktraloi">Trả lời</a>&nbsp;&nbsp;<br />
                        <a  style="cursor:pointer" class="nutxoasp" rel="<?=$dstinnhan[$i]['id'];?>" rev="smg">Xóa</a>&nbsp;&nbsp;<br />
    
                    </td>
                </tr>
               <? } } ?>
		</table>
	</div>
	
</div>



<? }else if($id['cate']==22){?>
<div class="tcn">
	<div class="tcn_contents">
		<span style="color:#f00;"><?=$msg;?></span>
		<form action="" enctype="multipart/form-data" method="post">
		<input type="hidden" name="idnguoinhan" id="idnguoinhan" value="<?=$replyto[0]['fromuser'];?>" /> 
		<table cellpadding="5" cellspacing="0">
			<? foreach($tinnhan as $field =>$configuser){
					if($field!='tablename' && $configuser['display']=='1'){
					if(isset($_POST[$field]))
						$value = $_POST[$field];
					else if($replyto[0][$field]!='')
						$value = $replyto[0][$field];
					else				
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
					<input type="submit" name="guitin" id="guitin" value=" Gửi đi " />
				</td>
			</tr>
		</table>
		</form>
	</div>
</div>
<? }?>




<div class="bgxacnhan" id="xacnhanxoa">
	<div class="popupxacnhan">
		<div style="width:450px; height:auto;" class="regbox regbox_corner_top regbox_corner_bottom">
			<div class="regbox_header regbox_corner_top" id="tieudetin" style="width:450px; text-align:left;">
				<b>Xác nhận xóa tin nhắn</b>
			</div>
			<div class="regbox_cont" id="noidungxoa" style="height:250px; background:#fff;">
			
			</div>
			<div class="regbox_footer regbox_corner_bottom">
				<input type="button" name="nuthuyxoa" id="nuthuyxoa" class="newuser_button" value=" Xem lại " style="display:inline; float:left;" />
				<a href="#" id="traloi_smg"><input type="button" name="traloi_smg" class="newuser_button" value=" Trả lời " style="display: inline; float:left; margin-left:5px;" /></a>
				<input type="button" name="nutxoangay_smg" id="nutxoangay_smg" class="newuser_button" value=" Xóa ngay " style="display: inline;" />
			</div>
		</div>
	</div>
</div>