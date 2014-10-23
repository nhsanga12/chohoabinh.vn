<div class="tieude">
	&nbsp;&nbsp;&nbsp; Quản lý cấu hình
</div>

<? if ($id['option'] == 'main') {?>		
		<div id="rs_line_h"><form action="" name="frm_srh" onsubmit="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'?>'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value;return false;">
		<div id="rs_line_h_l">
		<input type="text" name="search" size="20" value="" />
		<select name="limit_on_page">
			<option value="">Số tin hiển thị</option>
			<option value="10" <? if ($config['limit_on_page'] == 10) echo 'selected'?>>10 mẫu tin/trang</option>
			<option value="50" <? if ($config['limit_on_page'] == 50) echo 'selected'?>>50 mẫu tin/trang</option>
			<option value="100" <? if ($config['limit_on_page'] == 100) echo 'selected'?>>100 mẫu tin/trang</option>
		</select>
		<input type="button" name="submit" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'?>'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value" value="Tìm" />
		</div>
		<div id="rs_line_h_r">
		<input type="button" name="add_new" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:add'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>'" value="Thêm mới"  />
		<input type="button" name="delete" value="Xóa chọn" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>');" title="Xóa những mẫu tin đã được chọn"  />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
	</form></div>
	<div style="font-size:10px; margin-left:10px;">Có tất cả <strong><?=$pages['rs']?></strong> mẫu tin được tìm thấy trong <strong><?=$pages['page']?></strong> trang (đang xem trang <strong><?=$pages['current']?></strong>)<br /><br /></div>	
	<!-- Header -->
	<form name="frm">
	<div id="rs_line">
		<div id="rs_header" style="width:5%">STT</div>
		<div id="rs_header" style="width:68%">Tên cấu hình</div>
		<div id="rs_header" style="width:22%; text-align:center">Ngày cập nhật</div>
		<div id="rs_header" style="width:3%; text-align:center;"><input type="checkbox" name="idall" id="idall" value="" title="Click để chọn tất cả" onclick="chkall();" /></div>
	</div>
	<!-- End Header -->
	<!-- Detail -->
	<? for ($i=0; $i < count($rs_list); $i++) { ?>
	<div id="rs_line">
		<div id="rs_detail" style="width:5%; text-align:"><?=$i+1?>.</div>
		<div id="rs_detail" style="width:68%"><a href="<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit;item:'.$rs_list[$i]['id']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>"><?=$rs_list[$i]['title']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?></a></div>
		<div id="rs_detail" style="width:22%;text-align:center;"><?=date('d-m-Y',$rs_list[$i]['lastdate']);?></div>
		<div id="rs_detail" style="width:3%; text-align:center;"><input type="checkbox" name="iddetail" name="iddetail" value="<?=$rs_list[$i]['id']?>" title="đánh dấu chọn mẫu tin này" /></div>
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
			Tên cấu hình :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_title" value="" size="40" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Khóa (key) cấu hình :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_key_id" value="" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Giá trị (value) cấu hình :
		</div>
		<div id="rs_line_r">
			<textarea name="add_key_value" cols="40" rows="3"></textarea>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form></div><br /><br />
<? }?>

<? if ($id['option'] == 'edit') {?>
	<div style="margin-left:15px;">
	<h5>Cập nhật <?=$menu[$id['com']][$id['target']]?> :  <?=$detail[0]['title']?></h5>
	<span id="red"><em><?=$msg?></em></span>
	</div>
	<div><form action="" method="post" enctype="multipart/form-data">
	<div id="rs_line">
		<div id="rs_line_l">
			Tên cấu hình :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_title" value="<?=$detail[0]['title']?>" size="40" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Khóa (key) cấu hình :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_key_id" value="<?=$detail[0]['key_id']?>" readonly="<?=$detail[0]['key_id']?>" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Giá trị (value) cấu hình :
		</div>
		<div id="rs_line_r">
			<textarea name="add_key_value" cols="40" rows="3"><?=$detail[0]['key_value']?></textarea>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form></div><br /><br />
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
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form></div>
<? }?>

