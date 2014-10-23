<div class="tieude">
	&nbsp;&nbsp;&nbsp; <? if($id['items']!='') echo 'Xem duyệt hồ sơ'; else echo 'Điều chỉnh hồ sơ'?>
	
</div>

<div class="dong" style="color:#f00; text-align:center;">
<form action="" enctype="multipart/form-data" method="post">
	<select name="trangthaixem" id="trangthaixem" style="margin:8px 2px; float:left;">
		<option value="" label="---Trạng thái---">---Trạng thái---</option>
		<? for($k=0;$k<count($trangthai);$k++){ if($rs_list[0]['status']==$k) $sel = 'selected="selected"'; else $sel='';?>
			<option value="<?=$k;?>" label="<?=$trangthai[$k];?>" <?=$sel;?>><?=$trangthai[$k];?></option>
		<? }?>
	</select>
	<input type="submit" name="save" value="Lưu lại" onclick="cfrm_save('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>')" style="margin:8px 2px; float:left;" />
</form>	
	<?=$msm;?>
	<img src="images/doc-icon.png" alt="Xuất PDF" style="float:right; margin:5px 10px 0px 10px;" />
	<div style=" float:right; padding:0 5px; line-height:30px;">
		<?  $filelink = 'phieuin'.$id['items'].'.docx';
			$filelink2 = 'phieuin'.$id['items'].'_t23.docx';
			if(is_file($filelink) && is_file($filelink2)){
		?>
			<a href="<?=$filelink;?>" style="color:#FF6600">
				Tải file (Trang 1-4)
			</a>&nbsp;&nbsp;&nbsp;
			<a href="<?=$filelink2;?>" style="color:#FF6600">
				Tải file (Trang 2-3)
			</a>&nbsp;&nbsp;&nbsp;
			<a href="?gnc=com:jobs;target:detail;option:add;typefile:docx;items:<?=$id['items'];?>">
				Tạo lại
			</a>
		<? }else{?>
			<a href="?gnc=com:jobs;target:detail;option:add;typefile:docx;items:<?=$id['items'];?>">
				Tạo file word để in
			</a>
		<? }?>
	</div>
</div>
<div class="dongxd"></div>
<div class="dongh">
	<?php foreach($profile_tit as $key=>$value){?>
		<div id="rs_line">
			<div id="rs_line_l">
				<?=$profile_tit[$key]['vn'];?>
			</div>
			<div id="rs_line_r" class="dangtuyen">
				<?php
					if($profile_tit[$key]['type']=='select'){
						$str = html_select($key,$rs_list[0][$key]);
						echo '<select name="'.$key.'" id="'.$key.'" value="'.$rs_list[0][$key].'">'.$str.'</select>';
				
					}else if($profile_tit[$key]['type']=='textarea')
						echo '<textarea name="'.$key.'" id="'.$key.'">'.$rs_list[0][$key].'</textarea>';
				
					else if($profile_tit[$key]['type']=='file'){
						if($rs_list[0][$key]!='')
							echo '<img src="../lib/articles/'.$rs_list[0][$key].'" height="100" alt="'.$key.'" />';
						else
							echo '"Chưa có hình"';
						
					}else if($profile_tit[$key]['type']=='date'){
						echo '<input name="'.$key.'" id="'.$key.'" type="text" value="'.$rs_list[0][$key].'" />';
						echo "<script type=\"text/javascript\">
									/* <![CDATA[ */
										$(function() {
											$('#".$key."').datepick({dateFormat: 'dd-mm-yyyy'});
										});
									/* ]]> */
								</script>";
					}else
						echo '<input name="'.$key.'" id="'.$key.'" value="'.$rs_list[0][$key].'" type="'.$profile_tit[$key]['type'].'" />';
				?>
			</div>
		</div>
	<? }?>
</div>

