<script language="javascript" type="text/javascript">
		function addpic(c)
        {
            var kt,id;
			for (i=0;i<c;i++) {
				id	= "rs_add_pic_"+i;
				kt  = document.getElementById(id).style.display;
				if (kt == "none") {
					document.getElementById(id).style.display="block";
					break;
				}
			}
			if (i > c-1) alert ('Chỉ được upload một lượt '+c+' hình');
        }
		
		function addvideo(c)
        {
            var kt,id;
			for (i=0;i<c;i++) {
				id	= "rs_add_video_"+i; k=i+1;
				valuepic = "add_file_tit_"+i;
				kt  = document.getElementById(id).style.display;
				if (kt == "none") {
					document.getElementById(id).style.display="block";
					document.getElementById(valuepic).value="Picture "+k;
					break;
				}
			}
			if (i > c-1) alert ('Chỉ được upload một lượt '+c+' file');
        }
</script>

<div class="tieude">
	&nbsp;&nbsp;&nbsp; Quản lý bài viết
</div>

<? $title = categories_detail($id['category']); ?>
<? if ($id['option'] == 'main') {?>
	<? 	$link = "window.location='?gnc=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value+';grpid:'+document.frm_srh.groupid.value+';category:'+document.frm_srh.add_parentid.value";
	?>
	<div id="rs_line_h"><form action="" name="frm_srh" onsubmit="<?=$link;?>">
		<div id="rs_line_h_l">
		
		<select name="groupid" id="groupid" style="width:100px; float:left;" onchange="getnewcat(); window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'?>'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value+';grpid:'+document.frm_srh.groupid.value+';category:';">
			<?=group_select($grpid);?>
		</select>
		
		<div id="testthu" style="float:left; margin-left:5px; margin-right:5px;">
			<? 	$ext = "onchange=\"window.location='?gnc=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value+';grpid:'+document.frm_srh.groupid.value+';category:'+document.frm_srh.add_parentid.value\"";
				categories_select ('add_parentid',$grpid,0,$id['category'],0,'',$ext);
			?>
		</div>
		<select name="limit_on_page" style="width:70px;margin-right:15px;" <?=$ext;?>>
			<option value="">Hiển thị</option>
			<option value="10" <? if ($config['limit_on_page'] == 10) echo 'selected'?>>10 tin/trang</option>
			<option value="50" <? if ($config['limit_on_page'] == 50) echo 'selected'?>>50 tin/trang</option>
			<option value="100" <? if ($config['limit_on_page'] == 100) echo 'selected'?>>100 tin/trang</option>
		</select>
		<input type="text" name="search" size="20" value="<?=$searchval;?>" onclick=" if(this.value=='Từ khóa') return this.value='';" onblur=" if(this.value=='') return this.value='Từ khóa';" />
		<input type="button" name="submit" onclick="<?=$link;?>" value="Tìm bài viết" />
		</div>
		<div id="rs_line_h_r">
		<input type="button" name="dupple" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>;category:<?=$id['category']?>;dupple:1');" title="Sao chép những mẫu tin đã được chọn" value="Double"  />
		<input type="button" name="move" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>;category:<?=$id['category']?>;dupple:9');" title="Di chuyển những mẫu tin đã được chọn" value="Move"  />
		<input type="button" name="add_new" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:add'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>;category:<?=$id['category']?>'" value="Thêm"  />
		<input type="button" name="delete" value="Xóa" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>;category:<?=$id['category']?>;dupple:0');" title="Xóa những mẫu tin đã được chọn"  />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
	</form></div>
	<div style="margin-bottom:7px;margin-left:12px;">
		Danh mục <font color="#CC3300"><b><?=$title[0]['title'];?></b></font> - Có tất cả <font color="#CC3300"><strong><?=$pages['rs']?></strong></font> mẫu tin. Đang xem trang <?=$pages['current']?>/<?=$pages['page']?>
	</div>	
	<!-- Header -->
	<form name="frm" action="" method="post">
	<div id="rs_line">
		<div id="rs_header" style="width:5%">STT</div>
		<div id="rs_header" style="width:50%">Tiêu đề/tên &nbsp; <a href="#" style=" font-size:10px; color:#FF6600;">Edit</a></div>
		<div id="rs_header" style="width:10%;">Trạng thái</div>
		<div id="rs_header" style="width:21%"> Danh mục <font style="color:#FFCC00">((</font> ! <font style="color:#FFCC00">))</font></div>
		<div id="rs_header" style="width:10%; text-align:center">Ngày cập nhật</div>
		<div id="rs_header" style="width:3%; text-align:center;"><input type="checkbox" name="idall" id="idall" value="" title="Click để chọn tất cả" onclick="chkall();" /></div>
	</div>
	<!-- End Header -->
	<!-- Detail -->
	<? for ($i=0; $i < count($rs_list); $i++) { ?>
	<div id="rs_line" onmousemove="this.style.background='#e3f1f2';" onmouseout="this.style.background='#ffffff';">
		<div id="rs_detail" style="width:5%;">
			<input type="text" name="s<?=$rs_list[$i]['id']?>" id="state_p_<?=$rs_list[$i]['id']?>" value="<?=$rs_list[$i]['state_p']?>" style="width:30px; border:1px solid #ccc; text-align:right; background:none;" onchange=" update_art(<?=$rs_list[$i]['id'];?>,'state_p','')" />
		</div>
		<div id="rs_detail" style="width:50%;cursor:pointer;" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit;item:'.$rs_list[$i]['id']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>;category:<?=$rs_list[$i]['category']?>'">
		&nbsp; <a href="<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit;item:'.$rs_list[$i]['id']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>;category:<?=$rs_list[$i]['category']?>">
					<?=$rs_list[$i]['title']?>
					<? if($rs_list[$i]['status']==1){?><font color="#FF0000"> (off)</font><? }?>
					<? if($rs_list[$i]['hot']=='1'){?><font color="#1ca14e"><b> (HOT)</b></font><? }?>
					<? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?>
				</a>
		</div>
		
		<div id="rs_detail" style="width:10%">
			<? $color = array('','#f00','#039','#090'); $onf = $rs_list[$i]['status'];  ?>
			<select name="status" id="status_<?=$rs_list[$i]['id'];?>" style="color:<?=$color[$onf];?>; background:none;" onchange=" update_art(<?=$rs_list[$i]['id'];?>,'status','')">
				<option value="2" label="<?=$onoff[2];?>" <? if($onf==2){?>selected="selected"<? }?> ><?=$onoff[2];?></option>
				<option value="1" label="<?=$onoff[1];?>" <? if($onf==1){?>selected="selected"<? }?> ><?=$onoff[1];?></option>
				<option value="3" label="<?=$onoff[3];?>" <? if($onf==3){?>selected="selected"<? }?> ><?=$onoff[3];?></option>
			</select>
		</div>
		<div id="rs_detail" style="width:21%">
			<?
				$ext = " onchange=\" update_art(".$rs_list[$i]['id'].",'category','') \" style = \"width:150px;\" ";
				categories_select('category_'.$rs_list[$i]['id'],$grpid,0,$rs_list[$i]['category'],0,'',$ext);
			?>
		</div>
		<div id="rs_detail" style="width:10%; text-align:center;"><?=date('d/m/Y',$rs_list[$i]['lastdate']);?></div>
		<div id="rs_detail" style="width:3%; text-align:center;"><input type="checkbox" name="iddetail" value="<?=$rs_list[$i]['id']?>" title="đánh dấu chọn mẫu tin này" /></div>
	</div>
	<? }?>
	<!-- End Detail -->
	<br />&nbsp;&nbsp;&nbsp; Xem trang :
		<select name="gotopgae" onchange="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';groups:'.$id['groups'].';category:'.$id['category'].';option:main;limit_on_page:'.$config['limit_on_page'].';page:'?>'+this.value">
			<? for ($i = 1; $i <= $pages['page']; $i++) { ?>
			 <option value="<?=$i?>" <? if ($i == $pages['current']) echo 'selected';?>><?=$i?></option>
			<? }?>
		</select>
		
	</div></form>
<? }?>




