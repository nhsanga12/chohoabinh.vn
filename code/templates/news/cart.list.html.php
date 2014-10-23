<div class="bgtrang">
	<div class="rows">
		<div class="lefts">
			<div class="pro_list">
				<div class="pro_list_header">
					<div class="sptab">
						<span> <?=$danhmuc[0]['title'];?> </span>
					</div>
					<div class="spcolum">
						<span style="margin-left:165px;"> Thông tin sản phẩm </span>
						<span style="margin-left:310px;"> Thành tiền </span>
					</div>
				</div>
				<div class="pro_list_cont">
					<table cellpadding="0" cellspacing="0" width="100%" class="tb_pro">
						<? for($n=0;$n<count($sanpham);$n++){?>
							<tr id="sanpham_<?=$sanpham[$n]['id'];?>">
								<td width="180" valign="top">
									<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><img src="<?=$config['url'];?>lib/articles/thums_<?=$sanpham[$n]['picture'];?>" alt="<?=$sanpham[$n]['title'];?>" class="listpro_img" border="0" /></a>
								</td>
								<td width="350" valign="top">
									<div class="noidungtomtat">
										<a href="<?=sys_link('com=home&target=main&category='.$sanpham[$n]['category'].'&detail='.$sanpham[$n]['id']);?>"><h2><?=$sanpham[$n]['title'];?></h2></a>
										<table cellpadding="0" cellspacing="0" class="subpro" width="90%">
											<tr><td width="70">Chủ shop:</td><td><a href="#"><?=$sanpham[$n]['fullname'];?></a></td></tr>
											<tr><td>Điện thoại:</td><td><?=$sanpham[$n]['phone'];?></td></tr>
											<tr><td valign="top">Địa chỉ:</td><td><?=$sanpham[$n]['address'];?></td></tr>
											<tr><td>Tình trạng:</td><td><? if($sanpham[$n]['acti']!='') echo '<div class="xacthuc">Chưa xác thực thông tin</div>'; else echo 'Đã xác thực thông tin';?></td></tr>
											<tr><td>Danh hiệu:</td><td><? if($sanpham[$n]['vip']==1) echo '<div class="vip">VIP</div>'; else echo '<div class="thanhvien">Thành viên</div>';?></td></tr>
											
											<tr><td></td>
											
											<?php
													if($sanpham[$n]['likes']=='' || $sanpham[$n]['likes']=='0')
														$lk = 1;
													else
														$lk = (int)$sanpham[$n]['likes'];
												?>
											<td align="right">
												<div class="likeshare removeitem" id="loaihang_<?=$sanpham[$n]['id'];?>" style="float: right;" > Loại</div>
												<input id="inloaihang_<?=$sanpham[$n]['id'];?>" type="hidden" value="<?=$sanpham[$n]['id'];?>" />
											</td></tr>
										</table>
									</div>
								</td>
								<td valign="top">
									<table cellpadding="0" cellspacing="0" class="subpro" style="margin:15px 1px 1px 25px; width:200px;">
										<tr><td width="70">Đơn giá:</td>
											<td align="right">
												<span class="pro_gia"><? $giatien =formatMoney($sanpham[$n]['gia'],0);
												if($sanpham[$n]['loaitien']=='USD')
													echo str_replace(".",",",$giatien);
												else
													echo $giatien;
												?></span>
												<? if($sanpham[$n]['loaitien']=='USD') echo '$'; else echo 'đ';?>
											</td>
										</tr>
										<tr><td>Số lượng:</td><td align="right">
											<input type="text" name="sluong" id="sluong" rel="<?=$sanpham[$n]['id'];?>" value="<?=$amount[$sanpham[$n]['id']];?>" class="sluong pro_gia" style="text-align:right; font-weight:bold; width:50px;" />&nbsp;&nbsp;</td></tr>
										<tr><td>Thành tiền:</td><td align="right">
										<b><span class="pro_gia">
											<? $thanhtien = (int)$amount[$sanpham[$n]['id']] * (int)$sanpham[$n]['gia'];
												$tongtien += $thanhtien;
												echo formatMoney($thanhtien,0);
											?>
										</span></b> <? if($sanpham[$n]['loaitien']=='USD') echo '$'; else echo 'đ';?></td></tr>
										<tr>
											<td colspan="2" align="center" valign="bottom" height="90">
												<select name="hinhthuctt" style="margin:10px 10px 10px 10px; border:1px solid #ddd; float:right; width:155px; height:25px;">
													<option value="1" <? if($_SESSION['carthttt'][$sanpham[$n]['id']] == '1'){?>selected="selected"<? }?> label="Chuyển khoản">Chuyển khoản</option>
													<option value="2" <? if($_SESSION['carthttt'][$sanpham[$n]['id']] == '2'){?>selected="selected"<? }?> label="Tiền mặt">Tiền mặt</option>
													<option value="" <? if($_SESSION['carthttt'][$sanpham[$n]['id']] == ''){?>selected="selected"<? }?> label="Thanh toán khác">Thanh toán khác</option>
												</select>
												<input type="button" id="thanhtoan_<?=$sanpham[$n]['id'];?>" style="margin:0px 10px 0px 10px; float:right; height:25px; cursor:pointer;" value=" Thanh toán " />
											
											</td>
										</tr>
										
									</table>
								</td>
							</tr>					
						<? } ?>
					</table>
					<div class="tongtien">
						<? if($_SESSION['cart']['sum']>0){?>
							Tổng tiền: 
							<span class="pro_gia2">
								<?=formatMoney($tongtien,0);?>
							</span> đ &nbsp;&nbsp;
						<? }else{?>
							<div class="giotrong">Giỏ hàng trống !</div>
						<? }?> 
					</div>
					<a id="thanhtoan" style="cursor:pointer;"><div class="muahang" style="float:right; width:100px; margin:10px 0px 0px 0px;"> Gửi đơn hàng</div></a>
					<a id="huygiohang" style="cursor:pointer;"><div class="muahang" style="float:right; width:100px; margin:10px 20px 0px 0px;">Hủy giỏ hàng</div></a>
				</div>
			</div>
			<div class="jquery_ms" style="display:none">	Đang thực hiện ....</div>
			
			<div class="bgxacnhan" id="xacnhanxoa">
				<div class="popupxacnhan" style="margin-top:10%;">
					<div style="width:450px; height:auto;" class="regbox regbox_corner_top regbox_corner_bottom">
						<div class="regbox_header regbox_corner_top" style="width:450px; text-align:left;">
							<b>Xác nhận thông tin thanh toán</b> - Hóa đơn: <?=$hoadon;?>
						</div>
						<div class="regbox_cont" id="noidungxoa" style="height:300px; background:#fff; padding-top:30px;">
							<? foreach($buysell as $field=>$configuser){
								if($field!='tablename'){
								$value = $memberdt[0][$field];
							?>
							<div class="form_line">
								<div class="form_line_left">
									<?=$configuser['vn'];?>
								</div>
								<div class="form_line_right">
									<? if($configuser['type'] == 'textarea'){?>
										<textarea name="<?=$field;?>" id="<?=$field;?>" class="tcninput" style="width:<?=$configuser['width'];?>px; height:<?=$configuser['height'];?>px;"></textarea>
									<? }else{?>
									<input type="<?=$configuser['type'];?>" name="<?=$field;?>" id="<?=$field;?>" class="tcninput" style="width:<?=$configuser['width'];?>px;" value="<?=$value;?>"  />
									<? }?>
								</div>
							</div>
							<? } } ?>
						
						</div>
						<div class="regbox_footer regbox_corner_bottom">
							<input type="hidden" name="hoadon" id="hoadon" value="<?=$hoadon;?>" />
							<input type="button" name="nuthuyxoa" id="nuthuyxoa" class="newuser_button" value=" Xem lại " style="display:inline; float:left;" />
							<input type="button" name="nutmuahang" id="nutmuahang" class="newuser_button" value=" Đồng ý mua hàng " style="display: inline;" />
						</div>
					</div>
				</div>
			</div>
						
		</div>
		
		
		<?=sys_option('home','main','right');?>
		
	</div>
</div>