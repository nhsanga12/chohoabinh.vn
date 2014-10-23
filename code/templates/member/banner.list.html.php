<? if($_SESSION['user']['id']!= false){?>
	<div style="line-height:25px; padding-left:20px; margin-bottom:-15px;">
		Bạn có tổng cộng <b><?=count_banner_of_mem($_SESSION['user']['id']);?></b> banner và sản phẩm VIP
        <input type="button" id="taomoibanner" value=" Tạo mới " onclick="newLocation('<?=sys_link('com=home&target=main&category=71&detail=0&cate=21&ok=9710');?>')" style="cursor:pointer; background:#f7c9c8; float:right;" />
	</div>
<? }?>

<div class="tcn">
	<div class="tcn_contents">
		<?=$msg;?>
		<table cellpadding="5" cellspacing="0" width="100%">
			<? if(count($dsbanner)==0){?>
				<tr>
					<td> Bạn chưa tạo Banner hoặc sản phẩm VIP nào. Hãy <b>tạo Banner hoặc sản phẩm VIP mới</b>.</td>
				</tr>
			<? }?>
			
			<? for($i=0;$i<count($dsbanner);$i++){
				
				if($dsbanner[$i]['types']=='2')
					$picture = $dsbanner[$i]['picture'];
				else
					$picture = 'thums_'.$dsbanner[$i]['picture'];
			?>
			<tr id="dongsp_<?=$dsbanner[$i]['bannerid'];?>">
				<td width="110" valign="top" align="left" style="border-bottom:1px solid #eee;">
					<img src="<?=$config['url'];?>lib/articles/<?=$picture;?>" class="thumlist" width="100" id="hinhsp_<?=$dsbanner[$i]['bannerid'];?>" />
				</td>
				<td align="left" valign="top" style="border-bottom:1px solid #eee;">
					<div class="noidungtomtat" style="margin:0; padding:0; width:100%; line-height:18px;">
						<a href="<?=sys_link('com=home&target=main&category='.$id['category'].'&detail='.$dsbanner[$i]['articles'].'&cate='.$dsbanner[$i]['bannerid']);?>" style="margin-top:0px;" id="tieudesp_<?=$dsbanner[$i]['bannerid'];?>">
							<h2 style="margin-top:0px; line-height:12px;"><?=$dsbanner[$i]['title'];?></h2>
						</a>
                        
                        
						Vị trí: 
                        <span class="pro_gia2" id="vitri_<?=$dsbanner[$i]['bannerid'];?>">
							<?=$dsbanner[$i]['vitri'];?>
                        </span><br />
                        
						Từ ngày: <span class="pro_duong"><?=date("d-m-Y",$dsbanner[$i]['disfrom']);?></span><br />
						Đến ngày: <span class="pro_duong"><?=date("d-m-Y",$dsbanner[$i]['disto']);?></span><br />
						<? if($dsbanner[$i]['types']=='2'){?>
							Link: <span class="pro_duong"><?=$dsbanner[$i]['links'];?></span><br />
						<? }else{?>
                        	Danh mục: <span class="pro_duong"><?=$dsbanner[$i]['links'];?></span><br />
                        <? }?>
						<div class="dangtat" id="dangtat_<?=$dsbanner[$i]['bannerid'];?>" style="display:<? if($dsbanner[$i]['status']==0) echo 'block'; else echo 'none';?>;">Đang tắt</div>
                        <? if($dsbanner[$i]['hanchay']==1){?><div class="dangtat" id="hethan_<?=$dsbanner[$i]['bannerid'];?>" style=" margin-top:-70px; color:#fff; background:#900;">Hết hạn</div><? }?>
					</div>

				</td>
				<td width="200" align="left" valign="top" style="line-height:18px;border-bottom:1px solid #eee;">
                	<b>Tổng chi phí: 0đ (đang miễn phí)</b><br />
                     
					 <? if($dsbanner[$i]['status']==0){?>
                    	<a style="cursor:pointer" class="nutxoabanner cams" rel="<?=$dsbanner[$i]['bannerid'];?>" rev="bat">Bật quảng cáo</a><br />
                     <? }else{?>
                     	<a style="cursor:pointer" class="nutxoabanner cams" rel="<?=$dsbanner[$i]['bannerid'];?>" rev="ngung">Ngưng quảng cáo</a><br />
                     <? }?>
                     <?php
					 	$vitri = str_replace("H ","96",$dsbanner[$i]['vitri']);
						$vitri = str_replace("D ","97",$vitri);
						$vitri = str_replace("N ","98",$vitri);
						$vitri = str_replace("VIP ","95",$vitri);
						$cong = 19 + (int)$dsbanner[$i]['types'];
					 ?>
					<a href="<?=sys_link('com=home&target=main&category=71&detail='.$dsbanner[$i]['bannerid'].'&cate='.$cong.'&ok='.$vitri);?>" class="cams">Sửa</a>   /    
                    <a style="cursor:pointer" class="nutxoabanner cams" rel="<?=$dsbanner[$i]['bannerid'];?>">Xóa</a><br />
				</td>
			</tr>
			<? }?>
		</table>
	</div>
</div>
<div class="bgxacnhan" id="xacnhanxoa">
	<div class="popupxacnhan">
		<div style="width:450px; height:auto;" class="regbox regbox_corner_top regbox_corner_bottom">
			<div class="regbox_header regbox_corner_top" style="width:450px; text-align:left;" id="tieudetin">
				<b>Xác nhận</b>
			</div>
			<div class="regbox_cont" id="noidungxoa" style="height:250px; background:#fff;">
			
			</div>
			<div class="regbox_footer regbox_corner_bottom">
				<input type="button" name="nuthuyxoa" id="nuthuyxoa" class="newuser_button" value=" Xem lại " style="display:inline; float:left;" />
				<input type="button" name="nutxoangay" id="nutxoabanner" class="newuser_button" value=" Xóa ngay " style="display: inline;" />
                <input type="button" name="ngungbanner" id="ngungbanner" class="newuser_button" value=" Ngưng chạy " style="display: none;" />
                <input type="button" name="batbanner" id="batbanner" class="newuser_button" value=" Cho chạy lại " style="display: none;" />
			</div>
		</div>
	</div>
</div>