<? if ($id['option'] == 'add') {?>
	<div style="margin-left:15px;">
		<h5>Thêm bài viết  <span id="red"><?=$msg?></span></h5>
	</div>
	
	<form action="" method="post" enctype="multipart/form-data">
	<div style="width:98%; margin:auto;">
	<table cellpadding="0" cellspacing="0" width="100%;">
		<tr>
			<td valign="top" colspan="3">
				<div id="rs_line" style=" background:#0099CC; width:100%; color:#FFFFFF; line-height:30px; font-size:12px; margin:0px;">&nbsp;&nbsp;&nbsp;Tiêu đề & Tình trạng :
					<input type="submit" name="submit" value="Save" style="float:right;font-size:12px; color:#f00;" />
					<input type="button" name="cancel" value="Back" style="float:right;font-size:12px;" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>'" />
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top" width="40%">
				<div id="rs_line">
					<? for ($i=0; $i < count($lgroups); $i++) { ?>
						<div id="rs_line_u">
							Tiêu đề bài viết (<?=$lgroups[$i]['key']?>):
						</div>
						<div id="rs_line_d">			
							<div>
								<input type="text" name="add_title_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_title_'.$lgroups[$i]['key']];?>" style="width:100%" /> <br />
								 <a style=" cursor:pointer; color:#999933;" onclick=" active(44<?=$i;?>);">
									Tiêu đề & Mô tả SEO (<?=$lgroups[$i]['key']?>) <img src="images/arrow2.gif" />
								</a>
							</div>
							<div style=" display: none;" id="edit_44<?=$i;?>">
								Tiêu đề SEO (<?=$lgroups[$i]['key']?>): <br />
								<input type="text" name="add_seotit_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_seotit_'.$lgroups[$i]['key']];?>" style="width:100%" /> <br />
								<textarea name="add_seodes_<?=$lgroups[$i]['key']?>" style="width:100%;"><?=$_POST['add_seodes_'.$lgroups[$i]['key']];?></textarea> 
							</div>
						
						</div>
					<? }?>
				</div>
			</td>
			<td valign="top" width="40%">
				<div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Trạng thái :
						<input type="radio" name="add_status" size="1" value="2" checked="checked" />Bật&nbsp;
						<input type="radio" name="add_status" size="1" value="1" />Tắt&nbsp;
						<input type="radio" name="add_status" size="1" value="3" />Mới&nbsp;
					</div>
				</div>
				 <div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Thứ tự bài viết :
						<input type="text" name="add_state_p" size="1" value="<?=$_POST['add_state_p'];?>" />
						
					</div>
				</div>
				<div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Hình ảnh bài viết:
					</div>
					<div id="rs_line_d">
						<input type="file" name="add_picture" size="35" id="imgid" />
					</div>
				</div>
				<div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Hình thumnail: Mặc định sẽ tự động tạo từ hình gốc. 
					</div>
					<div id="rs_line_d">
						<i>Để cho đẹp hơn bạn có thể</i>
						<input type="submit" name="taothums" value="tạo thumnail" />
					</div>
				</div>
				
				
				
				<div id="edit_88" style=" display:none; border: 1px solid #CEE3ED; background:#CEE3ED; padding:10px 0px 10px 0px;margin-left:10%; width:90%">
					<div id="rs_line">
						<div id="rs_line_l">
							Mã:
						</div>
						<div id="rs_line_r">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div><input type="text" name="add_ma_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_ma_'.$lgroups[$i]['key']];?>" /> (<?=$lgroups[$i]['key']?>)</div>
						<? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Giá:
						</div>
						<div id="rs_line_r">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div>
								<input type="text" name="add_gia_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_gia_'.$lgroups[$i]['key']];?>" style="width:90px;" />
								<select name="cbbloaitien_<?=$lgroups[$i]['key']?>">
									<option value="VND" <? if($lgroups[$i]['key']=='vn' || !isset($_POST['cbbloaitien_'.$lgroups[$i]['key']])) echo 'selected="selected"';?>>VND</option>
									<option value="USD" <? if($lgroups[$i]['key']=='en') echo 'selected="selected"';?>>USD</option>
								</select> (<?=$lgroups[$i]['key']?>)
							</div>
						<? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Khuyến mãi :
						</div>
						<div id="rs_line_r">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div><input type="text" name="add_khuyenmai_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_khuyenmai_'.$lgroups[$i]['key']];?>" /> (<?=$lgroups[$i]['key']?>)</div>
						<? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Thương hiệu :
						</div>
						<div id="rs_line_r">
							<? for ($i=0; $i < count($lgroups); $i++) { ?>
								<select name="add_thuonghieu_<?=$lgroups[$i]['key']?>" style="width:150px;">
									<option value="0"> Thương hiệu </option>
									<? option_select(1,6);?>
								</select>(<?=$lgroups[$i]['key']?>)&nbsp;&nbsp;
							 <? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Số lượt mua :
						</div>
						<div id="rs_line_r">
							<input type="text" name="add_opt" size="1" value="<?=$_POST['add_opt'];?>" />
						</div>
					</div>
				</div>
				
			</td>
			<td valign="top" width="20%">
					
					<div id="rs_line">
						<div id="rs_line_u" style="text-align:right;">
							
							<a style=" cursor:pointer; color:#999933;" onclick=" active(88);">Chi tiết sản phẩm <img src="images/arrow3.gif" /></a>
						</div>
						<div id="hinhchinh">
							<? if(is_file('../lib/articles/thums_'.$_SESSION['auth']['name'].'.'.$_SESSION['auth']['temp'])){?>
							<br /><img src="../lib/articles/thums_<?=$_SESSION['auth']['name'];?>.<?=$_SESSION['auth']['temp'];?>" width="150" style="margin-left:5px;"><br />
							<? }?>
						</div>
						
					</div>
			</td>
		</tr>
			
			
			<? if($thumpic!='' || $id['thums']==1){ ?>
			<tr>
				<td valign="top">
					<div>
					<script type="text/javascript">
						var jcrop_api, boundx, boundy;
							jQuery(function($){
						
							  $('#target').Jcrop({
								onChange:   showCoords,
								onSelect:   showCoords,
								onRelease:  clearCoords,
								aspectRatio: 1
							  },function(){
									// Use the API to get the real image size
									var bounds = this.getBounds();
									boundx = bounds[0];// width hình trên giao dien = 350
									boundy = bounds[1];// height hình trên giao dien
									// Store the API in the jcrop_api variable
									jcrop_api = this;
								  });
						
							});
						
							function showCoords(c)
							{
								if (parseInt(c.w) > 0)
								{
								  var rx = 150 / c.w;
								  var ry = 150 / c.h;
						
								  $('#preview').css({
									width: Math.round(rx * boundx) + 'px',
									height: Math.round(ry * boundy) + 'px',
									marginLeft: '-' + Math.round(rx * c.x) + 'px',
									marginTop: '-' + Math.round(ry * c.y) + 'px'
								  });
								}
								
							  $('#x1').val(c.x);
							  $('#y1').val(c.y);
							  $('#x2').val(c.x2);
							  $('#y2').val(c.y2);
							  $('#w').val(c.w);
							  $('#h').val(c.h);
							};
							function clearCoords()
							{
							  $('#x1').val('');
							  $('#y1').val('');
							  $('#x2').val('');
							  $('#y2').val('');
							  $('#w').val('');
							  $('#h').val('');
							};
						
						</script>
						
					<img src="../lib/articles/thums_<?=$_SESSION['auth']['name'];?>.<?=$_SESSION['auth']['temp'];?>" width="350" id="target" />
					</div>
					</td>
					<td colspan="2" valign="top">
						<div>
							<br /><i>Rê và kéo chuột trên hình bên trái để chọn vùng cần cắt.<br />
							<br /> Sau đó nhấn Save thumnails</i><br />
							<input type="hidden" size="4" id="x1" name="x1" />
							<input type="hidden" size="4" id="y1" name="y1" />
							<input type="hidden" size="4" id="x2" name="x2" />
							<input type="hidden" size="4" id="y2" name="y2" />
							<input type="hidden" size="4" id="w" name="w" />
							<input type="hidden" size="4" id="h" name="h" />
							<br />
							<input type="button" value=" Save thumnails" id="save_thumnails" onclick="savethumtemp('?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:add;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>;thums:1');" rel="thums_<?=$_SESSION['auth']['name'].'.'.$_SESSION['auth']['temp'];?>" />
							<div style="width:100%; height:200px; margin-top:9px;">
							  <div style="width:150px;height:150px;overflow:hidden; float:left;">
								<img src="../lib/articles/thums_<?=$_SESSION['auth']['name'];?>.<?=$_SESSION['auth']['temp'];?>" id="preview" alt="Preview" class="jcrop-preview" />
							  </div>
							  <div style="display:block; width:180px; margin-left:10px; float: left;" id="ketquathum">
								<img src="../lib/articles/thums_<?=$_SESSION['auth']['name'];?>.<?=$_SESSION['auth']['temp'];?>" width="150" style="margin:0px;" id="newthums" /><br />Hình thumnail hiện tại<br />
							  </div>
							</div>
						</div>
					</td>
			</tr>
			<? }?>
		<tr>
			<td valign="top" colspan="3">
				<div id="rs_line" style=" background:#0099CC; width:100%; color:#FFFFFF; line-height:30px; font-size:12px; margin:0px;">&nbsp;&nbsp;&nbsp;Nội dung :		
				<input type="button" name="add_new_manual" value="Thêm hình album" onClick="addvideo(<?=$config['max_file']?>);" style="float:right; margin:4px 3px 2px 6px;" />
				<select name="nhomfile" style="float:right; margin:4px;">
						<option value="images"> Picture </option>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">
				<div id="edit_188" style="display:none;">
					<div id="rs_line" style="margin:0px;">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div style=" position:absolute; padding:5px;">Tóm tắt <?=$lgroups[$i]['title']?>&nbsp;&nbsp;&nbsp;</div>
							<textarea id="add_quick_<?=$lgroups[$i]['key']?>" name="add_quick_<?=$lgroups[$i]['key']?>" rows=1 cols=15><?=$_POST['add_quick_'.$lgroups[$i]['key']]?></textarea>
							<script type="text/javascript">
								CKEDITOR.replace( 'add_quick_<?=$lgroups[$i]['key']?>',
									{	toolbarStartupExpanded : false,
										enterMode		: '2',
										height : 100,
										filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
										filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
										filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
										filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
										filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
										filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
									});
							</script>
						<? }?>
					</div>
				</div>
				
				<div id="rs_line" style="margin:0px;">
					<? for ($i=0; $i < count($lgroups); $i++) { ?>
						<div style=" position:absolute; padding:5px; width:750px; text-align:right;">
							Nội dung <?=$lgroups[$i]['title']?>&nbsp;&nbsp;&nbsp;
						</div>
						<textarea id="add_contents_<?=$lgroups[$i]['key']?>" name="add_contents_<?=$lgroups[$i]['key']?>" rows=4 cols=15><?=$_POST['add_contents_'.$lgroups[$i]['key']]?></textarea>
						<script type="text/javascript">
							CKEDITOR.replace( 'add_contents_<?=$lgroups[$i]['key']?>',
								{	enterMode		: '2',
									extraPlugins : 'uicolor',
									height : 200,
									width : 750,
									toolbar :
									[
										['RemoveFormat','-','Font','FontSize','TextColor','BGColor','-','Smiley','Undo','Redo','HorizontalRule'],
										['Bold','Italic','Underline','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','Outdent','Indent','-','Link','Unlink','Anchor','Image','Table','-','Blockquote','Maximize','Source']
									],
									filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
									filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
									filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
									filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
									filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
									filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
								});
						</script>
					<? }?>
				</div>
				
				<div style="margin-top:10px;">
					<input type="submit" name="submit" value=" Save " style="color:#f00;" />
					<input type="reset" name="reset" value=" Cancel " />
					<input type="button" name="cancel" value=" Back " onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>'" />
				</div>
				
			</td>
			<td valign="top" width="20%">
				<div id="rs_line">
					<div id="rs_line_u" style="text-align:right;">
						<a style=" cursor:pointer; color:#999933;" onclick=" active(188);">Ẩn/hiện nội dung tóm tắt <img src="images/arrow3.gif" /></a>
					</div>
				</div>
				<div style="border:1px solid #fff; width:98%; margin:2px 0px 2px 0px; padding-left:1%; padding-bottom:1%;">
				<!-- ============== MANUAL ======================-->
				<? for ($i=0;$i<$config['max_file'];$i++) {?>
					<div id="rs_add_video_<?=$i?>" style="display:none; ">
						<div id="rs_line" style="text-align:left;">			
							<div style=" height:auto; width:90%; margin-top:1%;">
								Tiêu đề hình: <input type="text" name="add_file_tit_<?=$i?>" id="add_file_tit_<?=$i?>" style=" width:20%;" value="" /> <input type="file" name="add_file_<?=$i?>" size="10" />&nbsp;&nbsp;&nbsp; Thumnail: <input type="file" name="add_thumnail_<?=$i?>" size="10" />
							</div>
						</div>
					</div>
				<? }?>	
				<!-- ============== END MANUAL ======================-->
				</div>
			</td>
		
		</tr>
	</table>
	</div>
</form>
<? }?>



