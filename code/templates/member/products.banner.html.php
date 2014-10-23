<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<table cellpadding="5" cellspacing="0" width="100%" style="border: 1px solid #ddd;">
			<tr>
				<? foreach($bannergroup as $key => $value){?>
					<td align="center" valign="middle" class="tieudebang">
						<span style="line-height:15px;"><?=$value['vn'];?></span>
					</td>
				<? }?>				
			</tr>
			
			<tr>
				<? foreach($bannergroup as $key => $value){?>
					<td <? if($value['width']!=''){?> width="<?=$value['width'];?>" <? }?> valign="top" align="center" class="noidungbang">
						<? for($m=0;$m<$value['max'];$m++){?>
							<div class="yellowcell trickercalender" style=" font-size:12px;<?=$value['itemcss'];?>" rel="<?=$value['keydis'];?> <?=$m+1;?>"><?=$value['keydis'];?> <?=$m+1;?></div>
						<? }?>
					</td>
				<? }?>
			</tr>
			
		</table>
	</div>
</div>

<? 
	if($id['cate']=='21'){ // banner
		$sty = "style=\"display:block;\"";
		$select = " selected=\"selected\"";
		$dis = "block";
		$dissp = "style=\"display:none;\"";
		$vitri = str_replace("95","VIP ",$id['ok']);
		$vitri = str_replace("96","H ",$vitri);
		$vitri = str_replace("97","D ",$vitri);
		$vitri = str_replace("98","N ",$vitri);
		$noidung = "<script language=\"javascript\" type=\"text/javascript\"> LoadCalender('".trim($vitri)."','','');</script>";
	
	}else if($id['ok']!=''){ //sản phẩm có cho biết vị trí đặt
		$sty = "style=\"display:block;\"";
		$vitri = str_replace("95","VIP ",$id['ok']);
		$vitri = str_replace("96","H ",$vitri);
		$vitri = str_replace("97","D ",$vitri);
		$vitri = str_replace("98","N ",$vitri);
		$noidung = "<script language=\"javascript\" type=\"text/javascript\"> LoadCalender('".trim($vitri)."','','');</script>";
		$select =  $dissp = '';
		$dis = "none";
		
	}else{ //sản phẩm không biết vị trí đặt
	 	$sty = $noidung =  $select =  $dissp = '';
		$dis = "none";
	}
	
	if($msg!='')
		$sty = "style=\"display:none;\"";
?>

