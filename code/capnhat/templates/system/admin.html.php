<div class="tieude">
	&nbsp;&nbsp;&nbsp; Quản lý admin
</div>

<? if ($id['option'] == 'main') {?>		
		<div id="rs_line_h"><form action="" name="frm_srh" onsubmit="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'?>'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value+';grpid:'+document.frm_srh.groupid.value;return false;">
		<div id="rs_line_h_l">
		<input type="text" name="search" size="20" value="<?=$id['search'];?>" />
		<select name="limit_on_page">
			<option value="">Số tin hiển thị</option>
			<option value="10" <? if ($config['limit_on_page'] == 10) echo 'selected'?>>10/trang</option>
			<option value="50" <? if ($config['limit_on_page'] == 50) echo 'selected'?>>50/trang</option>
			<option value="100" <? if ($config['limit_on_page'] == 100) echo 'selected'?>>100/trang</option>
		</select>
		<select name="groupid">
			<option value="" label="Nhóm quản trị">Nhóm quản trị</option>
			<?=group_select($id['grpid']);?>
		</select>
		<input type="button" name="submit" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'?>'+document.frm_srh.limit_on_page.value+';search:'+document.frm_srh.search.value+';grpid:'+document.frm_srh.groupid.value" value="Tìm" />
		</div>
		<div id="rs_line_h_r">
		<input type="button" name="add_new" onclick="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:add'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>'" value="Thêm mới"  />
		<input type="button" name="delete" value="Xóa chọn" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>');" title="Xóa những mẫu tin đã được chọn"  />
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
	</form></div>
	<!-- Header -->
	<form name="frm">
	<div id="rs_line">
		<div id="rs_header" style="width:5%">STT</div>
		<div id="rs_header" style="width:38%">Tên quản trị</div>
		<div id="rs_header" style="width:30%">Nhóm quản trị</div>
		<div id="rs_header" style="width:22%; text-align:center">Ngày cập nhật</div>
		<div id="rs_header" style="width:3%; text-align:center;"><input type="checkbox" name="idall" id="idall" value="" title="Click để chọn tất cả" onclick="chkall();" /></div>
	</div>
	<!-- End Header -->
	<!-- Detail -->
	<? for ($i=0; $i < count($rs_list); $i++) { ?>
	<div id="rs_line">
		<div id="rs_detail" style="width:5%; text-align:"><?=$i+1?>.</div>
		<div id="rs_detail" style="width:38%"><a href="<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit;item:'.$rs_list[$i]['id']?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>"><?=$rs_list[$i]['name']?><? if($rs_list[$i]['title'] == "") echo '#'.$rs_list[$i]['id'];?></a></div>
		<div id="rs_detail" style="width:30%">
			<?=$rs_list[$i]['title']?>
		</div>
		<div id="rs_detail" style="width:22%;text-align:center;"><?=date('d-m-Y',$rs_list[$i]['lastdate']);?></div>
		<div id="rs_detail" style="width:3%; text-align:center;"><input type="checkbox" name="iddetail" name="iddetail" value="<?=$rs_list[$i]['id']?>" title="đánh dấu chọn mẫu tin này" /></div>
	</div>
	<? }?>
	<!-- End Detail -->
	</form>
	<div id="rs_line" style="text-align:right">
	<p><form name="gfrm" onsubmit="return false;">
		
		Trang
		<select name="gotopgae" onchange="window.location='<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'.$config['limit_on_page'].';page:'?>'+this.value">
			<? for ($i = 1; $i <= $pages['page']; $i++) { ?>
			 <option value="<?=$i?>" <? if ($i == $pages['current']) echo 'selected';?>><?=$i?></option>
			<? }?>
		</select>
		<input type="button" name="button" onclick="gotopage(document.gfrm.goinput.value,'<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:main;limit_on_page:'.$config['limit_on_page'].';page:'?>');" value="Di chuyển đến" /> &nbsp;
	</form></p>
	</div>	
<? }?>



<!--==========================================================-->
<? if ($id['option'] == 'add') {?>
	<div style="margin-left:15px;">
	<h4>Thêm quản trị mới</h4>
	<span id="red"><em><?=$msg?></em></span>
	</div>
	<div>
	<form action="" method="post" enctype="multipart/form-data" name="frm" id="frm">
	<div id="rs_line">
		<div id="rs_line_l">
			Tên đầy đủ :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_name" value="" size="40" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Tên đăng nhập :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_username" value="" size="30" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Mật khẩu :
		</div>
		<div id="rs_line_r">
			<input type="password" name="add_password" value="" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Nhập lại mật khẩu :
		</div>
		<div id="rs_line_r">
			<input type="password" name="add_repassword" value="" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Nhóm quản trị :
		</div>
		<div id="rs_line_r">
			<select name="add_groupid" style=" width:210px;">
				<?=group_select();?>
			</select>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			E-mail :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_email" value="" size="40" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Hệ phân quyền :
		</div>
		<div id="rs_line_r">
			<? 
			$menun = $menu;
			while (list($key,$value) = each($menun)) {
				echo '<ul id="menu_l">';
				echo '<li>'.$title[$key].'</li>';
				while (list($key1,$value1) = each($value)) {
					if ($key1 != 'home' && $key1 != 'signin' && $key1 != 'signout' && $key1 != 'profiles') {
						echo '<ul>';
						echo '<li>';
							echo '<input type="checkbox" name="'.$key1.'_main'.'" value="1" id="iddetail" /> Quản lý ';
							echo '<input type="checkbox" name="'.$key1.'_add'.'" value="1" id="iddetail" /> Thêm ';
							echo '<input type="checkbox" name="'.$key1.'_edit'.'" value="1" id="iddetail" /> Sửa ';
							echo '<input type="checkbox" name="'.$key1.'_delete'.'" value="1" id="iddetail" /> Xóa ';
							echo ' &nbsp; - &nbsp; ';
						echo $value1.'</li>';
						echo '</ul>';
					}
				}
				echo '</ul>';
			} 
			?>
			<input type="checkbox" name="checkall" onclick="chkall();" style="margin-left:14px;" id="idall" /> <font style="color:#f00;">Check all</font>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<br />
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form>
	</div><br /><br />
<? }?>

