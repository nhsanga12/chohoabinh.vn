<div class="tieude">
	&nbsp;&nbsp;&nbsp; Tìm kiếm hồ sơ
</div>
<form action="" enctype="multipart/form-data" method="post">
<div class="dongxanh bogoc">
	<div class="cottrai">Người nộp: &nbsp;&nbsp;</div>
	<div class="cotphai"><input type="text" name="nguoinop" value="<?=$_POST['nguoinop'];?>" /></div>
</div>
<div class="dong">
	<div class="cottrai">Vị trí tuyển dụng: &nbsp;&nbsp;</div>
	<div class="cotphai">
		<select name="vitrituyendung" id="vitrituyendung">
			<option value="" label="---Tất cả vị trí tuyển dụng---">---Tất cả vị trí tuyển dụng---</option>
			<? for($k=0;$k<count($listpost);$k++){ if( $_POST['vitrituyendung']!='' && $rs_list[0]['vitriid']==$listpost[$k]['id']) $sele = 'selected="selected"'; else $sele='';?>
				<option value="<?=$listpost[$k]['id'];?>" label="<?=$listpost[$k]['vitri'];?>" <?=$sele;?>><?=$listpost[$k]['vitri'];?></option>
			<? }?>
		</select>
	</div>
</div>
<div class="dong">
	<div class="cottrai">Di động: &nbsp;&nbsp;</div>
	<div class="cotphai"><input type="text" name="didong" value="<?=$_POST['didong'];?>" /></div>
</div>
<div class="dong">
	<div class="cottrai">Email: &nbsp;&nbsp;</div>
	<div class="cotphai"><input type="text" name="email" value="<?=$_POST['email'];?>" /></div>
</div>

<div class="dong">
	<div class="cottrai">Ngày nộp: &nbsp;&nbsp; Từ &nbsp;</div>
	<div class="cotphai">
		<input type="text" name="tungay" id="tungay" value="<?=$_POST['tungay'];?>" />
		<script type="text/javascript">
			/* <![CDATA[ */
				$(function() {
					$('#tungay').datepick({dateFormat: 'dd-mm-yyyy'});
				});
			/* ]]> */
		</script>
		<b>đến</b> <input type="text" name="denngay" id="denngay" value="<?=$_POST['denngay'];?>" />
		<script type="text/javascript">
			/* <![CDATA[ */
				$(function() {
					$('#denngay').datepick({dateFormat: 'dd-mm-yyyy'});
				});
			/* ]]> */
		</script>
	</div>
</div>
<div class="dong">
	<div class="cottrai">Trạng thái hồ sơ: &nbsp;&nbsp;</div>
	<div class="cotphai">
		<select name="trangthaixem" id="trangthaixem">
			<option value="" label="---Tất cả trạng thái---">---Tất cả trạng thái---</option>
			<? for($k=0;$k<count($trangthai);$k++){ if($_POST['trangthaixem']!='' && $rs_list[0]['status']==$k) $sel = 'selected="selected"'; else $sel='';?>
				<option value="<?=$k;?>" label="<?=$trangthai[$k];?>" <?=$sel;?>><?=$trangthai[$k];?></option>
			<? }?>
		</select>
	</div>
</div>
<div class="dong">
	<div class="cottrai"></div>
	<div class="cotphai"><input type="submit" name="tim" id="tim" value=" Tìm "  /></div>
</div>
</form>

<form name="frm" action="" method="post" enctype="multipart/form-data">
	<div class="dongh" style="margin-top:2px;">	
		<table cellpadding="5" cellspacing="0" width="100%" style="margin:0; border-left:1px solid #ddd; border-right:1px solid #ddd;">
			<tr>
				<td class="demuc" style="width:15px;">
					<input type="checkbox" name="idall" id="idall" value="0" onclick="chkall();" style="width:15px;" />
				</td>
				<? for($d=0;$d<count($demuc);$d++){?>
					<td class="demuc" align="<?=$align[$d];?>">
						<?=$demuc[$d];?>
					</td>
				<? }?>
			</tr>
			
			<? $stt=1;
			
				for($r=0;$r<count($rs_list);$r++){ 
				$sum = count($field);
				$ngay = (int)$rs_list[$r]['bydate']; 
				if($ngay>=$tungay && $ngay<=$denngay){?>
				<tr>
					<td style="width:15px;"><input type="checkbox" name="iddetail" id="iddetail" value="<?=$rs_list[$r]['id'];?>" style="width:15px;" /></td>
					<td align="left"><?=$stt;?></td>
					<? for($d=1;$d<$sum;$d++){?>
							<td align="<?=$align[$d];?>">
								<? if($d==$linkpos){?><a href="?gnc=com:jobs;target:detail;items:<?=$rs_list[$r]['id'];?>"><? }?>
									<?
										if($field[$d]=='status')
											echo $trangthai[$rs_list[$r][$field[$d]]];
										else if($field[$d]=='bydate')
											echo date("d-m-Y",$rs_list[$r]['bydate']);
										else
											echo $rs_list[$r][$field[$d]];
									?>
								<? if($d==$linkpos){?></a><? }?>
							</td>
					<? }?>
					
				</tr>
			<? $stt++; } }?>
			
		</table>
	</div>
	<div class="dongline" style=" height:20px;"></div>
	<div class="dong" style="margin-bottom:10px;">
		<img src="images/arrow_up.png" alt="up" style="margin:0px 0px 0px 5px;" />
		<select name="trangthaixem" id="trangthaixem">
			<option value="" label="---Trạng thái---">---Trạng thái---</option>
			<? for($k=0;$k<count($trangthai);$k++){?>
				<option value="<?=$k;?>" label="<?=$trangthai[$k];?>"><?=$trangthai[$k];?></option>
			<? }?>
		</select>
		
		<input type="button" name="save" value="Lưu lại" onclick="cfrm_save('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>')" />

		<input type="button" name="deleted" value="Xóa hồ sơ" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>')" />
		
	</div>
	
</form>

				