<div class="dongxd">&nbsp;&nbsp;&nbsp;I. THÔNG TIN CÁ NHÂN</div>
<div class="dongh">
	<?php foreach($profile as $key=>$value){?>
		<div id="rs_line">
			<div id="rs_line_l">
				<?=$profile[$key]['vn'];?>
			</div>
			<div id="rs_line_r" class="dangtuyen">
				<?php
					if($profile[$key]['type']=='select'){
						$str = html_select($key,$rs_list[0][$key]);
						echo '<select name="'.$key.'" id="'.$key.'" value="'.$rs_list[0][$key].'">'.$str.'</select>';
				
					}else if($profile[$key]['type']=='textarea')
						echo '<textarea name="'.$key.'" id="'.$key.'">'.$rs_list[0][$key].'</textarea>';
				
					else if($profile[$key]['type']=='date'){
						echo '<input name="'.$key.'" id="'.$key.'" type="text" value="'.$rs_list[0][$key].'" />';
						echo "<script type=\"text/javascript\">
									/* <![CDATA[ */
										$(function() {
											$('#".$key."').datepick({dateFormat: 'dd-mm-yyyy'});
										});
									/* ]]> */
								</script>";
					}else
						echo '<input name="'.$key.'" id="'.$key.'" value="'.$rs_list[0][$key].'" type="'.$profile[$key]['type'].'" />';
				?>
			</div>
		</div>
	<? }?>
	<div id="rs_line"><br /><b>+ Liên hệ trong trường hợp khẩn cấp</b><br /><br /></div>
	<?php foreach($profile_r as $key=>$value){?>
		<div id="rs_line">
			<div id="rs_line_l">
				<?=$profile_r[$key]['vn'];?>
			</div>
			<div id="rs_line_r" class="dangtuyen">
				<?php
					if($profile_r[$key]['type']=='select'){
						$str = html_select($key,$rs_list[0][$key]);
						echo '<select name="'.$key.'" id="'.$key.'" value="'.$rs_list[0][$key].'">'.$str.'</select>';
				
					}else if($profile_r[$key]['type']=='textarea')
						echo '<textarea name="'.$key.'" id="'.$key.'">'.$rs_list[0][$key].'</textarea>';
				
					else if($profile_r[$key]['type']=='date'){
						echo '<input name="'.$key.'" id="'.$key.'" type="text" value="'.$rs_list[0][$key].'" />';
						echo "<script type=\"text/javascript\">
									/* <![CDATA[ */
										$(function() {
											$('#".$key."').datepick({dateFormat: 'dd-mm-yyyy'});
										});
									/* ]]> */
								</script>";
					}else
						echo '<input name="'.$key.'" id="'.$key.'" value="'.$rs_list[0][$key].'" type="'.$profile_r[$key]['type'].'" />';
				?>
			</div>
		</div>
	<? }?>
</div>


<div class="dongxd">&nbsp;&nbsp;&nbsp;II. HỌC VẤN</div>
<div class="dongh">
	<?=html_jobgroup('degree',$id['items'],'de_',10);?>
</div>

<div class="dongxd">&nbsp;&nbsp;&nbsp;III. KINH NGHIỆM LÀM VIỆC</div>
<div class="dongh">
	<?=html_jobgroup('experience',$id['items'],'ex_',10);?>
</div>

<div class="dongxd"m style="background:none; color:#555;">+ Tên người phụ trách trực tiếp trước đây/Tên người có thể tham khảo</div>
<div class="dongh">
	<?=html_jobgroup('manager',$id['items'],'ma_',4);?>
</div>

<div class="dongxd">&nbsp;&nbsp;&nbsp;IV. CÁC KHÓA HUẤN LUYỆN</div>
<div class="dongh">
	<?=html_jobgroup('straining',$id['items'],'st_',10);?>
</div>


<div class="dongxd">&nbsp;&nbsp;&nbsp;V. KHẢ NĂNG SỬ DỤNG NGÔN NGỮ & KỸ NĂNG MÁY TÍNH</div>
<div class="dongh">
	<?=html_jobskills($id['items']);?>
</div>

<div class="dongxd">&nbsp;&nbsp;&nbsp;VI. THÔNG TIN KHÁC</div>
<div class="dongh">
	<?=html_get_anwer($id['items']);?>
</div>

<!--<div class="dongxd">&nbsp;&nbsp;&nbsp;VII. XÁC NHẬN</div>
<div class="dongh">
	<?=html_convertline('declaration');?>
</div>-->

<div class="dong">&nbsp;</div>

<?php
	if($id['option']=='add')
	echo $exit;
?>
				
