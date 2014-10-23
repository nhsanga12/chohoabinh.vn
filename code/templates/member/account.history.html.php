<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<table cellpadding="5" cellspacing="0" width="100%" style="border: 1px solid #ddd;">
			<tr>
				<td align="center" valign="middle" class="tieudebang"> Cổng thanh toán</td>
				<td align="center" valign="middle" class="tieudebang"> Loại giao dịch</td>
				<td align="right" valign="middle" class="tieudebang"> Số tiền </td>
				<td align="center" valign="middle" class="tieudebang"> Ngày giao dịch </td>
				<td align="center" valign="middle" class="tieudebang"> &nbsp;</td>
			</tr>
			<? for($i=0;$i<3;$i++){?>
			<tr id="dongsp_<?=$i;?>">
				<td width="150" valign="top" align="center" class="noidungbang">
					<img src="<?=$config['url'];?>lib/images/nganluong.jpg" class="thumlist" width="100" id="hinhsp_<?=$i;?>" />
				</td>
				<td align="center" valign="top" class="noidungbang">
					Gửi vào
				</td>
				<td align="right" valign="top" class="noidungbang">
					100.000
				</td>
				<td align="center" valign="top" class="noidungbang">
					Ngày 6-1-2013
				</td>
				<td width="30" align="left" valign="top" class="noidungbang">
					<a  style="cursor:pointer" class="nutxoasp" rel="<?=$dssanpham[$i]['id'];?>">Xóa</a><br />

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
				<b>Xác nhận xóa file</b>
			</div>
			<div class="regbox_cont" id="noidungxoa" style="height:250px; background:#fff;">
			
			</div>
			<div class="regbox_footer regbox_corner_bottom">
				<input type="button" name="nuthuyxoa" id="nuthuyxoa" class="newuser_button" value=" Xem lại " style="display:inline; float:left;" />
				<input type="button" name="nutxoangay" id="nutxoangay" class="newuser_button" value=" Xóa ngay " style="display: inline;" />
			</div>
		</div>
	</div>
</div>