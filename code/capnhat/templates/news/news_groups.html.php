<div class="tieude">
	&nbsp;&nbsp;&nbsp; Quản lý Nhóm quản trị
</div>

<? if ($id['option'] == 'main') {?>		
		<div id="rs_line_h"><form action="" name="frm_srh" onsubmit="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'?>'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value;return false;">
		<div id="rs_line_h_l">
		<input type="text" name="search" size="50" value="" />
		<select name="limit_on_page">
			<option value="">Số tin hiển thị</option>
			<option value="10" <? if ($config['limit_on_page'] == 10) echo 'selected'?>>10/trang</option>
			<option value="50" <? if ($config['limit_on_page'] == 50) echo 'selected'?>>50/trang</option>
			<option value="100" <? if ($config['limit_on_page'] == 100) echo 'selected'?>>100/trang</option>
		</select>
		<input type="button" name="submit" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'?>'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value" value="Lọc mẫu tin" />
		</div>
		<div id="rs_line_h_r">
		<input type="button" name="add_new" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:add'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>'" value="Thêm mẫu tin"  />
		<input type="button" name="delete" value="xóa mẫu tin" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>');" title="Xóa những mẫu tin đã được chọn"  />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
	</form></div>
	<div>
		&nbsp;&nbsp;Có tất cả <strong><?=$pages['rs']?></strong> nhóm được tìm thấy trong <strong><?=$pages['page']?></strong> trang (đang xem trang <strong><?=$pages['current']?></strong>)</div><br />	
	<!-- Header -->
	<form name="frm">
	<div id="rs_line">
		<div id="rs_header" style="width:5%">ID</div>
		<div id="rs_header" style="width:30%">Tên nhóm</div>
		<div id="rs_header" style="width:15%">Số user</div>
		<div id="rs_header" style="width:15%">Danh mục</div>
		<div id="rs_header" style="width:15%">Bài viết</div>
		<div id="rs_header" style="width:15%;">Ngày cập nhật</div>
		<div id="rs_header" style="width:3%;text-align:center;">
			<input type="checkbox" name="idall" id="idall" value="" title="Click để chọn tất cả" onclick="chkall();" />
		</div>
	</div>
	<!-- End Header -->
	<!-- Detail -->
	<? for ($i=0; $i < count($rs_list); $i++) { ?>
	<div id="rs_line">
		<div id="rs_detail" style="width:5%; text-align:">
			<?=$rs_list[$i]['id'];?>.
		</div>
		<div id="rs_detail" style="width:30%">
			<a href="<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit;item:'.$rs_list[$i]['id']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>"><?=$rs_list[$i]['title']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?></a>
		</div>
		<div id="rs_detail" style="width:15%">
			<?=$rs_list[$i]['sumuser'];?>
		</div>
		<div id="rs_detail" style="width:15%">
			<?=$rs_list[$i]['sumcate'];?>
		</div>
		<div id="rs_detail" style="width:15%">
			<?=$rs_list[$i]['newestarticles'];?>
		</div>
		<div id="rs_detail" style="width:15%">
			<?=date($config['time_format_full'],$rs_list[$i]['lastdate']);?>
		</div>
		<div id="rs_detail" style="width:3%; text-align:center;">
			<input type="checkbox" name="iddetail" id="iddetail" value="<?=$rs_list[$i]['id']?>" title="đánh dấu chọn mẫu tin này" />
		</div>
	</div>
	<? }?>
	<!-- End Detail -->
	</form>
	<div id="rs_line" style="text-align:right">
	<p><form name="gfrm" onsubmit="return false;">
		Gõ vào <input type="text" name="goinput" value="<?=$pages['current']?>" size="1" />
		hoặc chọn
		<select name="gotopgae" onchange="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'.$config['limit_on_page'].';page:'?>'+this.value">
			<? for ($i = 1; $i <= $pages['page']; $i++) { ?>
			 <option value="<?=$i?>" <? if ($i == $pages['current']) echo 'selected';?>><?=$i?></option>
			<? }?>
		</select>
		trang
		<input type="button" name="button" onclick="gotopage(document.gfrm.goinput.value,'<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'.$config['limit_on_page'].';page:'?>');" value="Di chuyển đến" /> &nbsp;
	</form></p>
	</div>	
<? }?>




<? if ($id['option'] == 'add') {?>
	<div style="margin-left:15px;">
	<h5>Thêm <?=$menu[$id['com']][$id['target']]?></h5>
	<span id="red"><em><?=$msg?></em></span>
	</div>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Tên nhóm bài viết :
			<p>Tên nhóm bài viết, ví dụ: <strong>Du lịch</strong> hoặc <strong>Chuyên nghành</strong></p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" name="add_title_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_title']?>" /> <?=$lgroups[$i]['title']?></div>
		<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Tên phụ :
			<p>Tên hiển thị trên website hoặc tên viết tắt</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" name="add_name_<?=$lgroups[$i]['key']?>" value="<?=$_POST['add_name']?>" /> <?=$lgroups[$i]['title']?></div>
		<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Thứ tự sắp xếp :
			<p>Thứ tự sẽ quy định ưu tiên cho nhóm nào đứng trước nhóm nào</p>
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_oder" value="1" size="1" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form></div>
<? }?>
<? if ($id['option'] == 'edit') {?>
	<div style="margin-left:15px;">
		<h5>Cập nhật : <?=$detail[0]['title']?></h5>
		<span id="red"><em><?=$msg?></em></span>
	</div>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Tên nhóm bài viết :
			<p>Tên nhóm bài viết, ví dụ: <strong>Du lịch</strong> hoặc <strong>Chuyên nghành</strong></p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" name="add_title_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['title']?>" /> <?=$lgroups[$i]['title']?></div>
		<? }?>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Tên phụ :
			<p>Tên hiển thị trên website hoặc tên viết tắt</p>
		</div>
		<div id="rs_line_r">
		<? for ($i=0; $i < count($lgroups); $i++) { ?>
			<div><input type="text" name="add_name_<?=$lgroups[$i]['key']?>" value="<?=$detail[$i]['name']?>" /> <?=$lgroups[$i]['title']?></div>
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
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form></div>
<? }?>
<? if ($id['option'] == 'delete') {?>
	<div style="margin-left:15px;">
		<h5>Xóa các mẫu tin: <?=$menu[$id['com']][$id['target']]?></h5>
		<span id="red"><em><?=$msg?></em></span>
	</div>
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
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" /><br /><br />
		</div>
	</div>
	</form></div>
<? }?>
<br /><br />

