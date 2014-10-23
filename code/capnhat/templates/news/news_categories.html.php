<div class="tieude">
	&nbsp;&nbsp;&nbsp; Quản lý Danh mục (menu)
</div>

<? if ($id['option'] == 'main') {
	$exts = "window.location='?gnc=com:".$id['com'].";target:".$id['target'].";option:main;limit_on_page:'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value+';grpid:'+document.frm_srh.groupid.value;";
?>
	<div id="rs_line_h"><form action="" name="frm_srh" onsubmit="<?=$exts;?>return false;">
		<div id="rs_line_h_l">
		<select name="groupid" style="width:120px;" onchange="<?=$exts;?>">
			<?=group_select($id['grpid']);?>
		</select>
		<select name="limit_on_page" onchange="<?=$exts;?>">
			<option value="">Số menu hiển thị</option>
			<option value="10" <? if ($config['limit_on_page'] == 10) echo 'selected'?>>10 menu/trang</option>
			<option value="50" <? if ($config['limit_on_page'] == 50) echo 'selected'?>>50 menu/trang</option>
			<option value="100" <? if ($config['limit_on_page'] == 100) echo 'selected'?>>100 menu/trang</option>
		</select>
		
		<input type="text" name="search" size="30" value="<?=$searchval;?>" onclick=" if(this.value=='Tên menu cần tìm') return this.value='';" onblur=" if(this.value=='') return this.value='Tên menu cần tìm';" />
		<input type="button" name="submit" onclick="<?=$exts;?>" value=" Tìm " />
		</div>
		<div id="rs_line_h_r">
			<input type="button" name="add_new" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:add'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:'+document.frm_srh.groupid.value" value="Thêm mẫu tin"  />
			<input type="button" name="delete" value="xóa mẫu tin" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:'+document.frm_srh.groupid.value);" title="Xóa những mẫu tin đã được chọn"  />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
	</form></div>
	<div style="margin-bottom:7px;margin-left:12px;">
		<font color="#CC3300"><b><?=$title[0]['title'];?></b></font> - Có tất cả <strong><?=$pages['rs']?></strong> Menu. Đang xem trang <?=$pages['current']?>/<?=$pages['page']?>
	</div>
	<!-- Header -->
	<form name="frm" action="" method="post" enctype="multipart/form-data" >
	<div id="rs_line">
		<div id="rs_header" style="width:5%">STT</div>
		<div id="rs_header" style="width:59%">Tiêu đề/Tên</div>
		<div id="rs_header" style="width:22%; text-align:left">Danh mục cha</div>
		<div id="rs_header" style="width:10%;">Tình trạng</div>
		<div id="rs_header" style="width:3%; text-align:center;"><input type="checkbox" name="idall" id="idall" value="" title="Click để chọn tất cả" onclick="chkall();" /></div>
	</div>
	<!-- End Header -->
	<!-- Detail -->
	<? for ($i=0; $i < count($rs_list); $i++) { ?>
	<div id="rs_line" onmousemove="this.style.background='#ffe0d1';" onmouseout="this.style.background='#ffffff';">
		<div id="rs_detail" style="width:5%;">
			<input type="text" name="oderid<?=$rs_list[$i]['id']?>" id="oderid_<?=$rs_list[$i]['id']?>" size="8" value="<?=$rs_list[$i]['oderid'];?>" style="width:30px; border:1px solid #ccc; text-align:right; background:none;" onchange=" update_cate(<?=$rs_list[$i]['id'];?>,'oderid')" />
		</div>
		<div id="rs_detail" style="width:49%; cursor:pointer;" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit;item:'.$rs_list[$i]['id']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>'">
			<a href="<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit;item:'.$rs_list[$i]['id']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$rs_list[$i]['groupid'];?>" >
				<?=$rs_list[$i]['title']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?>
			</a>
		</div>
		<div id="rs_detail" style="width:32%">
			<div style="width:100%;">
				<?
					$ext = " onchange=\" update_cate(".$rs_list[$i]['id'].",'parentid') \" style = \"width:250px;\" ";
					categories_select('parentid_'.$rs_list[$i]['id'],$grpid,0,$rs_list[$i]['parentid'],0,'',$ext);
				?>
			</div>
		</div>
		<? $color = array('','#f00','#039'); $onf = $rs_list[$i]['status'];  ?>
		<div id="rs_detail" style="width:10%; color:<?=$color[$onf];?>;">
			&nbsp;<!--<? echo $onoff[$onf];?>
			<input type="button" value="<? if($onf==1) echo $onoff[2]; else echo $onoff[1];?>" name="change_status" id="change_status" />-->
			<select name="status" id="status_<?=$rs_list[$i]['id'];?>" style="color:<?=$color[$onf];?>; background:none;" onchange=" update_cate(<?=$rs_list[$i]['id'];?>,'status')">
				<option value="2" label="<?=$onoff[2];?>" <? if($onf==2){?>selected="selected"<? }?> ><?=$onoff[2];?></option>
				<option value="1" label="<?=$onoff[1];?>" <? if($onf==1){?>selected="selected"<? }?> ><?=$onoff[1];?></option>
			</select>
		</div>
		<div id="rs_detail" style="width:3%; text-align:center;">
			<input type="checkbox" name="iddetail" value="<?=$rs_list[$i]['id']?>" title="đánh dấu chọn mẫu tin này" />
		</div>
	</div>
	<? }?>
	<!-- End Detail -->
	<div id="rs_line"><br />
			Xem trang : 
			<select name="gotopgae" onchange="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';groups:'.$id['groups'].';option:main;limit_on_page:'.$config['limit_on_page'].';page:'?>'+this.value">
				<? for ($i = 1; $i <= $pages['page']; $i++) { ?>
				 <option value="<?=$i?>" <? if ($i == $pages['current']) echo 'selected';?>><?=$i?></option>
				<? }?>
			</select>
			 <input type="submit" name="save" value="Lưu thông tin" style="margin-left:100px;" />
	
	</div></form>
<? }?>