<? if ($id['option'] == 'edit') {?>
	<div style="margin-left:15px;">
		<h5>Cập nhật bài viết danh mục <font color="#CC3300"><b><?=$title[0]['title'];?></b></font>. <span id="red"><?=$msg?></span></h5>
	</div>
	
	<form action="" method="post" enctype="multipart/form-data" id="coords" class="coords">
	<div style="width:98%; margin:auto;">
	<table cellpadding="0" cellspacing="0" width="100%;">
		<tr>
			<td valign="top" colspan="3">
				<div id="rs_line" style=" background:#0099CC; width:100%; color:#FFFFFF; line-height:30px; font-size:12px; margin:0px;">&nbsp;&nbsp;&nbsp;Tiêu đề & Tình trạng :
					<input type="submit" name="submit" value="Save" style="float:right;font-size:12px; color:#f00;" />
					<input type="button" name="cancel" value="Back" style="float:right;font-size:12px;" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>'" />
					<input type="button" name="addmore" value="Add other" style="float:right;font-size:12px;" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:add;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>'" />
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top" width="40%">
				<div id="rs_line">
					<? for ($i=0; $i < count($lgroups); $i++) { ?>
						<div id="rs_line_u">
							Tiêu đề bài viết (<?=$lgroups[$i]['key']?>):
						</div>
						<div id="rs_line_d">			
							<div>
								<input type="text" name="add_title_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['title']?>" style="width:100%" /> <br />
								 <a style=" cursor:pointer; color:#999933;" onclick=" active(44<?=$i;?>);">
									Tiêu đề & Mô tả SEO (<?=$lgroups[$i]['key']?>) <img src="images/arrow2.gif" />
								</a>
							</div>
							<div style=" display: none;" id="edit_44<?=$i;?>">
								Tiêu đề SEO (<?=$lgroups[$i]['key']?>): <br />
								<input type="text" name="add_seotit_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['seotit']?>" style="width:100%" /> <br />
								<textarea name="add_seodes_<?=$lgroups[$i]['key']?>" style="width:100%;"></textarea> 
							</div>
						
						</div>
					<? }?>
				</div>
			</td>
			<td valign="top" width="40%">
				<div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Trạng thái :
						<input type="radio" name="add_status" size="1" value="2" <? if($detail[0]['status'] == '2') echo 'checked="checked"'; ?> />Bật&nbsp;
				<input type="radio" name="add_status" size="1" value="1" <? if($detail[0]['status'] == '1') echo 'checked="checked"'; ?>/>Tắt&nbsp;
				<input type="radio" name="add_status" size="1" value="3" <? if($detail[0]['status'] == '3') echo 'checked="checked"'; ?>/>Mới&nbsp;
					</div>
				</div>
				 <div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Thứ tự bài viết :
						<input type="text" name="add_state_p" size="1" value="<?=$detail[0]['state_p'];?>" />
						
					</div>
				</div>
				<div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Hình ảnh bài viết:
					</div>
					<div id="rs_line_d">
						<input type="file" name="add_picture" size="20" /> 
						<input type="hidden" name="old_picture" value="<?=$detail[0]['picture']?>" /> 
						<input type="checkbox" name="xoahinh" value="xoahinh" /> Xóa hình
					</div>
				</div>
				<div id="rs_line" style="margin-left:10%; width:90%">
					<div id="rs_line_u">
						Hình thumnail:
					</div>
					<div id="rs_line_d">
						<i>Mặc định hình thumnail sẽ tự động được tạo từ hình gốc. Để cho đẹp hơn bạn có thể</i> <a style="text-decoration:underline; color:#FF6600; cursor:pointer;" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:edit;item:<?=$id['item']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>;thum:1'">tạo ngay đây</a> 
					</div>
				</div>
				
				<div id="edit_88" style=" display:none; border: 1px solid #CEE3ED; background:#CEE3ED; padding:10px 0px 10px 0px;margin-left:10%; width:90%">
					<div id="rs_line">
						<div id="rs_line_l">
							Mã :
						</div>
						<div id="rs_line_r">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div><input type="text" name="add_ma_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['ma']?>" /> (<?=$lgroups[$i]['key']?>)</div>
						<? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Giá:
						</div>
						<div id="rs_line_r">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div>
								<input type="text" name="add_gia_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['gia']?>" style="width:90px;" />
								<select name="cbbloaitien_<?=$lgroups[$i]['key']?>">
									<option value="VND" <? if($lgroups[$i]['key']=='vn' || !isset($detail[$i]['loaitien'])) echo 'selected="selected"';?>>VND</option>
									<option value="USD" <? if($lgroups[$i]['key']=='en') echo 'selected="selected"';?>>USD</option>
								</select> (<?=$lgroups[$i]['key']?>)
							</div>
						<? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Khuyến mãi :
						</div>
						<div id="rs_line_r">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div><input type="text" name="add_khuyenmai_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['khuyenmai']?>" /> (<?=$lgroups[$i]['key']?>)</div>
						<? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Thương hiệu :
						</div>
						<div id="rs_line_r">
							<? for ($i=0; $i < count($lgroups); $i++) { ?>
								<select name="add_thuonghieu_<?=$lgroups[$i]['key']?>" style="width:150px;">
									<option value="0"> Thương hiệu </option>
									<? option_select(1,6);?>
								</select>(<?=$lgroups[$i]['key']?>)&nbsp;&nbsp;
							 <? }?>
						</div>
					</div>
					<div id="rs_line">
						<div id="rs_line_l">
							Số lượt mua :
						</div>
						<div id="rs_line_r">
							<input type="text" name="add_opt" size="1" value="<?=$detail[0]['opt'];?>" />
						</div>
					</div>
				</div>
				
			</td>
			<td valign="top" width="20%">
				
				<div id="rs_line">
					<div id="rs_line_u" style="text-align:right;">
						
						<a style=" cursor:pointer; color:#999933;" onclick=" active(88);">Chi tiết sản phẩm <img src="images/arrow3.gif" /></a>
					</div>
				</div>
				
					<? if ($detail[0]['picture']) echo '<br /><img src="../lib/articles/'.$detail[0]['picture'].'" width="150" style="margin-left:5px;"><br />';?>
			</td>
		</tr>
		
		<? if($id['thum']==1){?>
		<tr>
			<td valign="top">
				<div>
				<script type="text/javascript">
					var jcrop_api, boundx, boundy;
						jQuery(function($){
					
						  $('#target').Jcrop({
							onChange:   showCoords,
							onSelect:   showCoords,
							onRelease:  clearCoords,
							aspectRatio: 1
						  },function(){
								// Use the API to get the real image size
								var bounds = this.getBounds();
								boundx = bounds[0];// width hình trên giao dien = 350
								boundy = bounds[1];// height hình trên giao dien
								// Store the API in the jcrop_api variable
								jcrop_api = this;
							  });
					
						});
					
						function showCoords(c)
						{
							if (parseInt(c.w) > 0)
							{
							  var rx = 150 / c.w;
							  var ry = 150 / c.h;
					
							  $('#preview').css({
								width: Math.round(rx * boundx) + 'px',
								height: Math.round(ry * boundy) + 'px',
								marginLeft: '-' + Math.round(rx * c.x) + 'px',
								marginTop: '-' + Math.round(ry * c.y) + 'px'
							  });
							}
							
						  $('#x1').val(c.x);
						  $('#y1').val(c.y);
						  $('#x2').val(c.x2);
						  $('#y2').val(c.y2);
						  $('#w').val(c.w);
						  $('#h').val(c.h);
						};
						function clearCoords()
						{
						  $('#x1').val('');
						  $('#y1').val('');
						  $('#x2').val('');
						  $('#y2').val('');
						  $('#w').val('');
						  $('#h').val('');
						};
					
					</script>
					
				<? if ($detail[0]['picture']) echo '<img src="../lib/articles/'.$detail[0]['picture'].'" width="350" id="target" /><br />';?>
				</div>
				</td>
				<td colspan="2" valign="top">
					<div>
						<br /><i>Rê và kéo chuột trên hình bên trái để chọn vùng cần cắt.<br />
						<br /> Sau đó nhấn Save thumnails</i><br />
						<input type="hidden" size="4" id="x1" name="x1" />
						<input type="hidden" size="4" id="y1" name="y1" />
						<input type="hidden" size="4" id="x2" name="x2" />
						<input type="hidden" size="4" id="y2" name="y2" />
						<input type="hidden" size="4" id="w" name="w" />
						<input type="hidden" size="4" id="h" name="h" />
						<br />
						<input type="button" value=" Save thumnails" id="save_thumnails" onclick="save_thumnail();" rel="<?=$detail[0]['picture'];?>" />
						<div style="width:100%; height:200px; margin-top:9px;">
						  <div style="width:150px;height:150px;overflow:hidden; float:left;">
							<img src="../lib/articles/<?=$detail[0]['picture'];?>" id="preview" alt="Preview" class="jcrop-preview" />
						  </div>
						  <div style="display:block; width:180px; margin-left:10px; float: left;" id="ketquathum">
							<img src="../lib/articles/thums_<?=$detail[0]['picture'];?>" width="150" style="margin:0px;" id="newthums" /><br />Hình thumnail hiện tại<br />
						  </div>
						</div>
					</div>
				</td>
		</tr>
		<? }?>
		
		<tr>
			<td valign="top" colspan="3">
				<div id="rs_line" style=" background:#0099CC; width:100%; color:#FFFFFF; line-height:30px; font-size:12px; margin:0px;">&nbsp;&nbsp;&nbsp;Nội dung :		
				<input type="button" name="add_new_manual" value="Thêm hình album" onClick="addvideo(<?=$config['max_file']?>);" style="float:right; margin:4px 3px 2px 6px;" />
				<select name="nhomfile" style="float:right; margin:4px;">
						<option value="images"> Picture </option>
				</select>
				</div>
			</td>
		</tr>
		<tr>
			<td valign="top" colspan="2">
				<div id="edit_188" style="display:none;">
					<div id="rs_line" style="margin:0px;">
						<? for ($i=0; $i < count($lgroups); $i++) { ?>
							<div style=" position:absolute; padding:5px;">Tóm tắt <?=$lgroups[$i]['title']?>&nbsp;&nbsp;&nbsp;</div>
							<textarea id="add_quick_<?=$lgroups[$i]['key']?>" name="add_quick_<?=$lgroups[$i]['key']?>" rows=1 cols=15><?=$detail[$i]['quick']?></textarea>
							<script type="text/javascript">
								CKEDITOR.replace( 'add_quick_<?=$lgroups[$i]['key']?>',
									{	toolbarStartupExpanded : false,
										enterMode		: '2',
										height : 100,
										filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
										filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
										filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
										filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
										filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
										filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
									});
							</script>
						<? }?>
					</div>
				</div>
				
				<div id="rs_line" style="margin:0px;">
					<? for ($i=0; $i < count($lgroups); $i++) { ?>
						<div style=" position:absolute; padding:5px; width:750px; text-align:right;">
							Nội dung <?=$lgroups[$i]['title']?>&nbsp;&nbsp;&nbsp;
						</div>
						<textarea id="add_contents_<?=$lgroups[$i]['key']?>" name="add_contents_<?=$lgroups[$i]['key']?>" rows=4 cols=15><?=$detail[$i]['contents']?></textarea>
						<script type="text/javascript">
							CKEDITOR.replace( 'add_contents_<?=$lgroups[$i]['key']?>',
								{	enterMode		: '2',
									extraPlugins : 'uicolor',
									height : 200,
									width : 750,
									toolbar :
									[
										['RemoveFormat','-','Font','FontSize','TextColor','BGColor','-','Smiley','Undo','Redo','HorizontalRule'],
										['Bold','Italic','Underline','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','NumberedList','BulletedList','Outdent','Indent','-','Link','Unlink','Anchor','Image','Table','-','Blockquote','Maximize','Source']
									],
									filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
									filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?Type=Images',
									filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?Type=Flash',
									filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
									filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
									filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
								});
						</script>
					<? }?>
				</div>
				
				<div style="margin-top:10px;">
					<input type="submit" name="submit" value=" Save " style="color:#f00;" />
					<input type="reset" name="reset" value=" Cancel " />
					<input type="button" name="cancel" value=" Back " onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>'" />
				</div>
				
			</td>
			<td valign="top" width="20%">
				<div id="rs_line">
					<div id="rs_line_u" style="text-align:right;">
						<a style=" cursor:pointer; color:#999933;" onclick=" active(188);">Ần/hiện nội dung tóm tắt <img src="images/arrow3.gif" /></a>
					</div>
				</div>
				<div style="border:1px solid #fff; width:98%; margin:2px 0px 2px 0px; padding-left:1%; padding-bottom:1%;">
				<!-- ============== MANUAL ======================-->
				<? for ($i=0;$i<$config['max_file'];$i++) {?>
					<div id="rs_add_video_<?=$i?>" style="display:none; ">
						<div id="rs_line" style="text-align:left;">			
							<div style=" height:auto; width:90%; margin-top:1%;">
								Tiêu đề hình: <input type="text" name="add_file_tit_<?=$i?>" id="add_file_tit_<?=$i?>" style=" width:20%;" value="" /> <input type="file" name="add_file_<?=$i?>" size="10" />&nbsp;&nbsp;&nbsp; Thumnail: <input type="file" name="add_thumnail_<?=$i?>" size="10" />
							</div>
						</div>
					</div>
				<? }?>	
				<!-- ============== END MANUAL ======================-->
				</div>
			</td>
		
		</tr>
	</table>
	</div>
</form>
<? }?>








