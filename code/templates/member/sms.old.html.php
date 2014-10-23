<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<table cellpadding="5" cellspacing="0" width="100%" style="border: 1px solid #ddd;">
			<tr>
				<td align="left" valign="middle" class="tieudebang" style="padding-left:10px;"> Sản phẩm </td>
				<td align="left" valign="middle" class="tieudebang">Nội dung </td>
				<td align="center" valign="middle" class="tieudebang">&nbsp; </td>
			</tr>
			<? for($i=0;$i<count($tinnhanphanhoi);$i++){?>
			<tr id="dongsp_<?=$tinnhanphanhoi[$i]['idsmg'];?>">
				<td align="left" valign="top" class="noidungbang" style="padding-left:10px; min-width:150px;">
					<? if($tinnhanphanhoi[$i]['picture']){?>
                    	<a target="_blank" href="<?=sys_link('com=home&target=main&category='.$tinnhanphanhoi[$i]['category'].'&detail='.$tinnhanphanhoi[$i]['id'])?>">
						<img src="<?=$config['url'];?>lib/articles/<?=$tinnhanphanhoi[$i]['picture'];?>" alt="<?=$tinnhanphanhoi[$i]['title'];?>" width="100" />
                        </a>
						<br />
					<? }?>
					<a href="<?=sys_link('com=home&target=main&category='.$tinnhanphanhoi[$i]['category'].'&detail='.$tinnhanphanhoi[$i]['id'])?>" style=" font-size:11px; color:#00A9D6; font-weight:bold;" target="_blank"><?=$tinnhanphanhoi[$i]['title'];?></a>
					
				</td>
				<td align="left" valign="top" class="noidungbang" style="padding-left:10px;">
					<font style="color:#3B5998; font-weight:bold; font-size:12px; line-height:18px;">
						<?
                        	if($tinnhanphanhoi[$i]['fromuser']!='')
								echo $tinnhanphanhoi[$i]['fullname']." (".$tinnhanphanhoi[$i]['usersname']."):";
							else
								echo $tinnhanphanhoi[$i]['email']." (".$tinnhanphanhoi[$i]['dienthoai']."):";
						?>
                        
                         
                    </font>
					&nbsp;&nbsp;&nbsp;
					<font style="color:#aaa; font-size:11px; line-height:18px;">
						<?=date("H\hi  d-m-Y",$tinnhanphanhoi[$i]['bydate']);?>
					</font><br />
                    <font style="color:#aaa; font-size:11px; line-height:18px; text-transform:capitalize;">
					<?  if($tinnhanphanhoi[$i]['oauth_provider']=='')
								echo 'xalomuaban';
							else
								echo $tinnhanphanhoi[$i]['oauth_provider'];
					?> 
                    </font> 
					<br />
					<p id="tieudesp_<?=$tinnhanphanhoi[$i]['idsmg'];?>"><?=$tinnhanphanhoi[$i]['contents'];?></p>
					
				</td>
				<td width="80" align="right" valign="top" class="noidungbang">
					<a  href="<?=sys_link('com=home&target=main&category=76&detail='.$tinnhanphanhoi[$i]['idsmg'].'&cate=22')?>" rel="<?=$tinnhanphanhoi[$i]['idsmg'];?>">Trả lời</a>&nbsp;&nbsp;<br /><br />
					<a  style="cursor:pointer" class="nutxoasp" rel="<?=$tinnhanphanhoi[$i]['idsmg'];?>" rev="smg">Xóa</a>&nbsp;&nbsp;<br />

				</td>
			</tr>
			<? }?>
		</table>
	</div>
</div>
<div class="bgxacnhan" id="xacnhanxoa">
	<div class="popupxacnhan">
		<div style="width:450px; height:auto;" class="regbox regbox_corner_top regbox_corner_bottom">
			<div class="regbox_header regbox_corner_top" style="width:450px; text-align:left;">
				<b>Xác nhận xóa tin nhắn</b>
			</div>
			<div class="regbox_cont" id="noidungxoa" style="height:250px; background:#fff;">
			
			</div>
			<div class="regbox_footer regbox_corner_bottom">
				<input type="button" name="nuthuyxoa" id="nuthuyxoa" class="newuser_button" value=" Xem lại " style="display:inline; float:left;" />
				<input type="button" name="nutxoangay_smg" id="nutxoangay_smg" class="newuser_button" value=" Xóa ngay " style="display: inline;" />
			</div>
		</div>
	</div>
</div>