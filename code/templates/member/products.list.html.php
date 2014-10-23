<? if($_SESSION['user']['id']!= false){?>
	<div style="line-height:25px; padding-left:20px; margin-bottom:-15px;">
		Bạn có tổng cộng <b><?=count_pro_of_mem($_SESSION['user']['id']);?></b> sản phẩm
	</div>
<? }?>

<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<table cellpadding="5" cellspacing="0" width="100%">
			<? if(count($dssanpham)==0){?>
				<tr>
					<td> Bạn chưa tạo sản phẩm nào. Hãy nhấn vào menu <b>Tạo sản phẩm mới</b> để tạo.</td>
				</tr>
			<? }?>
			
			<? for($i=0;$i<count($dssanpham);$i++){?>
			<tr id="dongsp_<?=$dssanpham[$i]['id'];?>">
				<td width="110" valign="top" align="left" style="border-bottom:1px solid #eee;">
					<img src="<?=$config['url'];?>lib/articles/thums_<?=$dssanpham[$i]['picture'];?>" class="thumlist" width="100" id="hinhsp_<?=$dssanpham[$i]['id'];?>" />
				</td>
				<td align="left" valign="top" style="border-bottom:1px solid #eee;">
					<div class="noidungtomtat" style="margin:0; padding:0; width:100%; line-height:18px;">
						<a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&detail='.$dssanpham[$i]['id']);?>" style="margin-top:0px;" id="tieudesp_<?=$dssanpham[$i]['id'];?>">
							<h2 style="margin-top:0px; line-height:12px;"><?=$dssanpham[$i]['title'];?></h2>
						</a>
						Giá: <span class="pro_gia2" id="giasp_<?=$dssanpham[$i]['id'];?>">
						<? $giatien =formatMoney($dssanpham[$i]['gia'],0);
							if($dssanpham[$i]['loaitien']=='USD')
								echo str_replace(".",",",$giatien);
							else
								echo $giatien;
						?></span>
						<? if($dssanpham[$i]['loaitien']=='USD') echo $dssanpham[$i]['loaitien']; else echo 'đ';?><br />
						Mã sp: <span class="pro_duong"><?=$dssanpham[$i]['ma'];?></span><br />
						Ngày đăng: <span class="pro_duong"><?=date("d-m-Y H:i",$dssanpham[$i]['bydate']);?></span><br />
						<? if($dssanpham[$i]['status']=='1'){?>
							<div class="dangtat">Đang tắt</div>
						<? }?>
					</div>

				</td>
				<td width="200" align="left" valign="top" style="line-height:18px;border-bottom:1px solid #eee;">
					<a href="#" class="cams">Up tin bằng Pin (500PIN/lần)</a><br />
					<a href="#" class="cams">Up tin bằng SMS: soạn XXX gửi 81xx</a><br />
					<a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&detail='.$dssanpham[$i]['id'].'&cate=10');?>" class="cams">Cài đặt up tin tự động hàng ngày</a><br />
					<a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&detail='.$dssanpham[$i]['id'].'&cate=20');?>" class="cams">Đặt vào vị trí VIP </a><br />
					<a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&detail='.$dssanpham[$i]['id']);?>" class="cams">Sửa</a>   /    
                    <a style="cursor:pointer" class="nutxoasp cams" rel="<?=$dssanpham[$i]['id'];?>">Xóa</a><br />

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