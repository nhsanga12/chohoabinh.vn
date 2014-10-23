<div class="tcn">
	<div class="tcn_contents">
		<? if(count($dstaikhoan)==0){?>
			Bạn chưa tạo tài khoản nào. <a href="<?=sys_link('com=home&target=main&category=74');?>"><b>Tạo ngay tại đây</b></a>
		<? }?>
		<table cellpadding="5" cellspacing="0" width="100%">
			<? for($i=0;$i<count($dstaikhoan);$i++){ $idbank = $dstaikhoan[$i]['bankid'];?>
			<tr id="dongsp_<?=$dstaikhoan[$i]['users_bankid'];?>">
				<td width="210" valign="top" align="left" style="border-bottom:1px solid #eee;">
					<img src="<?=$config['url'];?>lib/images/<?=$banklist[$idbank]['images'];?>" class="thumlist" width="200" id="hinhsp_<?=$dstaikhoan[$i]['users_bankid'];?>" />
				</td>
				<td align="left" valign="top" style="border-bottom:1px solid #eee;">
					<div class="noidungtomtat" style="margin:0; padding:0; width:100%; line-height:18px;">
						<a href="<?=sys_link('com=home&target=main&category=74&detail='.$dstaikhoan[$i]['users_bankid']);?>" style="margin-top:0px;" id="tieudesp_<?=$dstaikhoan[$i]['id'];?>">
							<h2 style="margin-top:0px; line-height:12px;"><?=$banklist[$idbank]['fullname'];?></h2>
						</a>
						Chi nhánh: <span class="pro_gia2" id="chinhanh_<?=$dstaikhoan[$i]['users_bankid'];?>"><?=$dstaikhoan[$i]['chinhanh'];?></span><br />
						Tên tài khoản: <span class="pro_duong"><?=$dstaikhoan[$i]['chutaikhoan'];?></span><br />
						Số tài khoản: <span class="pro_duong"><?=$dstaikhoan[$i]['sotaikhoan'];?></span><br /><br /><br />
						<? if($dstaikhoan[$i]['status']=='1'){?>
							<div class="dangtat">Đang tắt</div>
						<? }?>
					</div>

				</td>
				<td width="100" align="left" valign="top" style="line-height:18px;border-bottom:1px solid #eee;">
					<a href="<?=sys_link('com=home&target=main&category=74&detail='.$dstaikhoan[$i]['users_bankid']);?>">Sửa</a>   /    <a  style="cursor:pointer" class="nutxoasp" rel="<?=$dstaikhoan[$i]['id'];?>">Xóa</a><br />

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