<? ////////////////////////////////////////////////////////////////////////////?>

<? if ($id['option'] == 'add') {?>
	<div style="margin-left:15px;">
		<h5>Thêm danh mục</h5>
		<span id="red"><em><?=$msg?></em></span>
	</div>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div style=" margin:0px; width:100%; height:30px;margin-left:12px;">
		<input type="button" name="cancel" value="Danh sách menu" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>'" style="cursor:pointer;" />
		<input type="submit" name="submit" value=" Save " style="color:#f00; cursor:pointer;" />
	</div>
	
	<div id="rs_line">
		<div id="rs_line_l">
			Nhóm quản trị :<br /><br />
		</div>
		<div id="rs_line_r">
			<select name="groupid" id="groupid" style="width:190px;" onchange="getnewcat();">
				<?=group_select($grpid);?>
			</select>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Danh mục cha :
			<br /><br />
		</div>
		<div id="rs_line_r">
			<div id="testthu">
				<? //categories_select ('add_parentid',$grpid,0,0,0,'') ?>
				<? categories_select ('add_parentid',$grpid,0,$_POST['add_parentid'],0,'') ?>
			</div>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Hình banner của danh mục :
		</div>
		<div id="rs_line_r">
			<input type="file" name="add_picture" size="35" /><input type="text" name="add_textcolor" value="ffffff" size="6" maxlength="6" /> (color)
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l"><p>Mỗi danh mục có 1 hình ảnh đặc trưng riêng, và 1 hình phụ</p>
		</div>
		<div id="rs_line_r">
			<input type="file" name="add_picture_ov" size="35" />(Hình phụ)
		</div>
	</div>
	
	<script language="javascript" type="text/javascript">
		document.getElementById("add_title_vn").focus();
	</script>
	
	<div id="rs_line">
		<div id="rs_line_l">
			Tên danh mục :
			<p>Đây là tên danh mục website sẽ được hiển thị thành các menu</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" id="add_title_<?=$lgroups[$i]['key']?>" name="add_title_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_title']?>" size="50" autofocus="autofocus" /> <?=$lgroups[$i]['title']?></div>
		<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Tiêu đề SEO :
			<p>Tiêu đề SEO là tiêu đề hiển hiện trên trang tìm kiếm google (Nếu để trống hệ thống tự động lấy <b>Tên danh mục</b> ghi vào)</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" name="add_seotit_cat_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_seotit_cat']?>" size="50" /> <?=$lgroups[$i]['title']?></div>
		<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Thứ tự sắp xếp :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_oder" value="1" size="1" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Tình trạng: 
			<select name="status">
				<option value="2" label="<?=$onoff[2];?>" selected="selected"><?=$onoff[2];?></option>
				<option value="1" label="<?=$onoff[1];?>"><?=$onoff[1];?></option>
			</select>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Nội dung loại bài viết :
			<p>Thường được sử dụng làm mô tả seo (description). Đôi khi được dùng mô tả vắn tắt cho danh mục hiển thị trên website</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<?=$lgroups[$i]['title']?><br />
			<textarea id="add_contents_<?=$lgroups[$i]['key']?>" name="add_contents_<?=$lgroups[$i]['key']?>" rows=4 cols=50><?=$detail[$i]['contents']?></textarea>
        <? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>'" />
		</div>
	</div>
	</form></div>
<? }?>