<div class="bgxacnhan" id="calenderbox" <?=$sty;?>>
	<div class="popupxacnhan" style="margin-top:5%;">
		<div style="width:750px; height:auto;" class="regbox regbox_corner_top regbox_corner_bottom">
			<div class="regbox_header regbox_corner_top" style="width:750px; text-align:left;">
				Lịch đặt sản phẩm/banner tại vị trí &nbsp;<span class="pro_gia2" id="tenvitri"><?=$vitri;?></span>
                <input type="button" name="closecalender" id="closecalender" class="newuser_button" value=" Đóng lại " style="display: inline; float:right; margin:4px 4px 0px 0px;" />
			</div>
			<div class="regbox_cont" id="noidunghienthi" style="height:550px; background:#fff;">
				<div id="noidunglich">
                	<?=$noidung;?>
				</div>
				<div id="bangchonchinh">
					<form action="" method="post" enctype="multipart/form-data">
						<div style="width:46%; text-align:left; margin-left:1%; color:#444; margin-top:10px;float:left;">
							<table border="0" cellpadding="10" cellspacing="0">
								<tr>
									<td colspan="2"><b> Ngày hiển thị sản phẩm hoặc banner của bạn : </b></td>
								</tr>
								<tr>
									<td>Từ ngày</td>
									<td>
										<div class="ongaythang ongaythang_at" id="dis_tungay"><?=date("d-m-Y",$bannerdt[0]['disfrom']);?></div>
										<span class="red" id="mieuta01" onclick="rechoice()">Click chuột vào lịch để chọn</span>
										<input type="hidden" name="calen_tungay" id="calen_tungay" value="<?=date("d-m-Y",$bannerdt[0]['disfrom']);?>" />
									</td>
								</tr>
								<tr>
									<td>Đến ngày</td>
									<td>
										<div class="ongaythang" id="dis_denngay"><?=date("d-m-Y",$bannerdt[0]['disto']);?></div>
										<span class="blue" id="mieuta02" onclick="rechoice()">Chọn lại</span>
										<input type="hidden" name="calen_denngay" id="calen_denngay" value="<?=date("d-m-Y",$bannerdt[0]['disto']);?>" />
										<input type="hidden" name="vitridien" id="vitridien" value="0" />
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<input type="submit" name="luulailich" value=" Lưu lại " id="luulailich" <? if(count($bannerdt)>0) echo ''; else {?>disabled="disabled"<? }?> /><span id="notesave" class="red"></span><br /><br />
                                        <div style="width:80px;height:30px;margin:0; padding:0; line-height:30px; float:left;font-size:12px"> Ký hiệu màu: </div>
                                        <div class="ngaythang" style="width:120px;height:30px;margin:0; padding:0; line-height:30px; float:left;font-size:12px"> Ngày còn trống</div>
                                        <div class="bgdadat" style="width:120px;height:30px;margin:0; padding:0; line-height:30px;float:left;font-size:12px"> Ngày đã đặt </div>
									</td>
								</tr>
							</table>
						</div>
						<div style="width:46%; text-align:left; margin-left:1%; color:#444; margin-top:10px; float:left;">
							<table border="0" cellpadding="10" cellspacing="0">	
								<tr>
									<td colspan="2"><b> Sản phẩm hoặc banner của bạn : </b></td>
								</td>
								<tr>
									<td>Hình thức</td>
									<td>
										<select name="hinhthucs" id="hinhthucs" onchange="hinhthucdat();">
											<option value="1" label="Đặt sản phẩm">Đặt sản phẩm</option>
											<option value="2" label="Đặt Banner" <?=$select;?>>Đặt Banner</option>
										</select>&nbsp;&nbsp;
                                        Vị trí:
                                        <select name="vitribanner" id="vitribanner" onchange=" change_vitri();">
                                            <? foreach($bannergroup as $key => $value){
												for($m=0;$m<$value['max'];$m++){ 
													if($value['keydis']." ".($m+1) == $vitri )
														$select = " selected=\"selected\"";
													else
														$select = "";	
											?>
                                                	<option value="<?=$value['keydis'];?> <?=$m+1;?>" label="<?=$value['keydis'];?> <?=$m+1;?>" <?=$select;?>>
														<?=$value['keydis'];?> <?=$m+1;?>
                                                    </option>
                                            <?  }
											   }  ?>
										</select>
									</td>
								</tr>
								<tr>
									<td width="80" valign="top">
										<div class="hinhthucval" id="htten_1" <?=$dissp;?>>Sản phẩm</div>
										<div class="hinhthucval" id="htten_2" style="display:<?=$dis;?>;">Chọn banner<br /><br />Link: </div>
									</td>
									<td valign="top">
                                    	
										<div class="hinhthucval" id="hinhthuc_1" <?=$dissp;?>>
                                            <select name="tieudesp" id="tieudesp" onchange=" change_imgs();" style="width:90%;">
                                            	<? for($x=0;$x<count($dssanpham);$x++){
													if($dssanpham[$x]['id']==$detail[0]['id'] && $id['cate'] == 20)
														$select = " selected=\"selected\"";
													else
														$select = "";	
												?>
                                                	<option value="<?=$dssanpham[$x]['id'];?>" label="<?=$dssanpham[$x]['title'];?>" <?=$select;?>>
														<?=$dssanpham[$x]['title'];?>
                                                    </option>
												<? }?>
                                            </select><br /><br />
											<? for($m=0;$m<count($dssanpham);$m++){
													if(($dssanpham[$m]['id']==$detail[0]['id'] && $id['cate'] == 20) || ($m==0 && $id['detail']==0))
														$diss = "block";
													else
														$diss = "none";	
													if($dssanpham[$m]['picture']){
												?>
                                            	<img src="<?=$config['url'];?>lib/articles/thums_<?=$dssanpham[$m]['picture'];?>" class="thumlist" width="80" style=" display:<?=$diss;?>;" id="imgs_<?=$dssanpham[$m]['id'];?>" />
                                            <? } } ?>
										</div>
										<div class="hinhthucval" id="hinhthuc_2" style="display:<?=$dis;?>;">
											<input type="file" name="filebanner" style="width:50%;" /> ( Size: 220x200 )
                                            <input type="hidden" name="oldpic" value="<?=$bannerdt[0]['picture'];?>" />
                                            <input type="text" name="linkbanner" value="<?=$bannerdt[0]['links'];?>" style="width:100%;" />
                                            <? if($bannerdt[0]['picture']){?>
                                            	<img src="<?=$config['url'];?>lib/articles/<?=$bannerdt[0]['picture'];?>" class="thumlist" width="80" />
                                             <? }?>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</form>
				</div>
			</div>
			<div class="regbox_footer regbox_corner_bottom">
				<input type="button" name="closecalender" id="closecalender2" class="newuser_button" value=" Đóng lại " style="display: inline;" />
			</div>
		</div>
	</div>
</div>