<? if ($id['option'] == 'delete' && $id['dupple'] == 0 ) {?>
	<p>
	<h5>Xóa các mẫu tin: <?=$menu[$id['com']][$id['target']]?></h5>
	<span id="red"><em><?=$msg?></em></span>
	</p>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Danh sách các mẫu tin cần xóa :
			<p>Bạn cần lưu ý rằng khi đã quyết định xóa một mẫu tin thì không thể phục hồi lại</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($rs_list); $i++) { ?>
			<div><strong><?=$rs_list[$i]['title']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?></strong></div>
		<? }?>	
		</div>
	</div>
	<div id="rs_line">&nbsp;</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>'" />
		</div>
	</div>
	</td></tr>
	</table>
	</form></div>
<? }?>






<!--  ==================================================================
					Phần sao chép bài viết
 	==================================================================
-->
<? if ($id['option'] == 'delete' && $id['dupple'] == 1) {?>
	<p>
	<h5>Sao chép các mẫu tin: <?=$menu[$id['com']][$id['target']]?></h5>
	<span id="red"><em><?=$msg?></em></span>
	</p>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Danh sách các mẫu tin cần sao chép :
			<p>Bạn cần lưu ý rằng các mẩu tin sao chép sẽ có nội dung giống mẩu tin gốc mà bạn chọn</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($rs_list); $i++) { ?>
			<div><strong><?=$rs_list[$i]['title']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?></strong> (<?=$rs_list[$i]['language']?>)</div>
		<? }?>
		<? if(count($rs_list)==0){?> Để tiếp tục sao chép thêm lần nữa nhấn "<b>Sao chép</b>", ngược lại nhấn "<b>Xem kết quả</b>" để ngưng và xem kết quả.<br /><br />Số lần sao chép: <b><?=$_SESSION['dup']-1;?> lần </b> <? }?>
		</div>
	</div>
	<div id="rs_line">&nbsp;</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Sao chép lần <?=$_SESSION['dup'];?>" />
			<input type="button" name="cancel" value="Xem kết quả" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>'" />
		</div>
	</div>
	</form></div>