<? ////////////////////////////////////////////////////////////////////////////?>

<? if ($id['option'] == 'edit') {?>
	<div style="margin-left:15px;">
		<h5>Cập nhật danh mục : <span id="red"><?=$detail[0]['title']?></span></h5>
		<span id="red"><em><?=$msg?></em></span>
	</div>
	<div><form action="" method="post" enctype="multipart/form-data">
	
	<div style=" margin:0px; width:100%; height:30px;margin-left:12px;">
			<input type="button" name="cancel" value="Danh sách menu" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>'" style=" cursor:pointer;" />
			<input type="button" name="add_new" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:add'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;grpid:<?=$grpid?>'" value="Thêm mẫu tin" style="cursor:pointer;"  />
			<input type="submit" name="submit" value="Update" style=" cursor:pointer; color:#f00;" />
	</div>
		
	<div id="rs_line">
		<div id="rs_line_l">
			Nhóm quản trị :<br /><br />
		</div>
		<div id="rs_line_r">
			<select name="groupid" id="groupid" style="width:190px;" onchange="getnewcat();">
				<?=group_select($grpid);?>
			</select>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Danh mục cha :
			<br /><br />
		</div>
		<div id="rs_line_r">
			<div id="testthu">
				<?  categories_select ('add_parentid',$grpid,0,$detail[0]['parentid'],$detail[0]['id']) ?>
			</div>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Tên danh mục :
			<p>Đây là tên danh mục website sẽ được hiển thị thành các menu</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" name="add_title_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['title']?>" size="50" /> <?=$lgroups[$i]['title']?></div>
		<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Tiêu đề SEO :
			<p>Tiêu đề SEO là tiêu đề hiển hiện trên trang tìm kiếm google (Nếu để trống hệ thống tự động lấy <b>Tên danh mục</b> ghi vào)</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" name="add_seotit_cat_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['seotit_cat']?>" size="50" /> <?=$lgroups[$i]['title']?></div>
			<input type="hidden" name="sitemappoint_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['sitemappoint']?>" />
		<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Thứ tự sắp xếp :
			<p>Thứ tự sẽ quy định ưu tiên cho nhóm nào đứng trước nhóm nào</p>
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_oder" value="<?=$detail[0]['oderid']?>" size="1" />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			Tình trạng: 
			<select name="status">
				<option value="2" label="<?=$onoff[2];?>" <? if($detail[0]['status']==2){?>selected="selected"<? }?> ><?=$onoff[2];?></option>
				<option value="1" label="<?=$onoff[1];?>" <? if($detail[0]['status']==1){?>selected="selected"<? }?> ><?=$onoff[1];?></option>
			</select>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Nội dung loại bài viết :
			<p>Thường được sử dụng làm mô tả seo (description). Đôi khi được dùng mô tả vắn tắt cho danh mục hiển thị trên website</p>
		</div>
		<div id="rs_line_r" style="margin-bottom:10px;">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<?=$lgroups[$i]['title']?><br />
			<textarea id="add_contents_<?=$lgroups[$i]['key']?>" name="add_contents_<?=$lgroups[$i]['key']?>" rows=4 cols=50><?=$detail[$i]['contents']?></textarea><br />
    	<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Hình banner và mã màu chữ tiêu đề:
			<p>Mỗi danh mục có 1 hình ảnh đặc trưng riêng</p>
		</div>
		<div id="rs_line_r"><input type="text" name="add_textcolor" value="<? if($detail[0]['textcolor']=='') echo 'ffffff'; else echo $detail[0]['textcolor']; ?>" size="6" maxlength="6" /> (color)<br />
			<input type="file" name="add_picture" size="20" /> 
			<input type="hidden" name="old_picture" value="<?=$detail[0]['picture']?>" /> 
			<input type="checkbox" name="xoahinh" value="xoahinh" /> Xóa hình
		</div>
	</div>
	<? if ($detail[0]['picture']) echo '<br /><img src="../lib/banner/'.$detail[0]['picture'].'" height="80"><br />';?><font style=" font-size:10px;"><?=$detail[0]['picture']?></font>
	<br />
	
	<div id="rs_line">
		<div id="rs_line_l">
			Hình phụ:
		</div>
		<div id="rs_line_r">
			<input type="file" name="add_picture_ov" size="20" /> 
			<input type="hidden" name="old_picture_ov" value="<?=$detail[0]['picture_ov']?>" /> 
			<input type="checkbox" name="xoahinh_ov" value="xoahinh_ov" /> Xóa hình
		</div>
	</div>
	<? if ($detail[0]['picture_ov']) echo '<br /><img src="../lib/banner/'.$detail[0]['picture_ov'].'" height="80"><br />';?><font style=" font-size:10px;"><?=$detail[0]['picture_ov']?></font>
	<br />
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>'" />
		</div>
	</div>
	</form></div>
<? }?>
<? if ($id['option'] == 'delete') {?>
	<div style="margin-left:15px;">
		<h5>Xóa các <?=$menu[$id['com']][$id['target']]?></h5>
		<span id="red"><em><?=$msg?></em></span>
	</div>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Danh sách các danh mục cần xóa :
			<p>Danh mục bị xóa sẽ không hiển thị trên web. Để phục hồi hãy dùng chức năng Restore trong Hệ thống</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($rs_list); $i++) { ?>
			<div><strong><?=$rs_list[$i]['title']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?></strong></div>
		<? }?>	
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Xóa luôn <font style="color:#f00; font-weight:bold;">danh mục con</font> :
			<p>Các danh mục con của danh mục này sẽ xóa luôn nếu bạn chọn <b>Xóa luôn</b>. Mặc định các bài viết của danh mục cũng xóa theo.</p>
		</div>
		<div id="rs_line_r">
			<input type="radio" name="delete_sub" value="1" /> Xóa luôn
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="radio" name="delete_sub" value="2" checked="checked" /> Không cần
		</div>
	</div>
	<div id="rs_line">&nbsp;</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Đồng ý xóa" style="color:#f00;" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>'" />
		</div>
	</div>
	</form></div>
<? }?>

<br /><br /><br />

<div  class="jquery_ms">Đang cập nhật ...</div>

