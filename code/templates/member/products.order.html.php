<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<table cellpadding="5" cellspacing="0" width="100%">
			<? if(count($dssanpham)==0){?>
				<tr>
					<td> Bạn chưa có sản phẩm nào được đặt hàng.</td>
				</tr>
			<? }?>
			<? for($i=0;$i<count($dssanpham);$i++){?>
			<tr>
				<td width="110" valign="top" align="left" style="border-bottom:1px solid #eee;">
					<img src="<?=$config['url'];?>lib/articles/thums_<?=$dssanpham[$i]['picture'];?>" class="thumlist" width="100" />
				</td>
				<td align="left" valign="top" style="border-bottom:1px solid #eee;">
					<div class="noidungtomtat" style="margin:0; padding:0; width:100%; line-height:18px;">
						<a href="#" style="margin-top:0px;">
							<h2 style="margin-top:0px; line-height:12px;"><?=$dssanpham[$i]['title'];?></h2>
						</a>
						Giá: <span class="pro_gia2">
						<? $giatien =formatMoney($dssanpham[$i]['gia'],0);
							if($dssanpham[$i]['loaitien']=='USD')
								echo str_replace(".",",",$giatien);
							else
								echo $giatien;
						?></span>
						<? if($dssanpham[$i]['loaitien']=='USD') echo $dssanpham[$i]['loaitien']; else echo 'đ';?><br />
						Số lượng đặt: <span class="pro_duong"><b><?=$dssanpham[$i]['amount'];?></b></span><br />
						Ngày đặt: <span class="pro_duong"><?=date("d-m-Y H:i",$dssanpham[$i]['ngaydat']);?></span><br /><br />
					</div>

				</td>
				<td width="300" align="left" valign="top" style="line-height:18px;border-bottom:1px solid #eee;">
					Người đặt hàng: <b><?=$dssanpham[$i]['fullname'];?></b><br />
					Điện thoại: <?=$dssanpham[$i]['phone'];?><br />
					Email: <?=$dssanpham[$i]['email'];?><br />
					Địa chỉ liên hệ: <?=$dssanpham[$i]['address'];?><br />
					Yêu cầu: <?=$dssanpham[$i]['description'];?><br />


				</td>
				<td width="70" align="left" valign="top" style="line-height:18px;border-bottom:1px solid #eee;">
					<a href="#">Xóa</a><br />
					<a href="#">Phản hồi</a><br />
				</td>
			</tr>
			<? }?>
		</table>
	</div>
</div>
