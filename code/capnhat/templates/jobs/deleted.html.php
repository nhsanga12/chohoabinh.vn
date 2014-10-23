<div class="tieude" style="color:#f00;">
	&nbsp;&nbsp;&nbsp; Hồ sơ đã xóa
</div>
<form name="frm" action="" method="post" enctype="multipart/form-data">
	<div class="dongh" style="margin-top:2px;">	
		<table cellpadding="5" cellspacing="0" width="100%" style="margin:0; border-left:1px solid #ddd; border-right:1px solid #ddd;">
			<tr>
				<td class="demuc" style="width:15px;">
					
				</td>
				<? for($d=0;$d<count($demuc);$d++){?>
					<td class="demuc" align="<?=$align[$d];?>">
						<?=$demuc[$d];?>
					</td>
				<? }?>
			</tr>
			
			<? for($r=0;$r<count($rs_list);$r++){ $sum = count($field); ?>
				<tr>
					<td style="width:15px;"><input type="checkbox" name="iddetail" id="iddetail" value="<?=$rs_list[$r]['id'];?>" style="width:15px;" /></td>
					<td align="left"><?=$r+1;?></td>
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
			<? }?>
			
		</table>
	</div>
	<div class="dongline" style=" height:20px;"></div>
	<div class="dong" style="margin-bottom:10px;">
		<img src="images/arrow_up.png" alt="up" style="margin:0px 0px 0px 5px;" />
		<input type="checkbox" name="idall" id="idall" value="0" onclick="chkall();" style="width:15px;" /> All
		<input type="button" name="deleted" value="Xóa vĩnh viễn" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:delete'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>')" style="color:#f00;" />
		<input type="button" name="edit" value="Phục hồi hồ sơ" onclick="cfrm_del('<?='?gnc=com:'.$id['com'].';target:'.$id['target'].';option:edit'?>;limit_on_page:<?=$id['limit_on_page']?>;page:<?=$pages['current']?>;search:<?=$id['search']?>;groups:<?=$id['groups']?>;category:<?=$id['category']?>')" />
		
	</div>
	
</form>

				