<? }?>





<!--  ==================================================================
					Phần di chuyển bài viết
 	==================================================================
-->
<? if ($id['option'] == 'delete' && $id['dupple'] == 9) {?>
	<p>
	<h5>Di chuyển các mẫu tin: <?=$menu[$id['com']][$id['target']]?></h5>
	<span id="red"><em><?=$msg?></em></span>
	</p>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Danh sách các mẫu tin cần di chuyển :
			<p>Bạn cần lưu ý rằng các mẩu tin trên sẽ được chuyển đến menu mà bạn chọn bên dưới</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($rs_list); $i++) { ?>
			<div><strong><?=$rs_list[$i]['title']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?></strong>(<?=$rs_list[$i]['language']?>)</div>
		<? }?>
		<? if($bi!=0){?>
			<span id="red">Đã chuyển thành công <?=$bi;?> bài viết !!</span><br /><br />
		<? }?>
		<br />- Vui lòng chọn <strong>Menu</strong> cần chuyển đến :<br /> 
		<span id="red" style="font-size:11px;"><i> * Lưu ý chọn các menu không có menu con</i></span><br /><br />
		<?  categories_select ('dest_id',$id['groups'],0,0,0,'*','','-') ?>
		</div>
	</div>
	<div id="rs_line">&nbsp;</div>
	<div id="rs_line">
		<div id="rs_line_r"><br />
			<input type="submit" name="submit" value="Chuyển đi" />
			<input type="button" name="cancel" value="Xem kết quả" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$j?>'" />
		</div>
	</div>
	</form></div>
<? }?>
<br /><br /><br /><br />
<div  class="jquery_ms">Đang cập nhật ...</div>