<!--==========================================================-->
<? if ($id['option'] == 'edit') {?>
	<div style="margin-left:15px;">
	<h4>Cập nhật phân quyền quản trị: <span style="color:#f00;"><?=$detail[0]['name']?></span></h4>
	<span id="red"><em><?=$msg?></em></span>
	</div>
	<div><form action="" method="post" enctype="multipart/form-data" name="frm" id="frm">
	<div id="rs_line">
		<div id="rs_line_l">
			Tên đầy đủ :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_name" value="<?=$detail[0]['name']?>" size="40" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Tên đăng nhập :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_username" value="<?=$detail[0]['username']?>" size="30" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Mật khẩu :
		</div>
		<div id="rs_line_r">
			<input type="password" name="add_password" value="" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Nhập lại mật khẩu :
		</div>
		<div id="rs_line_r">
			<input type="password" name="add_repassword" value="" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Nhóm quản trị :
		</div>
		<div id="rs_line_r">
			<select name="add_groupid" style=" width:210px;">
				<?=group_select($detail[0]['groupjobs']);?>
			</select>
			<input name="old_groupid" type="hidden" value="<?=$detail[0]['groupjobs'];?>" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			E-mail :
		</div>
		<div id="rs_line_r">
			<input type="text" name="add_email" value="<?=$detail[0]['email']?>" size="40" />
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_l">
			Hệ phân quyền :
		</div>
		<div id="rs_line_r">
			<? 
			$menuz = $menu;
			$i = 0;
			while (list($key,$value) = each($menuz)) {
				echo '<ul id="menu_l">';
				echo '<li>'.$title[$key].'</li>';
				while (list($key1,$value1) = each($value)) {
					if ($key1 != 'home' && $key1 != 'signin' && $key1 != 'signout' && $key1 != 'profiles') {
						echo '<ul>';
						echo '<li>';
							echo '<input type="checkbox" name="'.$key1.'_main'.'" id="iddetail_1" value="1" ';
							if ($role[$key1]['main'] == '1') echo 'checked';
							echo '/> Quản lý ';
							echo '<input type="checkbox" name="'.$key1.'_add'.'" id="iddetail_2" value="1" ';
							if ($role[$key1]['add'] == 1) echo 'checked';
							echo '/> Thêm ';
							echo '<input type="checkbox" name="'.$key1.'_edit'.'" id="iddetail_3" value="1" ';
							if ($role[$key1]['edit'] == 1) echo 'checked';
							echo '/> Sửa ';
							echo '<input type="checkbox" name="'.$key1.'_delete'.'" id="iddetail_4" value="1" ';
							if ($role[$key1]['delete'] == 1) echo 'checked';
							echo '/> Xóa ';
							echo ' &nbsp; - &nbsp; ';
						echo $value1.'</li>';
						echo '</ul>';
						$i++;
					}
				}
				echo '</ul>';
			} 
			?>
			<input type="checkbox" name="checkall" onclick="chkallcol(1);" style="margin-left:14px;" id="idall_1" />
			<font style="color:#f00;">Quản lý</font>
			<input type="checkbox" name="checkall" onclick="chkallcol(2);" style="margin-left:4px;" id="idall_2" />
			<font style="color:#f00;">Thêm</font>
			<input type="checkbox" name="checkall" onclick="chkallcol(3);" style="margin-left:4px;" id="idall_3" />
			<font style="color:#f00;">Sửa</font>
			<input type="checkbox" name="checkall" onclick="chkallcol(4);" style="margin-left:4px;" id="idall_4" />
			<font style="color:#f00;">Xóa</font>
			&nbsp;&nbsp;&nbsp;-<font style="color:#f00;"> &lt;Check all&gt;</font>
		</div>
	</div>
	<div id="rs_line">
		<div id="rs_line_r">
			<br />
			<input type="submit" name="submit" value="Chấp nhận" />
			<input type="reset" name="reset" value="Hủy bỏ" />
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form></div>
	<br /><br />
<? }?>
<? if ($id['option'] == 'delete') {?>
	<p>
	<h5>Xóa quản trị : <?=$menu[$id['com']][$id['target']]?></h5>
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
			<input type="button" name="cancel" value="Quay về" onclick="window.location='?gnc=com:<?=$id['com']?>;target:<?=$id['target']?>;option:main;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$id['page']?>;search:<?=$id['search']?>'" />
		</div>
	</div>
	</form></div>
<? }?>

